<?php
/**
 * Xdebug Manager for DevServer
 * @version  2.0
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     https://www.easyphp.org
 */

 
$module_version = '1.7';

$module_info = array();
$module_info = array(
	"module_application_name" 		=> "Xdebug Manager",
	"module_application_version" 	=> $module_version,
	"en"	=>	array(
		"Application"	=>	array(
				"Installation date"	=>	"${date}",
				"Website"	=>	"<a href='http://www.easyphp.org/' target='_blank'>www.easyphp.org</a>"
		),
		"How to uninstall this module ?"	=>	array(
				"If you want to uninstall this module, you just have to<br />delete the folder"	=>	"<br />[modules folder]\\xdebugmanager",
		),			
	),
	"fr"	=>	array(
		"Application"	=>	array(
				"Date d'installation"	=>	"${date}",
				"Site web"	=>	"<a href='http://www.easyphp.org/' target='_blank'>www.easyphp.org</a>"
		),
		"Comment d&eacute;sinstaller ce module ?"	=>	array(
				"Si vous voulez d&eacute;sinstaller ce module, il suffit de supprimer le r&eacute;pertoire"	=>	"<br />[modules folder]\\xdebugmanager",
		),		
	),	
);

$module_i18n = array();
$module_i18n = array(
	"en"	=>	array(
		"startxdebug"	=>	"start xdebug",
		"stopxdebug"	=>	"stop xdebug",
		"start"			=>	"start",
		"stop"			=>	"stop",
		"outputdir"		=>	"Directory",
		"files"			=>	"file(s)",
	),
	"fr"	=>	array(
		"startxdebug"	=>	"d&eacute;marrer xdebug",
		"stopxdebug"	=>	"arr&ecirc;ter xdebug",
		"start"			=>	"d&eacute;marrer",
		"stop"			=>	"arr&ecirc;ter",
		"outputdir"		=>	"R&eacute;pertoire",
		"files"			=>	"fichier(s)",		
	),
);

/* -- APP INFO -- */
$application_info = '<pre>';
foreach($module_info[$lang] as $section_name => $section) {
	$application_info .= "<b style='color:#AF2D00'>" . $section_name . "</b><br />";
	foreach($section as $title => $text) {
		$application_info .= "<b>" . $title . "</b> : " . $text . "<br />";						
	}
	$application_info .= '<br />';
}
$application_info .= '</pre>';
/* ---------- */

if ($eds_httpserver_running == 1) {
	?>
	<style type="text/css" media="all">
	a.xdebug_list_directory {
		text-decoration: none;
	}

	.xdebug_list_directory samp {
		color:silver;
		padding-left:0px;
	}

	.xdebug_list_directory samp:hover {
		color:gray;
		cursor:pointer;
	}
	</style>
	<div class="row panel panel-default" style="margin:0px 0px 5px 0px;padding:5px;background-color:#ecf0f1;border:none;">
		<a id="anchor_xdebugmanager"></a>
		<div class="col-sm-10" style="padding:5px 0px 0px 5px;">
			<img src="images/module_icon_virtualhostsmanager.png" />
			&nbsp;<strong><?php echo $module_info['module_application_name'] . ' ' . $module_info['module_application_version'] ?></strong>
			<span role="button" style="outline:0;padding:0px 10px 0px 10px;color:silver;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-cog" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="<b class='text-center'><?php echo $module_info['module_application_name'] . ' ' . $module_info['module_application_version'] ?></b>" data-content="<?php echo htmlentities($application_info) ?>"></span>
		</div>
		<?php include ("xdebugmanager.php"); ?>
	</div>
	<?php
} else {
	?>
	<div class="row panel panel-default" style="margin:0px 0px 5px 0px;padding:5px;background-color:#f6f8f8;border:none;" data-toggle="tooltip" data-placement="top" title="Start a HTTP server!">
		<div class="col-sm-10" style="padding:5px 0px 0px 5px;">
			<span style="opacity:0.5">
				<img src="images/module_icon_virtualhostsmanager.png" />
				&nbsp;<strong><?php echo $module_info['module_application_name'] . ' ' . $module_info['module_application_version'] ?></strong>
			</span>
			<span role="button" style="outline:0;padding:0px 10px 0px 10px;opacity:0.5;color:silver;cursor:pointer;" tabindex="0" class="glyphicon glyphicon-cog" aria-hidden="true" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="<b class='text-center'><?php echo $module_info['module_application_name'] . ' ' . $module_info['module_application_version'] ?></b>" data-content="<?php echo htmlentities($application_info) ?>"></span>
		</div>
	</div>		
	<?php
}
?>
