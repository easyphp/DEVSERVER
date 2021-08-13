<?php
/**
 * Virtual Hosts Manager for DevServer
 * @version  2.0
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     https://www.easyphp.org
 */


$module_version = '2.0';

$module_info = array();
$module_info = array(
	"module_application_name" 		=> "Virtual Hosts Manager",
	"module_application_version" 	=> $module_version,
	"en"	=>	array(
		"Application"	=>	array(
				"Installation date"	=>	"${date}",
				"Website"	=>	"<a href='https://www.easyphp.org/' target='_blank'>www.easyphp.org</a>"
		),
		"How to uninstall this module ?"	=>	array(
				"If you want to uninstall this module, you just have to<br />delete the folder"	=>	"<br />[modules folder]\\virtualhostsmanager2",
		),			
	),
	"fr"	=>	array(
		"Application"	=>	array(
				"Date d'installation"	=>	"${date}",
				"Site web"	=>	"<a href='https://www.easyphp.org/' target='_blank'>www.easyphp.org</a>"
		),
		"Comment d&eacute;sinstaller ce module ?"	=>	array(
				"Si vous voulez d&eacute;sinstaller ce module, il suffit de supprimer le r&eacute;pertoire"	=>	"<br />[modules folder]\\virtualhostsmanager2",
		),		
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
?>

<style type="text/css" media="all">
.vhost_list_name_broken {
	color:#e74c3c;
}

.vhost_list_name_broken:hover {
	color:#e74c3c;
	border-bottom: 1px #e74c3c dotted;
	cursor:pointer;
}


.vhost_name {
	color:#555;
	padding-left:8px;
	font-weight:bold;
}

a.vhost_list_directory {
	text-decoration: none;
}

.vhost_list_directory samp {
	color:silver;
	padding-left:0px;
}

.vhost_list_directory samp:hover {
	color:gray;
	cursor:pointer;
}

a.vhost_delete {
    color: #555;
    text-decoration: none;
}

.vhost_delete:focus {
	outline: 0;
}
</style>

<div class="row panel panel-default" style="margin:0px 0px 5px 0px;padding:5px;background-color:#ecf0f1;border:none;">
	<?php include ("virtualhostsmanager2.php"); ?>
</div>
