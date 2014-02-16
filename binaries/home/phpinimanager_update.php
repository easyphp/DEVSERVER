<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

if ($_POST){
	$source = "../conf_files/php.ini";
	$phpini = file_get_contents($source);
	
	include("../php/php_runningversion/easyphp.php"); 

	// Backup old php.ini
	copy($source, '../conf_files/php_' . $phpversion['dirname'] . '_' . date("Y-m-d@U") . '.ini');

	foreach ($_POST as $parameter => $parameter_value){
		// Search and replace
		$pattern = "/" . $parameter . "(\s|\t|)=(\s|\t|)(.*)/";	
		$replacement = $parameter . " = " . $parameter_value;
		$phpini = preg_replace($pattern, $replacement, $phpini);
	}

	// Save new php.ini
	file_put_contents($source, $phpini);

	$redirect = "http://" . $_SERVER['HTTP_HOST'] . "/home/index.php?page=php-page";
	sleep(2);
	header("Location: " . $redirect); 
	exit;
}
?>