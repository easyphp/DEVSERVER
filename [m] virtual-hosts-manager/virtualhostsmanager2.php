<?php
/**
 * Virtual Hosts Manager for DEVSERVER
 * @version  2.0
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

include_once('virtualhostsmanager2_functions.php');

$module_i18n = array();
$module_i18n = array(
	"en"	=>	array(
		"norights"				=>	"Unfortunately, you do not have the rights to create a Virtual Host. You must have write permissions on the file:",
		"activate"				=>	"activate",		
		"desactivate"			=>	"deactivate",		
		"delete"				=>	"Delete this Virtual Host",	
		"add_vhost"				=>	"Add a Virtual Host",	
		"add_vhost_chapo"		=>	"When maintaining and developing multiple sites / applications on internet, it is helpful to have a copy of each site / application 
									running on your local computer and to have them running in the same conditions (same server configuration, same path...). Virtual 
									Hosts allow you to do that. Thus, whenever you move your projects to production environment, you don't have to change the absolute 
									path manually and they run exactely the same way.",	
		"add_vhost_1"			=>	"<span>If the directory you want to use doesn't exist, create it</span><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(eg: D:\localweb\projet1)",	
		"add_vhost_2"			=>	"<span>Choose a name</span> (eg: Projet1)",	
		"add_vhost_3"			=>	"<span>Copy below the path to your directory</span> (eg: D:\weblocal\projet1)",	
		"add_vhost_4"			=>	"create",	
		"info"					=>	"info",	
		"cancel"				=>	"cancel",		
		"close"					=>	"close",	
		"warning_servername_1"	=>	"The name can only contain alpha-numeric characters, dots, underscores and hyphens.",
		"warning_servername_2"	=>	"If the name is an internet address, this address will redirected on your local computer. Not on internet.",
		"warning_conf"			=>	"If you experience any problem, open the folder 'EasyPHP-xxx/conf_files/', delete or rename 'httpd.conf', rename the most recent backup 
									(example : 'httpd_2011-03-18@1300458590.conf' &gt; 'httpd.conf') and restart EasyPHP. Follow the same procedure with the hosts file :",
		"warning_url"			=>	"The name looks like an internet address. Be carefull. If the name chosen is www.google.com for example, the address 
									http://www.google.com will be redirected to your local computer and won't be reachable on internet. You can do that, but don't 
									forget to deactivate your virtual 
									host or to delete it if you want go on internet.",
		"save"					=>	"Save",	
		"add_vhost_warning_1"	=>	"Warning : the name is empty.",
		"add_vhost_warning_2"	=>	"Warning : the path is empty.",
		"add_vhost_warning_3"	=>	"Warning : the directory corresponding to the path you have chosen does not exist.",
		"add_vhost_warning_4"	=>	"Warning : the name can only contain alpha-numeric characters, dots, underscores and hyphens.",
		"add_vhost_warning_5"	=>	"Warning : this name, or a part of this name, is already used by the system.",
	),
	"fr"	=>	array(
		"norights"				=>	"Malheureusement, vous n&apos;avez pas les droits n&eacute;cessaires pour cr&eacute;er un H&ocirc;te Virtuel. Vous devez avoir les 
									droits en &eacute;criture pour le fichier :",
		"activate"				=>	"activer",		
		"desactivate"			=>	"d&eacute;sactiver",		
		"delete"				=>	"Supprimer cet H&ocirc;te Virtuel",	
		"add_vhost"				=>	"ajouter un h&ocirc;te virtuel",	
		"add_vhost_chapo"		=>	"Quand on maintient ou d&eacute;veloppe de plusieurs sites / applications sur Internet, il est utile d&apos;avoir une copie de chaque 
									site / application qui fonctionne sur un ordinateur en local dans les m&ecirc;mes conditions (m&ecirc;me configuration du 
									serveur, le m&ecirc;me chemin ...). Les H&ocirc;tes Virtuels permettent de le faire. Ainsi, une fois vos d&eacute;veloppements termin&eacute;s, lorsque vous 
									transf&eacute;rez vos projets sur votre environnement de production, vous n&apos;avez pas &agrave; changer le chemin absolu manuellement. Ils fonctionneront 
									exactement de la m&ecirc;me mani&egrave;re.",	
		"add_vhost_1"			=>	"<span>Si le dossier que vous souhaitez utiliser n&apos;existe pas, cr&eacute;ez le.</span><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(eg: D:\localweb\project1)",	
		"add_vhost_2"			=>	"<span>Choisissez un nom</span> (eg: Project1)",	
		"add_vhost_3"			=>	"<span>Copiez ci-dessous le chemin de votre dossier</span> (eg: D:\weblocal\project1)",	
		"add_vhost_4"			=>	"cr&eacute;er",		
		"info"					=>	"info",	
		"cancel"				=>	"annuler",		
		"close"					=>	"fermer",		
		"warning_servername_1"	=>	"Le nom ne peut contenir que des caract&egrave;res alphanum&eacute;riques, des points, traits de soulignement (underscore) et des tirets.",
		"warning_servername_2"	=>	"Si le nom choisi est une adresse Internet, cette adresse sera redirig&eacute;e sur votre ordinateur local. Pas sur Internet.",
		"warning_conf"			=>	"En cas de probl&egrave;me, ouvrir le r&eacute;pertoire 'EasyPHP-xxx/conf_files/', effacer ou renommer 'httpd.conf', renommer la 
									sauvegarde la plus r&eacute;cente (exemple : 'httpd_2011-03-18@1300458590.conf' &gt; 'httpd.conf') et red&eacute;marrer EasyPHP.",
		"warning_url"			=>	"Le nom ressemble &agrave; une adresse Internet. Soyez tr&egrave;s vigilant. Si le nom choisi est www.google.com par exemple, 
									l&apos;adresse http://www.google.com sera redirig&eacute; vers votre ordinateur local et ne sera plus accessibles sur internet. 
									Vous pouvez le faire, mais n&apos;oubliez pas de d&eacute;sactiver votre h&ocirc;te virtuel ou de l&apos;effacer si vous voulez 
									aller sur internet.",
		"save"					=>	"Enregistrer",	
		"add_vhost_warning_1"	=>	"Attention : le nom est vide.",
		"add_vhost_warning_2"	=>	"Attention : le chemin est vide.",
		"add_vhost_warning_3"	=>	"Attention : le r&eacute;pertoire correspondant au chemin que vous avez saisi n'existe pas.",
		"add_vhost_warning_4"	=>	"Attention : le nom ne peut contenir que des carat&egrave;res alphanum&eacute;riques, des points, tirets et tirets bas (underscore).",	
		"add_vhost_warning_5"	=>	"Attention : ce nom, ou une partie de ce nom, est d&eacute;j&agrave; utilis&eacute; par le syst&egrave;me.",			
	),
);


$help = '<table style="border-collapse:separate;border-spacing:5px;">';
$help .= '<tr>';
$help .= '<td><a type="submit" class="btn btn-default btn-xs" href="https://www.easyphp.org/support.php" target="_blank"><span class="glyphicon glyphicon-link small" aria-hidden="true"></span></a></td>';
$help .= '<td><samp class="small">support</samp></td>';
$help .= '</tr>';
$help .= '<tr>';
$help .= '<td style="vertical-align:top"><form method="post" style="display:inline" action="http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'" class="form-inline" role="form">';
$help .= '<input type="hidden" name="action[request][0][type]" value="exe" />';
$help .= '<input type="hidden" name="action[request][0][value]" value="'.urlencode('explorer apache-vhosts.conf').'" />';
$help .= '<button type="submit" class="btn btn-default btn-xs" onclick="delay()"><span class="glyphicon glyphicon-pencil small" aria-hidden="true"></span></button>';
$help .= '</form></td>';
$help .= '<td><samp class="small">modify <i>apache-vhosts.conf</i> manually</samp></td>';
$help .= '</tr>';
$help .= '<tr>';
$help .= '<td style="vertical-align:top"><form method="post" style="display:inline" action="http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'" class="form-inline" role="form">';
$help .= '<input type="hidden" name="action[request][0][type]" value="exe" />';
$help .= '<input type="hidden" name="action[request][0][value]" value="'.urlencode('explorer ' . get_hostsfile_dir() . '\hosts').'" />';
$help .= '<button type="submit" class="btn btn-default btn-xs" onclick="delay()"><span class="glyphicon glyphicon-pencil small" aria-hidden="true"></span></button>';
$help .= '</form></td>';
$help .= '<td><samp class="small">modify <i>hosts</i> manually <span style="color:red">(admin rights needed)</span></samp></td>';
$help .= '</tr>';
$help .= '</table>';
?>


<a id="anchor_virtualhostsmanager2"></a>
<div class="col-sm-10" style="padding:5px 0px 0px 5px;">
	<img src="images/module_icon_virtualhostsmanager.png" />
	&nbsp;<strong><?php echo $module_info['module_application_name'] . ' ' . $module_info['module_application_version'] ?></strong>
	<span role="button" style="padding:0px 10px 0px 10px;color:silver;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-cog" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" data-content="<?php echo htmlentities($application_info) ?>"></span>
	<span role="button" style="padding:0px 10px 0px 0px;color:silver;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-tasks" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="" data-content="<?php echo htmlentities($help) ?>"></span>
	<span role="button" style="padding:0px 0px 0px 0px;color:#f39c12;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="" data-content="<samp class='small'><?php echo htmlentities('Certificates expire after 27 months. Renew them from time to time (delete the virtual host and recreate it).') ?></samp>"></span>
</div>

<?php
// test apache version
include(dirname(getcwd()).'/eds-binaries/httpserver/' . $conf_httpserver['httpserver_folder'] . '/eds-app-settings.php');
$apache_version = str_replace('.','',$app_settings['app_version_nb']);

if ($apache_version < 2448) {
	echo '<br style="clear:both"; />';
	echo '<div class="alert alert-warning text-center" style="margin:10px 20px 5px 20px; ">You need Apache 2.2.48 or newer. Visit the <a href="https://warehouse.easyphp.org/">warehouse</a> for new versions.</div>';
} else {

	if (is_writable(get_hostsfile_dir() . '\hosts')) {
		?>
		<div class="col-sm-2 text-right" style="padding:0px 0px 0px 0px;">
			<a role="button" tabindex="0" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_vhost2">add a virtual host</a>
		</div>
		<?php

		//== DISPLAY VIRTUAL HOSTS ===============================================
		
		// create 'apache-vhosts.conf' if doesn't exist
		if(!is_file('apache-vhosts.conf')) file_put_contents('apache-vhosts.conf', '');
		
		$vhosts_file = trim(file_get_contents('apache-vhosts.conf'));
		
		if (preg_match_all('/#?<VirtualHost.*?SSLEngine.*?<\/VirtualHost>/s', $vhosts_file, $vhosts_array)) {
		
			echo '<div class="col-sm-12" style="padding-top:5px;">';
			echo '<table class="table table-hover table-condensed vhost_table" style="padding:20px;">';
			foreach ($vhosts_array[0] as $key => $vhost) {

				// Status
				$vhost2_status = 1;
				if (strpos($vhost,'#') !== false) $vhost2_status = 0;
				
				// ServerName
				preg_match('/^[\s#]*ServerName\s*(.*)/m', $vhost, $matches);
				$vhost_servername = trim($matches[1]);
				
				// DocumentRoot
				preg_match('/^[\s#]*DocumentRoot\s*"(.*)"/m', $vhost, $matches);
				$vhost_documentroot = trim($matches[1]);
							
				if ($vhost2_status == 1) {
					$button_status_text = 'deactivate';
					$button_status_opacity = '1';
				} else {
					$button_status_text = 'activate';
					$button_status_opacity = '0.5';
				}
				?>
				<tr>
					<?php
					if ($eds_httpserver_running == 1) {
						// Http server active
					

						if ($vhost2_status == 1) {
							// Active Virtual Host
							if (file_exists($vhost_documentroot)) {
								// DocumentRoot exists
								?>
								<td>
									<span class="glyphicon glyphicon-paperclip" style="vertical-align:middle;color:gray;" aria-hidden="true"></span>
								</td>
								<td style="width:40%">
									<a role="button" class="btn btn-primary btn-xs" href="http://<?php echo $vhost_servername . ':' . $conf_httpserver['httpserver_port'] ?>" target="_blank"><samp>http</samp></a>
									<a role="button" class="btn btn-primary btn-xs" href="https://<?php echo $vhost_servername ?>" target="_blank"><samp>https</samp></a>
									<span class="vhost_name"><?php echo wordwrap($vhost_servername, 30, "<br />", true); ?></span>
								</td>
								<td>
									<?php
									if (stripos($vhost_servername,'.') !== false) {
										echo '<span role="button" style="outline:0;padding:0px 10px 0px 10px;color:#D9534F;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-flag" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="<b class=\'text-center\'>WARNING</b>" data-content="<p style=\'color:#D9534F;\'>' . $module_i18n[$lang]['warning_url'] . '</p>"></span>';
									}							
									?>
								</td>
								<?php
							} else {
								// DocumentRoot doesn't exist
								?>
								<td>
									<span class="glyphicon glyphicon-eye-close" style="color:#e74c3c;opacity:0.5;" aria-hidden="true"></span>
								</td>
								<td style="width:30%">
									<span class="vhost_list_name_broken" style="opacity:0.5;" data-toggle="tooltip" data-placement="top" title="The folder doesn't exist. Check your folder or delete this virtual host and create a new one." target="_blank"><b><?php echo wordwrap($vhost_servername, 30, "<br />", true); ?></b></span>			
								</td>
								<td>
									<?php
									if (stripos($vhost_servername,'.') !== false) {
										echo '<span role="button" style="outline:0;padding:0px 10px 0px 10px;color:#e2a1a0;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-flag" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="<b class=\'text-center\'>WARNING</b>" data-content="<p style=\'color:#D9534F;\'>' . $module_i18n[$lang]['warning_url'] . '</p>"></span>';
									}							
									?>
								</td>
								<?php								
							}
							
						} else {
							// Inactive Virtual Host
							if (file_exists($vhost_documentroot)) {
								?>
								<td>
									<span class="glyphicon glyphicon-ban-circle" style="color:gray;opacity:0.5;" aria-hidden="true"></span>
								</td>
								<td style="width:40%">
									<button type="button" class="btn btn-default btn-xs" disabled="disabled"><samp>http</samp></button>
									<button type="button" class="btn btn-default btn-xs" disabled="disabled"><samp>https</samp></button>
									<span class="vhost_name" style="opacity:0.5"><?php echo wordwrap($vhost_servername, 30, "<br />", true); ?></span>
								</td>
								<?php
							} else {
								?>
								<td>
									<span class="glyphicon glyphicon-eye-close" style="color:#e74c3c;opacity:0.5;" aria-hidden="true"></span>
								</td>
								<td style="width:30%">
									<span class="vhost_list_name_broken" style="opacity:0.5;" data-toggle="tooltip" data-placement="top" title="The folder doesn't exist. Check your folder or delete this virtual host and create a new one." target="_blank"><b><?php echo wordwrap($vhost_servername, 30, "<br />", true); ?></b></span>			
								</td>
								<?php								
							}
							?>
							<td>
								<?php
								if (stripos($vhost_servername,'.') !== false) {
									echo '<span role="button" style="outline:0;padding:0px 10px 0px 10px;color:#e2a1a0;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-flag" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="<b class=\'text-center\'>WARNING</b>" data-content="<p style=\'color:#D9534F;\'>' . $module_i18n[$lang]['warning_url'] . '</p>"></span>';
								}							
								?>
							</td>
							<?php						
						}											

					} else {
						// Http server inactive
						if (file_exists($vhost_documentroot)) {
							?>
							<td>
								<span class="glyphicon glyphicon-ban-circle" style="color:gray;" aria-hidden="true"></span>
							</td>
							<td style="width:30%">
								<span class="vhost_name" data-toggle="tooltip" data-placement="top" title="Start an HTTP server!" target="_blank" style="opacity:0.5;"><b><?php echo wordwrap($vhost_servername, 30, "<br />", true); ?></b></a>
							</td>
							<?php
						} else {
							?>
							<td>
								<span class="glyphicon glyphicon-eye-close" style="color:#e74c3c;opacity:0.5;" aria-hidden="true"></span>
							</td>
							<td style="width:30%">
								<span class="vhost_list_name_broken" style="opacity:0.5;" data-toggle="tooltip" data-placement="top" title="The folder doesn't exist. Check your folder or delete this virtual host and create a new one." target="_blank"><b><?php echo wordwrap($vhost_servername, 30, "<br />", true); ?></b></span>			
							</td>
							<?php								
						}
						?>
						<td>
							<?php
							if (stripos($vhost_servername,'.') !== false) {
								echo '<span role="button" style="outline:0;padding:0px 10px 0px 10px;color:#e2a1a0;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-flag" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="<b class=\'text-center\'>WARNING</b>" data-content="<p style=\'color:#D9534F;\'>' . $module_i18n[$lang]['warning_url'] . '</p>"></span>';
							}							
							?>
						</td>
						<?php
						}
					?>
					<td>
						<span class="glyphicon glyphicon-folder-open small" style="color:silver;padding-right:0px;" aria-hidden="true"></span>
					</td>
					<?php
					if (file_exists($vhost_documentroot)) {
						?>
						<td style="width:60%">
							<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" class="form-inline" role="form" name="vhost_<?php echo $key ?>">
								<input type="hidden" name="action[request][0][type]" value="exe" />
								<input type="hidden" name="action[request][0][value]" value="<?php echo urlencode('explorer ' . $vhost_documentroot) ?>" />
								<a type="submit" role="submit" class="vhost_list_directory" data-toggle="tooltip" data-placement="top" title="Explore Directory" onclick="delay();document.forms['vhost_<?php echo $key ?>'].submit()"><samp class="small"><?php echo wordwrap(str_replace('/', '\\', $vhost_documentroot), 30, "<br />", true) ?></samp></a>
							</form>					
						</td>
						<?php
					} else {
						?>
						<td style="width:60%">
							<samp class="small" style="color:silver;"><?php echo wordwrap(str_replace('/', '\\', $vhost_documentroot), 30, "<br />", true) ?></samp>
						</td>					
						<?php
					}
					
					// modify
					if ($vhost2_status == 0) {
						?>
						<td class="text-right"></td>
						<?php
					} else {
						?>
						<td class="text-right">				
							<a role="button" tabindex="0" class="btn btn-default btn-xs" style="opacity:<?php echo $button_status_opacity ?>;" data-toggle="modal" data-target="#modify_vhost2_<?php echo $key ?>"><span class="glyphicon glyphicon-pencil"></span></a>
						</td>
						<?php
					}				
					?>
					
					<!-- activate / deactivate -->
					<td class="text-right">				
						<a role="button" tabindex="0" class="btn btn-info btn-xs" style="width:100px;opacity:<?php echo $button_status_opacity ?>;" aria-hidden="true" data-toggle="popover" data-placement="top" data-trigger="focus" data-html="true" data-content="<div class='text-center'><a href='?vhost2_current_servername=<?php echo $vhost_servername ?>&vhost2_current_status=<?php echo $vhost2_status ?>&action=include&value=<?php echo urlencode("../eds-modules/virtualhostsmanager2/virtualhostsmanager2_update.php") ?>' onclick='delay()' style='color:white;' class='btn btn-danger btn-sm'>confirm</a><div>"><?php echo $button_status_text ?></a>
					</td>
					
					<!-- delete -->
					<td class="text-right">
						<a role="button" tabindex="0" style="cursor:pointer;padding:3px 10px 0px 10px;" class="vhost_delete glyphicon glyphicon-remove" aria-hidden="true" data-toggle="popover" data-placement="top" data-trigger="focus" data-html="true" data-content="<div class='text-center'><a href='?vhost2_servername_delete=<?php echo $vhost_servername ?>&action=include&value=<?php echo urlencode("../eds-modules/virtualhostsmanager2/virtualhostsmanager2_update.php") ?>' onclick='delay()' style='color:white;' class='btn btn-danger btn-sm'>delete</a><div>"></a>
					</td>
				</tr>
				
				<?php
			}
			echo '</table>';
			echo '</div>';
		}
		//========================================================================

		// MODALS EDIT VHOST
		foreach ($vhosts_array[0] as $key => $vhost) {

			// ServerName
			preg_match('/^[\s#]*ServerName\s*(.*)/m', $vhost, $matches);
			$vhost_servername = trim($matches[1]);
			
			// DocumentRoot
			preg_match('/^[\s#]*DocumentRoot\s*"(.*)"/m', $vhost, $matches);
			$vhost_documentroot = trim($matches[1]);					
			?>

			<div class="modal fade" id="modify_vhost2_<?php echo $key ?>" tabindex="-1" role="dialog" aria-labelledby="modify_vhost2_<?php echo $key ?>">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					
						<div class="modal-header">
							<h3 class="modal-title" style="text-align:center;">Modify this Virtual Host</h3>
						</div>	
					
						<div class="modal-body" style="padding:10px 40px 10px 40px;">
							
							<?php
							// Errors
							if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '1')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_1'] . '</div>';	
							}
							if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '2')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_2'] . '</div>';	
							}
							if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '3')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_3'] . '</div>';	
							}
							if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '4')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_4'] . '</div>';	
							}
							if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '5')){
								echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_5'] . '</div>';	
							}	
							?>			
						
							<form method="post" action="<?php echo 'http://' . $_SERVER["HTTP_HOST"] . '/index.php#anchor_virtualhostsmanager2' ?>" role="form" id="edit_vhost_form_<?php echo $key; ?>">
								<div class="form-group">
									
									<label for="vhost_name" style="padding-top:10px;"><span class="badge small">1</span> Name</label>
									<div class="input-group" style="padding-left:25px;">
										<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span></span>
										<input type="text" class="form-control input-sm" id="vhost_name" name="vhost_name" value="<?php if (isset($_GET['to']) AND $_GET['to'] == 'add_vhost_error') {echo $_GET['add_vhost_name'];} else {echo $vhost_servername;} ?>" placeholder="">
									</div>						
									<p style="color:gray;padding-left:25px;margin-bottom:0px;margin-top:4px;"><span class="label label-danger">!</span> <?php echo $module_i18n[$lang]['warning_servername_1']; ?></p>
									<p style="color:gray;padding-left:25px;"><span class="label label-danger">!</span> <?php echo $module_i18n[$lang]['warning_servername_2']; ?></p>
									

									<label for="vhost_link" style="padding-top:30px;"><span class="badge small">2</span> Path</label>
									<div class="input-group" style="padding-left:25px;">
										<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></span>
										<input type="text" class="form-control input-sm" id="vhost_link" name="vhost_link" value="<?php if (isset($_GET['to']) AND $_GET['to'] == 'add_vhost_error') {echo urldecode($_GET['add_vhost_link']);} else {echo urldecode($vhost_documentroot);} ?>" placeholder="">
									</div>	
									
									<label for="vhost_link" style="padding-top:30px;"><span class="badge small">3</span> <a class="btn btn-danger btn-xs" role="button" data-toggle="collapse" href="#vhosts_expert_mode_<?php echo $key ?>" aria-expanded="false" aria-controls="vhosts_expert_mode_<?php echo $key ?>">expert mode</a></label>
									<div  class="collapse" id="vhosts_expert_mode_<?php echo $key ?>">
										
										<div style="padding-left:25px;">
											<p style="font-size:90%;color:#c0392b">
											Change those parameters only if you know what you do. If you have any problem after creating this virtual host, you can change the parameters or delete it and create a new one.
											<br />
											More information : <a href="https://httpd.apache.org/docs/2.4/" target="_blank">Apache Documentation</a>
											</p>
				
<textarea class="form-control" rows="7" id="vhost_directory" name="vhost_directory">
<?php
// Directory
preg_match('/<Directory.*?>(.*?)<\/Directory>/s', $vhost, $matches);
echo trim($matches[1]);
?>
</textarea>

										</div>							
									</div>							

									<input type="hidden" name="to" value="modify_vhost2" />
									<input type="hidden" name="vhost_modal" value="modify_vhost2_<?php echo $key ?>" />
									<input type="hidden" name="vhost_current_status" value="<?php echo $vhost2_status ?>" />
									<input type="hidden" name="vhost_current_name" value="<?php echo $vhost_servername ?>" />
									<input type="hidden" name="dashboard_url" value="<?php echo urlencode($_SERVER["HTTP_REFERER"]); ?>" />
									<input type="hidden" name="action[request][0][type]" value="include" />
									<input type="hidden" name="action[request][0][value]" value="../eds-modules/virtualhostsmanager2/virtualhostsmanager2_update.php" />

								</div>
							</form>

						</div>
						<div class="modal-footer">
							<a href="#" class="cancel_btn_<?php echo $key; ?> hide_btn btn btn-default btn-sm" data-dismiss="modal">cancel</a>
							<button type="button" class="hide_btn save_btn btn btn-primary btn-sm" onclick="document.getElementById('edit_vhost_form_<?php echo $key; ?>').submit()">save</button>
							<img style="display:none" class="loading" src="images/loading_26x26.gif" />
						</div>
					</div>
				</div>
			</div>			
			<?php
		}
		// / MODALS EDIT VHOST
		?>

		<!-- MODAL ADD VHOST -->
		<div class="modal fade" id="add_vhost2" tabindex="-1" role="dialog" aria-labelledby="add_vhost2">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				
					<div class="modal-header">
						<h3 class="modal-title" style="text-align:center;"><?php echo $module_i18n[$lang]['add_vhost']; ?></h3>
					</div>			
				
					<div class="modal-body" style="padding:10px 40px 10px 40px;">
				
						<p class="text-muted"><?php echo $module_i18n[$lang]['add_vhost_chapo']; ?></p>

						<?php
						// Errors
						if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '1')){
							echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_1'] . '</div>';	
						}
						if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '2')){
							echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_2'] . '</div>';	
						}
						if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '3')){
							echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_3'] . '</div>';	
						}
						if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '4')){
							echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_4'] . '</div>';	
						}
						if (isset($_GET['add_vhost_error']) AND ($_GET['add_vhost_error'] == '5')){
							echo '<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> ' . $module_i18n[$lang]['add_vhost_warning_5'] . '</div>';	
						}	
						?>			
					
						<form method="post" action="<?php echo 'http://' . $_SERVER["HTTP_HOST"] . '/index.php#anchor_virtualhostsmanager2' ?>" role="form" id="add_vhost2_form">
							<div class="form-group">

								<label for="vhost_createdir" style="padding-top:10px;"><span class="badge small">1</span> <?php echo $module_i18n[$lang]['add_vhost_1']; ?></label>
								
								<label for="vhost_name" style="padding-top:20px;"><span class="badge small">2</span> <?php echo $module_i18n[$lang]['add_vhost_2']; ?></label>
								<div class="input-group" style="padding-left:25px;">
									<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span></span>
									<input type="text" class="form-control input-sm" id="vhost_name" name="vhost_name" value="<?php if (isset($_GET['add_vhost_name']) AND $_GET['add_vhost_name']) echo $_GET['add_vhost_name'] ?>" placeholder="">
								</div>						
								<p style="color:gray;padding-left:25px;margin-bottom:0px;margin-top:4px;"><span class="label label-danger">!</span> <?php echo $module_i18n[$lang]['warning_servername_1']; ?></p>
								<p style="color:gray;padding-left:25px;"><span class="label label-danger">!</span> <?php echo $module_i18n[$lang]['warning_servername_2']; ?></p>
								

								<label for="vhost_link" style="padding-top:30px;"><span class="badge small">3</span> <?php echo $module_i18n[$lang]['add_vhost_3']; ?></label>
								<div class="input-group" style="padding-left:25px;">
									<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></span>
									<input type="text" class="form-control input-sm" id="vhost_link" name="vhost_link" value="<?php if (isset($_GET['add_vhost_link']) AND $_GET['add_vhost_link']) echo urldecode($_GET['add_vhost_link']) ?>" placeholder="">
								</div>	
								
								<label for="vhost_link" style="padding-top:30px;"><span class="badge small">4</span> <a class="btn btn-danger btn-xs" role="button" data-toggle="collapse" href="#vhosts_expert_mode" aria-expanded="false" aria-controls="vhosts_expert_mode">expert mode</a></label>
								<div  class="collapse" id="vhosts_expert_mode">
									
									<div style="padding-left:25px;">
										<p style="font-size:90%;color:#c0392b">
										Change those parameters only if you know what you do. If you have any problem after creating this virtual host, you can change the parameters or delete it and create a new one.
										<br />
										More information : <a href="http://httpd.apache.org/docs/2.4/" target="_blank">Apache Documentation</a>
										</p>
						
<textarea class="form-control" rows="7" id="vhost_directory" name="vhost_directory">
Options FollowSymLinks Indexes ExecCGI
AllowOverride All
Order deny,allow
Allow from 127.0.0.1
Deny from all
Require all granted
</textarea>

									</div>							
								</div>							
								
								<input type="hidden" name="to" value="add_vhost2" />
								<input type="hidden" name="vhost_modal" value="add_vhost2" />
								<input type="hidden" name="dashboard_url" value="<?php echo urlencode($_SERVER["HTTP_REFERER"]); ?>" />
								<input type="hidden" name="action[request][0][type]" value="include" />
								<input type="hidden" name="action[request][0][value]" value="../eds-modules/virtualhostsmanager2/virtualhostsmanager2_update.php" />

							</div>
						</form>

					</div>
					<div class="modal-footer">
						<a href="#" class="cancel_btn hide_btn btn btn-default btn-sm" data-dismiss="modal">cancel</a>
						<button type="button" class="hide_btn save_btn btn btn-primary btn-sm" onclick="document.getElementById('add_vhost2_form').submit()">save</button>
						<img style="display:none" class="loading" src="images/loading_26x26.gif" />
					</div>
				</div>
			</div>
		</div>
		<!-- /MODAL ADD VHOST -->
		<?php	
		
		
		
		
	} else {
		echo '<br style="clear:both"; />';
		echo '<div class="alert alert-warning text-center" style="margin:10px 20px 5px 20px; ">' . $module_i18n[$lang]['norights'] . ' ' . get_hostsfile_dir() . '\hosts</div>';
	}
}
?>


<script src="library/jquery/jquery.min.js"></script>
<script>
<?php
foreach ($vhosts_array[0] as $key => $vhost) {
	echo "\t$('.cancel_btn_" . $key . "').click(function(){\r\n";
	echo "\twindow.location.replace('index.php#anchor_virtualhostsmanager2');\r\n";
	echo "\t});\r\n";
}
?>
$('.cancel_btn').click(function(){
	window.location.replace('index.php#anchor_virtualhostsmanager2');
});
$('.hide_btn').show();
$('.save_btn').click(function(){
	$('.hide_btn').hide();
	$('.loading').css('display','inline');
});
</script>

<?php
if (isset($_GET['add_vhost_error']) AND $_GET['add_vhost_error']) {
	?>
	<script>
		$(window).load(function(){
			$('#<?php echo $_GET['vhost_modal'] ?>').modal({
				show: true,
				backdrop: false
			});
		});
	</script>
	<?php
}
?>