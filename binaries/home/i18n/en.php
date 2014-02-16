<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

//== Navigation ==
$administration = "Administration";
$help = "help";
$t_back = "back";
$t_warning = "warning";
$back = "back";
$close = "close";
$t_save = "save";
$t_cancel = "cancel";
$cancel = "cancel";
$confirm = "confirm";
$download = "download";
$parameters = "Parameters";
$wait = "... and wait 5 sec. (servers have to reboot)";
$backhomepage = "back to homepage";


//== Recommended Modules ==
$recommended_modules = 'recommended modules';
$module_virtualhostsmanager_title = 'Virtual Hosts Manager';
$module_virtualhostsmanager_descr = 'Virtual Hosts Manager for EasyPHP allows to create / delete, activate / deactivate Virtual Hosts.';
$module_xdebugmanager_title = 'Xdebug Manager';
$module_xdebugmanager_descr = 'Xdebug Manager for EasyPHP allows you to start, stop and control Xdebug.';
$module_webgrind_title = 'Webgring';
$module_webgrind_descr = 'Webgrind is an Xdebug web frontend. It implements a subset of the features of kcachegrind.';
$module_wordpress_title = 'WordPress';
$module_wordpress_descr = 'WordPress is a free and open source content management system (CMS).';
$module_prestashop_title = 'PrestaShop';
$module_prestashop_descr = 'PrestaShop is an e-commerce solution available under the Open Software License.';
$module_drupal_title = 'Drupal';
$module_drupal_descr = 'Drupal is a free and open source content management system (CMS).';
$module_joomla_title = 'Joomla!';
$module_joomla_descr = 'Joomla! is a free and open source content management system (CMS).';
$module_spip_title = 'SPIP';
$module_spip_descr = 'SPIP  is a free and open source content management system (CMS).';
$downloadninstall = "download and install";

$t_banner_php = "PHP";
$t_banner_database = "DATABASE";
$t_banner_server = "SERVER";
$t_banner_debugging = "DEBUGGING";
$t_banner_app_php = "PHP";
$t_banner_app_mysql = "MYSQL";
$t_banner_app_apache = "APACHE";
$t_banner_app_xdebug = "XDebug";

$t_php_versions = "Version";
$t_php_parameters = "Parameters";
$t_php_conffile = "Configuration File";
$t_php_credits = "Credits";


//== Setting ==
$t_settings_info_port80 = 'In order to avoid port conflict, if you use port 80 don\'t use applications that use the same port. Usual applications that may be using port 80 are, between others, Skype, Kazaa Lite, Norton Firewall, IIS, Yahoo Messenger, Internet Security... To know which ports are used, you can scan your computer with TCPView. If you have any port conflict, close your application and choose an other port for your application or EasyPHP.';
$t_settings_link = 'Display or change settings';
$t_settings_info_errors = 'You can change error levels but it is not recommended!';
$t_settings_info_applicationerrors = 'If you install an application and PHP errors occur (especially "notices") this means that the application does not meet all coding standards. Contact then the developers of the application.';

$t_mysql_datadir = "Data Folder";
$t_mysql_datadir_bulle = "By default, all information managed by MySQL is stored in this folder. All databases are stored here, as well as the status and log files that provide information about the server's operation.";
$t_mysql_datadir_portablemode = "Back to the original configuration if changes were made. CAUTION: do not forget to copy ALL MYSQL FILES AND FOLDERS in 'EasyPHP-xxx\mysql\data\'";
$t_mysql_default_param = "Default Parameters";
$t_mysql_default_param_bulle = "When you install an application using MySQL you usually need these settings: user name, password, database host.";
$t_mysql_logfile = "Log File";
$t_mysql_logfile_bulle = "The error log contains information indicating when MySQL was started and stopped and also any critical errors that occur while the server is running. If MySQL notices a table that needs to be automatically checked or repaired, it writes a message to the error log.";
$t_mysql_changedir = "Change MySQL data folder";
$t_mysql_conffile = "Configuration File";
$t_mysql_conffile_bulle = "MySQL is configured by placing directives in plain text configuration files.";

$t_php_conffile_bulle = "PHP is configured by placing directives in plain text configuration files.";

$t_apache_folder = "EasyPHP Folder";
$t_apache_conffile = "Configuration File";
$t_apache_conffile_bulle = "Apache is configured by placing directives in plain text configuration files.";
$t_apache_parameters = "Parameters";
$t_apache_logfiles = "Log Files";
$t_apache_logfiles_bulle = "Feedback about the activity and performance of the server as well as any problems that may be occurring.";

