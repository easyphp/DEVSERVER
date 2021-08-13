<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */


$httpserver_folders = @opendir('../eds-binaries/httpserver');
while ($httpserver_folder = @readdir($httpserver_folders)){
	if (@file_exists('../eds-binaries/httpserver/'.$httpserver_folder.'/eds-app-settings.php')){
		include('../eds-binaries/httpserver/'.$httpserver_folder.'/eds-app-settings.php');
		$app_settings['app_folder'] = $httpserver_folder;
		$http_servers_list[] = $app_settings;
	}
}
@closedir($httpserver_folders);

$dbserver_folders = @opendir('../eds-binaries/dbserver');
while ($dbserver_folder = @readdir($dbserver_folders)){
	if (@file_exists('../eds-binaries/dbserver/'.$dbserver_folder.'/eds-app-settings.php')){
		include('../eds-binaries/dbserver/'.$dbserver_folder.'/eds-app-settings.php');
		$app_settings['app_folder'] = $dbserver_folder;
		$db_servers_list[] = $app_settings;
	}
}
@closedir($dbserver_folders);

$php_folders = @opendir('../eds-binaries/php');
while ($php_folder = @readdir($php_folders)){
	if (@file_exists('../eds-binaries/php/'.$php_folder.'/eds-app-settings.php')){
		include('../eds-binaries/php/'.$php_folder.'/eds-app-settings.php');
		$php_settings['app_folder'] = $php_folder;
		$php_list[] = $php_settings;
	}
}
@closedir($php_folders);

?>

