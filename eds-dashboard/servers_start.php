<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

 
/* STARTUP */
if (isset($argv[1]) AND $argv[1] == 'startup') { 
	// EDS ini
	$edsini = parse_ini_file("../eds.ini");

	// Http Server
	if (($edsini['Autostart_httpserver'] == 1) AND (file_exists('conf_httpserver.php'))) {
		include('conf_httpserver.php');	
		include('..\\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-start.php');
	}
	
	// Db Server
	if (($edsini['Autostart_dbserver'] == 1) AND (file_exists('conf_dbserver.php'))) {
		include('conf_dbserver.php');	
		include('..\\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-start.php');
	}
}

/* START ALL SERVERS */
if (isset($argv[1]) AND $argv[1] == 'allservers') {
	// Http Server
	include('conf_httpserver.php');	
	include('..\\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-start.php');

	// Db Server
	include('conf_dbserver.php');	
	include('..\\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-start.php');	
}

/* START HTTP SERVER */
if (isset($argv[1]) AND $argv[1] == 'httpserver') {
	include('conf_httpserver.php');	
	include('..\\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-start.php');	
}

/* START DATABASE SERVER */
if (isset($argv[1]) AND $argv[1] == 'dbserver') {
	include('conf_dbserver.php');	
	include('..\\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-start.php');	
}
?>