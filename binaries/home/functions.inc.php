<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */


// Check if port is available
function check_port($port) {
	$conn = @fsockopen("127.0.0.1", $port, $errno, $errstr, 0.2);
	if ($conn) {
		fclose($conn);
		return true;
	}
}

 
function i18n_string($string){
	  $string = htmlspecialchars($string);
	  return $string;
}


function cut($text, $length) {
	if (strlen($text) <= $length) return $text;
	if (strlen($text) > $length) return substr($text, 0, $length-3) . '...';
}


function cutatspace($text, $length) {
	if (strlen($text) <= $length) return $text;
	$text = nl2br($text);
	$pos = strrpos(substr($text, 0, $length), " ");
	if (is_integer($pos) && $pos) return substr($text, 0, $pos) . '...';
	else return substr($text, 0, $length) . '...';
}

function timezones_select($selectedzone)
{
	echo '<select name="timezone" style="width:95%;">';
	function timezonechoice($selectedzone) {
		$all = timezone_identifiers_list();

		$i = 0;
		foreach($all AS $zone) {
			$zone = explode('/',$zone);
			$zonen[$i]['continent'] = isset($zone[0]) ? $zone[0] : '';
			$zonen[$i]['city'] = isset($zone[1]) ? $zone[1] : '';
			$zonen[$i]['subcity'] = isset($zone[2]) ? $zone[2] : '';
			$i++;
		}

		asort($zonen);
		$structure = '';
		foreach($zonen AS $zone) {
			extract($zone);
			if($continent == 'Africa' || $continent == 'America' || $continent == 'Antarctica' || $continent == 'Arctic' || $continent == 'Asia' || $continent == 'Atlantic' || $continent == 'Australia' || $continent == 'Europe' || $continent == 'Indian' || $continent == 'Pacific') {
				if(!isset($selectcontinent)) {
					$structure .= '<optgroup label="'.$continent.'">';
				} elseif($selectcontinent != $continent) {
					$structure .= '</optgroup><optgroup label="'.$continent.'">';
				}

				if(isset($city) != ''){
					if (!empty($subcity) != ''){
						$city = $city . '/'. $subcity;
					}
					$structure .= "<option ".((($continent.'/'.$city)==$selectedzone)?'selected="selected "':'')." value=\"".($continent.'/'.$city)."\">".str_replace('_',' ',$city)."</option>";
				} else {
					if (!empty($subcity) != ''){
						$city = $city . '/'. $subcity;
					}
					$structure .= "<option ".(($continent==$selectedzone)?'selected="selected "':'')." value=\"".$continent."\">".$continent."</option>";
				}

				$selectcontinent = $continent;
			}
		}
		$structure .= '</optgroup>';
		return $structure;
	}
	echo timezonechoice($selectedzone);
	echo '</select>';
}

/** 
 * Russell, 2012-11-10: Shared functionality useed in index.php and 
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