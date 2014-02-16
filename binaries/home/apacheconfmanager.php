<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

// Array of available ports
$ports = array(80,8080,8000,8888);
$ports_available = array($_SERVER['SERVER_PORT']);
foreach ($ports as $port){
	if (!check_port($port)) $ports_available[] = $port;
}


// Parameters
$parameters_mgmt = array(	
	'new_server_port'	=> array(
		'name'			=>	'available ports',
		'values'		=>	$ports_available,
		'description'	=>	$ports_available_desc,
	)
);

// Read httpd.conf -> array
$source = "../conf_files/httpd.conf";
$httpdconf = file_get_contents($source);
$httpdconf_array = explode("\r\n", $httpdconf);
$parameters_conf = array();

$action = "http://" . $_SERVER['HTTP_HOST'] . "/home/" . $file . "apacheconfmanager_update.php";	
?>

<form method="post" action="<?php echo $action; ?>" style="clear:both;width:580px;padding:10px 0px 0px 0px;margin:0px auto 0px auto;text-align:center;">

	<?php
	// TIMEZONE
	$timezone = date_default_timezone_get();
	echo '<div style="width:100%;padding:0px 0px 0px 0px;margin:0px;">';
	echo '<div style="float:left;width:100px;text-align:right;padding:5px;margin:0px;font-family:courrier;font-size:13px;color:#3F3F3F;">timezone</div>';
	echo '<div style="float:left;width:170px;padding:6px 5px 5px 5px;margin:0px;text-align:left;">';
	timezones_select($timezone);
	echo '</div>';
	echo '<div style="float:left;width:240px;padding:5px;margin:0px;font-style:italic;color:gray;text-align:left;">' . date('l jS \of F Y h:i:s A') . '</div>';
	echo '<br style="clear:both">';	
	echo '</div>';
	
	foreach ($parameters_mgmt as $parameter_mgmt => $parameter_mgmt_array){
		echo '<div style="width:100%;padding:10px 0px 0px 0px;margin:0px;">';
		echo '<div style="float:left;width:100px;text-align:right;padding:5px;margin:0px;font-family:courrier;font-size:13px;color:#3F3F3F;">' . $parameter_mgmt_array['name'] . '</div>';
		echo '<div style="float:left;width:170px;padding:6px 5px 5px 5px;margin:0px;text-align:left;">';
		echo '<select name="' . $parameter_mgmt . '" style="margin:0px;padding:0px;border:0px;background-color:#E3E3E3;color:#515250;font-size:100%;">';
		foreach ($parameter_mgmt_array['values'] as $value){
			echo '<option value="'.$value.'">'.$value.'</option>';
		}
		echo '</select>';
		echo '</div>';
		echo '<div class="apacheconf_desc">' . $parameter_mgmt_array['description'] . '</div>';
		echo '<br style="clear:both">';
		echo '</div>';
	}
	?>
			
	<div style="width:500px;padding:5px;margin:10px auto 0px auto;border:1px solid #EFCE1D;background-color:#FBD825;color:#895902;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">
		<?php echo $t_warning_apacheconf; ?>
	</div>

	<input type="submit" value="<?php echo $t_warning_save; ?>" class="submit" />
</form>
<br />