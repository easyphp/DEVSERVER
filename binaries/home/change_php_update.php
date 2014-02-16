<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */
 
include("../php/php_runningversion/easyphp.php"); 
 
// Backup old php.ini
copy('../conf_files/php.ini', '../conf_files/php_' . $phpversion['dirname'] . '_' . date("Y-m-d@U") . '.ini');
copy('../apache/php.ini', '../apache/php_' . $phpversion['dirname'] . '_' . date("Y-m-d@U") . '.ini');
copy('../conf_files/php.ini', '../php/php_runningversion/php.ini');

// Import new php.ini
$phpini_apache = file_get_contents('../php/' . $_GET['newphpdir'] . '/php.ini');
$phpini_apache = str_replace('${path}', dirname(dirname(__FILE__)), $phpini_apache);
file_put_contents('../apache/php.ini', $phpini_apache);
copy('../php/' . $_GET['newphpdir'] . '/php.ini', '../conf_files/php.ini');	

// Rename 'php_runningversion'
rename('../php/php_runningversion', '../php/' . $phpversion['dirname']);

// Rename new php version dir to 'php_runningversion'
rename('../php/' . $_GET['newphpdir'], '../php/php_runningversion');

sleep(3);
$redirect = "http://" . $_SERVER['HTTP_HOST'] . "/home/index.php?page=php-page&display=changephpversion";
header("Location: " . $redirect); 
exit;
?>