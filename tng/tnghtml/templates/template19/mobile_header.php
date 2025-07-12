<?php
	global $text, $currentuser, $cms, $allow_admin, $subroot, $tmp, $homepage;

	$pagetitle = getTemplateMessage('t19_maintitle');
?>

 <div id="mheader">
<header>
	<div class="container">
			<p class="brand"><img class="img-left" src="<?php echo $cms['tngpath']  . $templatepath . $tmp['t19_headimg']; ?>" alt="" /><a href="<?php echo $homepage; ?>"><?php echo $pagetitle; ?></a></p>
			<p class="slogan"><?php echo getTemplateMessage('t19_headsubtitle'); ?></p>
	</div>
</header>
</div>

