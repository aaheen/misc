<?php 
	global $text, $cms, $subroot, $tmp; 

	$dadlabel = getTemplateMessage('t23_dadside');
	$momlabel = getTemplateMessage('t23_momside');
?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?>">
<div id="art-main">
    <div class="cleared reset-box"></div>
<div class="art-nav">
	<div class="art-nav-l"></div>
	<div class="art-nav-r"></div>
<div class="art-nav-outer">
<div class="art-nav-wrapper">
<div class="art-nav-inner">
	<ul class="art-hmenu">
<?php
	if($dadlabel) {
?>
		<li>
			<a href="<?php echo $cms['tngpath']; ?>pedigree.php?personID=<?php echo $tmp['t23_dadperson']; ?>&amp;tree=<?php echo $tmp['t23_dadtree']; ?>"><span class="l"></span><span class="r"></span><span class="t"><?php echo $dadlabel; ?></span></a>
		</li>	
<?php		
	}
	if($momlabel) {
?>
		<li>
			<a href="<?php echo $cms['tngpath']; ?>pedigree.php?personID=<?php echo $tmp['t23_momperson']; ?>&amp;tree=<?php echo $tmp['t23_momtree']; ?>"><span class="l"></span><span class="r"></span><span class="t"><?php echo $momlabel; ?></span></a>
		</li>	
<?php		
	}
	echo showLinks(getTemplateMessage('t23_featurelinks'),false,"","<span class=\"l\"></span><span class=\"r\"></span><span class=\"t\">xxx</span>");
?>
	</ul>
</div>
</div>
</div>
</div>
<div class="cleared reset-box"></div>
<div class="art-sheet">
        <div class="art-sheet-cc"></div>
        <div class="art-sheet-body">
            <div class="art-content-layout">
                <div class="art-content-layout-row">
                    <div class="art-layout-cell art-content">
<div class="art-post">
    <div class="art-post-body">
		<h2 class="site-head"><a href="<?php echo $cms['tngpath']; ?>index.php"><?php echo getTemplateMessage('t23_maintitle'); ?></a></h2>
