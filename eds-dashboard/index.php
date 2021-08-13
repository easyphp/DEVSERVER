<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */
 
session_start(); 
include('functions.inc.php');
$lang = 'en';

// EDS ini
$edsini = parse_ini_file('../eds.ini');

// eds-http running ?
$httpserver_status = array();
exec('eds-app-list.exe -accepteula -e "eds-httpserver"', $httpserver_status);
$eds_httpserver_running = (strstr($httpserver_status[3], 'eds-httpserver') == TRUE) ? 1 : 0;

// eds-db running ?
$dbserver_status = array();
exec('eds-app-list.exe -accepteula -e "eds-dbserver"', $dbserver_status);
$eds_dbserver_running = (strstr($dbserver_status[3], 'eds-dbserver') == TRUE) ? 1 : 0;

// Conf files
include('conf_httpserver.php');
include('conf_dbserver.php');

//== ACTIONS ==================================================================

if (isset($_POST['action'])) {

	// Include and exec
	if (isset($_POST['action']['request'])) {
		foreach ($_POST['action']['request'] as $request) {
			if ($request['type'] == 'include') include(urldecode($request['value']));
			if ($request['type'] == 'exe') exec(urldecode($request['value']));
		}
	}
	$redirect = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header("Location: " . $redirect);
	exit;
}

if (isset($_GET['action'])) {
	
	// Include and exec
	if ($_GET['action'] == 'include') include(urldecode($_GET['value']));
	if ($_GET['action'] == 'exe') exec(urldecode($_GET['value']));
	if (isset($_GET['redirect'])) {
		$redirect = urldecode($_GET['redirect']);
	} else {
		$redirect = 'http://127.0.0.1:1111/index.php';
	}
	header("Location: " . $redirect);
	exit;
}
//=============================================================================


//== ALIAS ====================================================================

// Delete alias
if (isset($_GET['delete_alias'])) {
	$alias_serialized = file_get_contents('store_alias.php');
	$alias_array = array();
	$alias_array = unserialize($alias_serialized);
	unset($alias_array[$_GET['delete_alias']]);
	file_put_contents('store_alias.php',serialize($alias_array));
	header('Location: index.php'); 
	exit;
}

// Add alias
if (isset($_POST['alias_name'])){
	
	if ($_POST['alias_name'] == '') {
		header('Location: index.php?to=add_alias&alias_error=alias_name_empty'); 
		exit;
	}
	if ($_POST['alias_path'] == '') {
		header('Location: index.php?to=add_alias&alias_error=alias_path_empty'); 
		exit;
	}
	if (!file_exists($_POST['alias_path'])) {
		header('Location: index.php?to=add_alias&alias_error=alias_nofolder'); 
		exit;
	}
	
	// Add \ at the end if not present
	$alias_path = str_replace('/', '\\', $_POST['alias_path']);
	if (substr($alias_path, -1) !== '\\') $alias_path = $alias_path . '\\';

	$new_alias[0]['alias_path'] = urlencode($alias_path);
	$new_alias[0]['alias_name'] = 'edsa-' . $_POST['alias_name'];
	

	if (file_exists('store_alias.php')) {
		$alias_serialized = file_get_contents('store_alias.php');
	} else {
		$alias_serialized = serialize(array());
	}

	$alias_array = array();

	if ($alias_serialized != '') {
		$alias_names = array_column(unserialize($alias_serialized), 'alias_name');
		if (in_array($new_alias[0]['alias_name'], $alias_names)) {
			header('Location: index.php?to=add_alias&alias_error=alias_exists'); 
			exit;
		} else {
			$alias_array = array_merge(unserialize($alias_serialized), $new_alias);
		}
	} else {
		$alias_array = $new_alias;
	}
	file_put_contents('store_alias.php',serialize($alias_array));
	
	// Restart http server if http server running
	if ($eds_httpserver_running == 1) include('../eds-binaries/httpserver/' . $conf_httpserver['httpserver_folder'] . '/eds-app-restart.php');	
	
	header('Location: index.php'); 
	exit;
}
//=============================================================================


