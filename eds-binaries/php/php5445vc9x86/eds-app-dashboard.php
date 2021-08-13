<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

include(__DIR__ . '\eds-app-settings.php');

$serverconf = file_get_contents(__DIR__ . '\php.ini');
?>

<style type="text/css" media="all">
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
		<img src="images/<?php echo $php_settings['app_icon']; ?>" border="0" />
	</div>
	<div class="col-sm-11">
		<h1><?php echo strtoupper($php_settings['app_name']) ?><a href="<?php echo $php_settings['app_website_url'] ?>" target="_blank" style="position:absolute;padding:5px 0px 0px 5px;font-size:12px;color:silver;" data-toggle="tooltip" data-placement="top" title="Go to Website"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a></h1>
		<p>
			&#9642; version : <b><?php echo $php_settings['app_version_nb'] ?></b></br>
			&#9642; compiler : <b><?php echo $php_settings['app_build'] ?></small></b></br>
			&#9642; architecture : <b><?php echo $php_settings['app_mode'] ?></small></b></br>
			&#9642; xdebug : <b><?php echo $php_settings['xdebug_version'] ?></small></b></br>
		</p>
	</div>
</div>

<br />

<div class="table-responsive">
	<table class="table table-hover">
		<tbody>	
			<tr>
				<td style="white-space:nowrap;">
					<strong>Tag</strong>
					<a class="info_bulle" aria-hidden="true" data-toggle="popover" data-trigger="hover" data-html="true" data-content="If you want to try several configurations, you can use the same PHP version with different configurations or use different versions with identical or different configurations (ie. different php.ini). To recognize your versions/configurations you can add a short tag."><i class="fa fa-info-circle"></i></a>
				</td>
				<td>
					<?php			
						echo '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form">';
						echo '<input type="hidden" name="php_tag" value="add" />';
						echo '<button type="submit" class="btn btn-default btn-xs"  data-toggle="tooltip" data-placement="top" title="Add / Modify Tag" onclick="delay()"><span class="glyphicon glyphicon-tags small" aria-hidden="true"></span></button>';
						echo '</form>';		
					?>						
				</td>
				<td>
					<?php	
					if (isset($_POST['php_tag']) AND $_POST['php_tag'] !== "") {
						echo '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form">';
						echo '<input type="hidden" name="php_tag" value="addchange" />';
						echo '<input type="hidden" name="action[request][0][type]" value="include" />';
						echo '<input type="hidden" name="action[request][0][value]" value="' . urlencode(__DIR__ . '/eds-app-actions.php') . '" />';
						echo '<input type="text" class="form-control input-sm" id="php_tag" name="php_tag" value="' . $php_settings['app_tag'] . '" />';
						echo ' <button type="submit" class="btn btn-primary btn-sm" onclick="delay()">add / change tag</button>';
						echo ' <a href="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="btn btn-default btn-sm">cancel</a>';
						echo '</form>';	
					
					} else {
						if ($php_settings['app_tag'] !== '') {
							
							echo '<samp style="color:gray;" class="small">' . $php_settings['app_tag'] . '</samp>';	
						} else {
							echo '<samp style="color:gray;" class="small"><i>no tag</i></samp>';
						}	
					}
					?>
					
				</td>
			</tr>		
			<tr>
				<td style="white-space:nowrap;"><strong>Folder</strong></td>
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
				<td style="white-space:nowrap;"><strong>Files</strong></td>
				<td colspan="2">					
					<a href="<?php echo $_SERVER['REQUEST_URI'];?>&display=serverconffile"><button type="button" class="btn btn-primary btn-xs">Configuration File</button></a>
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
			<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . __DIR__ . '\php.ini') ?>" />
			<button type="submit" class="btn btn-default btn-xs" onclick="delay()" data-toggle="tooltip" data-placement="left" title="Edit configuration file"><span class="glyphicon glyphicon-pencil small" aria-hidden="true"></span></button>
		</form>	
		<a href="index.php?zone=applications&page=php&phpfolder=<?php echo basename(dirname(__FILE__)); ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
	</div>
	<pre style="clear:both"><?php echo htmlspecialchars($serverconf); ?></pre>
	<?php
}	
?>