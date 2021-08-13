<?php
/**
 * Virtual Hosts Manager for DEVSERVER
 * @version  2.0
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

include_once('virtualhostsmanager2_functions.php');
 
//== CHECK ERRORS ============================================================
if ((isset($_POST['to'])) AND (($_POST['to'] == "add_vhost2") OR ($_POST['to'] == "modify_vhost2"))) {
	
	$get_vhost_modal = '&vhost_modal=' . $_POST['vhost_modal'];
	$get_vhost_name = '&add_vhost_name=' . htmlspecialchars(trim($_POST['vhost_name']));
	$get_vhost_link = '&add_vhost_link=' . urlencode(trim($_POST['vhost_link']));
	
	// ERRORS
	if ($_POST['vhost_name'] == "") {
		header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?to=add_vhost_error' . $get_vhost_modal . $get_vhost_name . $get_vhost_link . '&add_vhost_error=1');
		exit;
	}
	elseif ($_POST['vhost_link'] == "") {
		header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?to=add_vhost_error' . $get_vhost_modal . $get_vhost_name . $get_vhost_link . '&add_vhost_error=2');
		exit;
	}
	elseif (($_POST['vhost_link'] != "") && (!is_dir($_POST['vhost_link']))) {
		header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?to=add_vhost_error' . $get_vhost_modal . $get_vhost_name . $get_vhost_link . '&add_vhost_error=3');
		exit;
	}
	elseif (!preg_match('/^[-a-zA-Z0-9_.]+$/i', trim($_POST['vhost_name']))) {
		header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?to=add_vhost_error' . $get_vhost_modal . $get_vhost_name . $get_vhost_link . '&add_vhost_error=4');
		exit;
	}
}
//============================================================================


//== ADD VITRTUAL HOST =======================================================
if ((isset($_POST['to'])) AND ($_POST['to'] == "add_vhost2")) {
	
	$vhosts_file = trim(file_get_contents('apache-vhosts.conf'));
	
	// Check if name already exists
	if (preg_match('/^[\s#]*ServerName\s+('.trim($_POST['vhost_name']).')\s*$/m', $vhosts_file)) {
		header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?to=add_vhost_error' . $get_vhost_modal . $get_vhost_name . $get_vhost_link . '&add_vhost_error=5');
		exit;
	}
	
	
	// Create certificates
	putenv("CAROOT=".getcwd()."\certificates\CA"); // define CA folder
	putenv("JAVA_HOME="); 	// remove JAVA_HOME variable to avoid CA for Java
							// and avoid "failed to execute 'keytool -importcert' error message
	exec(escapeshellarg(__DIR__.'\mkcert.exe')." -install");
	exec(escapeshellarg(__DIR__.'\mkcert.exe')." -key-file certificates/".trim($_POST['vhost_name'])."_certkeyfile.pem -cert-file certificates/".trim($_POST['vhost_name'])."_certfile.pem ".trim($_POST['vhost_name']));
	
	
	// Update apache-vhosts.conf
	$vhosts_file .= PHP_EOL.'<VirtualHost 127.0.0.1:${SRVPORT}>'.PHP_EOL;
	$vhosts_file .= 'DocumentRoot "'.str_replace('\\', '/', trim($_POST['vhost_link'])).'"'.PHP_EOL;
	$vhosts_file .= 'ServerName '.trim($_POST['vhost_name']).PHP_EOL;
	$vhosts_file .= 'ErrorLog "${LOG_DIR}/error_vh_'.trim($_POST['vhost_name']).'.log"'.PHP_EOL;
	$vhosts_file .= 'CustomLog "${LOG_DIR}/access_vh_'.trim($_POST['vhost_name']).'.log" combined'.PHP_EOL;
	$vhosts_file .= '<Directory "'.str_replace('\\', '/', trim($_POST['vhost_link'])).'">'.PHP_EOL;
	$vhosts_file .= trim($_POST['vhost_directory']).PHP_EOL;
	$vhosts_file .= '</Directory>'.PHP_EOL;
	$vhosts_file .= '</VirtualHost>'.PHP_EOL;	
	$vhosts_file .= '<VirtualHost 127.0.0.1:443>'.PHP_EOL;
	$vhosts_file .= 'DocumentRoot "'.str_replace('\\', '/', trim($_POST['vhost_link'])).'"'.PHP_EOL;
	$vhosts_file .= 'ServerName '.trim($_POST['vhost_name']).PHP_EOL;
	$vhosts_file .= 'ErrorLog "${LOG_DIR}/error_vh_'.trim($_POST['vhost_name']).'.log"'.PHP_EOL;
	$vhosts_file .= 'CustomLog "${LOG_DIR}/access_vh_'.trim($_POST['vhost_name']).'.log" combined'.PHP_EOL;	
	$vhosts_file .= 'SSLEngine on'.PHP_EOL;
	$vhosts_file .= 'SSLCertificateFile "${APPROOT}/eds-dashboard/certificates/'.trim($_POST['vhost_name']).'_certfile.pem"'.PHP_EOL;
	$vhosts_file .= 'SSLCertificateKeyFile "${APPROOT}/eds-dashboard/certificates/'.trim($_POST['vhost_name']).'_certkeyfile.pem"'.PHP_EOL;
	$vhosts_file .= '<Directory "'.str_replace('\\', '/', trim($_POST['vhost_link'])).'">'.PHP_EOL;
	$vhosts_file .= trim($_POST['vhost_directory']).PHP_EOL;
	$vhosts_file .= '</Directory>'.PHP_EOL;
	$vhosts_file .= '</VirtualHost>'.PHP_EOL;	
	file_put_contents('apache-vhosts.conf',trim($vhosts_file));


	// Modify Windows hosts file
	$hosts_file = trim(@file_get_contents(get_hostsfile_dir().'\hosts'));
	$pattern = '/^(#?)(127\.0\.0\.1\s+'.trim($_POST['vhost_name']).'\s*)$/m';
	if (preg_match($pattern,$hosts_file)) {
		$hosts_file = preg_replace($pattern, '$2', $hosts_file);		
	} else {
		$hosts_file .= PHP_EOL . "127.0.0.1 " . trim($_POST['vhost_name']);
	}
	file_put_contents(get_hostsfile_dir() . '\hosts', trim($hosts_file));	

	
	// Restart http server if http server running
	if ($eds_httpserver_running == 1) include('../eds-binaries/httpserver/' . $conf_httpserver['httpserver_folder'] . '/eds-app-restart.php');
	header("Location: index.php#anchor_virtualhostsmanager");  
	exit;
}
//============================================================================


//== MODIFY VIRTUAL HOST ====================================================
if ((isset($_POST['to'])) AND ($_POST['to'] == "modify_vhost2")) {	

	$vhosts_file = trim(file_get_contents('apache-vhosts.conf'));
	
	if (trim($_POST['vhost_current_name']) != trim($_POST['vhost_name'])){
		
		// Check if name already exists
		if (preg_match('/^[\s#]*ServerName\s*('.trim($_POST['vhost_name']).')\s*$/m', $vhosts_file)) {
			header("Location: " . 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?to=add_vhost_error' . $get_vhost_modal . $get_vhost_name . $get_vhost_link . '&add_vhost_error=5');
			exit;
		}	
		
		// Modify hosts Windows file
		$hosts_file = trim(@file_get_contents(get_hostsfile_dir().'\hosts'));
		$pattern = '/^([#]?)(127\.0\.0\.1\s+'.trim($_POST['vhost_current_name']).'\s*)$/m';
		if (preg_match($pattern, $hosts_file)) {
			$hosts_file = preg_replace($pattern, '127.0.0.1 ' . trim($_POST['vhost_name']), $hosts_file);	
		} else {
			$hosts_file .= PHP_EOL . '127.0.0.1 ' . trim($_POST['vhost_name']);
		}
		file_put_contents(get_hostsfile_dir() . '\hosts', trim($hosts_file));	
		
		// Update log path
		$vhosts_file = str_replace('error_vh_' . trim($_POST['vhost_current_name']).'.log','error_vh_' . trim($_POST['vhost_name']).'.log',$vhosts_file);
		$vhosts_file = str_replace('access_vh_' . trim($_POST['vhost_current_name']).'.log','access_vh_' . trim($_POST['vhost_name']).'.log',$vhosts_file);		
		
		// Update certificates path
		$vhosts_file = str_replace(trim($_POST['vhost_current_name']).'_certfile.pem',trim($_POST['vhost_name']).'_certfile.pem',$vhosts_file);
		$vhosts_file = str_replace(trim($_POST['vhost_current_name']).'_certkeyfile.pem',trim($_POST['vhost_name']).'_certkeyfile.pem',$vhosts_file);
		
		// Delete certificates
		array_map('unlink', glob(getcwd().'\certificates\\'.trim($_POST['vhost_current_name']).'_*'));		
		
		// Create new certificates
		exec(escapeshellarg(__DIR__.'\mkcert.exe')." -key-file certificates/".trim($_POST['vhost_name'])."_certkeyfile.pem -cert-file certificates/".trim($_POST['vhost_name'])."_certfile.pem ".trim($_POST['vhost_name']));		
	}

	preg_match('/<VirtualHost[^>]*>[^<]*ServerName\s+'.trim($_POST['vhost_current_name']).'\s+.*?SSLEngine.*?<\/VirtualHost>/s', $vhosts_file, $matches);
	$modified_vhost = $matches[0];
		
	// Modify ServerName
	$modified_vhost = preg_replace('/^ServerName\s+.*$/m', 'ServerName '.$_POST['vhost_name'], $modified_vhost);	
	
	// Modify vhost path
	$modified_vhost = preg_replace('/^DocumentRoot\s+.*$/m', 'DocumentRoot "'.str_replace('\\', '/', trim($_POST['vhost_link'])).'"', $modified_vhost);		
	$modified_vhost = preg_replace('/^<Directory.*>.*$/m', '<Directory "'.str_replace('\\', '/', trim($_POST['vhost_link'])).'">', $modified_vhost);	
	
	// Modify Directory
	$modified_vhost = preg_replace('/(<Directory.*?>)(.*?)(<\/Directory>)/s', '${1}'.PHP_EOL.trim($_POST['vhost_directory']).PHP_EOL.'$3', $modified_vhost);	
	
	// Update vhosts
	$pattern = '/<VirtualHost[^>]*>[^<]*ServerName\s+'.trim($_POST['vhost_current_name']).'\s+.*?SSLEngine.*?<\/VirtualHost>/s';
	$vhosts_file = preg_replace($pattern, $modified_vhost, $vhosts_file);	

	file_put_contents('apache-vhosts.conf',trim($vhosts_file));

			
	// Restart http server if http server running
	if ($eds_httpserver_running == 1) include('../eds-binaries/httpserver/' . $conf_httpserver['httpserver_folder'] . '/eds-app-restart.php');
	header("Location: index.php#anchor_virtualhostsmanager");  
	exit;
}
//============================================================================


//== ACTIVATE OR DESACTIVATE VIRTUAl HOST AND HOST NAME ======================
if (isset($_GET['vhost2_current_status'])) {
	
	$hashtag = ($_GET['vhost2_current_status'] == 0) ? '' : '#';

	// Modify apache-vhosts.conf
	$vhosts_file = trim(file_get_contents('apache-vhosts.conf'));
	$vhosts_file = preg_replace_callback('/#?<VirtualHost[^>]*>[^<]*ServerName\s+'.$_GET['vhost2_current_servername'].'\s+.*?SSLEngine.*?<\/VirtualHost>/s',
		function($matches) use ($hashtag) {
			return trim(preg_replace('/^([#]?)(.*)/m', $hashtag.'$2', $matches[0]));
	}, $vhosts_file);	
	file_put_contents('apache-vhosts.conf',trim($vhosts_file));	
	
	// Modify Windows hosts file
	$hosts_file = trim(file_get_contents(get_hostsfile_dir().'\hosts'));
	$pattern = '/^([#]?)(127\.0\.0\.1\s+'.trim($_GET['vhost2_current_servername']).'\s*)$/m';
	if (preg_match($pattern,$hosts_file)) {
		$hosts_file = preg_replace($pattern, $hashtag.'$2', $hosts_file);		
	} else {
		$hosts_file .= PHP_EOL . $hashtag . "127.0.0.1 " . trim($_GET['vhost2_current_servername']);
	}
	file_put_contents(get_hostsfile_dir() . '\hosts', trim($hosts_file));	
	
	
	// Restart http server if http server running
	if ($eds_httpserver_running == 1) include('../eds-binaries/httpserver/' . $conf_httpserver['httpserver_folder'] . '/eds-app-restart.php');	
	header("Location: index.php#anchor_virtualhostsmanager2");  
	exit;	
}
//============================================================================


//== DELETE VIRTUAL HOST AND HOST NAME =======================================
if (isset($_GET['vhost2_servername_delete'])) {
		
	// Delete vhost in apache-vhosts.conf
	$vhosts_file = trim(file_get_contents('apache-vhosts.conf'));
	$pattern = '/#?<VirtualHost[^>]*>[^<]*ServerName\s+'.trim($_GET['vhost2_servername_delete']).'\s+.*?SSLEngine.*?<\/VirtualHost>\s*/s';
	$vhosts_file = preg_replace($pattern, '', $vhosts_file);	
	file_put_contents('apache-vhosts.conf',trim($vhosts_file));	
	
	// Delete host in Windows hosts file
	$hosts_file = trim(@file_get_contents(get_hostsfile_dir().'\hosts'));
	$pattern = '/#?127\.0\.0\.1\s+'.trim($_GET['vhost2_servername_delete']).'\s*/s';
	$hosts_file = preg_replace($pattern, '', $hosts_file);	
	file_put_contents(get_hostsfile_dir() . '\hosts', trim($hosts_file));

	// Delete certificates
	array_map('unlink', glob(getcwd().'\certificates\\'.trim($_GET['vhost2_servername_delete']).'_*'));
		
	// Restart http server if http server running
	if ($eds_httpserver_running == 1) include('../eds-binaries/httpserver/' . $conf_httpserver['httpserver_folder'] . '/eds-app-restart.php');	
	header("Location: index.php#anchor_virtualhostsmanager");  
	exit;
}
//============================================================================
?>