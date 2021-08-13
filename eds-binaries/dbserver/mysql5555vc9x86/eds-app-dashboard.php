<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

include(__DIR__ . '\\eds-app-settings.php');

$serverconf = file_get_contents(__DIR__ . '\my.ini');
$servererrorlog = file_get_contents(__DIR__ . '\data\mysql_error.log');

$control = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form" style="float:left;">';

if ($eds_dbserver_running == 0) {

	// app not running -> run app
	$control .= '<input type="hidden" name="action[request][0][type]" value="include" />';
	$control .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(__DIR__ . '/eds-app-start.php') . '" />';
	$control .= '<button type="submit" class="btn btn-success btn-sm" onclick="delay()" style="padding-left:20px;padding-right:20px;"><span class="glyphicon glyphicon-play small" aria-hidden="true"></span>&nbsp;&nbsp;start&nbsp;</button>';
	$control .= '</form>';
	
} else {
	
	// app running - > restart / stop app
	$control .= '<input type="hidden" name="action[request][0][type]" value="include" />';
	$control .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(__DIR__ . '/eds-app-restart.php') . '" />';
	$control .= '<button type="submit" class="btn btn-warning btn-sm" onclick="delay()" style="margin-left:0px;"><span class="glyphicon glyphicon-refresh small" aria-hidden="true"></span>&nbsp;&nbsp;restart&nbsp;</button>';
	$control .= '</form>';
	$control .= '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form" style="float:left;">';
	$control .= '<input type="hidden" name="action[request][0][type]" value="include" />';
	$control .= '<input type="hidden" name="action[request][0][value]" value="' . urlencode(__DIR__ . '/eds-app-stop.php') . '" />';
	$control .= '<button type="submit" class="btn btn-danger btn-sm" onclick="delay()" style="margin-left:10px;"><span class="glyphicon glyphicon-stop small" aria-hidden="true"></span>&nbsp;&nbsp;stop&nbsp;</button>';
	$control .= '</form>';

}
?>

<style type="text/css" media="all">
.support_link {
	color:#FF5722;
	border-bottom:1px dotted #FF5722;
}
.support_link:hover {
	text-decoration:none;
	border-bottom:1px dotted #DD2C00;
	color:#DD2C00;
}

a.info_bulle {
	color:#FFD54F;
}

.info_bulle:hover {
	cursor:pointer;
	color:#c0c0c0;
}

.info_bulle:focus {
	outline: 0;
}
</style>

<div class="row">
	<div class="col-sm-1 text-center">
		<img src="images/<?php echo $app_settings['app_icon']; ?>" border="0" />
	</div>
	<div class="col-sm-11">
		<h1><?php echo strtoupper($app_settings['app_name']) ?><a href="<?php echo $app_settings['app_website_url'] ?>" target="_blank" style="position:absolute;padding:5px 0px 0px 5px;font-size:12px;color:silver;" data-toggle="tooltip" data-placement="top" title="Go to Website"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a></h1>
		<p>
			&#9642; version : <b><?php echo $app_settings['app_version_nb'] ?></b><br />
			&#9642; architecture : <b><?php echo $app_settings['app_mode'] ?></small></b><br />
		</p>
	</div>
</div>

<br />

