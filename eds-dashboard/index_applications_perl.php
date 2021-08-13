<div class="row">
	<div class="col-sm-1 text-center">
		<img src="images/eds_icon_perl.png" border="0" />
	</div>
	<div class="col-sm-11">
		<h1>PERL<a href="http://www.perl.org" target="_blank" style="position:absolute;padding:5px 0px 0px 5px;font-size:12px;color:silver;" data-toggle="tooltip" data-placement="top" title="Go to Website"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a></h1>
	</div>
</div>

<br />

<h3>SELECT A VERSION</h3>
<div class="row">
	<div class="col-sm-12">
		<p class="text-muted">Activate a version and start a HTTP server supporting Perl.</p>
		<?php
		if (file_exists('../eds-binaries/perl')) {
			$perl_folders = @opendir('../eds-binaries/perl');
			while ($perl_folder = @readdir($perl_folders)){
				if (@file_exists('../eds-binaries/perl/'.$perl_folder.'/eds-app-settings.php')){
					
					include('../eds-binaries/perl/' . $perl_folder . '/eds-app-settings.php');
				
					if ($perl_folder == 'default') {
						echo '<div style="padding:2px;margin-left:10px;">';
						echo '<button type="button" class="btn btn-primary btn-xs" style="font-size:85%;width:60px;">active</button>';
						echo ' ' . $app_settings['app_name']. ' <b>' . $app_settings['app_version'] . '</b>';
						echo '</div>';
					} else {
						echo '<div style="padding:2px;margin-left:10px;">';
						echo '<a href="index.php?action=include&value=' . urlencode('action_perl.php') . '&folder=' . $perl_folder . '&redirect=' . urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '" class="btn btn-default btn-xs" style="font-size:85%;width:60px;">select</a>';
						echo '<span style="color:silver;"> ' . $app_settings['app_name']. ' ' . $app_settings['app_version'] . '</span>';	
						echo '</div>';
					}	
				}				
			}
			@closedir($perl_folders);
		}
		?>
		<div style="margin:10px 0px 0px 34px;">
			<a href="http://www.easyphp.org/download.php" target="_blank" class="menu_link" data-toggle="tooltip" data-placement="right" title="add a version"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>
		</div>
	</div>
</div>

<br />

<h3>SHEBANG LINE</h3>
<div class="row">
	<div class="col-sm-12">				
		<p class="text-muted" style="margin-bottom:0px;">The default location of the Perl executable is :</p>
		<p class="text-muted text-center"><samp style="color:#2c3e50;font-weight:bold;"><?php echo dirname(__DIR__)?>\eds-binaries\perl\default\perl\bin\perl.exe</samp></p>
		<p class="text-muted">The first line of a script starting with #! is known as a "shebang" line. This line indicates the location of the Perl executable.</p>
		<p class="text-muted">So, your shebang line must be :</p>
		<pre style="background:#042029;color:#839496"><span style="color:#586e75">#!<?php echo dirname(__DIR__)?>\eds-binaries\perl\default\perl\bin\perl.exe</span></pre>				
		<p class="text-muted">Copy this line and paste it at the beginning of your Perl scripts.</p>
	</div>
</div>				

<h3>EXEMPLE</h3>			
<pre style="background:#042029;color:#839496"><span style="color:#586e75;font-style:italic">#!<?php echo dirname(__DIR__)?>\eds-binaries\perl\default\perl\bin\perl.exe</span>
<span style="color:#859900">print</span> <span style="color:#269186"><span style="color:#2aa198">"</span>Content-type: text/html<span style="color:#dc322f">\n</span><span style="color:#dc322f">\n</span><span style="color:#2aa198">"</span></span>;
<span style="color:#859900">print</span> <span style="color:#269186"><span style="color:#2aa198">"</span>&lt;html><span style="color:#2aa198">"</span></span>;
<span style="color:#859900">print</span> <span style="color:#269186"><span style="color:#2aa198">"</span>&lt;body><span style="color:#2aa198">"</span></span>;
<span style="color:#859900">print</span> <span style="color:#269186"><span style="color:#2aa198">"</span>Perl example<span style="color:#2aa198">"</span></span>;
<span style="color:#859900">print</span> <span style="color:#269186"><span style="color:#2aa198">"</span>&lt;/body><span style="color:#2aa198">"</span></span>;
<span style="color:#859900">print</span> <span style="color:#269186"><span style="color:#2aa198">"</span>&lt;/html><span style="color:#2aa198">"</span></span>;
</pre>



You can find this example in : <samp style="color:#2c3e50;font-weight:bold;"><?php echo dirname(__DIR__)?>\eds-www\</samp>