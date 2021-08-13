<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

exec('eds-app-stop.exe -accepteula "eds-httpserver"');
include(__DIR__ . '\\eds-app-actions.php');
exec('eds-app-launch "' . __DIR__ . '\bin\\eds-httpserver.exe"');
sleep(2);
?>