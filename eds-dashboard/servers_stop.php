<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

 /* STOP ALL SERVERS */
if (isset($argv[1]) AND $argv[1] == 'allservers') {
	// Http Server
	include('conf_httpserver.php');	
	include('..\\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-stop.php');

	// Db Server
	include('conf_dbserver.php');	
	include('..\\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-stop.php');
}

/* STOP HTTP SERVER */
if (isset($argv[1]) AND $argv[1] == 'httpserver') {
	include('conf_httpserver.php');	
	include('..\\eds-binaries\httpserver\\' . $conf_httpserver['httpserver_folder'] . '\eds-app-stop.php');
}

/* STOP DB SERVER */
if (isset($argv[1]) AND $argv[1] == 'dbserver') {
	include('conf_dbserver.php');	
	include('..\\eds-binaries\dbserver\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-stop.php');
}
?>