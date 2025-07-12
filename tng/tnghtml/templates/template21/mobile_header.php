<?php
	global $text, $currentuser, $cms, $allow_admin, $subroot, $tmp, $homepage;

	$dadlabel = getTemplateMessage('t21_dadside');
	$momlabel = getTemplateMessage('t21_momside');
	$pagetitle = getTemplateMessage('t21_maintitle');

	$pagetitle = getTemplateMessage('t21_maintitle');
?>

 <div class="mheader">
<header>
<div class="container">
	<section class="headerBox75Left">
			<p class="brand"><img class="img-left" src="<?php echo $cms['tngpath']  . $templatepath . $tmp['t21_headimg']; ?>" alt="" /><a href="<?php echo $cms['tngpath'] . $homepage; ?>"><?php echo $pagetitle; ?></a></p>
			<p class="slogan"><?php echo getTemplateMessage('t21_headsubtitle'); ?></p>
	</section>
	<section class="headerBox25Right">
			<ul class="list1">
			<?php
			    if($dadlabel) {
			?>
					<li><a href="<?php echo $cms['tngpath']; ?>pedigree.php?personID=<?php echo $tmp['t21_dadperson']; ?>&amp;tree=<?php echo $tmp['t21_dadtree']; ?>"><span class="l"></span><span class="t"><?php echo $dadlabel; ?></span></a></li>
			<?php       
			    }
			    if($momlabel) {
			?>
					<li><a href="<?php echo $cms['tngpath']; ?>pedigree.php?personID=<?php echo $tmp['t21_momperson']; ?>&amp;tree=<?php echo $tmp['t21_momtree']; ?>"><span class="l"></span><span class="t"><?php echo $momlabel; ?></span></a></li>
			<?php       
			    }
			?>
		<li><a href="<?php echo $tmp['t21_link-1']; ?>" ><?php echo $tmp['t21_texttitle1']; ?></a></li>
		<li><a href="<?php echo $tmp['t21_link-2']; ?>" ><?php echo $tmp['t21_texttitle2']; ?></a></li>		
	</ul>	
	</section>
		<div class="clear"></div>
		</div>
	</header>
<div class="container">