<?php
if ((basename(__DIR__) !== $conf_dbserver['dbserver_folder']) AND ($conf_dbserver['dbserver_folder'] != '') AND ($eds_dbserver_running == 1)) {
	
	// Another server is running -> stop it
	?>
	<div class="row">
		<div class="col-sm-10 text-center">
			<b>Another server is running. You need to stop it fist.</b>		
			<br />
			<br />
			<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form">
				<input type="hidden" name="action[request][0][type]" value="include" />
				<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode(dirname(__DIR__) . '\\' . $conf_dbserver['dbserver_folder'] . '\eds-app-stop.php') ?>" />
				<button type="submit" class="btn btn-danger btn-sm" onclick="delay()"><span class="glyphicon glyphicon-stop" aria-hidden="true"></span>&nbsp;&nbsp;<strong>stop the active server</strong></button>
			</form>			
		</div>
	</div>
	<?php	
	
} else {
	
	?>
	<div class="table-responsive">
		<table class="table table-hover">
			<tbody>
				<tr>
					<td style="padding-top:15px;white-space:nowrap;"><strong>Server</strong></td>
					<td colspan="2"><?php echo $control; ?></td>
				</tr>
				
				<?php
				if ($eds_dbserver_running == 1) {	
					?>
					<tr>
						<td style="padding-top:15px;white-space:nowrap;"><strong>Port</strong></td>
						<td colspan="2"><kbd><?php echo $conf_dbserver['dbserver_port']; ?></kbd></td>
					</tr>
					<?php
				}
				?>
			

				<tr>
					<td style="white-space:nowrap;"><strong>Server Root</strong></td>
					<td>
						<?php			
						echo '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form">';
						echo '<input type="hidden" name="action[request][0][type]" value="exe" />';
						echo '<input type="hidden" name="action[request][0][value]" value="' . urlencode('explorer.exe ' . __DIR__) . '" />';
						echo '<button type="submit" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Explore Server Root" onclick="delay()"><span class="glyphicon glyphicon-folder-open small" aria-hidden="true"></span></button>';
						echo '</form>';		
						?>						
					</td>
					<td>
						<?php
						echo '<samp style="color:silver;" class="small">' . __DIR__ . '\\' . '</samp>';
						?>
					</td>
				</tr>
				
				<tr>
					<td style="white-space:nowrap;"><strong>Databases Folder</strong></td>
					<td>
						<?php			
						echo '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form">';
						echo '<input type="hidden" name="action[request][0][type]" value="exe" />';
						echo '<input type="hidden" name="action[request][0][value]" value="' . urlencode('explorer.exe ' . __DIR__ . '\data\\') . '" />';
						echo '<button type="submit" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Explore Server Root" onclick="delay()"><span class="glyphicon glyphicon-folder-open small" aria-hidden="true"></span></button>';
						echo '</form>';		
						?>						
					</td>
					<td>
						<?php
						echo '<samp style="color:silver;" class="small">' . __DIR__ . '\data\\' . '</samp>';
						?>
					</td>
				</tr>				
				
				<tr>					
					<td style="white-space:nowrap;"><strong>Files</strong></td>
					<td colspan="2">					
						<a href="<?php echo $_SERVER['REQUEST_URI'];?>&display=serverconffile"><button type="button" class="btn btn-primary btn-xs">Configuration File</button></a>
						<a href="<?php echo $_SERVER['REQUEST_URI'];?>&display=servererrorlog"><button type="button" class="btn btn-primary btn-xs">Error Log</button></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
		
	<?php
	if (isset($_GET['display']) AND $_GET['display'] == 'serverconffile') {
		?>
		
		<h4 style="display:inline">Configuration File</h4>
		<div style="float:right;padding-bottom:10px;">
			<form method="post" style="display:inline" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form">
				<input type="hidden" name="action[request][0][type]" value="exe" />
				<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . __DIR__ . '\my.ini') ?>" />
				<button type="submit" class="btn btn-default btn-xs" onclick="delay()"><span class="glyphicon glyphicon-pencil small" aria-hidden="true"></span></button>
			</form>	
			<a href="index.php?zone=applications&page=dbserver&serverfolder=<?php echo basename(dirname(__FILE__)); ?>" class="btn btn-primary btn-xs inline"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
		</div>
		<pre style="clear:both"><?php echo htmlspecialchars($serverconf); ?></pre>
		<?php
	}
	
	if (isset($_GET['display']) AND $_GET['display'] == 'servererrorlog') {
		?>
		<h4 style="display:inline">Error Log</h4>
		<div style="float:right;padding-bottom:10px;">
			<form method="post" style="display:inline" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form">
				<input type="hidden" name="action[request][0][type]" value="exe" />
				<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . __DIR__ . '\data\mysql_error.log') ?>" />
				<button type="submit" class="btn btn-default btn-xs" onclick="delay()"><span class="glyphicon glyphicon-pencil small" aria-hidden="true"></span></button>
			</form>	
			<a href="index.php?zone=applications&page=dbserver&serverfolder=<?php echo basename(dirname(__FILE__)); ?>" class="btn btn-primary btn-xs inline"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
		</div>
		<pre style="clear:both"><?php echo htmlspecialchars($servererrorlog); ?></pre>
		<?php
	}

}
?>