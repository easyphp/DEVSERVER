<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

// Check if port is available
function check_port($port) {
	$conn = @fsockopen("127.0.0.1", $port, $errno, $errstr, 0.2);
	if ($conn) {
		fclose($conn);
		return true;
	}
}

// Array of available ports
$ports = array(80,8080,8000,8888,8008);
$ports_available = array();
foreach ($ports as $port){
	if (!check_port($port)) $ports_available[] = $port;
}


// CONTROL
$control = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form" style="float:left;">';
$control .= 'PHP version: ';

$control .= '<select name="action[variable][php_folder]" class="form-control input-sm">';
	$php_folders = @opendir('../eds-binaries/php');
	while (($php_folder = @readdir($php_folders)) !== false){
		if (@file_exists('../eds-binaries/php/'.$php_folder.'/eds-app-settings.php')){
			// include php settings
			include('../eds-binaries/php/'.$php_folder.'/eds-app-settings.php');
			if ($php_settings['app_architecture'] == 'x86' OR $php_settings['app_architecture'] == '') {
				$tag = ($php_settings['app_tag'] !== "") ? ' &nbsp;&nbsp;-&nbsp;&nbsp;' . $php_settings['app_tag'] : '';
				$selected_php = ($php_folder == $conf_httpserver['php_folder']) ? 'selected' : '';
				$control .= '<option value="' . urlencode($php_folder) . '" '.$selected_php.'>' . $php_settings['app_version'] . $tag . '</option>';
			}
		}
	}
	@closedir($php_folders);	
$control .= '</select>';

$control .= '<span style="padding:0px 5px 0px 20px;">Port:</span>';
$control .= '<select name="action[variable][server_port]" class="form-control input-sm">';
	if ($eds_httpserver_running == 1) $control .= '<option value="' . $conf_httpserver['httpserver_port'] . '" selected>' . $conf_httpserver['httpserver_port'] . '</option>';	
	foreach ($ports_available AS $port_available){
		if ($conf_httpserver['httpserver_port'] !== $port_available) $control .= '<option value="' . $port_available . '">' . $port_available . '</option>';		
	}
$control .= '</select>';
	
if ($eds_httpserver_running == 0) {
	// app not running - > start app
	$control .= '<input type="hidden" name="action[request][0][type]" value="include" />';
	$control .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(__DIR__ . '/eds-app-start.php') . '" />';
	$control .= '<button type="submit" class="btn btn-success btn-sm" onclick="delay()" style="margin-left:20px;"><span class="glyphicon glyphicon-play small" aria-hidden="true"></span>&nbsp;&nbsp;start&nbsp;</button>';
	$control .= '</form>';
	
} else {
	// app running - > restart / stop app
	$control .= '<input type="hidden" name="action[request][0][type]" value="include" />';
	$control .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(__DIR__ . '/eds-app-restart.php') . '" />';
	$control .= '<button type="submit" class="btn btn-warning btn-sm" onclick="delay()" style="margin-left:20px;"><span class="glyphicon glyphicon-refresh small" aria-hidden="true"></span>&nbsp;&nbsp;restart&nbsp;</button>';
	$control .= '</form>';
	$control .= '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form" style="float:left;">';
	$control .= '<input type="hidden" name="action[request][0][type]" value="include" />';
	$control .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(__DIR__ . '/eds-app-stop.php') . '" />';
	$control .= '<button type="submit" class="btn btn-danger btn-sm" onclick="delay()" style="margin-left:10px;"><span class="glyphicon glyphicon-stop small" aria-hidden="true"></span>&nbsp;&nbsp;stop&nbsp;</button>';
	$control .= '</form>';
}

// include server settings
include(__DIR__ . '\\eds-app-settings.php');

$serverconf = file_get_contents(__DIR__ . '\conf\httpd.conf');
$servererrorlog = file_get_contents(__DIR__ . '\logs\error.log');
$serveraccesslog = file_get_contents(__DIR__ . '\logs\access.log');
?>

<style type="text/css" media="all">
.support_link {
	color:#FF5722;
	border-bottom:1px dotted #FF5722;
}
.support_link:hover {
	text-decoration:none;
	border-bottom:1px dotted #DD2C00;
	color:#DD2C00;
}

a.info_bulle {
	color:#FFD54F;
}

.info_bulle:hover {
	cursor:pointer;
	color:#c0c0c0;
}

.info_bulle:focus {
	outline: 0;
}
</style>