<div class="container">

	<div class='row'>
	
		<!-- SIDE BAR MENU -->
		<div class="col-sm-3">
			<?php include('sidebarmenu.inc.php'); ?>	
		</div>
		
		<div class="col-sm-9">
			<?php
			if (!isset($_GET['page'])) {
			?>
				<div class="row">
					<div class="col-sm-1 text-center">
						<img src="images/eds_icon_devserver.png" border="0" />
					</div>
					<div class="col-sm-11">
						<h1>EASYPHP DEVSERVER<a href="http://www.easyphp.org" target="_blank" style="position:absolute;padding:5px 0px 0px 5px;font-size:12px;color:silver;" data-toggle="tooltip" data-placement="top" title="Go to Website"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a></h1>
						<p>
							&#9642; version : <b><?php echo $edsini['Version'] ?></b><br />
							&#9642; support : <a href='http://www.easyphp.org/support.php' target="_blank"><span class="glyphicon glyphicon-link small" aria-hidden="true"></span></a><br />
						</p>						
					</div>
				</div>
				
				<br />
				
				<?php
				$update_message = "<div class='small text-justify'>EasyPHP Devserver is updated regularly.</div><div class='text-justify small' style='padding-top:10px;'>However, between two major updates you can find intermediate updates in the Warehouse.</div><div class='text-center'><a href='http://warehouse.easyphp.org' target='_blank' style='color:white;' class='btn btn-danger btn-xs'>Visit the Warehouse</a></div>";
				?>

				<h3 style="margin-bottom:0px;">STARTUP SETTINGS</h3>
				<div class="row">
					<div class="col-sm-12">
	
						<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" role="form" style="padding-left:20px;">
							<div class="col-sm-5">
								<div class="checkbox">
									<label><input type="checkbox" name="autohttpserver" value="1" <?php echo ($edsini['Autostart_httpserver'] == '1')?'checked':''; ?> /> Start <b>HTTP SERVER</b> on start-up</label><br />
									<label><input type="checkbox" name="autodbserver" value="1" <?php echo ($edsini['Autostart_dbserver'] == '1')?'checked':''; ?> /> Start <b>DATABASE SERVER</b> on start-up</label>
								</div>
							</div>
							<div class="col-sm-7" style="text-align:left;padding-top:15px;">
								<input type="hidden" name="action[request][0][type]" value="include" />
								<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('action_eds.php') ?>" />
								<button type="submit" class="btn btn-primary btn-xs" onclick="delay()">save</button>
							</div>
						</form>

					</div>
				</div>				
				
				<br />
				
				<h3 style="margin-bottom:0px;">APPLICATIONS</h3>
				<div class="row text-center">
					<div class="col-sm-2 col-sm-offset-1 update_apps">
						<h4>PHP</h4>
						<div style="margin-top:-10px;"><i class="devicon-php-plain" style="font-size:100px;color:#d4d4d4;"></i></div>
						<p class="update_popover" style="padding-top:0px"><a role="button" tabindex="0" style="cursor:pointer;" class="btn btn-default btn-xs" aria-hidden="true" data-toggle="popover" data-placement="top" data-trigger="focus" data-html="true" data-content="<?php echo $update_message ?>"><span class="glyphicon glyphicon-save"></span> update</a></p>
					</div>
					<div class="col-sm-2 update_apps">
						<h4>Apache</h4>
						<div style="margin-top:0px;"><i class="devicon-apache-plain-wordmark" style="font-size:90px;color:#d4d4d4;"></i></div>
						<p class="update_popover" style="padding-top:0px"><a role="button" tabindex="0" style="cursor:pointer;" class="btn btn-default btn-xs" aria-hidden="true" data-toggle="popover" data-placement="top" data-trigger="focus" data-html="true" data-content="<?php echo $update_message ?>"><span class="glyphicon glyphicon-save"></span> update</a></p>
					</div>
					<div class="col-sm-2 update_apps">
						<h4>MySQL</h4>
						<i class="devicon-mysql-plain-wordmark" style="font-size:90px;color:#d4d4d4;"></i>
						<p class="update_popover" style="padding-top:0px"><a role="button" tabindex="0" style="cursor:pointer;" class="btn btn-default btn-xs" aria-hidden="true" data-toggle="popover" data-placement="top" data-trigger="focus" data-html="true" data-content="<?php echo $update_message ?>"><span class="glyphicon glyphicon-save"></span> update</a></p>
					</div>
					<div class="col-sm-2 update_apps">
						<h4>Nginx</h4>
						<i class="devicon-nginx-plain" style="font-size:90px;color:#d4d4d4;"></i>
						<p class="update_popover" style="padding-top:0px"><a href="http://www.easyphp.org/download.php" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-save"></span> add</a></p>
					</div>
				</div>

				<br />
				
				<div class="row text-center">
					<div class="col-sm-2 col-sm-offset-1 update_apps">
						<h4>Python</h4>
						<i class="devicon-python-plain" style="font-size:60px;color:#d4d4d4;"></i>
						<p class="update_popover" style="padding-top:20px"><a href="http://www.easyphp.org/download.php" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-save"></span> add</a></p>
					</div>
					<div class="col-sm-2 update_apps">
						<h4>Ruby</h4>
						<i class="devicon-ruby-plain" style="font-size:50px;color:#d4d4d4;"></i>
						<p class="update_popover" style="padding-top:30px"><a href="http://www.easyphp.org/download.php" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-save"></span> add</a></p>
					</div>
					<div class="col-sm-2 update_apps">
						<h4>Perl</h4>
						<samp style="font-size:30px;color:#d4d4d4;">Perl</samp>
						<p class="update_popover" style="padding-top:40px"><a href="http://www.easyphp.org/download.php" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-save"></span> add</a></p>
					</div>
					<div class="col-sm-2">
						<p style="padding-top:70px"><a href="http://warehouse.easyphp.org" class="btn btn-primary btn-xs" target="_blank"><span class="glyphicon glyphicon-plus"></span> more</a></p>
					</div>
				</div>		

			<?php
			// PHP
			} elseif($_GET['page'] == "php") {		
				
				if (isset($_GET['phpfolder'])) {
					include('../eds-binaries/php/' . $_GET['phpfolder'] . '/eds-app-dashboard.php');
				} else {
					echo '<h3>PHP</h3>';
					echo '<h4>Choose a version</h4>';
					echo '<ul class="nav nav-pills">';
					foreach ($php_list AS $app_params) {
						echo '<li><a href="index.php?zone=applications&page=php&phpfolder=' . $app_params['app_folder'] . '"><img src="images/' . $app_params['app_icon'] . '" border="0" width="20" style="vertical-align:-8px" /> ' . $app_params['app_name'] . ' ' . $app_params['app_version'] . '</a></li>';
					}
					echo '</ul>';

				}		
		
			// DB SERVER
			} elseif($_GET['page'] == "dbserver") {		
				
				if (isset($_GET['serverfolder'])) {
					include('../eds-binaries/dbserver/' . $_GET['serverfolder'] . '/eds-app-dashboard.php');
				} else {
					echo '<h3>DATABASE SERVERS</h3>';
					echo '<h4>Choose a server</h4>';
					echo '<ul class="nav nav-pills">';
					foreach ($db_servers_list AS $app_params) {
						echo '<li><a href="index.php?zone=applications&page=dbserver&serverfolder=' . $app_params['app_folder'] . '"><img src="images/' . $app_params['app_icon'] . '" border="0" width="20" style="vertical-align:-8px" /> ' . $app_params['app_name'] . ' ' . $app_params['app_version'] . '</a></li>';
					}
					echo '</ul>';

				}
				
			// HTTP SERVER
			} elseif($_GET['page'] == "httpserver") {
				if (isset($_GET['serverfolder'])) {
					include('../eds-binaries/httpserver/' . $_GET['serverfolder'] . '/eds-app-dashboard.php');
				} else {
					echo '<h3>HTTP SERVERS</h3>';
					echo '<h4>Choose a server</h4>';
					echo '<ul class="nav nav-pills">';
					foreach ($http_servers_list AS $app_params) {
						echo '<li><a href="index.php?zone=applications&page=httpserver&serverfolder=' . $app_params['app_folder'] . '"><img src="images/' . $app_params['app_icon'] . '" border="0" width="20" style="vertical-align:-8px" /> ' . $app_params['app_name'] . ' ' . $app_params['app_version'] . '</a></li>';
					}
					echo '</ul>';

				}
				
			// PYTHON
			} elseif($_GET['page'] == "python") {
				include('index_applications_python.php');			
				
			// RUBY
			} elseif($_GET['page'] == "ruby") {
				include('index_applications_ruby.php');			
			
			// PERL
			} elseif($_GET['page'] == "perl") {
				include('index_applications_perl.php');			
			}			
			?>

		</div>
	</div>
</div> <!-- /container -->