<br />
<div class="list-group">
	<div class="list-group-item disabled"><a href="index.php"><small class="glyphicon glyphicon-chevron-left"></small> <strong>Dashboard</strong></a></div>

	<div class="list-group-item"><a href="index.php?zone=applications">Settings & Applications</a></div>

	<!-- PHP -->
	<div type="button" class="list-group-item">
		<a class="" role="button" data-toggle="collapse" href="index.php?zone=applications&page=php#php_list" aria-expanded="false" aria-controls="php_list">PHP</a>
		<div class="collapse <?php echo ((isset($_GET['page']) AND ($_GET['page'] == 'php'))) ? 'in' : '' ; ?>" id="php_list">
			<div>&#9642; <a href="index.php?zone=applications&page=php" class="menu_link"><small>All versions</small></a></div>
			<?php
			foreach ($php_list AS $app_params) {
				echo '<div>&#9642; <a href="index.php?zone=applications&page=php&phpfolder=' . $app_params['app_folder'] . '" class="menu_link" data-toggle="tooltip" data-placement="right" title="' . $app_params['app_tag'] . '"><small>' . $app_params['app_name'] . ' ' . $app_params['app_version'] . '</small></a></div>';
			}
			?>	
			<div>&#9642; <a href="http://warehouse.easyphp.org" target="_blank" class="menu_link" data-toggle="tooltip" data-placement="right" title="add a version"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a></div>
		</div>				 
	</div>

	<!-- HTTP SERVER -->
	<div type="button" class="list-group-item">
		<a class="" role="button" data-toggle="collapse" href="index.php?zone=applications&page=httpserver#http_list" aria-expanded="false" aria-controls="http_list">HTTP SERVER</a>
		<div class="collapse <?php echo ((isset($_GET['page']) AND ($_GET['page'] == 'httpserver'))) ? 'in' : '' ; ?>" id="http_list">
			<div>&#9642; <a href="index.php?zone=applications&page=httpserver" class="menu_link"><small>All versions</small></a></div>
			<?php
			foreach ($http_servers_list AS $app_params) {
				$httpserver_name = ($conf_httpserver['httpserver_folder'] == $app_params['app_folder']) ?  '<b>' . $app_params['app_name'] . ' ' . $app_params['app_version'] . '</b>' : $app_params['app_name'] . ' ' . $app_params['app_version'];
				echo '<div>&#9642; <a href="index.php?zone=applications&page=httpserver&serverfolder=' . $app_params['app_folder'] . '" class="menu_link"><small>' . $httpserver_name . '</small></a></div>';
			}
			?>
			<div>&#9642; <a href="http://www.easyphp.org/download.php" target="_blank" class="menu_link" data-toggle="tooltip" data-placement="right" title="add a server"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a></div>			
		</div>				 
	</div>

	<!-- DB SERVER -->
	<div type="button" class="list-group-item">
		<a class="" role="button" data-toggle="collapse" href="index.php?zone=applications&page=dbserver#db_list" aria-expanded="false" aria-controls="db_list">DB SERVER</a>
		<div class="collapse <?php echo ((isset($_GET['page']) AND ($_GET['page'] == 'dbserver'))) ? 'in' : '' ; ?>" id="db_list">
			<div>&#9642; <a href="index.php?zone=applications&page=dbserver" class="menu_link"><small>All versions</small></a></div>
			<?php
			foreach ($db_servers_list AS $app_params) {
				$httpserver_name = ($conf_dbserver['dbserver_folder'] == $app_params['app_folder']) ? '<b>' . $app_params['app_name'] . ' ' . $app_params['app_version'] . '</b>' : $app_params['app_name'] . ' ' . $app_params['app_version'];
				echo '<div>&#9642; <a href="index.php?zone=applications&page=dbserver&serverfolder=' . $app_params['app_folder'] . '" class="menu_link"><small>' . $httpserver_name . '</small></a></div>';
			}
			?>	
			<div>&#9642; <a href="http://www.easyphp.org/download.php" target="_blank" class="menu_link" data-toggle="tooltip" data-placement="right" title="add a server"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a></div>						
		</div>				 
	</div>

	<!-- PYTHON -->
	<div type="button" class="list-group-item">
		<a href="index.php?zone=applications&page=python">PYTHON</a>		 
	</div>

	<!-- RUBY -->
	<div type="button" class="list-group-item">
		<a href="index.php?zone=applications&page=ruby">RUBY</a>		 
	</div>

	<!-- PERL -->
	<div type="button" class="list-group-item">
		<a href="index.php?zone=applications&page=perl">PERL</a>		 
	</div>

</div>	