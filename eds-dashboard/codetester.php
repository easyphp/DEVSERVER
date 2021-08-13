<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

session_start(); 
include('functions.inc.php');
$lang = 'en';

$verify_nonce = verify_nonce();

if (isset($_POST['to']) AND $_POST['to'] == "interpretcode") {
	file_put_contents('codetester_source.php', $_POST['sourcecode']);
}
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

		<title>EasyPHP Devserver</title>

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="library/font-awesome/css/font-awesome.min.css">
		
		<!-- Bootstrap core CSS -->
		<link href="library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Devicon -->
		<link rel="stylesheet" type="text/css" href="library/devicon/devicon.min.css">			
		
		<!-- Custom CSS -->
		<link rel="stylesheet" href="custom.css" type="text/css" />

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
	</head>

	<body style="padding-top:0px;background-color:#ecf0f1;">
					
		<div style="text-align:center;background-color:#e3e7e8;padding:15px;">
			<a href="index.php" class="btn btn-danger"><b>CLOSE</b></a>
		</div>
		
		<div class="container">
			
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
				<h3>Code</h3>
				<form  method="post" action="codetester.php">
					<textarea style="display:none" name="sourcecode" id="editor_php_content"></textarea>
					<div style="background-color:#2c3e50;padding:10px;border-radius:4px;">
						<div id="editor_php" style="height:300px;"><?php echo htmlentities(trim(file_get_contents('codetester_source.php'))); ?></div>
					</div>
					<input type="hidden" name="nonce" value="<?php echo get_nonce(); // Russell, 2012-11-10 ?>" />
					<input type="hidden" name="to" value="interpretcode" />
					<input type="submit" class="btn btn-default btn-sm" style="margin-top:4px;" value="interpret" class="submit" />
				</form>
				</div>
			</div>		

			<br />
			
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<h3>Code interpreted by the server and sent to the browser</h3>
					<div style="background-color:white;border-radius:4px;padding:20px;margin-bottom:50px;">
						<?php
						if ($verify_nonce) {
							?>
							<iframe src="codetester_source.php" height="100%" width="100%" frameborder="0" style="z-index:100;height:1500px;"></iframe>
							<?php
						} else {
							echo '<span style="color:#f1c40f;font-family:monospace;">Detected an invalid submit. Resubmit your code with the button "interpret".</span>';
						}
						?>
					</div>
				</div>
			</div>
			
		</div>
		
		<!-- JavaScript -->
		<script src="library/jquery/jquery.min.js"></script>
		<script src="library/ace/ace.js" type="text/javascript" charset="utf-8"></script>
		<script>
			var editor_php = ace.edit("editor_php");
			document.getElementById('editor_php').style.fontSize='14px';
			editor_php.setTheme("ace/theme/twilight");
			editor_php.getSession().setMode("ace/mode/php");
			editor_php.setHighlightActiveLine(false);
			var textarea_php = $('#editor_php_content');
			editor_php.getSession().on('change', function () {
				textarea_php.val(editor_php.getSession().getValue());
			});
			textarea_php.val(editor_php.getSession().getValue());
		</script>

	</body>
</html>