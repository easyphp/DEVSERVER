<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */


/** 
 * Russell, 2012-11-10: Shared functionality used in index.php and 
 * codetester.php.
 * Side-affect, can't use browser's back button to get old results as
 * a re-post will have a different nonce so will block
 */
function get_nonce() {
    $nonce = isset($_SESSION['nonce'])?$_SESSION['nonce']: hash('sha512', get_random_string());
    $_SESSION['nonce'] = $nonce;
    return $nonce;
}
function remove_nonce() {
    unset($_SESSION['nonce']); //Remove the nonce from being used again!
}

function verify_nonce() {
    $nonce = get_nonce();  // Fetch the nonce from the last request
    remove_nonce(); // clear it so it can't be used again now we have it locally
    session_regenerate_id(true); // replace old session, stops session fixation    
    // only verify if nonce is sent and matches what is expected
    return (isset($_POST['nonce']) AND $_POST['nonce'] == $nonce);
}

function get_random_string() 
{
  $random_string = array();
  for($index=0; $index<32; $index++)
  {
    //ascii chars 32 - 126 are printable (127 is DEL)
    $random_string[] = chr( mt_rand(32,126));
  }
  return  implode($random_string);
}
?>