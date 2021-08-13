<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

include("notification.php"); 
$new_content = '<?php $notification = array(\'check_date\'=>\'' . @date('Ymd') . '\',\'date\'=>\'' . $notification['date'] . '\',\'status\'=>\'0\',\'link\'=>\'' . $notification['link'] . '\',\'message\'=>\'' . $notification['message'] . '\',\'link_text\'=>\'' . $notification['link_text'] . '\'); ?>';
file_put_contents('notification.php', $new_content);

$redirect = $notification['link'];
header("Location: " . $redirect); 
exit;	
?>