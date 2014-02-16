<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

include("functions.inc.php");

/**
 * Russell, 2012-11-10: nonce functionality relies on sessions
 * Also added a hidden input called nonce in rendered html below
 */
session_start();
                                  
if (isset($HTTP_GET_VARS)){ while(list($name, $value) = each($HTTP_GET_VARS)) { $$name = $value; } }
if (!isset($_GET['to'])) $_GET['to'] = '';
if (!isset($_GET['page'])) $_GET['page'] = '';
if (!isset($_GET['recommendedmodules'])) $_GET['recommendedmodules'] = '';
if (!isset($_GET['display'])) $_GET['display'] = '';
if (!isset($_GET['editnotes'])) $_GET['editnotes'] = '';
if (!isset($_POST['to'])) $_POST['to'] = '';
if (!isset($_GET['exts'])) $_GET['exts'] = '';
if (!isset($_GET['exts'])) $directory = '';

if ($_GET['display'] == "phpinfo") {
	ob_start();
	phpinfo();
	$phpinfo = ob_get_contents();
	ob_end_clean();
	preg_match_all("=<body[^>]*>(.*)</body>=siU", $phpinfo, $tab);
	$phpinfo = $tab[1][0];
	$phpinfo = str_replace(";", "; ", $phpinfo);
	$phpinfo = str_replace(",", ", ", $phpinfo);
}

if ($_GET['display'] == "phpcredits") {
	ob_start();
	phpcredits(CREDITS_ALL - CREDITS_FULLPAGE);
	$phpcredits = ob_get_contents();
	ob_end_clean();
	$phpcredits = str_replace('<h1>PHP Credits</h1>', '', $phpcredits);
}


$modules = @opendir("../../modules");
$modules_files = array();
while ($modules_file = @readdir($modules)){
	if (($modules_file != '..') && ($modules_file != '.') && ($modules_file != '') && (@is_dir("../../modules/".$modules_file)) && @file_exists("../../modules/".$modules_file."/easyphp+.php")){ 
		$modules_files[] = $modules_file;
	}
	sort($modules_files);
}
@closedir($modules);
clearstatcache();


// Notifications
include("notification.php"); 
if (date('Ymd') != $notification['check_date']) {

	$context = stream_context_create(array('http' => array('timeout' => 1)));
	$content = @file_get_contents('http://www.easyphp.org/notifications/notification-devservervc9.txt', 0, $context);
	
	if (!empty($content)) {
		$content_array = explode('#', $content);
				
		if ($content_array[0] != $notification['date']) {
			$new_notification = fopen('notification.php', "w");
			$new_content = '<?php $notification = array(\'check_date\'=>\'' . date('Ymd') . '\',\'date\'=>\'' . $content_array[0] . '\',\'status\'=>\'1\',\'link\'=>\'' . $content_array[1] . '\',\'message\'=>\'' . $content_array[2] . '\'); ?>';
			fputs($new_notification,$new_content);
			fclose($new_notification);	
			$redirect = "http://" . $_SERVER['HTTP_HOST'] . "/home/index.php";
			header("Location: " . $redirect); 
			exit;	
		}
	}
	
	$new_notification = fopen('notification.php', "w");
	$new_content = '<?php $notification = array(\'check_date\'=>\'' . date('Ymd') . '\',\'date\'=>\'' . $notification['date'] . '\',\'status\'=>\'' . $notification['status'] . '\',\'link\'=>\'' . $notification['link'] . '\',\'message\'=>\'' . $notification['message'] . '\'); ?>';
	fputs($new_notification,$new_content);
	fclose($new_notification);
};

include("i18n.inc.php");
include("versions.inc.php"); 

