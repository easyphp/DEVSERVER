<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

include("i18n.inc.php"); 
/** 
 * Russell, 2012-11-10: nonce functionality relies on some function calls
 * located in functions.inc.php and needs sessions to operate
 * Also added a hidden input called nonce in rendered html below
 */
include("functions.inc.php");
session_start();

if (isset($_POST['to']) AND $_POST['to'] == "interpretcode") {
  file_put_contents('codesource.php', 
          verify_nonce() ? $_POST['sourcecode'] : 'Detected an invalid submit, maybe an exploit attempt (o2326570).');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>[EasyPHP] Code</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="images_easyphp/easyphp_favicon.ico" />

<body style="margin:0px;padding:0px;background:#ffffff;font-family:arial, helvetica, sans-serif;">

<div style="margin:0px 0px 10px 0px;padding:10px;font-size:18px;font-weight:bold;text-align:center;background-color:#EEEEEE;">
	<a href="index.php" title="<?php echo $close; ?>" style="padding:2px 10px 2px 10px;margin:0px;background-color:#A84B43;border:1px solid #A84B43;text-transform:uppercase;color:white;text-decoration:none;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;"><?php echo $close; ?></a>
</div>

<div style="width:770px;margin:0px auto 2px auto;padding:0px 0px 0px 0px;color:black;font-size:18px;font-weight:bold;"><?php echo $t_ct_code; ?></div>
<form  method="post" action="codetester.php" style="width:760px;margin:0px auto 0px auto;padding:10px;background-color:#EEEEEE;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">
	<textarea name="sourcecode" rows="10" style="width:748px;margin:0px;padding:5px;border:1px solid #c0c0c0;"><?php echo '' . trim(file_get_contents('codesource.php')); ?></textarea>
	<input type="hidden" name="to" value="interpretcode" />
        <input type="hidden" name="nonce" value="<?php echo get_nonce(); /* Russell, 2012-11-10 */ ?>" />
	<input type="submit" value="Interpret the code" class="submit" style="width:150px;margin:4px 0px 0px 0px;padding:0px;border:solid 1px silver;cursor:pointer;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;" />
</form>

<br />
<div style="width:770px;margin:0px auto 2px auto;padding:0px 0px 0px 0px;color:black;font-size:18px;font-weight:bold;"><?php echo $t_ct_codeinterpreted; ?></div>
<div style="width:760px;margin:0px auto 0px auto;padding:10px;font-size:12px;background-color:#FFF3AF;-moz-border-radius:2px;-khtml-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;"><?php include('codesource.php'); ?></div>
	
</body>
</html>