// Notifications
include("notification.php"); 
if (@date('Ymd') != $notification['check_date']) {
	$context = stream_context_create(array('http' => array('timeout' => 1)));
	$content = @file_get_contents('http://www.easyphp.org/notifications/notification-easyphp-devserver.txt', 0, $context);
	if (!empty($content)) {
		$content_array = explode('#', $content);	
		if ($content_array[0] != $notification['date']) {
			$new_content = '<?php $notification = array(\'check_date\'=>\'' . @date('Ymd') . '\',\'date\'=>\'' . $content_array[0] . '\',\'status\'=>\'1\',\'link\'=>\'' . $content_array[1] . '\',\'message\'=>\'' . $content_array[2] . '\',\'link_text\'=>\'' . $content_array[3] . '\'); ?>';
			file_put_contents('notification.php', $new_content);
			$redirect = "http://" . $_SERVER['HTTP_HOST'] . "/index.php";
			header("Location: " . $redirect); 
			exit;	
		}
	}
	$new_content = '<?php $notification = array(\'check_date\'=>\'' . @date('Ymd') . '\',\'date\'=>\'' . $notification['date'] . '\',\'status\'=>\'' . $notification['status'] . '\',\'link\'=>\'' . $notification['link'] . '\',\'message\'=>\'' . $notification['message'] . '\',\'link_text\'=>\'' . $notification['link_text'] . '\'); ?>';
	file_put_contents('notification.php', $new_content);
};
$notification_banner = '<div class="alert-danger blink text-center" style="padding:5px 0px 5px 0px;">';
$notification_banner .= $notification['message'];
$notification_banner .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="notification_redirect.php" class="btn btn-primary btn-xxs" target="_blank" onclick="setTimeout(\'history.go(0);\',1500)">';
$notification_banner .= $notification['link_text'];
$notification_banner .= '</a>';
$notification_banner .= '</div>';

