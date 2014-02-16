<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

// Parameters
$parameters_mgmt = array(
	'max_execution_time'	=> array(
		'name'			=>	'max execution time',
		'values'		=>	array(30,60,120,180),
		'description'	=>	'Maximum execution time of each script, in seconds<br /><b>Default value: 30 *</b>'
		),
		
	'error_reporting'		=> array(
		'name'			=>	'error reporting',
		'values'		=>	array('E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED','E_ALL','E_ALL & ~E_DEPRECATED & ~E_STRICT'),
		'description'	=>	'Default value: E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED<br /><b>Development value: E_ALL *</b><br />Production value: E_ALL & ~E_DEPRECATED & ~E_STRICT'
	),	
	'upload_max_filesize'	=>	array(
		'name'			=>	'upload max filesize',
		'values'		=>	array('2M','10M','50M'),
		'description'	=>	'Maximum allowed size for uploaded files<br /><b>Default value: 2M *</b>'
	)
);

// Read php.ini -> array
$source = "../conf_files/php.ini";
$phpini = file_get_contents($source);
$phpini_array = explode("\r\n", $phpini);
$parameters_ini = array();
foreach ($phpini_array as $value){
	if ((substr($value,0,1) != ";") AND (substr($value,0,1) != "[")  AND (substr($value,0,1) != "")){
		$parameter = explode("=", $value);
		$parameters_ini = $parameters_ini + array(trim($parameter[0]) => trim($parameter[1]));
	}
}

$action = "http://" . $_SERVER['HTTP_HOST'] . "/home/" . $file . "phpinimanager_update.php";	
?>

<form method="post" action="<?php echo $action; ?>">
	<?php
	foreach ($parameters_mgmt as $parameter_mgmt => $parameter_mgmt_array){
		echo '<div style="width:100%;padding:0px 0px 0px 0px;margin:0px;">';
		echo '<div style="float:left;width:110px;text-align:right;padding:5px;margin:0px;font-family:courrier;font-size:13px;color:#3F3F3F;">' . $parameter_mgmt_array['name'] . '</div>';
		echo '<div style="float:left;width:170px;padding:6px 5px 5px 5px;margin:0px;text-align:left;">';
		echo '<select name="' . $parameter_mgmt . '" style="width:140px;">';
		foreach ($parameter_mgmt_array['values'] as $value){
			$selected = ($parameters_ini[$parameter_mgmt]==$value)?'selected="selected"':'';
			echo '<option ' . $selected . ' value="'.$value.'">'.$value.'</option>';
		}
		echo '</select>';
		echo '</div>';
		echo '<div style="float:left;width:220px;padding:5px;margin:0px;font-style:italic;color:gray;text-align:left;">' . $parameter_mgmt_array['description'] . '</div>';
		echo '<br style="clear:both">';
		echo '</div>';
	}
	?>
	
	<div style="width:100%;padding:0px;margin:0px;color:gray;text-align:right;font-style:italic">
		<?php echo $t_recommended; ?>
	</div>
	
	<div style="width:500px;padding:5px;margin:10px auto 0px auto;border:1px solid #EFCE1D;background-color:#FBD825;color:#895902;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">
		<?php echo $t_warning_phpini; ?>
	</div>

	<input type="submit" value="<?php echo $t_warning_save; ?>" class="submit" />
</form>
<br />