$t_localfiles = "LOCAL FILES";
$t_localfiles_intro = "Put your files in a folder or several folders and create links to those folders (alias). Thus, next update, you won't have to move your files, you will just have to recreate the links.";

$t_portablefiles = "PORTABLE FILES / LOCAL WEB";
$t_portablefiles_intro_1 = "If you use EasyPHP on a portable data storage device, put all needed files in this folder : ";
$t_portablefiles_intro_2 = ". All folders created in this folder appear below.";


$t_yourmodules = "MODULES";



$t_settings_change = "change";
$t_settings_display = "display";
$t_settings_modify = "modify";
$t_settings_configuration = "configuration";
$t_settings_extensions = "extensions";
$t_settings_mysqlerrorlog = "mysql error log";
$t_settings_apacheerrorlog = "apache error log";
$t_settings_apacheaccesslog = "apache access log";

$t_settings_addmoreversions = "Add more versions";
$t_settings_availableversions = "Available versions";
$t_settings_selectversion = "select";
$t_settings_selectedversion = "running";
$t_settings_notes = "notes";
$t_settings_notes_descr = "You can use this space to write notes. This can be useful if you installed several times the same version of PHP with different settings.";
$t_settings_notes_addchange = "click to add / change";


$hostname				= "Hostname";
$hostname_help			= "Due to incompatibilities with Windows Vista/Seven, 'localhost' is no longer used. Use '127.0.0.1' instead. For details, see FAQ";
$portnum				= "Port";
$easyphp_dir			= "EasyPHP folder";
$databases_dir			= "Databases folder";
$mysql_username			= "Username";
$mysql_password			= "Password";
$mysql_password_help	= "No password, leave it blank";
$mysql_host				= "Host";

$ao_warning = "Advanced options allow you to modify a configuration in such a way that you can jeopardize the integrity of the environement. So, use them wisely and be sure to know what you do.";
$ports_available_desc = "In order to avoid <b>port conflict</b>, if you use port 80 don't use applications that use the same port. Usual applications that may be using port 80 are, between others, Skype, Kazaa Lite, Norton Firewall (proxy function), IIS (under XP Pro), Yahoo Messenger, Internet Security...  To know which ports are used, you can scan your computer with <a href='http://technet.microsoft.com/en-us/sysinternals/bb897437' target='_blank'>TCPView</a>. If you have any port conflict, close your application and choose an other port for your application or EasyPHP. For details, see <a href='http://www.easyphp.org/faq.php' target='_blank'>FAQ</a>.";


//== Menu ==
$menu_mysql_manage = "Manage your databases";
$menu_section_parameters = "Parameters";
$menu_section_options = "Options";
$menu_section_advoptions = "Advanced options";
$menu_php_environment = "PHP environment";
$menu_php_extensions = "PHP extensions";
$menu_vhosts_add = "add virtual host";
$menu_alias_add = "add an alias";
$menu_module_add = "go to website";
$menu_phpconf = "PHP configuration";
$menu_apacheconf = "Apache configuration";
$menu_mysqlconf = "MySQL configuration";
$php_timezone = "Time Zone";

$t_donate = "Make a donation with";
$t_donate_text = "EasyPHP is free and can be used and modified by anyone, including for commercial purposes. If EasyPHP helped you in your projects or business, you can make a donation. Thank you for your support!";
$t_donate_or = "or";


//== Tips ==
$t_tip_0_title = "PHP news and tips";
$t_tip_0_text = "News and ressources for PHP developers and web designers on PHPDistiller.net";
$t_tip_0_link = "<a href='http://www.phpdistiller.net' target='_blank' title='Go to www.phpdistiller.net'>visit</a>";
$t_tip_1_title = "Coding standards";
$t_tip_1_text = "Clean up your code : setup WebCodeSniffer or use it online.";
$t_tip_1_link = "<a href='http://www.webcodesniffer.net/' target='_blank' title='Go to www.webcodesniffer.net'>visit</a>";
$t_tip_2_title = "Track bugs";
$t_tip_2_text = "Track and fix bugs : download and install the module Xdebug Manager";
$t_tip_2_link = "<a href='http://www.easyphp.org/modules.php' target='_blank' title='EasyPHP Module : Xdebug Manager'>download</a>";
$t_tip_3_title = "Configure & setup";
$t_tip_3_text = "Configure Apache, MySQL, PHP and download Virtual Hosts Manager";
$t_tip_3_link = "<a href='http://www.easyphp.org/modules.php' target='_blank' title='EasyPHP Module : Virutal Hosts Manager'>download</a>";
$t_tip_4_title = "Host your files";
$t_tip_4_text = "Turn your computer into a web hosting server with EasyPHP WebServer";
$t_tip_4_link = "<a href='http://www.easyphp.org' target='_blank' title='Download EasyPHP WebServer'>visit</a>";