$notification_popover = '<p class=\'text-center\' style=\'margin-bottom:0px;width:200px\'>';
$notification_popover .= $notification['message'];
$notification_popover .= '<br /><a href=\''.$notification['link'].'\' class=\'btn btn-primary btn-xxs\' target=\'_blank\'>' . $notification['link_text'] . '</a>';
$notification_popover .= '</p>';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Laurent Abbal">
		<link rel="icon" href="images/favicon.png" />

		<title>EasyPHP Devserver</title>

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="library/font-awesome/css/font-awesome.min.css">
		
		<!-- Bootstrap core CSS -->
		<link href="library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Devicon -->
		<link rel="stylesheet" type="text/css" href="library/devicon/devicon.min.css">			
		
		<!-- Custom CSS -->
		<link rel="stylesheet" href="custom.css" type="text/css" />

		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="bootstrap/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<script src="library/bootstrap/js/ie-emulation-modes-warning.js"></script>

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="library/bootstrap/js/ie10-viewport-bug-workaround.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<script language="javascript" type="text/javascript">
			function delay() {
				document.getElementById('delay').style.display = "block";
			}
		</script>
		
	</head>

	<body <?php if ($notification['status'] == 1) echo 'style="padding-top:75px"'; ?>>

		<nav class="navbar navbar-default navbar-fixed-top">
			<?php
			if ($notification['status'] == 1) {
				echo $notification_banner;
			}
			?>

			<div class="container">

				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a href="index.php"><img src="images/easyphp_devserver.png" width="200" height="40" alt="EasyPHP" border="0" /></a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <span class="sr-only">(current)</span></a></li>
						<li><a href="index.php?zone=applications">applications</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">tools <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="http://www.easyphp.org/download.php?s=eds" target="_blank"><span class="glyphicon glyphicon-plus text-muted small" aria-hidden="true"></span><strong> additional components</strong></a></li>
								<li><a href="http://warehouse.easyphp.org/index.php?s=eds" target="_blank"><span class="glyphicon glyphicon-plus text-muted small" aria-hidden="true"></span><strong> updates and tools</strong></a></li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="http://www.easyphp.org/easyphp-webserver.php?s=eds" style="padding-bottom:5px;" target="_blank"><span class="btn btn-default btn-xxs small glyphicon glyphicon-link" aria-hidden="true"></span> Self hosting with EasyPHP Webserver
									<br /><i class="small text-muted" style="padding-left:24px;color:silver;">Create your own web server and host your files</i>
									</a>
								</li>
								<li>
									<a href="http://www.codekodo.net/index.php?s=eds" style="padding-bottom:5px;" target="_blank"><span class="btn btn-default btn-xxs small glyphicon glyphicon-link" aria-hidden="true"></span> Codekodo
									<br /><i class="small text-muted" style="padding-left:24px;color:silver;">A simple coding environment with several languages</i>
									</a>
								</li>
								<li>
									<a href="http://www.webcodesniffer.net/index.php?s=eds" style="padding-bottom:5px;" target="_blank"><span class="btn btn-default btn-xxs small glyphicon glyphicon-link" aria-hidden="true"></span> Webcode Sniffer
									<br /><i class="small text-muted" style="padding-left:24px;color:silver;">Clean up code & respect standards</i>
									</a>
								</li>
								<li>
									<a href="http://www.dotip.net/index.php?s=eds" style="padding-bottom:5px;" target="_blank"><span class="btn btn-default btn-xxs small glyphicon glyphicon-link" aria-hidden="true"></span> dotIP
									<br /><i class="small text-muted" style="padding-left:24px;color:silver;">Link shortener and URL redirection</i>
									</a>
								</li>
							</ul>
						</li>
						<li><a href="http://www.easyphp.org/support.php?s=eds" target="_blank">support</a></li>
						<li><a href="http://www.easyphp.org/documentation/" target="_blank">documentation</a></li>
						<li><a href="http://www.easyphp.org/index.php?s=eds" target="_blank">website</a></li>
						<li><a href="http://warehouse.easyphp.org/index.php?s=eds" target="_blank">warehouse</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li>
							<a role="button" tabindex="0" class="notification_bell" data-toggle="popover" data-placement="bottom" data-html="true" data-trigger="focus" data-content="<?php echo $notification_popover ?>"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span></a>						
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
				
			</div><!-- /.container-fluid -->

		</nav>	

		<br />
		<br />

		<div id="delay">&nbsp;</div>
		
		<?php
		if (isset($_GET['zone']) AND  $_GET['zone'] == 'applications') {
			include('index_applications.php');	
		} else {
		?>
			<div class="container">
			
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<table class="table">	
							<tr>
								<td class="text-center" style="padding:0px">
									<h4 style="margin:0px">HTTP SERVER</h4>
								</td>
								<td class="text-center" style="padding:0px">
									<h4 style="margin:0px">DATABASE SERVER</h4>
								</td>
							</tr>
							<tr>
								<td class="text-center" style="padding:2px 0px 0px 0px;">
									<?php
									include(dirname(__DIR__) . '\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-settings.php');		
									include(dirname(__DIR__) . '\eds-binaries\php\\' . $conf_httpserver['php_folder'] . '\eds-app-settings.php');	
									$tooltip = (trim($php_settings['app_tag']) !== "") ? 'style="cursor:pointer" data-toggle="tooltip" data-placement="right" title="Tag : ' . trim($php_settings['app_tag']) . '"' : '';							

									if ($eds_httpserver_running == 1)
									{
										?>
										<div>
											<?php
											$startstop_http_button = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" style="display:inline;" role="form">';
											$startstop_http_button .= '<input type="hidden" name="action[request][0][type]" value="include" />';
											$startstop_http_button .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(dirname(__DIR__) . '\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-stop.php') . '" />';
											$startstop_http_button .= '<button type="submit" class="btn btn-danger btn-xs" style="padding-left:10px;padding-right:10px;" onclick="delay()" style="padding-left:20px;padding-right:20px;"><span class="glyphicon glyphicon-stop small" aria-hidden="true"></span>&nbsp;&nbsp;stop&nbsp;</button>';
											$startstop_http_button .= '</form>';
											echo $startstop_http_button;
											echo '&nbsp;';
											$restart_http_button = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" style="display:inline;" role="form">';
											$restart_http_button .= '<input type="hidden" name="action[request][0][type]" value="include" />';
											$restart_http_button .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(dirname(__DIR__) . '\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-restart.php') . '" />';
											$restart_http_button .= '<button type="submit" class="btn btn-warning btn-xs" style="padding-left:5px;padding-right:5px;" onclick="delay()" style="padding-left:20px;padding-right:20px;" data-toggle="tooltip" data-placement="top" title="Restart"><span class="glyphicon glyphicon-refresh small" aria-hidden="true"></span></button>';
											$restart_http_button .= '</form>';
											echo $restart_http_button;											
											?>
											&nbsp;
											<a href="index.php?zone=applications&page=httpserver&serverfolder=<?php echo $conf_httpserver['httpserver_folder'] ?>" class="btn btn-default btn-xs" style="padding:2px 6px 0px 6px;" data-toggle="tooltip" data-placement="top" title="Server Settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
											&nbsp;
											<a href="index.php?zone=applications&page=httpserver" class="btn btn-default btn-xs" style="padding-top:2px;padding-bottom:0px;" data-toggle="tooltip" data-placement="top" title="Change Server"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>

											<div style="margin-top:5px;">
												<i style="color:silver;"><samp class="small"><?php echo $app_settings['app_name'] . ' ' . $app_settings['app_version'] . ' - PHP </samp><samp class="small" ' . $tooltip . '>' . $php_settings['app_version']; ?></samp></i>			
											</div>
											<div style="margin-top:-5px;">
												<i><samp class="small" style="color:silver;">Port: <?php echo $conf_httpserver['httpserver_port']?></samp></i>			
											</div>
											
										</div>
										<?php
									} else {
										?>
										<div>
											<?php
											$startstop_http_button = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" style="display:inline;" role="form">';
											$startstop_http_button .= '<input type="hidden" name="action[request][0][type]" value="include" />';
											$startstop_http_button .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(dirname(__DIR__) . '\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-start.php') . '" />';
											$startstop_http_button .= '<button type="submit" class="btn btn-success btn-xs" style="padding-left:10px;padding-right:10px;" onclick="delay()" style="padding-left:20px;padding-right:20px;"><span class="glyphicon glyphicon-play small" aria-hidden="true"></span>&nbsp;&nbsp;start&nbsp;</button>';
											$startstop_http_button .= '</form>';
											echo $startstop_http_button;
											?>
											&nbsp;
											<a href="index.php?zone=applications&page=httpserver&serverfolder=<?php echo $conf_httpserver['httpserver_folder'] ?>" class="btn btn-default btn-xs" style="padding:2px 6px 0px 6px;" data-toggle="tooltip" data-placement="top" title="Server Settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
											&nbsp;
											<a href="index.php?zone=applications&page=httpserver" class="btn btn-default btn-xs" style="padding-top:2px;padding-bottom:0px;" data-toggle="tooltip" data-placement="top" title="Change Server"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>

											<div style="margin-top:5px;">
												<i style="color:#ecf0f1;"><samp class="small"><?php echo $app_settings['app_name'] . ' ' . $app_settings['app_version'] . ' - PHP </samp><samp class="small" ' . $tooltip . '>' . $php_settings['app_version']; ?></samp></i>			
											</div>
											<div style="margin-top:-5px;">
												<i><samp class="small" style="color:#ecf0f1;">Port: <?php echo $conf_httpserver['httpserver_port']?></samp></i>			
											</div>

										</div>
										<?php
									}
									?>
								</td>
								<td class="text-center" style="padding:2px 0px 0px 0px;">
									<?php
									include(dirname(__DIR__) . '\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-settings.php');
									if ($eds_dbserver_running == 1)
									{	
										?>
										<div>
											<?php
											$startstop_db_button = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" style="display:inline;" role="form">';
											$startstop_db_button .= '<input type="hidden" name="action[request][0][type]" value="include" />';
											$startstop_db_button .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(dirname(__DIR__) . '\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-stop.php') . '" />';
											$startstop_db_button .= '<button type="submit" class="btn btn-danger btn-xs" style="padding-left:10px;padding-right:10px;" onclick="delay()" style="padding-left:20px;padding-right:20px;"><span class="glyphicon glyphicon-stop small" aria-hidden="true"></span>&nbsp;&nbsp;stop&nbsp;</button>';
											$startstop_db_button .= '</form>';
											echo $startstop_db_button;
											echo '&nbsp;';
											$restart_db_button = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" style="display:inline;" role="form">';
											$restart_db_button .= '<input type="hidden" name="action[request][0][type]" value="include" />';
											$restart_db_button .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(dirname(__DIR__) . '\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-restart.php') . '" />';
											$restart_db_button .= '<button type="submit" class="btn btn-warning btn-xs" style="padding-left:5px;padding-right:5px;" onclick="delay()" style="padding-left:20px;padding-right:20px;" data-toggle="tooltip" data-placement="top" title="Restart"><span class="glyphicon glyphicon-refresh small" aria-hidden="true"></span></button>';
											$restart_db_button .= '</form>';
											echo $restart_db_button;																				
											?>	
											&nbsp;
											<a href="index.php?zone=applications&page=dbserver&serverfolder=<?php echo $conf_dbserver['dbserver_folder'] ?>" class="btn btn-default btn-xs" style="padding:2px 6px 0px 6px;" data-toggle="tooltip" data-placement="top" title="Server Settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
											&nbsp;
											<a href="index.php?zone=applications&page=dbserver" class="btn btn-default btn-xs" style="padding-top:2px;padding-bottom:0px;" data-toggle="tooltip" data-placement="top" title="Change Server"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>
										</div>
										<div style="margin-top:5px;">
											<i><samp class="small" style="color:silver;"><?php echo $app_settings['app_name'] . ' ' . $app_settings['app_version'] ?></samp></i>													
										</div>
										<div style="margin-top:-5px;">
											<i><samp class="small" style="color:silver;">Port:  <?php echo $conf_dbserver['dbserver_port']?></samp></i>													
										</div>
										<?php
									}else{
										?>
										<div>
											<?php
											$startstop_db_button = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" style="display:inline;" role="form">';
											$startstop_db_button .= '<input type="hidden" name="action[request][0][type]" value="include" />';
											$startstop_db_button .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(dirname(__DIR__) . '\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-start.php') . '" />';
											$startstop_db_button .= '<button type="submit" class="btn btn-success btn-xs" style="padding-left:10px;padding-right:10px;" onclick="delay()" style="padding-left:20px;padding-right:20px;"><span class="glyphicon glyphicon-play small" aria-hidden="true"></span>&nbsp;&nbsp;start&nbsp;</button>';
											$startstop_db_button .= '</form>';
											echo $startstop_db_button;
											?>
											&nbsp;
											<a href="index.php?zone=applications&page=dbserver&serverfolder=<?php echo $conf_dbserver['dbserver_folder'] ?>" class="btn btn-default btn-xs" style="padding:2px 6px 0px 6px;" data-toggle="tooltip" data-placement="top" title="Server Settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
											&nbsp;
											<a href="index.php?zone=applications&page=dbserver" class="btn btn-default btn-xs" style="padding-top:2px;padding-bottom:0px;" data-toggle="tooltip" data-placement="top" title="Change Server"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>

											<div style="margin-top:5px;">
												<i style="color:#ecf0f1;"><samp class="small"><?php echo $app_settings['app_name'] . ' ' . $app_settings['app_version']; ?></samp></i>			
											</div>
											<div style="margin-top:-5px;">
												<i><samp class="small" style="color:#ecf0f1;">Port: <?php echo $conf_dbserver['dbserver_port']?></samp></i>			
											</div>
										</div>
										<?php
									}
									?>
								</td>
							</tr>
						</table>				
					</div>								
				</div>								
			

				<?php
				// Add ALIAS
				if (isset($_GET['to']) AND $_GET['to'] == 'add_alias'){
					?>
					<br />
					
					<div class="row" style="background-color:#f7f7f7;border-radius:4px;">
					
						<div class="col-sm-6 col-sm-offset-3">
							<h3>Add Working Directory</h3>
							<?php
							if (isset($_GET['alias_error']) AND ($_GET['alias_error'] == 'alias_exists')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> This name is already taken!</div>';	
							}
							if (isset($_GET['alias_error']) AND ($_GET['alias_error'] == 'alias_name_empty')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Working directory name <b>empty</b></div>';
							}
							if (isset($_GET['alias_error']) AND ($_GET['alias_error'] == 'alias_path_empty')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Working directory path <b>empty</b></div>';
							}
							if (isset($_GET['alias_error']) AND ($_GET['alias_error'] == 'alias_nofolder')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> This directory <b>doesn\'t exist</b></div>';
							}							
							
							?>
							<form method="post" action="index.php" role="form" id="alias-form">
								<div class="form-group">
									<label for="alias_name"><span class="badge small">1</span> Working directory name</label>
									<p style="color:silver;padding-left:25px;margin-bottom:0px;">Example: "Project Alpha"</p>
									<p style="color:silver;padding-left:25px;"><b>Note</b>: the prefix 'edsa-' will be added to the name in order to avoid any conflict.</p>
									<div class="input-group" style="padding-left:25px;">
										<span class="input-group-addon input-sm">edsa-</span>
										<input type="text" class="form-control input-sm" id="alias_name" name="alias_name" placeholder="working directory name" />
									</div>
								</div>
								<div class="form-group">
									<label for="alias_path"><span class="badge small">2</span> Path to the working directory</label>
									<p style="color:silver;padding-left:25px;">Example: "D:\Development\Project-Alpha"</p>
									<div class="input-group" style="padding-left:25px;">
										<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></span>
										<input type="text" class="form-control input-sm" id="alias_path" name="alias_path" placeholder="working directory path" />
									</div>
								</div>
								<div class="text-center"><button type="submit" onclick="delay()" class="btn btn-primary btn-sm">save</button> <a href="index.php" class="btn btn-default btn-sm">cancel</a></div>
							</form>	
							<br />
						</div>
					</div>					
					<?php
				}
				?>				
					
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h3>WORKING DIRECTORIES</h3>
						
							<p class="text-muted">Organise your working environment by listing your working directories below. All files in your working directories will be interpreted by the server. <b>Warning</b>: if you use a removable drive, use the "Portable Directory" below.</p>

							<ul class="list-group" style="margin-bottom:5px;">
									<?php
									if (file_exists('store_alias.php')) {
										$alias_serialized = file_get_contents('store_alias.php');
										if ($alias_serialized != '') {
											foreach (unserialize($alias_serialized) as $key => $alias) {
												?>
												<li class="list-group-item" style="padding:0px 10px 0px 0px;">
													<table class="table table-condensed" style="padding:0px;margin-bottom:0px;">
														<tr>												
														<?php
														if (file_exists(urldecode($alias['alias_path']))) {
															// Directory exists
															if ($eds_httpserver_running == 1) {
																?>
																<td data-toggle="tooltip" data-placement="left" title="Expand">										
																	<a data-toggle="collapse" href="#collapse_alias_<?php echo $key ?>" aria-expanded="false" aria-controls="collapse_alias_<?php echo $key ?>"><span class="glyphicon glyphicon-menu-hamburger" style="color:#95a5a6;" aria-hidden="true"></span></a>
																</td>
																<td style="width:40%">
																	<a href="http://127.0.0.1:<?php echo $conf_httpserver['httpserver_port'] ?>/<?php echo $alias['alias_name'] ?>" class="list_alias_name" data-toggle="tooltip" data-placement="top" title="Open in Browser"><b><?php echo wordwrap(substr($alias['alias_name'],5), 20, "<br />", true); ?></b></a>
																</td>
																<?php
															} else {
																?>
																<td>
																	<span class="glyphicon glyphicon-ban-circle" style="color:gray;opacity:0.5" aria-hidden="true"></span>
																</td>
																<td style="width:40%">
																	<span class="list_alias_name" style="opacity:0.5" data-toggle="tooltip" data-placement="top" title="Start an HTTP server!"><b><?php echo substr($alias['alias_name'],5) ?></b></span>
																</td>
																<?php
															}
															?>
															<td>
																<span class="glyphicon glyphicon-list small" style="color:silver;" aria-hidden="true"></span>
															</td>
															<td style="width:60%">
																<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form" style="display:inline" name="alias_<?php echo $key ?>">
																	<input type="hidden" name="action[request][0][type]" value="exe" />
																	<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . urldecode($alias['alias_path'])) ?>" />
																	<a type="submit" role="submit" class="list_alias_directory"  data-toggle="tooltip" data-placement="top" title="Open in File Explorer" onclick="delay();document.forms['alias_<?php echo $key ?>'].submit()"><samp class="small"><?php echo wordwrap(urldecode($alias['alias_path']), 50, "<br />", true); ?></samp></a>
																</form>		
															</td>
															<td class="text-right">
																<a role="button" tabindex="0" style="cursor:pointer;" class="delete_alias glyphicon glyphicon-remove" aria-hidden="true" data-toggle="popover" data-trigger="focus" data-html="true" data-placement="top" data-content="<div class='text-center'><a href='?delete_alias=<?php echo $key ?>' style='color:white;' class='btn btn-danger btn-sm'>delete</a></div>"></a>
															</td>
															<?php
														} else {
															// Directory doesn't exist
															?>
															<td>
																<span class="glyphicon glyphicon-eye-close" style="color:#e74c3c;opacity:0.5" aria-hidden="true"></span>
															</td>
															<td style="width:40%">														
																<span class="list_alias_name_broken" style="opacity:0.5" data-toggle="tooltip" data-placement="top" title="The folder doesn't exist. Check your folder or delete this working directory and create a new one."><b><?php echo wordwrap(substr($alias['alias_name'],5), 20, "<br />", true); ?></b></span>
															</td>
															<td>	
																<span class="glyphicon glyphicon-list small" aria-hidden="true" style="color:silver;padding-right:0px;"></span>														
															</td>														
															<td style="width:60%">													
																<samp class="small" style="color:silver;"><?php echo wordwrap(urldecode($alias['alias_path']), 50, "<br />", true); ?></samp>
															</td>
															<td class="text-right">
																<a role="button" tabindex="0" style="cursor:pointer;" class="delete_alias glyphicon glyphicon-remove" aria-hidden="true" data-toggle="popover" data-trigger="focus" data-html="true" data-placement="top" data-content="<div class='text-center'><a href='?delete_alias=<?php echo $key ?>' style='color:white;' class='btn btn-danger btn-sm'>delete</a></div>"></a>
															</td>
															<?php
														}
														?>
														</tr>
													</table>

													<div class="collapse" id="collapse_alias_<?php echo $key ?>">
														<iframe src="explorer.php?alias=<?php echo $alias['alias_name'] ?>&root_dir=<?php echo urldecode($alias['alias_path']) ?>" style="width:100%;" frameborder="0" scrolling="auto" height="400"></iframe>
													</div>												
													
												</li>
												<?php
											}
										}
									}
								?>
							</ul>
							<a href="?to=add_alias" style="float:right" class="btn btn-default btn-xs" href="#" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> add directory</a>
							<br />
							<br />
							<p class="text-muted">If you use a removable drive, store your files in the directory indicated below.</p>
							<ul class="list-group">
								<li class="list-group-item" style="padding:0px;">
									<table class="table table-condensed" style="padding:0px;margin-bottom:0px;">
										<tr>
											<?php
											if ($eds_httpserver_running == 1) {
												?>
												<td data-toggle="tooltip" data-placement="left" title="Expand">										
													<a data-toggle="collapse" href="#collapse_portabledirectory" aria-expanded="false" aria-controls="collapse_portabledirectory"><span class="glyphicon glyphicon-menu-hamburger" style="color:#95a5a6;" aria-hidden="true"></span></a>
												</td>
												<td style="width:30%">
													<a href="http://127.0.0.1:<?php echo $conf_httpserver['httpserver_port'] ?>" class="list_alias_name" data-toggle="tooltip" data-placement="top" title="Open in Browser"><b>Portable Directory</b></a>
												</td>
												<?php
											} else {
												?>
												<td>										
													<span class="glyphicon glyphicon-ban-circle" style="color:#95a5a6;opacity:0.5;" aria-hidden="true"></span>
												</td>
												<td style="width:30%">
													<span class="list_alias_name" style="opacity:0.5" data-toggle="tooltip" data-placement="top" title="Start an HTTP server!"><b>Portable Directory</b></span>
												</td>
												<?php
											}
											?>
											<td>
												<span class="glyphicon glyphicon-list small" aria-hidden="true" style="color:silver;padding-right:0px;"></span>
											</td>
											<td style="width:70%">
												<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form" style="display:inline" name="localweb">
													<input type="hidden" name="action[request][0][type]" value="exe" />
													<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . dirname(__DIR__) . '\eds-www') ?>" />
													<a type="submit" role="submit" class="list_alias_directory"  data-toggle="tooltip" data-placement="top" title="Open in File Explorer" onclick="delay();document.forms['localweb'].submit()"><samp class="small"><?php echo dirname(__DIR__)?>\eds-www</samp></a>
												</form>	
											</td>												
										</tr>
									</table>
									
									<div class="collapse" id="collapse_portabledirectory">
										<iframe src="explorer.php?root_dir=<?php echo urlencode(dirname(__DIR__).'\eds-www\\') ?>" style="width:100%;" frameborder="0" scrolling="auto" height="400"></iframe>
									</div>

								</li>
							</ul>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h3>MODULES</h3>
						<?php
						//= MODULES ======================================================================================== 
						
						$modules = opendir("../eds-modules");
						$modules_folders = array();
						
						while ($modules_file = @readdir($modules)){
							if (($modules_file != '..') && ($modules_file != '.') && ($modules_file != '') && (@is_dir("../eds-modules/".$modules_file)) && @file_exists("../eds-modules/".$modules_file."/eds-module.php")){ 
								$modules_folders[] = $modules_file;
							}
							sort($modules_folders);
						}
						
						@closedir($modules);
						clearstatcache();

						if (count($modules_folders) == 0) {
							echo "<div class='modules_none'>" . $module_none . "<a href='http://warehouse.easyphp.org' target='_blank' class='add_link'>". $menu_module_add ."</a></div>";
						} else {
							foreach ($modules_folders as $module_folder) {
								include('../eds-modules/' . $module_folder . '/eds-module.php');
							}
						}
						
						?>
						<p class="text-right"><a href="http://warehouse.easyphp.org" target="_blank" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-plus"></span> add modules</a></p>
						<?php
						
						//==================================================================================================
						?>					
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h3>PHP CODE TESTER</h3>				
						<p class="text-muted">To quickly test a piece of code, use the editor below.<br /><small style="color:silver;">PHP version : 5.6.26 (if you need an higher version, test your code in a "Working Directory" or the "Portable Directory").</small></p>
						<?php	
						
						//= CODE TESTER ====================================================================================== 
						?>
						<div class="col-sm-3 text-muted" style="font-size:90%;padding:0px 20px 0px 0px;text-align:justify;">
							<b>Reminders :</b>
							<ul>
							<li>The PHP code needs to be enclosed in special tags :<br /><kbd>&lt;?php</kbd> and <kbd>?&gt;</kbd>.</li>
							<li>Devserver is configured in such a way that all errors are reported (errors, warnings, notices...). Some of the notices and warnings may seem trivial at first, but they reveal holes in your code. We strongly encourage best practice coding standards in order to obtain a consistent, clean and portable code.</li>
							</ul>
						</div>
						
						<?php
						$code_example = 'Example :<br />' . "\n";
						$code_example .= '<?php' . "\n";
						$code_example .= 'echo "The current date is ";' . "\n";
						$code_example .= 'echo date("l F d, Y");' . "\n";
						$code_example .= '?>';
						?>
					
						<div class="col-sm-9" style="padding:20px 0px 0px 0px;">
							<form  method="post" action="codetester.php">
								<textarea style="display:none" name="sourcecode" id="editor_php_content"></textarea>
								<div style="background-color:#2c3e50;padding:10px;border-radius:4px;">
								<div id="editor_php" style="height:250px;"><?php echo htmlentities($code_example) ?></div>
								</div>
								<input type="hidden" name="nonce" value="<?php echo get_nonce(); // Russell, 2012-11-10 ?>" />
								<input type="hidden" name="to" value="interpretcode" />
								<input type="submit" class="btn btn-default btn-sm" style="margin-top:4px;" value="interpret" class="submit" />
							</form>
						</div>
						
						<?php
						//==================================================================================================
						?>					
					</div>
		
				</div>				
				
				
			</div> <!-- /container -->
				
			<?php
		}
		?>
		
		<br />
		<br />

		<div class="row" style="margin:0px;">
			<div class="col-sm-12 text-center text-muted">
				<small><em>EasyPHP 2000 - 2017 | <a href="http://www.easyphp.org" target="_blank" class="EasyPHP" title="EasyPHP">www.easyphp.org</a></em></small>
				<br />
				<small><samp>DEVSERVER <?php echo $edsini['Version'] ?> <i>lite</i></samp></small>
				<br />
				<a href="http://www.easyphp.org" target="_blank" class="EasyPHP" title="EasyPHP"><img src="images/logo_easyphp.png" alt="EasyPHP" border="0" /></a>
			</div>
		</div>
		
		<br />
		
		<div style="position:fixed;bottom:0px;right:15px;text-align:right">
			<a role="button" data-toggle="collapse" href="#systrayinfo" aria-expanded="false" aria-controls="systrayinfo" style="font-size:30px;color:#2980b9;line-height:50px;"><span class="glyphicon glyphicon-dashboard"></span></a>
			<div class="collapse" id="systrayinfo">
				<div style="background-color:#ecf0f1;padding:10px;margin-bottom:15px;width:90px;text-align:left;border-radius:4px;font-size:90%;color:#34495e;">
					Use the icon <img src="images/favicon.png" /> in the system tray below to control EasyPHP Devserver.
				</div>
			</div>
		</div>
		
		
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="library/jquery/jquery.min.js"></script>
		
		<script src="library/ace/ace.js" type="text/javascript" charset="utf-8"></script>
	
		<script>
			var editor_php = ace.edit("editor_php");
			document.getElementById('editor_php').style.fontSize='14px';
			editor_php.setTheme("ace/theme/twilight");
			editor_php.getSession().setMode("ace/mode/php");
			editor_php.setHighlightActiveLine(false);
			var textarea_php = $('#editor_php_content');
			editor_php.getSession().on('change', function () {
				textarea_php.val(editor_php.getSession().getValue());
			});
			textarea_php.val(editor_php.getSession().getValue());
		</script>		
		
		<script src="library/bootstrap/js/bootstrap.min.js"></script>
		
		<script>
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
		</script>
		<script>
			$(function () {
			  $('[data-toggle="popover"]').popover()
			})		
		</script>	

	</body>
</html>