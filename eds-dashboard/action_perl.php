<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

if (file_exists('..\eds-binaries\perl\default')) {
	include ('..\eds-binaries\perl\default\eds-app-settings.php');
	rename('..\eds-binaries\perl\default', '..\eds-binaries\perl\\' . $app_settings['app_folder']);
}
rename('..\eds-binaries\perl\\' . $_GET['folder'], '..\eds-binaries\perl\default');
?>