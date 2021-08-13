<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

$autostart_httpserver = (isset($_POST['autohttpserver']) AND $_POST['autohttpserver'] == '1')?'1':'0';
$autostart_dbserver = (isset($_POST['autodbserver']) AND $_POST['autodbserver'] == '1')?'1':'0';

// Update eds.ini
$ini_content = file_get_contents('..\eds.ini');

	// Update Autostart_httpserver
	$replacement = '${1}' . $autostart_httpserver;
	$ini_content = preg_replace('/^([\s|\t]*Autostart_httpserver.*\=[\s|\t]*)(.*)$/m', $replacement, $ini_content);

	// Update Autostart_dbserver
	$replacement = '${1}' . $autostart_dbserver;
	$ini_content = preg_replace('/^([\s|\t]*Autostart_dbserver.*\=[\s|\t]*)(.*)$/m', $replacement, $ini_content);
	
file_put_contents ('..\eds.ini', $ini_content);
?>