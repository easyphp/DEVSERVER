<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

if (file_exists('..\eds-binaries\python\default')) {
	include ('..\eds-binaries\python\default\eds-app-settings.php');
	rename('..\eds-binaries\python\default', '..\eds-binaries\python\\' . $app_settings['app_folder']);
}
rename('..\eds-binaries\python\\' . $_GET['folder'], '..\eds-binaries\python\default');
?>