<div class="row">
	<div class="col-sm-1 text-center">
		<img src="images/<?php echo $app_settings['app_icon']; ?>" border="0" />
	</div>
	<div class="col-sm-11">
		<h1><?php echo strtoupper($app_settings['app_name']) ?><a href="<?php echo $app_settings['app_website_url'] ?>" target="_blank" style="position:absolute;padding:5px 0px 0px 5px;font-size:12px;color:silver;" data-toggle="tooltip" data-placement="top" title="Go to Website"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a></h1>
		<p>
			&#9642; version : <b><?php echo $app_settings['app_version_nb'] ?></b><br />
			&#9642; compiler : <b><?php echo $app_settings['app_build'] ?></small></b><br />
			&#9642; architecture : <b><?php echo $app_settings['app_mode'] ?></small></b><br />
			&#9642; supported languages : <b><?php echo $app_settings['app_supported_languages'] ?></small></b><br />
		</p>
	</div>
</div>

<br />

<?php
if ((basename(__DIR__) !== $conf_httpserver['httpserver_folder']) AND ($conf_httpserver['httpserver_folder'] != '') AND ($eds_httpserver_running == 1)) {

	// Another server is running -> stop it
	?>
	<div class="row">
		<div class="col-sm-10 text-center">
			<b>Another server is running. You need to stop it first.</b>
			<br />
			<br />
			<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form">
				<input type="hidden" name="action[request][0][type]" value="include" />
				<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode(dirname(__DIR__) . '\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-stop.php') ?>" />
				<button type="submit" class="btn btn-danger btn-sm" onclick="delay()"><span class="glyphicon glyphicon-stop" aria-hidden="true"></span>&nbsp;&nbsp;<strong>stop the active server</strong></button>
			</form>
		</div>
	</div>
	<?php	
	
} else {

	$info_server = "<p style='color:#FF5722;' class='small'>If an error occurs when you start the server, see <a href='http://www.easyphp.org/support.php' class='support_link' target='_blank'>support</a>.</p>";
	$info_server .= "<p class='small'>";
	$info_server .= "<b>Typical case:</b><br />";
	$info_server .= "If you have an error message like : 'The program can't start because MSVCR1xx.dll / VCRUNTIME1xx.dll  is missing..'";
	$info_server .= "</p>";
	$info_server .= "<ul>";
	$info_server .= "<li class='small'>see the <a href='http://www.easyphp.org/support.php' class='support_link' target='_blank'>FAQ</a>.</li>";
	$info_server .= "<li class='small'>or, if you cannot update your system (because you have administrator rights for example), install a VC11 version of the server and/or PHP. See <a href='http://warehouse.easyphp.org' class='support_link' target='_blank'>downloads</a>.</li>";
	$info_server .= "</ul>";

	?>
	<div class="table-responsive">
		<table class="table table-hover">
			<tbody>
				<tr>
					<td style="padding-top:15px;white-space:nowrap;">
						<strong>Server</strong>
						<a role="button" tabindex="0" class="info_bulle" aria-hidden="true" data-toggle="popover" data-trigger="focus" data-html="true" data-content="<?php echo $info_server ?>"><i class="fa fa-info-circle"></i></a>
					</td>
					<td colspan="2"><?php echo $control; ?></td>
				</tr>				
				<?php
				// SERVER RUNNING
				if ($eds_httpserver_running == 1) {
					?>
					<tr>
						<td style="white-space:nowrap;"><strong>Parameters</strong></td>
						<td colspan="2">
							<?php
							preg_match('/^ServerName(.*):(.*)$/m', $serverconf, $serverhostport);
							include('../eds-binaries/php/'.$conf_httpserver['php_folder'].'/eds-app-settings.php');
							$tooltip = (trim($php_settings['app_tag']) !== "") ? 'style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="Tag : ' . trim($php_settings['app_tag']) . '"' : '';
							?>
							<em>PHP version: </em><kbd <?php echo $tooltip; ?>><?php echo trim($php_settings['app_version']); ?></kbd>
							&nbsp;&nbsp;&nbsp;&nbsp;<em>Port: </em><kbd><?php echo trim($serverhostport[2]); ?></kbd>
							&nbsp;&nbsp;&nbsp;&nbsp;<em>Host: </em><kbd><?php echo trim($serverhostport[1]); ?></kbd>

						</td>
					</tr>
					<tr>
						<td style="white-space:nowrap;"><strong>Server URL</strong></td>
						<td style="white-space:nowrap;">
							<a href="http://<?php echo trim($serverhostport[1]) . ':' . trim($serverhostport[2]); ?>" data-toggle="tooltip" data-placement="top" title="Browse http://127.0.0.1:<?php echo trim($serverhostport[2]) ?>" target="_blank" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-link small" aria-hidden="true"></span></a>
						</td>
						<td>
							<samp style="color:silver;" class="small">http://<?php echo trim($serverhostport[1]) . ':' . trim($serverhostport[2]); ?></samp>
						</td>
					</tr>
					<?php
				}			
				?>
				<tr>
					<td style="white-space:nowrap;"><strong>Document Root</strong></td>
					<td style="white-space:nowrap;">
						<?php			
						preg_match('/^DocumentRoot[\s]+"(.*)"[\s]+$/m', $serverconf, $documentroot);
						echo '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form">';
						echo '<input type="hidden" name="action[request][0][type]" value="exe" />';
						echo '<input type="hidden" name="action[request][0][value]" value="' . urlencode('explorer.exe ' . str_replace('/', '\\', trim($documentroot[1]))) . '" />';
						echo '<button type="submit" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Explore Document Root" onclick="delay()"><span class="glyphicon glyphicon-folder-open small" aria-hidden="true"></span></button>';
						echo '</form>';		
						?>
					</td>
					<td style="width:100%">
						<?php
						echo '<samp style="color:silver;" class="small">' . str_replace('/', '\\', trim($documentroot[1])) . '\</samp>';
						?>		
					</td>
				</tr>
				<tr>
					<td style="white-space:nowrap;"><strong>Server Root</strong></td>
					<td>
						<?php			
						echo '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form">';
						echo '<input type="hidden" name="action[request][0][type]" value="exe" />';
						echo '<input type="hidden" name="action[request][0][value]" value="' . urlencode('explorer.exe ' . __DIR__) . '" />';
						echo '<button type="submit" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Explore Server Root" onclick="delay()"><span class="glyphicon glyphicon-folder-open small" aria-hidden="true"></span></button>';
						echo '</form>';		
						?>						
					</td>
					<td>
						<?php
						echo '<samp style="color:silver;" class="small">' . __DIR__ . '\\' . '</samp>';
						?>
					</td>
				</tr>
				<tr>					
					<td style="white-space:nowrap;"><strong>Files</strong></td>
					<td colspan="2">					
						<a href="<?php echo $_SERVER['REQUEST_URI'];?>&display=serverconffile"><button type="button" class="btn btn-primary btn-xs">Configuration File</button></a>
						<a href="<?php echo $_SERVER['REQUEST_URI'];?>&display=servererrorlog"><button type="button" class="btn btn-primary btn-xs">Error Log</button></a>
						<a href="<?php echo $_SERVER['REQUEST_URI'];?>&display=serveraccesslog"><button type="button" class="btn btn-primary btn-xs">Access Log</button></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
		
	<?php
	if (isset($_GET['display']) AND $_GET['display'] == 'serverconffile') {
		?>
		<h4 style="display:inline">Configuration File</h4>
		<div style="float:right;padding-bottom:10px;">
			<form method="post" style="display:inline" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form">
				<input type="hidden" name="action[request][0][type]" value="exe" />
				<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . __DIR__ . '\conf\httpd.conf') ?>" />
				<button type="submit" class="btn btn-default btn-xs" onclick="delay()" data-toggle="tooltip" data-placement="left" title="Edit configuration file"><span class="glyphicon glyphicon-pencil small" aria-hidden="true"></span></button>
			</form>	
			<a href="index.php?zone=applications&page=httpserver&serverfolder=<?php echo basename(dirname(__FILE__)); ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
		</div>
		<pre style="clear:both"><?php echo htmlspecialchars($serverconf); ?></pre>
		<?php
	}

	if (isset($_GET['display']) AND $_GET['display'] == 'servererrorlog') {
		?>
		<h4 style="display:inline">Error Log</h4>
		<div style="float:right;padding-bottom:10px;">
			<form method="post" style="display:inline" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form">
				<input type="hidden" name="action[request][0][type]" value="exe" />
				<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . __DIR__ . '\logs\error.log') ?>" />
				<button type="submit" class="btn btn-default btn-xs" onclick="delay()" data-toggle="tooltip" data-placement="left" title="Edit Error Log"><span class="glyphicon glyphicon-pencil small" aria-hidden="true"></span></button>
			</form>	
			<a href="index.php?zone=applications&page=httpserver&serverfolder=<?php echo basename(dirname(__FILE__)); ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
		</div>
		<pre style="clear:both"><?php echo htmlspecialchars($servererrorlog); ?></pre>
		<?php
	}

	if (isset($_GET['display']) AND $_GET['display'] == 'serveraccesslog') {
		?>
		<h4 style="display:inline">Access Log</h4>	
		<div style="float:right;padding-bottom:10px;">
			<form method="post" style="display:inline" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form">
				<input type="hidden" name="action[request][0][type]" value="exe" />
				<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . __DIR__ . '\logs\access.log') ?>" />
				<button type="submit" class="btn btn-default btn-xs" onclick="delay()" data-toggle="tooltip" data-placement="left" title="Edit Access Log"><span class="glyphicon glyphicon-pencil small" aria-hidden="true"></span></button>
			</form>	
			<a href="index.php?zone=applications&page=httpserver&serverfolder=<?php echo basename(dirname(__FILE__)); ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
		</div>
		<pre style="clear:both"><?php echo htmlspecialchars($serveraccesslog); ?></pre>
		<?php
	}	
}
?>