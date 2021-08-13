<?php
/**
 * EasyPHP Devserver: a complete development environment
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */


$module_version = '4.0.10.20';
$module_info = array();
$module_info = array(
	"module_name" 		=> array(
		"en"	=>	"MySQL Administration : PhpMyAdmin",
		"fr"	=>	"Administration MySQL : PhpMyAdmin"
		),
	"module_application_name" 		=> "PhpMyAdmin",
	"module_application_version" 	=> $module_version,
	"en"	=>	array(
		"Application"	=>	array(
				"Installation date"	=>	"${date}",
				"Website"	=>	"<a href='http://www.phpmyadmin.net/' target='_blank'>www.phpmyadmin.net</a>"
		),
		"Login/Password by default"	=>	array(
				"Login"		=>	"root",
				"Password"	=>	"'' (no password)"
		),
		"How to uninstall this module ?"	=>	array(
				"If you want to uninstall this module, you just have to<br />delete the folder"	=>	"<br />[modules folder]\\${name}",
		),	
	),
	"fr"	=>	array(
		"Application"	=>	array(
				"Date d'installation"	=>	"${date}",
				"Site web"	=>	"<a href='http://www.phpmyadmin.net/' target='_blank'>www.phpmyadmin.net</a>"
		),
		"Comment d&eacute;sinstaller ce module ?"	=>	array(
				"Si vous voulez d&eacute;sinstaller ce module, il suffit de supprimer le r&eacute;pertoire"	=>	"<br />[modules folder]\\${name}",
		),
	),	
);

$module_i18n = array();
$module_i18n = array(
	"en"	=>	array(
		"open"	=>	"open"
	),
	"fr"	=>	array(
		"open"	=>	"ouvrir"
	),
);


/* -- APP INFO -- */
$application_info = '<pre>';
foreach($module_info[$lang] as $section_name => $section) {
	$application_info .= '<b style="color:#AF2D00">' . $section_name . '</b><br />';
	foreach($section as $title => $text) {
		$application_info .= '<b>' . $title . '</b> : ' . $text . '<br />';
	}
	$application_info .= '<br />';
}
$application_info .= '</pre>';
/* ------------- */


if ($eds_httpserver_running == 1
	AND $eds_dbserver_running == 1
	AND isset($conf_dbserver['dbserver_folder'])
	AND strstr($conf_dbserver['dbserver_folder'],'mysql')) {
	?>
	<div class="row panel panel-default" style="margin:0px 0px 5px 0px;padding:5px;background-color:#ecf0f1;border:none;;">

		<div class="col-sm-10" style="padding:5px 0px 0px 5px;">
			<img src="images/modules_icon_phpmyadmin.png" />
			&nbsp;<strong><?php echo $module_info['module_name'][$lang] . ' ' . $module_info['module_application_version'] ?></strong>
			<span role="button" style="padding:0px 10px 0px 10px;color:silver;cursor:pointer;" tabindex="0" class="delete_alias glyphicon glyphicon-cog" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="<b class='text-center'><?php echo $module_info['module_application_name'] ?> <?php echo $module_info['module_application_version'] ?></b>" data-content="<?php echo htmlentities($application_info) ?>"></span>
		</div>
		<div class="col-sm-2 text-right" style="padding:0px 0px 0px 0px;">
			<a href="http://127.0.0.1:<?php echo $conf_httpserver['httpserver_port'] ?>/eds-modules/<?php echo basename(__DIR__) ?>" class="btn btn-primary btn-sm" target="_blank">open</a>
		</div>
		
	</div>
	<?php
} else {
	?>
	<div class="row panel panel-default" style="margin:0px 0px 5px 0px;padding:5px;background-color:#f6f8f8;border:none;" data-toggle="tooltip" data-placement="top" title="Start a HTTP server and MySQL!">

		<div class="col-sm-10" style="padding:5px 0px 0px 5px;">
			<span style="opacity:0.5">
				<img src="images/modules_icon_phpmyadmin.png" />
				&nbsp;<strong><?php echo $module_info['module_name'][$lang] . ' ' . $module_info['module_application_version'] ?></strong>
			</span>
			<span role="button" style="padding:0px 10px 0px 10px;opacity:0.5;color:silver;cursor:pointer;" tabindex="0" class="delete_alias glyphicon glyphicon-cog" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="<b class='text-center'><?php echo $module_info['module_application_name'] ?> <?php echo $module_info['module_application_version'] ?></b>" data-content="<?php echo htmlentities($application_info) ?>"></span>
		</div>
		
	</div>
	<?php
}
?>
