<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */
 
include("notification.php"); 
$new_notification = fopen('notification.php', "w");
$new_content = '<?php $notification = array(\'check_date\'=>\'' . date('Ymd') . '\',\'date\'=>\'' . $notification['date'] . '\',\'status\'=>\'0\',\'link\'=>\'' . $notification['link'] . '\',\'message\'=>\'' . $notification['message'] . '\'); ?>';
fputs($new_notification,$new_content);
fclose($new_notification);	
$redirect = $notification['link'];
header("Location: " . $redirect); 
exit;	
?>