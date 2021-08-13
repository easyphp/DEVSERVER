<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

//== ACTIONS ==================================================================

if (isset($_POST['action'])) {

	// Include and exec
	if (isset($_POST['action']['request'])) {
		foreach ($_POST['action']['request'] as $request) {
			if ($request['type'] == 'include') include(urldecode($request['value']));
			if ($request['type'] == 'exe') exec(urldecode($request['value']));
		}
	}
	
	$redirect = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header("Location: " . $redirect);
	exit;
}
//=============================================================================

// Conf files
include("conf_httpserver.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Laurent Abbal">
		<link rel="icon" href="images/favicon.png" />

		<title>EasyPHP Devserver | File Explorer</title>

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="library/font-awesome/css/font-awesome.min.css">
				
		<!-- Bootstrap core CSS -->
		<link href="library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom CSS -->
		<link rel="stylesheet" href="custom_explorer.css" type="text/css" />

		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="bootstrap/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<script src="library/bootstrap/js/ie-emulation-modes-warning.js"></script>

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="library/bootstrap/js/ie10-viewport-bug-workaround.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
 		<script language="javascript" type="text/javascript">
			function delay() {
				document.getElementById('delay').style.display = "block";
			}
		</script>		
		
	</head>
	
	<body style="background-color:transparent;padding:0px;margin:0px;">

		<?php
		$root_dir = urldecode($_GET['root_dir']);
		
		if (!isset($_GET['dir'])) {
			$dir = $root_dir;
		} else {
			$dir = urldecode($_GET['dir']);
		}

		// Open a known directory, and proceed to read its contents
		if (is_dir($dir)) {
			if ($directory = opendir($dir)) {
				$list_file = array();
				$list_dir = array();
				while (($file = readdir($directory)) !== false) {
					if (($file != '..') && ($file != '.') && ($file != '')) {
						if (filetype($dir . $file) == "dir") $list_dir[] = $file;
						if (filetype($dir . $file) == "file") $list_file[] = $file;						
					}						
				}
				closedir($directory);
			}
			?>

			<div style="padding:0px 30px 0px 30px;margin:0px;">
				<div style="width:95%;top:0px;padding:10px 10px 10px 10px;margin:0px;background-color:#f5f5f5;border-radius:4px;">
					<?php
					if ($root_dir != $dir) {
						?>
						<a href="explorer.php?<?php echo (isset($_GET['alias']))?'alias='.$_GET['alias'].'&' : '' ?>dir=<?php echo urlencode(dirname($dir) . '\\') ?>&root_dir=<?php echo urlencode($root_dir) ?>" class="btn btn-default btn-xxs"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></a>
						<a href="explorer.php?<?php echo (isset($_GET['alias']))?'alias='.$_GET['alias'].'&' : '' ?>dir=<?php echo urlencode($root_dir) ?>&root_dir=<?php echo urlencode($root_dir) ?>" class="btn btn-default btn-xxs"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
						<div style="color:silver;padding:5px 0px 0px 0px;"><samp class="small"><?php echo $dir; ?></samp></div>
						<?php
					} else {
						?>
						<a href="explorer.php?<?php echo (isset($_GET['alias']))?'alias='.$_GET['alias'].'&' : '' ?>dir=<?php echo urlencode($root_dir) ?>&root_dir=<?php echo urlencode($root_dir) ?>" class="btn btn-default btn-xxs"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
						<div style="color:silver;padding:5px 0px 0px 0px;"><samp class="small"><?php echo $dir; ?></samp></div>
						<?php
					}
					?>
				</div>
				
				<div id="delay">&nbsp;</div>
				
				<table class="table table-hover table-condensed" style="margin-top:10px;border:none;">
				<tbody>
				<?php
				$nd = 0;
				foreach($list_dir AS $dirname) {
					$nd++;
					?>
					<tr class="small">
					<td style="border-top:none;padding-left:10px;"><i class="fa fa-folder-open" style="color:silver;"></i></td>
					<td class="explorer_dirname" style="border-top:none;width:95%;"><a href="explorer.php?<?php echo (isset($_GET['alias'])) ? 'alias='.$_GET['alias'].'&' : ''; ?>dir=<?php echo urlencode($dir . $dirname . '\\')?>&root_dir=<?php echo urlencode($root_dir) ?>"><?php echo $dirname ?></a></td>
					<td style="border-top:none;padding-right:10px;">

						<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form" style="display:inline" name="explorer_dir_<?php echo $nd ?>">
							<input type="hidden" name="action[request][0][type]" value="exe" />
							<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . $dir . $dirname) ?>" />
							<a type="submit" role="submit" data-toggle="tooltip" data-placement="top" title="Open in File Explorer" onclick="delay();document.forms['explorer_dir_<?php echo $nd ?>'].submit()" style="cursor:pointer;"><span class="glyphicon glyphicon-list" style="color:#95a5a6;" aria-hidden="true"></span></a>
						</form>					
					
					</td>
					</tr>
					<?php
				}
				$nf = 0;
				foreach($list_file AS $filename) {
					$nf++;
					$extensions = array('php', 'py', 'txt', 'jpg', 'gif', 'png', 'rb', 'pl', 'html', 'htm');
					$alias_name = (isset($_GET['alias'])) ? '/' . $_GET['alias'] : '' ; 
					$browse = (in_array(pathinfo($filename, PATHINFO_EXTENSION), $extensions)) ? '<a href="http://127.0.0.1:' . $conf_httpserver['httpserver_port'] . $alias_name . '/' . str_replace('\\', '/', str_replace($root_dir, '', $dir)) . $filename . '" target="_blank"  data-toggle="tooltip" data-placement="top" title="Open in Browser">' . $filename . '</a>' : $filename;
					?>
					<tr class="small">
						<td style="border-top:none;padding-left:10px;"><i class="fa fa-file" style="color:silver;"></i></td>
						<td style="border-top:none;color:#555555;width:95%;"><?php echo $browse ?></td>
						<td style="border-top:none;padding-right:10px;">
						
							<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form" style="display:inline" name="explorer_file_<?php echo $nf ?>">
								<input type="hidden" name="action[request][0][type]" value="exe" />
								<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . $dir . $filename) ?>" />
								<a type="submit" role="submit" onclick="delay();document.forms['explorer_file_<?php echo $nf ?>'].submit()"  data-toggle="tooltip" data-placement="top" title="Edit" style="cursor:pointer;"><span class="glyphicon glyphicon-pencil" style="color:#95a5a6;" aria-hidden="true"></span></a>
							</form>				

						</td>
					</tr>
					<?php
				}	
				?>
				</tbody>
				</table>
			</div>
			<?php
		}
		?>
	
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="library/jquery/jquery.min.js"></script>
		<script src="library/bootstrap/js/bootstrap.min.js"></script>
		<script>
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
		</script>
		<script>
			$(function () {
			  $('[data-toggle="popover"]').popover()
			})		
		</script>	
	
	</body>
</html>