//== Info ==
$migration_title = "PHP 5.3 migration guide";
$migration_info = "Most improvements in PHP 5.3.x have no impact on existing code. However, there are a <a href='http://www.php.net/manual/en/migration53.incompatible.php'>few incompatibilities</a> and <a href='http://www.php.net/manual/en/migration53.new-features.php'>new features</a> that should be considered.";
$portable_title = "EasyPHP is portable";
$portable_info = "If you want to use EasyPHP on an USB drive, you just need to copy the entire EasyPHP folder on the key. Be sure that all your scripts are in the folder 'www' and your databases in 'mysql/data'.";


//== Local web ==
$localweb = "Local Web";
$localweb_intro = "Put your files in a folder or several folders and create links (alias or virtual host) to those folders. Thus, next update, you won't have to move your files, you will just have to recreate the links.";
$t_localweb_bulle = "For small scripts, applications or projects you can choose the 'www' folder. All folders created in 'www' appear below.";


//== Docroot ==
$docroot_select = "Select a new path";
$docroot_change = "change";		
$docroot_default = "set to default";
$docroot_warning_1 = "Field is empty.";
$docroot_warning_2 = "The directory corresponding to the path you have chosen does not exist.";

//== Code Tester ==
$t_ct_title = 'CODE TESTER';
$t_ct_infobulle = 'If you want to quickly test a piece of code, enter your code in the field below and click on "Interpret the code".';
$t_ct_reminders_title = 'Reminder :';
$t_ct_reminders_text_1 = 'The PHP code needs to be enclosed in special tags : &lt;?php and ?&gt;.';
$t_ct_reminders_text_2 = 'Easyphp is configured in such a way that all errors are reported (errors, warnings, notices...). Some of the notices and warnings may seem trivial at first, but they reveal holes in your code. EasyPHP strongly encourages best practice coding standards in order to obtain a consistent, clean and portable code.';
$t_ct_interpretcode = 'Interpret the code';
$t_ct_code = 'Code';
$t_ct_codeinterpreted = 'Code interpreted by the server and sent to the browser';

//== Alias ==
$alias_title = "Alias";
$alias_none = "No alias created ";
$alias_delete = "delete";
$alias_intro = "If you develop and maintain websites and applications on a large scale, you should use virtual hosts (see modules).";
$alias_1 = "<span>Create a directory</span> (eg: C:\localweb\websites\site1)";
$alias_2 = "<span>Create a name for the Alias</span> (eg: site1)";
$alias_3 = "<span>Copy the path to the directory you have created</span> (eg: C:\weblocal\websites\site1)";
$alias_4 = "Default settings for the directory";
$alias_5 = "create";
$alias_warning_1 = "Field 'name' is empty.";
$alias_warning_2 = "Field 'path' is empty.";
$alias_warning_3 = "The directory corresponding to the path you have chosen does not exist.";
$alias_warning_4 = "This name, or a part of this name, is already used by the system.";


//== Virtual Hosts ==
$vhosts_title = "Virtual Hosts";
$vhosts_none = "No virtual host created ";
$vhosts_delete = "delete";


//== Phpinimanager - Apacheconf manager ==
$t_info = "info";	
$t_open = "open";		
$t_warning_phpini = "If you experience any problem, open the folder '[EasyPHP-DevServer folder]/binaries/conf_files/', delete or rename 'php.ini', rename the most recent backup 'php.ini' and restart EasyPHP.";
$t_warning_apacheconf = "If you experience any problem, open the folder '[EasyPHP-DevServer folder]/binaries/conf_files/', delete or rename 'httpd.conf', rename the most recent backup 'httpd.conf' and restart EasyPHP.";
$t_recommended = "<b>*</b> highly recommended";
$t_warning_save = "I have read the warning above &raquo; Save";