// Document root
$localweb_path = str_replace('/', '\\', dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME']))) . '\data\localweb\\');
$localweb = @opendir($localweb_path);
$localweb_files = array();
while ($file = @readdir($localweb)){
	if (($file != '..') && ($file != '.') && ($file != '') && (@is_dir($localweb_path . "/" . $file))){ 
		// XSS vulnerability fixed
		// http://blog.madpowah.org/archives/2011/07/index.html#e2011-07-20T00_31_36.txt
		$localweb_files[] = addslashes($file);
	}
	sort($localweb_files);
}
@closedir($localweb);
clearstatcache();

include("alias.inc.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>DevServer - <?php echo $administration ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="images_easyphp/easyphp_favicon.ico" />
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>

<div id="top">
	<div class="container">
		<?php
		// Notification
		if ($notification['status'] == 1) {
			?>
			<div class="infobulle_notification_on"><a class="info" href="notification_redirect.php" target="_blank" onclick="setTimeout('history.go(0);',1500)">!<span><?php echo $notification['message']; ?><div><?php echo $download; ?></div></span></a></div>
			<?php
		} else {
			?>
			<div class="infobulle_notification_off"><a class="info" href="notification_redirect.php" target="_blank">!<span><?php echo $notification['message']; ?><div><?php echo $download; ?></div></span></a></div>
			<?php
		}
		?>
		<img src="images_easyphp/top_title.png" width="226" height="40" alt="EasyPHP" border="0" class="title" />
		<div class="website"><a href="http://www.easyphp.org" target="_blank">www.easyphp.org</a></div>
		<div class="help"><a href="<?php echo $lang ?>/index.html" target="_blank"><?php echo $help ?></a></div>
		<?php echo $lang_select; ?>	
		
		<div class="social_links">
			<a href="http://www.facebook.com/easywamp" target="_blank" class="facebook" title="facebook">f</a>
			<a href="http://www.twitter.com/easyphp" target="_blank" class="twitter" title="twitter">t</a>
			<a href="http://wwwgoogle.com/+easyphp" target="_blank" class="googleplus" title="google+">g</a>
			<a href="http://www.easyphp.org/subscribe.php" target="_blank" class="newsletter" title="newsletter">newsletter</a>
		</div>
		
		<br style="clear:both;" />
	</div>
</div>

<div id="main">

	<?php 
	//= CONFIGURATION ======================================================================================= 		
	$myini_array = file("../mysql/my.ini");
	$key_datadir =  key(preg_grep("/^datadir/", $myini_array));
	$mysql_datadir_array = explode("\"",$myini_array[$key_datadir]);
	$mysql_datadir = str_replace("/","\\", $mysql_datadir_array[1]);
	//======================================================================================================= ?>
	
	<?php
	// DONATION
	if ($_GET['to'] == "donate") {
		?>
		<div class="menu_donation">
			<div class='title'><?php echo $t_donation; ?></div>
			<div class='close'><a href='index.php'><?php echo $close; ?></a></div>
		
			<div class="donation">
				<p><?php echo $donate_text; ?></p>
				<a href="https://sourceforge.net/donate/index.php?group_id=14045&amt=5&type=0" title="Donate 5 USD"><img src="images_easyphp/don_5.png" width="34" height="13" alt="Donate 5 USD" title="Donate 5 USD" border="0" /></a><a href="https://sourceforge.net/donate/index.php?group_id=14045&amt=10&type=0" title="Donate 10 USD"><img src="images_easyphp/don_10.png" width="34" height="13" alt="Donate 10 USD" title="Donate 10 USD" border="0" /></a><a href="https://sourceforge.net/donate/index.php?group_id=14045&amt=20&type=0" title="Donate 20 USD"><img src="images_easyphp/don_20.png" width="34" height="13" alt="Donate 20 USD" title="Donate 20 USD" border="0" /></a><a href="https://sourceforge.net/donate/index.php?group_id=14045&amt=50&type=0" title="Donate 50 USD"><img src="images_easyphp/don_50.png" width="34" height="13" alt="Donate 50 USD" title="Donate 50 USD" border="0" /></a><a href="https://sourceforge.net/donate/index.php?group_id=14045&amt=100&type=0" title="Donate 100 USD"><img src="images_easyphp/don_100.png" width="34" height="13" alt="Donate 100 USD" title="Donate 100 USD" border="0" /></a><a href="https://sourceforge.net/donate/index.php?group_id=14045&amt=250&type=0" title="Donate 250 USD"><img src="images_easyphp/don_250.png" width="34" height="13" alt="Donate 250 USD" title="Donate 250 USD" border="0" /></a>
			</div>
		</div>
		</div></body></html>
		<?php
		exit; // close tags
	}
	?>

	<div id="banner">
		<?php
		if ($_GET['page'] == 'server-page' OR $_GET['page'] == 'database-page' OR $_GET['page'] == 'php-page') {
			?>
			<div style="float:left;width:150px;padding:0px 10px 0px 0px;">
			
				<div class='back'>
					<a href="index.php" title="<?php echo $t_back; ?>">
					<img src="images_easyphp/back.png" width="12" height="12" alt="<?php echo $t_back; ?>" title="<?php echo $t_back; ?>" border="0" />
					</a>
				</div>
				<div class="block" style="padding:0px 0px 0px 3px;text-align:right;">
					<?php
					$block_style = ($_GET['page'] == "server-page") ? "block_on":"block_off";
					echo '<span class="' . $block_style . '">' . $t_banner_app_apache . '</span>';
					?>
					<a href='index.php?page=server-page' class='settings'><img src="images_easyphp/edit.png" width="10" height="13" border="0" /></a>
				</div>
			
				<div class="block" style="float:none;text-align:right;">
					<?php
					$block_style = ($_GET['page'] == "database-page") ? "block_on":"block_off";
					echo '<span class="' . $block_style . '">' . $t_banner_app_mysql . '</span>';
					?>
					<a href='index.php?page=database-page' class='settings'><img src="images_easyphp/edit.png" width="10" height="13" border="0" /></a>
				</div>	
				
				<div class="block" style="float:none;text-align:right;">
					<?php
					$block_style = ($_GET['page'] == "php-page") ? "block_on":"block_off";
					echo '<span class="' . $block_style . '">' . $t_banner_php . '</span>';
					?>
					<a href='index.php?page=php-page' class='settings'><img src="images_easyphp/edit.png" width="10" height="13" border="0" /></a>
				</div>	

			</div>
			<?php
		} else {
			?>
			<div class="block" style="width:160px;margin:0px 0px 0px 120px;padding:0px 0px 0px 0px;">
				<span class="block_main"><?php echo $t_banner_app_apache; ?></span>
				<span class="infobulle_options"><a class="info" href="index.php?page=server-page"><img src="images_easyphp/edit.png" width="10" height="13" border="0" /><span>
					<?php echo $t_apache_folder; ?> : <b><?php echo $easyphp_path; ?></b><br /><br />
					<?php echo $hostname; ?> : <b><?php echo $_SERVER['SERVER_NAME'] ?></b><i>*</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $portnum; ?> : <b><?php echo $_SERVER['SERVER_PORT'] ?></b><i>**</i>
					<p><i>*</i> <?php echo $hostname_help; ?></p>
					<p><i>**</i> <?php echo $t_settings_info_port80; ?></p>					
					<div><?php echo $t_settings_link; ?></div>
				</span></a></span>
				<span class='app'><?php echo $version_apache; ?></span>	
			</div>
		
			<div class="block" style="width:160px;padding:0px 0px 0px 0px;">
				<span class="block_main"><?php echo $t_banner_app_mysql; ?></span>
				<span class="infobulle_options"><a class="info" href="index.php?page=database-page"><img src="images_easyphp/edit.png" width="10" height="13" border="0" /><span>
					<?php echo $t_mysql_default_param_bulle; ?>
					<ul>
					<li><?php echo $mysql_username; ?> : <b>root</b></li>
					<li><?php echo $mysql_password; ?> : &nbsp;&nbsp; <i>*</i></li>
					<li><?php echo $mysql_host; ?> : <b><?php echo $_SERVER['SERVER_NAME'] ?></b> <i>**</i></li>
					</ul>
					<p><i>*</i> <?php echo $mysql_password_help; ?></p>
					<p><i>**</i> <?php echo $hostname_help; ?></p>
					<div><?php echo $t_settings_link; ?></div>
				</span></a></span>
				<span class='app'><?php echo $version_mysql; ?></span>
			</div>	
			
			<div class="block" style="width:180px;padding:0px 0px 0px 0px;">
				<span class="block_main"><?php echo $t_banner_php; ?></span>
				<span class="infobulle_options"><a class="info" href="index.php?page=php-page"><img src="images_easyphp/edit.png" width="10" height="13" border="0" /><span>
					<?php echo $t_ct_reminders_text_2; ?><br /><br />
					<?php echo $t_settings_info_applicationerrors; ?><br /><br />
					<?php echo $t_settings_info_errors; ?>
					<div><?php echo $t_settings_link; ?></div>
				</span></a></span>
				<span class='app'><?php echo phpversion() ?><a href='index.php?page=php-page&display=changephpversion' class='settings_link' style="font-size:10px;background-color:#F3F3F3;"><?php echo $t_settings_change; ?></a></span>
			</div>
			<?php
		}
		?>
	</div>
		
	<div style="float:left;width:600px;">
	
		<?php
		// ///////////////////////////////////////////////////////////////////////
		// ////  SERVER PAGE  ////////////////////////////////////////////////////
		// ///////////////////////////////////////////////////////////////////////
		if ($_GET['page'] == "server-page") {
			?>
			<div class="settings" style='padding:0px 0px 0px 0px;'>
			
				<div class='left' style='color:black;font-size:18px;font-weight:bold;padding:0px;margin:0px;'><?php echo $t_banner_app_apache; ?>&nbsp;</div>
				<div class='right' style='color:black;font-size:18px;font-weight:bold;padding:0px;margin:0px;'></div>

				<div class='left'><?php echo $t_apache_parameters; ?> :</div>
				<div class='right'>
					&nbsp;&nbsp;<?php echo $hostname; ?> :<span class="config"><?php echo $_SERVER['SERVER_NAME'] ?></span><span class="infobulle_info"><a class="info" href="#">!<span><?php echo $hostname_help; ?></span></a></span>
					&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $portnum; ?> :<span class="config"><?php echo $_SERVER['SERVER_PORT'] ?></span>
				</div>
				
				<div class='left'><?php echo $t_apache_folder; ?> :</div>
				<div class='right'><span class="path"><?php echo $easyphp_path; ?></span></div>

				<div class='left'>
					<?php echo $t_apache_conffile; ?><span class="infobulle_settings"><a class="info" href="#">?<span><?php echo $t_apache_conffile_bulle; ?></span></a></span><b> : </b>
				</div>
				<div class='right'>
					<a href='index.php?page=server-page&display=apacheconffile' class="settings_link"><?php echo $t_settings_display; ?></a>
					<a href='index.php?page=server-page&display=apacheconfmodify' class="settings_link"><?php echo $t_settings_modify; ?></a>
				</div>					
				
				<div class='left'>
					<?php echo $t_apache_logfiles; ?><span class="infobulle_settings"><a class="info" href="#">?<span><?php echo $t_apache_logfiles_bulle; ?></span></a></span><b> : </b>
				</div>
				<div class='right' style='width:320px;'>
					<a href='index.php?page=server-page&display=apacheerrorlog' class="settings_link"><?php echo $t_settings_apacheerrorlog; ?></a>
					<a href='index.php?page=server-page&display=apacheaccesslog' class="settings_link"><?php echo $t_settings_apacheaccesslog; ?></a>
				</div>

			</div>
			<br style='clear:both;' />
			
			<?php
			// DISPLAY : MODIFY APACHE CONFIGURATION
			if ($_GET['display'] == "apacheconfmodify") {
				?>	
				<div class='menu_display'>
					<h5><?php echo $menu_apacheconf ?><span class="warningbulle"><a class="info" href="#">!<span><?php echo $ao_warning; ?></span></a></span></h5>
					<div class="apacheconf">
						<?php include ("apacheconfmanager.php"); ?>
					</div>
				</div>
				<?php
			}
		
			// DISPLAY : APACHE CONFIGURATION FILE
			if ($_GET['display'] == "apacheconffile") {
				?>			
				<div class='menu_display'>
					<h5><?php echo $t_apache_conffile; ?></h5>
					<pre><?php echo htmlspecialchars(file_get_contents('../conf_files/httpd.conf', FILE_USE_INCLUDE_PATH)); ?></pre>
				</div>
				<?php
			}
			
			// DISPLAY : APACHE ERROR LOG
			if ($_GET['display'] == "apacheerrorlog") {
				?>			
				<div class='menu_display'>
					<h5><?php echo $t_settings_apacheerrorlog; ?></h5>
					<pre><?php echo htmlspecialchars(file_get_contents('../apache/logs/error.log', FILE_USE_INCLUDE_PATH)); ?></pre>
				</div>
				<?php
			}

			// DISPLAY : APACHE ACCESS LOG
			if ($_GET['display'] == "apacheaccesslog") {
				?>
				<div class='menu_display'>
					<h5><?php echo $t_settings_apacheaccesslog; ?></h5>	
					<pre><?php echo htmlspecialchars(file_get_contents('../apache/logs/access.log', FILE_USE_INCLUDE_PATH)); ?></pre>
				</div>
				<?php
			}
			?>


			</div></body></html>
			<?php
			exit; // close tags
		}		
		

		// ///////////////////////////////////////////////////////////////////////
		// ////  DATABASE PAGE  //////////////////////////////////////////////////
		// ///////////////////////////////////////////////////////////////////////
		if ($_GET['page'] == "database-page") {
			?>
			<div class="settings" style='padding:0px 0px 0px 0px;'>
			
				<div class='left' style='color:black;font-size:18px;font-weight:bold;padding:0px;margin:0px;'><?php echo $t_banner_app_mysql; ?>&nbsp;</div>
				<div class='right' style='color:black;font-size:18px;font-weight:bold;padding:0px;margin:0px;'></div>

				<div class='left'>
					<?php echo $t_mysql_default_param; ?></span>
					<span class="infobulle_settings"><a class="info" href="#">?<span><?php echo $t_mysql_default_param_bulle; ?></span></a></span><b> : </b>
				</div>
				<div class='right'>
					&nbsp;&nbsp;<?php echo $mysql_username; ?> : <span class="config">root</span>
					&nbsp;&nbsp;<?php echo $mysql_password; ?> : <span class="config">&nbsp;&nbsp;</span><span class="infobulle_info"><a class="info" href="#">!<span><?php echo $mysql_password_help; ?></span></a></span>
					&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mysql_host; ?> : <span class="config"><?php echo $_SERVER['SERVER_NAME'] ?></span><span class="infobulle_info"><a class="info" href="#">!<span><?php echo $hostname_help; ?></span></a></span>
				</div>
				
				<div class='left'>
					<?php echo $t_mysql_datadir; ?></span>
					<span class="infobulle_settings"><a class="info" href="#">?<span><?php echo $t_mysql_datadir_bulle; ?></span></a></span><b> : </b>
				</div>
				<div class='right'>
					<span class="path"><?php echo $mysql_datadir; ?></span>
				</div>

				<div class='left'>
					<?php echo $t_mysql_conffile; ?><span class="infobulle_settings"><a class="info" href="#">?<span><?php echo $t_mysql_conffile_bulle; ?></span></a></span><b> : </b>
				</div>
				<div class='right'>
					<a href='index.php?page=database-page&display=mysqlconffile' class="settings_link"><?php echo $t_settings_display; ?></a>
					<a href='index.php?page=database-page&display=mysqlconfmodify' class="settings_link"><?php echo $t_settings_modify; ?></a>
				</div>	
								
				<div class='left'>
					<?php echo $t_mysql_logfile; ?>
					<span class="infobulle_settings"><a class="info" href="#">?<span><?php echo $t_mysql_logfile_bulle; ?></span></a></span><b> : </b>
				</div>
				<div class='right'><a href='index.php?page=database-page&display=mysqlerrorlog' class="settings_link"><?php echo $t_settings_display; ?></a></div>
				
			</div>
			<br style='clear:both;' />


			<?php
			// DISPLAY : MYSQL CONFIGURATION FILE
			if ($_GET['display'] == "mysqlconffile") {
				?>			
				<div class='menu_display'>
					<h5><?php echo $t_mysql_conffile; ?></h5>
					<pre><?php echo htmlspecialchars(file_get_contents('../mysql/my.ini', FILE_USE_INCLUDE_PATH)); ?></pre>
				</div>
				<?php
			}
			
			// DISPLAY : MODIFY MYSQL CONFIGURATION
			if ($_GET['display'] == "mysqlconfmodify") {
				?>	
				<div class='menu_display'>
					<h5><?php echo $menu_mysqlconf ?><span class="warningbulle"><a class="info" href="#">!<span><?php echo $ao_warning; ?></span></a></span></h5>
					<div class="mysqlconf">
						<?php include ("myinimanager.php"); ?>
					</div>
				</div>
				<?php
			}
			
			// DISPLAY : MYSQL ERROR LOG
			if ($_GET['display'] == "mysqlerrorlog") {
				?>			
				<div class='menu_display'>
					<h5><?php echo $t_mysql_logfile; ?></h5>
					<pre><?php echo file_get_contents('../mysql/data/mysql_error.log', FILE_USE_INCLUDE_PATH); ?></pre>
				</div>
				<?php
			}
			?>
			</div></body></html>
			<?php
			exit; // close tags
		}


		// ///////////////////////////////////////////////////////////////////////
		// ////  PHP PAGE  ///////////////////////////////////////////////////////
		// ///////////////////////////////////////////////////////////////////////
		if ($_GET['page'] == "php-page") {
			?>
			<div class="settings" style='padding:0px 0px 0px 0px;'>
			
				<div class='left' style='color:black;font-size:18px;font-weight:bold;padding:0px;margin:0px;'><?php echo $t_banner_app_php; ?>&nbsp;</div>
				<div class='right' style='color:black;font-size:18px;font-weight:bold;padding:0px;margin:0px;'></div>
			
				<div class='left'><?php echo $t_php_versions; ?></span><b> : </b></div>
				<div class='right'><span class="path"><?php echo phpversion() ?></span><a href='index.php?page=php-page&display=changephpversion' class="settings_link"><?php echo $t_settings_change; ?></a></div>		

				<div class='left'><?php echo $t_php_conffile; ?></span><span class="infobulle_settings"><a class="info" href="#">?<span><?php echo $t_php_conffile_bulle; ?></span></a></span><b> : </b></div>
				<div class='right'>
					<a href='index.php?page=php-page&display=phpconffile' class="settings_link"><?php echo $t_settings_display; ?></a><a href='index.php?page=php-page&display=phpconfmodify' class="settings_link"><?php echo $t_settings_modify; ?></a>
				</div>
				
				<div class='left'><?php echo $t_php_parameters; ?></span><b> : </b></div>
				<div class='right'><a href='index.php?page=php-page&display=phpinfo' class="settings_link"><?php echo $t_settings_configuration; ?></a><a href='index.php?page=php-page&display=extensions' class="settings_link"><?php echo $t_settings_extensions; ?></a></div>

				<div class='left'><?php echo $t_php_credits; ?></span><b> : </b></div>
				<div class='right'>
					<a href='index.php?page=php-page&display=phpcredits' class="settings_link"><?php echo $t_settings_display; ?></a>
				</div>
			</div>

			<br style='clear:both;' />
			<?php
			
			// DISPLAY : CHANGE PHP VERSION
			if ($_GET['display'] == "changephpversion") {
				?>			
				<div class='menu_display'>
					<h5><?php echo $t_php_versions; ?></h5>
					<div class='changephpversion_add'><?php echo $t_settings_addmoreversions; ?><br /><a href='http://www.easyphp.org/components.php' target='_blank' class='add_link'><?php echo $downloadninstall; ?></a></div>

					<div class='changephpversion_frame'>
					<?php
					$php_dir = @opendir("../php");
					$php_versions = array();
					while ($modules_file = @readdir($php_dir)){
						if (($modules_file != '..') && ($modules_file != '.') && ($modules_file != '') && (@is_dir("../php/".$modules_file)) && @file_exists("../php/".$modules_file."/easyphp.php")){ 
							$php_versions[] = $modules_file;
						}
						sort($php_versions);
					}
					@closedir($php_dir);
					clearstatcache();

					if (count($php_versions) > 1 ){
						echo '<b>' . $t_settings_availableversions . ' : </b><br />';
						foreach ($php_versions as $phpdir) {
							include("../php/$phpdir/easyphp.php");
							if ($phpdir == 'php_runningversion') {
								echo '<div class="version">';
								echo '<div class="selectversion"><span>' . $t_settings_selectedversion . '</span></div>';
								echo '<div class="versiontitle_on">PHP ' . $phpversion['version']. '</div>';
								echo '<div class="versiondate">' . $phpversion['date'] . '</div>';
								echo '<br style="clear:both"></div>';
							} else {
								echo '<div class="version">';
								echo '<div class="selectversion"><a href="change_php_update.php?newphpdir=' . $phpdir . '">' . $t_settings_selectversion . '</a></div>';
								echo '<div class="versiontitle_off">PHP ' . $phpversion['version'] . '</div>';
								echo '<div class="versiondate">' . $phpversion['date'] . '</div>';
								echo '<br style="clear:both"></div>';
							}
						}
					}else{
						echo '<br />';
					}
					?>
					<br style='clear:both;' />
					</div>
				</div>
				<?php
			}

			// DISPLAY : PHP INFO
			if ($_GET['display'] == "phpinfo") {
				?>
				<div class='menu_display'>
					<h5><?php echo $t_settings_configuration; ?></h5>
					<div class='phpinfo'><?php echo $phpinfo; ?></div>
				</div>
				<?php
			}

			// DISPLAY : PHP EXTENSIONS
			if ($_GET['display']=="extensions") {
				$extensions = @get_loaded_extensions();
				@sort($extensions);
				?>
				<div class='menu_display'>
					<h5><?php echo $t_settings_extensions; ?></h5>
					
					<div class='extensions'>
						<p><?php printf($extensions_nb,count($extensions)); ?></p>
						<?php			
						foreach($extensions as $extension) {
							echo "<a name=$extension></a>";
							echo "<div><img src='/images_easyphp/extension.gif' width='16' height='11' alt='extension' border='0' /><span class='extension_name'>$extension</span>&nbsp;&nbsp;[<a href='index.php?page=php-page&amp;display=extensions&amp;exts=$extension#$extension'>$extensions_functions</a>]</div>";
							if ($_GET['exts']==$extension) {
								$functions = @get_extension_funcs($_GET['exts']);
								if ($functions) {
									echo "<div class='function_name'>" .count($functions). " $extensions_functions :</div>";
									@sort($functions);
									foreach($functions as $function) {
										echo "<div class='function_name'><img src='images_easyphp/function.gif' width='16' height='11' alt='function' border='0' />" . $function . "</div>";
									}
								} else {
									echo "<div class='function_name'>No function found.</div>";
								}
								echo "<br />";
							}
						} ?>
					</div>
				</div>
				<?php
			}

			// DISPLAY : DISPLAY PHP CONFIGURATION FILE
			if ($_GET['display'] == "phpconffile") {
				?>
				<div class='menu_display'>
					<h5><?php echo $t_php_conffile; ?></h5>	
					<pre><?php echo htmlspecialchars(file_get_contents('../conf_files/php.ini', FILE_USE_INCLUDE_PATH)); ?></pre>
				</div>
				<?php
			}
			
			// DISPLAY : MODIFY PHP CONFIGURATION FILE
			if ($_GET['display'] == "phpconfmodify") {
				?>
				<div class='menu_display'>
					<h5><?php echo $menu_phpconf ?><span class="warningbulle"><a class="info" href="#">!<span><?php echo $ao_warning; ?></span></a></span></h5>
					<div class="phpconf">
						<?php include ("phpinimanager.php"); ?>
					</div>
				</div>
				<?php
			}
			
			// DISPLAY : PHP CREDITS
			if ($_GET['display'] == "phpcredits") {
				?>			
				<div class='menu_display'>
					<h5><?php echo $t_php_credits; ?></h5>
					<div class='phpinfo'><?php echo $phpcredits; ?></div>
				</div>
				</div></body></html>
				<?php
			}
			?>


			</div></body></html>
			<?php
			exit; // close tags
		}?>

	</div>

	<br style='clear:both;' />

	<div id='tips'>
		<div class='tip_0'>
			<div class='title'><?php echo $t_tip_0_title; ?></div>
			<p><?php echo $t_tip_0_text; ?></p>
			<div class='link'><?php echo $t_tip_0_link; ?></div>
		</div>
		<div class='tip_1'>
			<div class='title'><?php echo $t_tip_1_title; ?></div>
			<p><?php echo $t_tip_1_text; ?></p>
			<div class='link'><?php echo $t_tip_1_link; ?></div>
		</div>
		<div class='tip_2'>
			<div class='title'><?php echo $t_tip_2_title; ?></div>
			<p><?php echo $t_tip_2_text; ?></p>
			<div class='link'><?php echo $t_tip_2_link; ?></div>
		</div>
		<div class='tip_3'>
			<div class='title'><?php echo $t_tip_3_title; ?></div>
			<p><?php echo $t_tip_3_text; ?></p>
			<div class='link'><?php echo $t_tip_3_link; ?></div>
		</div>
		<div class='tip_4'>
			<div class='title'><?php echo $t_tip_4_title; ?></div>
			<p><?php echo $t_tip_4_text; ?></p>
			<div class='link'><?php echo $t_tip_4_link; ?></div>
		</div>		
		<br style='clear:both;' />
	</div>
	

	<h3>
		<?php echo $t_localfiles ?><span class="infobulle_section"><a class="info" href="#">?<span><?php echo $t_localfiles_intro; ?><br /><br /><?php echo $alias_intro; ?></span></a></span>
		<?php
		if ($nb_alias != 0) echo "<a href='index.php?to=add_alias_1' class='recommended'>+ " . $menu_alias_add . "</a>";
		?>
	</h3>
	<?php
	//== LOCAL FILES / ALIAS =========================================================================== ?>
	<div class='section'>
	
		<div class="alias_section">
			<?php
			read_alias();
			if ($nb_alias == 0) {
				echo "<div class='alias_none'>" . $alias_none . "<a href='index.php?to=add_alias_1' class='none_add_link'>". $menu_alias_add ."</a></div>";
			} else {
				list_alias();
			}?>
		</div>
		
	</div>
	<br style='clear:both;' />
	<?php
	//==================================================================================================
	
	//== ADD ALIAS =====================================================================================
		if ($_GET['to'] == "add_alias_1") {
			?>

			<div class='addanalias_frame'>
	
			<div class='title'><?php echo $menu_alias_add ?></div>
			<div class='close'><a href='index.php'><?php echo $close; ?></a></div>

				<div class="add_alias">
					<form method="post" action="index.php">
						<div>
							<div><span>1.</span> <?php echo $alias_1 ?></div>
							<div><span>2.</span> <?php echo $alias_2 ?></div>
							<input type="text" name="alias_name" class="input" style="width:300px" />
							<div><span>3.</span> <?php echo $alias_3 ?></div>
							<input type="text" name="alias_link" class="input" style="width:428px" />
							<input type="hidden" name="to" value="add_alias_2" />
							
							<div style="width:430px;text-align:center;padding:5px;margin:10px 0px 0px 10px;border:1px solid #EFCE1D;background-color:#FBD825;color:#895902;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">
								<?php echo $t_warning_phpini; ?>
							</div>						
											
							<input type="submit" value="<?php echo $t_warning_save; ?>" class="submit" />
						</div>
					</form>
				</div>
				<br />
			</div>
			</div></body></html>
			<?php
			exit; // close tags				
		} elseif ($_POST['to'] == "add_alias_2") {
			$addaliaswarning = '';
			if ($_POST['alias_name'] == "") {
				$addaliaswarning = $alias_warning_1;				
			} elseif ($_POST['alias_link'] == "") {
				$addaliaswarning = $alias_warning_2;						
			} elseif (($_POST['alias_link'] != "") && (!is_dir($_POST['alias_link']))) 	{
				$addaliaswarning = $alias_warning_3;					
			} elseif ($name_test == FALSE) {
				$addaliaswarning = $alias_warning_4;					
			}
			
			if ($addaliaswarning != '') {
				?>
				<div class='addanalias_frame'>
				<div class='title'><?php echo $menu_alias_add ?></div>
				<br />
				<div class='error_message_frame'>
					<div class='back'>
						<a href="javascript:history.back()" title="<?php echo $t_back; ?>">
						<img src="images_easyphp/back2.png" width="12" height="12" alt="<?php echo $t_back; ?>" title="<?php echo $t_back; ?>" border="0" />
						</a>
					</div>
					<div class='back_warning'>
						<span>
							<img src="images_easyphp/warning.png" width="12" height="12" alt="<?php echo $addaliaswarning; ?>" title="<?php echo $addaliaswarning; ?>" border="0" />
						</span>
					</div>
					<div class='error_message'><?php echo $addaliaswarning; ?></div>
					<br style='clear:both;' />
				</div>				
				<?php
			}			
			?>
			</div></body></html>
			<?php
			exit; // close tags	
		}	
	//==================================================================================================
	

	//= MODULES ======================================================================================== ?>	
	
	<h3><?php echo $t_yourmodules ?><span class="infobulle_section"><a class="info" href="#">?<span><?php echo $module_add; ?></span></a></span><a href='index.php?recommendedmodules=display' class='recommended'><?php echo $recommended_modules; ?></a></h3>
	
	<?php
	if ($_GET['recommendedmodules'] == "display") {
		?>
		<div class="recommendedmodules">
			<div class='title'><?php echo $recommended_modules; ?></div>
			<div class='close'><a href='index.php'><?php echo $close; ?></a></div>
			<div class='module_icon'><img src='images_easyphp/module_easyphp.png' width='32' height='32' alt='recommended modules' /></div><div class='module'><b><?php echo $module_virtualhostsmanager_title; ?></b><br /><?php echo $module_virtualhostsmanager_descr; ?><br /><a href='http://www.easyphp.org/modules.php' class='link' target='_blank'><?php echo $downloadninstall; ?></a></div>
			<div class='module_icon'><img src='images_easyphp/module_easyphp.png' width='32' height='32' alt='recommended modules' /></div><div class='module'><b><?php echo $module_xdebugmanager_title; ?></b><br /><?php echo $module_xdebugmanager_descr; ?><br /><a href='http://www.easyphp.org/modules.php' class='link' target='_blank'><?php echo $downloadninstall; ?></a></div>
			<div class='module_icon'><img src='images_easyphp/module_easyphp.png' width='32' height='32' alt='recommended modules' /></div><div class='module'><b><?php echo $module_webgrind_title; ?></b><br /><?php echo $module_webgrind_descr; ?><br /><a href='http://www.easyphp.org/modules.php' class='link' target='_blank'><?php echo $downloadninstall; ?></a></div>
			<div class='module_icon'><img src='images_easyphp/module_wordpress.png' width='32' height='32' alt='recommended modules' /></div><div class='module'><b><?php echo $module_wordpress_title; ?></b><br /><?php echo $module_wordpress_descr; ?><br /><a href='http://www.easyphp.org/modules.php' class='link' target='_blank'><?php echo $downloadninstall; ?></a></div>
			<div class='module_icon'><img src='images_easyphp/module_prestashop.png' width='32' height='32' alt='recommended modules' /></div><div class='module'><b><?php echo $module_prestashop_title; ?></b><br /><?php echo $module_prestashop_descr; ?><br /><a href='http://www.easyphp.org/modules.php' class='link' target='_blank'><?php echo $downloadninstall; ?></a></div>
			<div class='module_icon'><img src='images_easyphp/module_drupal.png' width='32' height='32' alt='recommended modules' /></div><div class='module'><b><?php echo $module_drupal_title; ?></b><br /><?php echo $module_drupal_descr; ?><br /><a href='http://www.easyphp.org/modules.php' class='link' target='_blank'><?php echo $downloadninstall; ?></a></div>
			<div class='module_icon'><img src='images_easyphp/module_joomla.png' width='32' height='32' alt='recommended modules' /></div><div class='module'><b><?php echo $module_joomla_title; ?></b><br /><?php echo $module_joomla_descr; ?><br /><a href='http://www.easyphp.org/modules.php' class='link' target='_blank'><?php echo $downloadninstall; ?></a></div>
			<div class='module_icon'><img src='images_easyphp/module_generique.png' width='32' height='32' alt='recommended modules' /></div><div class='module'><b><?php echo $module_spip_title; ?></b><br /><?php echo $module_spip_descr; ?><br /><a href='http://www.easyphp.org/modules.php' class='link' target='_blank'><?php echo $downloadninstall; ?></a></div>
		</div>
		</div>
		<br style='clear:both;' /><br style='clear:both;' />
		</body></html>
		<?php
		exit; // close tags
	}


	if (count($modules_files) == 0) {
		echo "<div class='modules_none'>" . $module_none . "<a href='http://www.easyphp.org' target='_blank' class='add_link'>". $menu_module_add ."</a></div>";
	} else {
		foreach ($modules_files as $file) {
			include("../../modules/$file/easyphp+.php");
		}
	}
	?>
	<br style='clear:both;' />

	<?php
	//==================================================================================================
	?>

	
	<h3><?php echo $t_portablefiles ?><span class="infobulle_section"><a class="info" href="#">?<span><?php echo $t_portablefiles_intro_1 . str_replace("/","\\", $localweb_path) . $t_portablefiles_intro_2; ?></span></a></span><span style='position:absolute;font-size:11px;margin:3px 0px 0px 20px;padding:0px;font-style:italic;font-weight:normal;color:gray;'><?php echo str_replace("/","\\", $localweb_path); ?></span></h3>

	<?php	
	//= PORTABLE FILES ================================================================================== ?>
	<div class='section'>
	
	<div class='localweb'>
		
		<div class='localweb_docs'>
			<?php
			$nbycol = (count($localweb_files)/4)+1;
			reset($localweb_files);
			while (key($localweb_files) !== null){ 
				echo "<div class='localweb_name'>";
				$i = 1;
				while (($i < $nbycol) AND (key($localweb_files) !== null)) {
					echo "<img src='images_easyphp/localweb_doc.gif' width='10' height='10' alt='localweb' /><a href='../" . current($localweb_files) . "' target='_blank' title='" . current($localweb_files) . "'>" . cut(current($localweb_files),25) . "</a><br />";
					next($localweb_files);
					$i++;
				}
				echo "</div>";
			}
			if (count($localweb_files) != 0) echo "<br style='clear:both' />";
			?>
		</div>			
	</div>
	<br style='clear:both;' />
	</div>
	<?php
	//==================================================================================================
	?>
	
	<h3><?php echo $t_ct_title ; ?><span class="infobulle_section"><a class="info" href="#">?<span><?php echo $t_ct_infobulle; ?></span></a></span></h3>

	<?php	
	//= CODE TESTER ====================================================================================== ?>
	<div class='section'>
	
	<div class='code_source'>
		
		<div class='frame'>
			<div class='frame_left'>
			<b><?php echo $t_ct_reminders_title; ?></b>
			<ul>
			<li><?php echo $t_ct_reminders_text_1; ?></li>
			<li><?php echo $t_ct_reminders_text_2; ?></li>
			</ul>
			</div>
			<div class='frame_right'>
				<form  method="post" action="codetester.php">
<textarea name="sourcecode" rows="8" onFocus="this.value=''; return false;">Example :<br />
<?php
echo '<?php' . "\n";
echo 'echo "Current date : ";' . "\n";
echo 'echo date("l F d, Y");' . "\n";
echo '?>';
?>
</textarea>
                                        <input type="hidden" name="nonce" value="<?php echo get_nonce(); /* Russell, 2012-11-10 */ ?>" />
					<input type="hidden" name="to" value="interpretcode" />
					<input type="submit" value="<?php echo $t_ct_interpretcode; ?>" class="submit" />
				</form>
			</div>
			<br style='clear:both;' />
		</div>			
	</div>

	<br style='clear:both;' />
	</div>
	<?php
	//==================================================================================================
	?>	

</div>

<div id="bottom">
	<div class="donation">
		<?php echo $t_donate_text; ?>
		<br />
		<b><?php echo $t_donate; ?> : </b>
		<a href='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XJDQGYKXJ3QB8' title='<?php echo $t_donate; ?> PayPal' target='_blank'><img src="images_easyphp/donation_paypal.png" width="46" height="14" alt="Donation - PayPal" border="0" style="vertical-align:middle;" /></a>
		<?php echo $t_donate_or; ?>
		<a href='https://coinbase.com/checkouts/51ef6075dff42be027148b59877987c6' title='<?php echo $t_donate; ?> Bitcoin' target='_blank'><img src="images_easyphp/donation_bitcoin.png" width="53" height="14" alt="Donation - Bitcoin" border="0" style="vertical-align:middle;" /></a><script src="https://coinbase.com/assets/button.js" type="text/javascript"></script>
		<?php echo $t_donate_or; ?>
		<a href='https://flattr.com/profile/easyphp' title='<?php echo $t_donate; ?> Flattr' target='_blank'><img src="images_easyphp/donation_flattr.png" width="52" height="14" alt="Donation - Flattr" border="0" style="vertical-align:middle;" /></a>
	</div>	
	<div class="footer_bottom">Icons by <a href='http://www.fatcow.com/free-icons' target='_blank'>FatCow</a> | <a href='http://www.easyphp.org' target='_blank'>EasyPHP</a> 2000 - 2014</div>
</div>	


</body>
</html>