<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

if (isset($_POST['php_tag'])) {

		// UPDATE eds-app-settings
		$php_settings = file_get_contents(__DIR__ . '\eds-app-settings.php');

			// extension_dir
			$replacement = '${1}' . htmlentities(trim($_POST['php_tag'])) . '$3';
			$php_settings = preg_replace('/^([\s|\t]*\'app_tag\'[\s|\t]*\=>[\s|\t]*\"[\s|\t]*)(.*)(\".*)$/m', $replacement, $php_settings);

		file_put_contents (__DIR__ . '\eds-app-settings.php', $php_settings);
		
} else {

	include(__DIR__ . '\eds-app-settings.php'); 
	
	// UPDATE PHP.INI
	$phpini = file_get_contents(__DIR__ . '\php.ini');
		
		// extension_dir
		$replacement = '${1}' . __DIR__ . '\ext' . '$3';
		$phpini = preg_replace('/^([\s|\t]*extension_dir[\s|\t]*\=[\s|\t]*\"[\s|\t]*)(.*)(\".*)$/m', $replacement, $phpini);	

		// zend_extension - xdebug dll
		$replacement = '${1}' . __DIR__ . '\\' . $php_settings['xdebug_dll'] . '$3';
		$phpini = preg_replace('/^([\s|\t]*zend_extension[\s|\t]*\=[\s|\t]*\"[\s|\t]*)(.*)(\".*)$/m', $replacement, $phpini);		
		
	file_put_contents (__DIR__ . '\php.ini', $phpini);
	
}
?>