//== Virtual Hosts ==
$vhosts_norights = "Unfortunately, you do not have rights to create a Virtual Host. You must have write permissions on the file:";
$vhosts_activate = "activate";
$vhosts_desactivate = "deactivate";		
$vhosts_delete = "delete";
$vhosts_add_vhost = "add a virtual host";
$vhosts_add_vhost_chapo = "When maintaining and developing multiple sites / applications on intenet, it is helpful to have a copy of each site / application running on your local computer and to have them running in the same conditions (same server configuration, same path...). Virtual Hosts allow you to do that. Create a new folder, put all your files in it and create a Virtual Host for that folder.";
$vhosts_add_vhost_1 = "<span>If the directory you want to use doesn't exist, create it</span> (eg: C:\localweb\websites\projet1)";
$vhosts_add_vhost_2 = "<span>Create a name for the Servername</span> (eg: projet1)";
$vhosts_add_vhost_3 = "<span>Copy below the path to your directory</span> (eg: C:\weblocal\websites\projet1)";
$vhosts_add_vhost_4 = "create";
$vhosts_info = "info";
$vhosts_cancel = "cancel";	
$vhosts_close = "close";
$vhosts_warning_servername_1 = "The name can only contain alpha-numeric characters, dots, underscores and hyphens.";
$vhosts_warning_servername_2 = "If the name is an internet address, this address will redirected on your local computer. Not on internet.";
$vhosts_warning_conf = "If you experience any problem, open the folder '[EasyPHP-DevServer folder]/binaries/conf_files/', delete or rename 'httpd.conf', rename the most recent backup 'httpd.conf' and restart EasyPHP. Follow the same procedure with the hosts file ";
$vhosts_warning_url = "The name looks like an internet address. Be carefull. If the name chosen is www.google.com for example, the address http://www.google.com will be redirected to your local computer and won't be reachable on internet. You can do that, but don't forget to deactivate your virtual host or to delete it if you want go on internet.";
$vhosts_save = "I have read the warning above &raquo; Save";
$vhosts_no_vhost_created = "No virtual host created ";
$vhosts_add_vhost = "add a virtual host";
$t_add_vhost_warning_1	= "Warning : the name is empty.";
$t_add_vhost_warning_2	= "Warning : the path is empty.";
$t_add_vhost_warning_3	= "Warning : the directory corresponding to the path you have chosen does not exist.";
$t_add_vhost_warning_4	= "Warning : the name can only contain alpha-numeric characters, dots, underscores and hyphens.";
$t_add_vhost_warning_5	= "Warning : this name, or a part of this name, is already used by the system.";


//== MySQL datadir ==
$t_changemysqldatadir_1 = "Create a new folder <span>(eg: C:\mydatabases)</span>";
$t_changemysqldatadir_2_1 = "Copy ALL FILES AND FOLDERS from";
$t_changemysqldatadir_2_2 = "to your new folder <span>(C:\mydatabases)</span>";
$t_changemysqldatadir_3 = "Copy the path to the folder you have created <span>('C:\mydatabases')</span>";
$t_changemysqldatadir_warning_conf = "If you experience any problem, open the folder '[EasyPHP-DevServer folder]/binaries/conf_files/', delete or rename 'my.ini', rename the most recent backup to 'my.ini' and restart EasyPHP.";
$t_changemysqldatadir_warning_1	= "Warning : the path is empty.";
$t_changemysqldatadir_warning_2	= "Warning : the folder corresponding to the path you have chosen does not exist.";
$t_changemysqldatadir_warning_3	= "Warning : the folder corresponding to the path you have chosen does not seem to contain all required subfolders.";


//== Extensions ==
$extensions_title = "EXTENSIONS";
$extensions_nb = "List of all modules compiled and loaded<br />You have %s extensions loaded.";
$extensions_show = "show";
$extensions_functions = "functions";


//== Modules ==
$module_none = "No module installed ";
$module_add = "Modules are pre-configured applications for EasyPHP. You can dowload, install and test immediately add-ons like Xdebug Manager, Virtual Hosts Manager, WebGrind... and applications like WordPress, Spip, Drupal, Joomla!, Prestashop... Modules are downlable on EasyPHP website.";


//== MySQL Info ==
$mysqlinfo_parameters_1 = "Host : '127.0.0.1'";
$mysqlinfo_parameters_2 = "Username : 'root'";
$mysqlinfo_parameters_3 = "Password : '' (no password)";
$mysqlinfo_parameters_4 = "Path to the database root (datadir)";
?>