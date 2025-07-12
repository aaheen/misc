<?php
	global $text, $subroot, $currentuser, $currentuserdesc, $allow_admin, $tmp, $mediatypes;
?>
<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?> publicback">
<div class="container">
	<div class="mainpage">
		<div id="lmenu">
			<a href="<?php echo $cms['tngpath']; ?>searchform.php" class="searchimg"><?php echo $text['search']; ?></a>
			<form action="<?php echo $cms['tngpath']; ?>search.php" method="get" style="margin-top:7px">
				<label class="fieldname"><?php echo $text['mnufirstname']; ?>:<br /><input type="text" name="myfirstname" class="mediumfield" size="14" /></label>
				<label class="fieldname"><?php echo $text['mnulastname']; ?>: <br /><input type="text" name="mylastname" class="mediumfield" size="14" /></label>
				<input type="hidden" name="mybool" value="AND" /><input type="submit" name="search" class="btn" value="<?php echo $text['mnusearchfornames']; ?>" class="small" />
			</form>

			<ul>
			<li><a href="<?php echo $cms['tngpath'] ?>searchform.php" class="lightlink"><?php echo $text['mnuadvancedsearch']; ?></a></li>
			<li><a href="<?php echo $cms['tngpath'] ?>surnames.php" class="lightlink"><?php echo $text['mnulastnames']; ?></a></li>
			</ul>
					
			<?php
			if( $currentuser ) {
				echo "<p style=\"margin-right:9px\"><span class=\"emphasisyellow\">{$text['welcome']}, $currentuserdesc.</span></p>\n";
				echo "<ul>\n";
				echo "<li><a href=\"{$cms['tngpath']}logout.php\" class=\"lightlink\">{$text['mnulogout']}</a></li>\n";
			}
			else {
				echo "<ul>\n";
				echo "<li><a href=\"{$cms['tngpath']}login.php\" class=\"lightlink\">{$text['mnulogon']}</a></li>\n";
			}
			echo "<li><a href=\"{$cms['tngpath']}whatsnew.php\" class=\"lightlink\">{$text['mnuwhatsnew']}</a></li>\n";
			echo "<li class=\"margin-bottom\"><a href=\"{$cms['tngpath']}mostwanted.php\" class=\"lightlink\">{$text['mostwanted']}</a></li>\n";
		
			foreach( $mediatypes as $mediatype ) {
				if(!$mediatype['disabled']) {
					echo "<li><a href=\"{$cms['tngpath']}browsemedia.php?mediatypeID={$mediatype['ID']}\" class=\"lightlink\">{$mediatype['display']}</a></li>\n";
				}
			}
			echo "<li><a href=\"{$cms['tngpath']}browsealbums.php\" class=\"lightlink\">{$text['albums']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}browsemedia.php\" class=\"lightlink\">{$text['allmedia']}</a></li>\n";
			
			echo "<li class=\"margin-top\"><a href=\"{$cms['tngpath']}cemeteries.php\" class=\"lightlink\">{$text['mnucemeteries']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}places.php\" class=\"lightlink\">{$text['places']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}browsenotes.php\" class=\"lightlink\">{$text['notes']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}anniversaries.php\" class=\"lightlink\">{$text['anniversaries']}</a>&nbsp;&nbsp;&nbsp;&nbsp;</li>\n";
			echo "<li><a href=\"{$cms['tngpath']}calendar.php\" class=\"lightlink\">{$text['calendar']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}reports.php\" class=\"lightlink\">{$text['mnureports']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}browsesources.php\" class=\"lightlink\">{$text['mnusources']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}browserepos.php\" class=\"lightlink\">{$text['repositories']}</a></li>\n";
			if(!$tngconfig['hidedna'])
				echo "<li><a href=\"{$cms['tngpath']}browse_dna_tests.php\" class=\"lightlink\">{$text['dna_tests']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}statistics.php\" class=\"lightlink\">{$text['mnustatistics']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}changelanguage.php\" class=\"lightlink\">{$text['mnulanguage']}</a></li>\n";
			if( $allow_admin ) {
				echo "<li><a href=\"{$cms['tngpath']}showlog.php\" class=\"lightlink\">{$text['mnushowlog']}</a></li>\n";
				echo "<li><a href=\"{$cms['tngpath']}admin.php\" class=\"lightlink\">{$text['mnuadmin']}</a></li>\n";
			}
			echo "<li><a href=\"{$cms['tngpath']}bookmarks.php\" class=\"lightlink\">{$text['bookmarks']}</a></li>\n";
			echo "<li><a href=\"{$cms['tngpath']}suggest.php?page=$title\" class=\"lightlink\">{$text['contactus']}</a></li>\n";
			if(!$currentuser && !$tngconfig['disallowreg'])
				echo "<li><a href=\"{$cms['tngpath']}newacctform.php\" class=\"lightlink\">{$text['mnuregister']}</a></li>\n";
		?>
					
			<br/>
		</div>
	
		<div id="innerpage">
			
<?php
		//begin HEADER IMAGE (default: small picture of a girl at the top right)
		//Actual file name has been replaced with t4_headimg variable, configurable from Template Settings. Default name of actual image is "smallphoto.jpg"
		//You can replace the t4_headimg PHP block in the line below with the desired image name if you prefer that to using the Template Settings.
?>
		<img src="<?php echo $cms['tngpath'] . $templatepath; ?><?php echo $tmp['t4_headimg']; ?>" alt="" class="smallphoto" />	
<?php

		//begin TITLE IMAGE (default: "Our Family Genealogy Pages")
		//Actual file name has been replaced with t4_titleimg variable, configurable from Template Settings. Default name of actual image is "title.gif"
		//You can replace the t4_headtitleimg PHP block in the line below with the desired image name if you prefer that to using the Template Settings.

	if($tmp['t4_titlechoice'] == "text") {
?>
				<div>
					<br/>
					<span class="titletop"><?php echo getTemplateMessage('t4_headtitle1'); ?></span><br />
					<span class="titlebottom">&nbsp;<?php echo getTemplateMessage('t4_headtitle2'); ?></span>
				</div>
<?php
	}
	else {

?>
				<img src="<?php echo $cms['tngpath'] . $templatepath; ?><?php echo $tmp['t4_titleimg']; ?>" alt="" class="banner" width="468" height="100" /><br />
<?php
	}
	//end TITLE IMAGE
?>
<br/>
	<div class="line"></div>
<br/>

<!-- topmenu for template 4 -->