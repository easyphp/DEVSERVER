<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

if (file_exists('..\eds-binaries\ruby\default')) {
	include ('..\eds-binaries\ruby\default\eds-app-settings.php');
	rename('..\eds-binaries\ruby\default', '..\eds-binaries\ruby\\' . $app_settings['app_folder']);
}
rename('..\eds-binaries\ruby\\' . $_GET['folder'], '..\eds-binaries\ruby\default');
?>