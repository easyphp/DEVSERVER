<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

exec('"' . __DIR__ . '\bin\\mysqladmin.exe" -u root shutdown');
sleep(2);
?>