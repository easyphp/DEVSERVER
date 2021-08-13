<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

// Stop
exec('"' . __DIR__ . '\bin\\mysqladmin.exe" -u root shutdown');
include(__DIR__ . '\\eds-app-actions.php');
sleep(2);
// Start
exec('eds-app-launch "' . __DIR__ . '\bin\\eds-dbserver.exe"'); 
sleep(2);
?>