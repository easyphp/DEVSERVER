<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */


// Variables
$server_port = '';
$php_folder = '';

if (isset($_POST['action']['variable']['server_port']) AND isset($_POST['action']['variable']['php_folder'])) {	
	$server_port = $_POST['action']['variable']['server_port'];
	$php_folder = $_POST['action']['variable']['php_folder'];		
} else {
	if (isset($conf_httpserver['httpserver_folder']) AND strstr($conf_httpserver['httpserver_folder'],'apache')) {
		
		$php_folder = $conf_httpserver['php_folder'];
		
		// Check if port is available
		function check_port($port) {
			$conn = @fsockopen("127.0.0.1", $port, $errno, $errstr, 0.2);
			if ($conn) {
				fclose($conn);
				return true;
			}
		}

		// Array of available ports
		$ports = array(80,8080,8000,8888,8008, 8118, 8181, 8111);
		$ports_available = array();
		foreach ($ports as $port){
			if (!check_port($port)) $ports_available[] = $port;
		}
		
		if (!in_array($conf_httpserver['httpserver_port'],$ports_available)) {
			$server_port = $ports_available[0];
		} else {
			$server_port = $conf_httpserver['httpserver_port'];
		}
	
	}
}


if (($server_port !== '') AND ($php_folder !== '')) {

	// HTTP CONFIGURATION FILES

	// Update httpd-php.conf
	include('..\\eds-binaries\php\\' . $php_folder . '\\eds-app-settings.php');
	$httpdphp = 'LoadModule ' . $php_settings['load_module_apache'] . ' "' . str_replace('\\', '/', dirname(dirname(__DIR__))) . '/php/' . $php_folder . '/' . $php_settings['load_module_apache_dll'] . '"' . "\r\n";
	$httpdphp .= 'PHPIniDir "' . str_replace('\\', '/', dirname(dirname(__DIR__))) . '/php/' . $php_folder . '/php.ini"' . "\r\n";
	$httpdphp .= 'SetEnv TMP "' . str_replace('\\', '/', dirname(dirname(__DIR__))) . '/tmp"';
	file_put_contents (__DIR__ . '\conf\httpd-php.conf', $httpdphp);

	// Update httpd.conf
	$serverconffile = file_get_contents(__DIR__ . '\conf\httpd.conf');

		// Update ServerRoot
		$replacement = '${1}' . str_replace('\\', '/', __DIR__) . '$3';
		$serverconffile = preg_replace('/^([\s|\t]*ServerRoot.*\")(.*)(\".*)$/m', $replacement, $serverconffile);

		// Update Listen - Port
		$replacement = '${1}' . $server_port;
		$serverconffile = preg_replace('/^([\s|\t]*Listen.*\:[\s|\t]*)(.*)$/m', $replacement, $serverconffile);

		// Update ServerName - Port
		$replacement = '${1}' . $server_port;
		$serverconffile = preg_replace('/^([\s|\t]*ServerName.*\:[\s|\t]*)(.*)$/m', $replacement, $serverconffile);	
		
		// DocumentRoot - eds-www
		$replacement = '${1}' . str_replace('\\', '/', dirname(dirname(dirname(__DIR__)))) . '$3';
		$serverconffile = preg_replace('/^([\s|\t]*DocumentRoot[\s|\t]*\")(.*)(\/eds-www.*)$/m', $replacement, $serverconffile);
		
		// DocumentRoot - Directory eds-www
		$replacement = '${1}' . str_replace('\\', '/', dirname(dirname(dirname(__DIR__)))) . '$3';
		$serverconffile = preg_replace('/^(.*Directory[\s|\t]*\")(.*)(\/eds-www.*)$/m', $replacement, $serverconffile);

		// Alias - eds-modules
		$replacement = '${1}' . str_replace('\\', '/', dirname(dirname(dirname(__DIR__)))) . '$3';
		$serverconffile = preg_replace('/^([\s|\t]*Alias[\s|\t]*\/eds-modules[\s|\t]*\")(.*)(\/eds-modules.*)$/m', $replacement, $serverconffile);
		
		// Alias - Directory eds-modules
		$replacement = '${1}' . str_replace('\\', '/', dirname(dirname(dirname(__DIR__)))) . '$3';
		$serverconffile = preg_replace('/^(.*Directory[\s|\t]*\")(.*)(\/eds-modules.*)$/m', $replacement, $serverconffile);	
		
		// ScriptAlias
		$replacement = '${1}' . str_replace('\\', '/', __DIR__) . '$3';
		$serverconffile = preg_replace('/^([\s|\t]*ScriptAlias[\s|\t]*\/cgi-bin\/[\s|\t]*\")(.*)(\/cgi-bin.*)$/m', $replacement, $serverconffile);
		
		// Cgi-bin - Directory
		$replacement = '${1}' . str_replace('\\', '/', __DIR__) . '$3';
		$serverconffile = preg_replace('/^(.*Directory[\s|\t]*\")(.*)(\/cgi-bin.*)$/m', $replacement, $serverconffile);	

	file_put_contents (__DIR__ . '\conf\httpd.conf', $serverconffile);


	// Update httpd-autoindex.conf
	$serverconffileautoindex = file_get_contents(__DIR__ . '\conf\extra\httpd-autoindex.conf');

		// Alias - Icons
		$replacement = '${1}' . str_replace('\\', '/', __DIR__) . '$3';
		$serverconffileautoindex = preg_replace('/^([\s|\t]*Alias[\s|\t]*\/icons\/[\s|\t]*\")(.*)(\/icons\/.*)$/m', $replacement, $serverconffileautoindex);
		
		// Alias - Directory Icons
		$replacement = '${1}' . str_replace('\\', '/', __DIR__) . '$3';
		$serverconffileautoindex = preg_replace('/^(.*Directory[\s|\t]*\")(.*)(\/icons.*)$/m', $replacement, $serverconffileautoindex);	
		
	file_put_contents (__DIR__ . '\conf\extra\httpd-autoindex.conf', $serverconffileautoindex);


	// Update httpd-alias.conf
	$alias_serialized = file_get_contents('store_alias.php');
	$store_alias = '';
	if ($alias_serialized != '') {
		foreach (unserialize($alias_serialized) as $key => $alias) {
			$alias_link = str_replace("\\","/", urldecode($alias['alias_path']));
			$alias_link = str_replace("//","/", $alias_link);
			if (substr($alias_link, -1) == "/"){$alias_link = substr($alias_link,0,strlen($alias_link)-1);}
			$store_alias .= "Alias \"/";
			$store_alias .= $alias['alias_name'];
			$store_alias .= "\" \"";
			$store_alias .= $alias_link;
			$store_alias .= "\"\r\n";
			$store_alias .= "<Directory \"$alias_link\">\r\n";
			$store_alias .= "\tOptions FollowSymLinks Indexes ExecCGI\r\n";
			$store_alias .= "\tAllowOverride All\r\n";
			$store_alias .= "\tOrder deny,allow\r\n";
			$store_alias .= "\tAllow from 127.0.0.1\r\n";
			$store_alias .= "\tDeny from all\r\n";
			$store_alias .= "\tRequire all granted\r\n";			
			$store_alias .= "</Directory>\r\n";
		}
	}
	file_put_contents(__DIR__ . '\conf\httpd-alias.conf', $store_alias);


	// Update httpd-vhosts.conf
	$vhosts_serialized = file_get_contents('store_vhosts.php');
	$store_vhosts = '';
	if ($vhosts_serialized != '') {
		foreach (unserialize($vhosts_serialized) as $key => $vhost) {
		
			if (isset($vhost['vhost_directory']) AND ($vhost['vhost_directory'] !== '')) {
				$store_vhosts .= "<VirtualHost 127.0.0.1>\n";
				$store_vhosts .= "\tDocumentRoot \"" . urldecode($vhost['vhost_link']) . "\"\n";
				$store_vhosts .= "\tServerName " . $vhost['vhost_name'] . "\n";
				$store_vhosts .= "\t<Directory \"" . urldecode($vhost['vhost_link']) . "\">\n";
				$store_vhosts .= $vhost['vhost_directory'] . "\r\n";
				$store_vhosts .= "\t</Directory>\r\n";
				$store_vhosts .= "</VirtualHost>\n";
			} else {
				$store_vhosts .= "<VirtualHost 127.0.0.1>\n";
				$store_vhosts .= "\tDocumentRoot \"" . urldecode($vhost['vhost_link']) . "\"\n";
				$store_vhosts .= "\tServerName " . $vhost['vhost_name'] . "\n";
				$store_vhosts .= "\t<Directory \"" . urldecode($vhost['vhost_link']) . "\">\n";
				$store_vhosts .= "\t\tOptions FollowSymLinks Indexes ExecCGI\r\n";
				$store_vhosts .= "\t\tAllowOverride All\r\n";
				$store_vhosts .= "\t\tOrder deny,allow\r\n";
				$store_vhosts .= "\t\tAllow from 127.0.0.1\r\n";
				$store_vhosts .= "\t\tDeny from all\r\n";
				$store_vhosts .= "\t\tRequire all granted\r\n";
				$store_vhosts .= "\t</Directory>\r\n";
				$store_vhosts .= "</VirtualHost>\n";
			}
			
		}
	}
	file_put_contents(__DIR__ . '\conf\httpd-vhosts.conf', $store_vhosts);		


	// PHP CONFIGURATION
	include('..\\eds-binaries\php\\' . $php_folder . '\\eds-app-actions.php');


	// CONF_HTTPSERVER.PHP
	$conf_httpserver_content = '<?php' . "\r\n";
	$conf_httpserver_content .= '$conf_httpserver = array();' . "\r\n";
	$conf_httpserver_content .= '$conf_httpserver = array(' . "\r\n";
	$conf_httpserver_content .= "\t" . '"httpserver_folder" => "' . basename((__DIR__)) . '",' . "\r\n";
	$conf_httpserver_content .= "\t" . '"httpserver_port" => "' . $server_port . '",' . "\r\n";
	$conf_httpserver_content .= "\t" . '"php_folder" => "' . $php_folder . '",' . "\r\n";
	$conf_httpserver_content .= ');' . "\r\n";
	$conf_httpserver_content .= '?>';
	file_put_contents ('conf_httpserver.php', $conf_httpserver_content);
}
?>