<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

if ($_POST){
	$source = "../conf_files/httpd.conf";
	$httpdconf = file_get_contents($source);
	
	// Backup old httpd.conf
	copy($source, '../conf_files/httpd_' . date("Y-m-d@U") . '.conf');
	
	// TIMEZONE
	$timezone = date_default_timezone_get();
	if (isset($_POST['timezone']) AND $_POST['timezone'] != $timezone)
	{
		// Search and replace
		$search = $timezone;
		$replace = $_POST['timezone'];
		$httpdconf = str_replace($search, $replace, $httpdconf);
	}
	
	// Search and replace
	$search = ':' . $_SERVER['SERVER_PORT'];
	$replace = ':' . $_POST['new_server_port'];
	$httpdconf = str_replace($search, $replace, $httpdconf);

	// Save new httpd.conf
	file_put_contents($source, $httpdconf);

	$redirect = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_POST['new_server_port'] . "/home/index.php?page=server-page";
	sleep(2);
	header("Location: " . $redirect); 
	exit;
}
?>