<?php
include("begin.php");
include("adminlib.php");
$textpart = "setup";
//include("getlang.php");
include("$mylanguage/admintext.php");

$treeList = array();
if( $link ) {
	$admin_login = 1;
	include("checklogin.php");
	include("version.php");

	if( $assignedtree || !$allow_edit ) {
		$message = $admtext['norights'];
		header( "Location: admin_login.php?message=" . urlencode($message) );
		exit;
	}

	$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
	$result = @tng_query($query);
	while( $row = tng_fetch_assoc($result) ) {
		$treeList[] = $row;
	}
}
else
	$result = false;

if(!$lineendingdisplay) {
	if($lineending == "\r\n")
		$lineendingdisplay = "\\r\\n";
	elseif($lineending == "\r")
		$lineendingdisplay = "\\r";
	elseif($lineending == "\n")
		$lineendingdisplay = "\\n";
}
if( empty($tngconfig['backupdays']) ) $tngconfig['backupdays'] = 30;
$tngconfig['doctype'] = preg_replace("/\"/", "&#34;",$tngconfig['doctype']);
$sitename = preg_replace("/\"/", "&#34;",$sitename);
$site_desc = preg_replace("/\"/", "&#34;",$site_desc);
$dbowner = preg_replace("/\"/", "&#34;",$dbowner);
$tngconfig['footermsg'] = isset($tngconfig['footermsg']) ? preg_replace("/\"/", "&#34;",$tngconfig['footermsg']) : "";
if(empty($tngconfig['altbirth'])) $tngconfig['altbirth'] = "CHR,BAPM";
if(empty($tngconfig['collstdevents'])) $tngconfig['collstdevents'] = "BIRT,BURI,CHR,DEAT,MARR";
if(!isset($tngconfig['scrollnotes'])) $tngconfig['scrollnotes'] = 1;
if(!isset($tngconfig['searchorder'])) $tngconfig['searchorder'] = 0;
if(!isset($tngconfig['collapsestd'])) $tngconfig['collapsestd'] = 0;
if(empty($tngconfig['sendingemail'])) $tngconfig['sendingemail'] = $emailaddr;

$helplang = findhelp("config_help.php");

tng_adminheader( $admtext['modifysettings'], $flags );
?>
<script type="text/javascript">
function toggleAll(display) {
	toggleSection('db','plus0',display);
	toggleSection('tables','plus1',display);
	toggleSection('folders','plus2',display);
	toggleSection('site','plus3',display);
	toggleSection('menus','plus4',display);
	toggleSection('media','plus5',display);
	toggleSection('lang','plus6',display);
	toggleSection('priv','plus7',display);
	toggleSection('names','plus8',display);
	toggleSection('cemeteries','plus9',display);
	toggleSection('mailreg','plus10',display);
	toggleSection('pref','plus11',display);
	toggleSection('mobile','plus12',display);
	toggleSection('dna','plus13',display);
	toggleSection('misc','plus14',display);
	return false;
}

function flipTreeRestrict(requirelogin) {
	if(parseInt(requirelogin)) {
		jQuery('#treerestrict').show();
		jQuery('#trdisabled').hide();
	}
	else {
		jQuery('#treerestrict').hide();
		jQuery('#trdisabled').show();
	}
}

function toggleAllowReg() {
	if(document.form1.disallowreg.selectedIndex == 1) {   //off
		jQuery('#autoapp').prop('disabled',true);
		jQuery('#autotree').prop('disabled',true);
		jQuery('#ackemail').prop('disabled',true);
		jQuery('#omitpwd').prop('disabled',true);
	}
	else {
		jQuery('#autoapp').prop('disabled',false);
		jQuery('#autotree').prop('disabled',false);
		if(document.form1.autoapp.selectedIndex == 0) {
			jQuery('#ackemail').prop('disabled',false);
		}
		jQuery('#omitpwd').prop('disabled',false);
	}
}

function toggleAutoApprove() {
	if(document.form1.autoapp.selectedIndex == 1) {   //off
		jQuery('#ackemail').prop('disabled',true);
	}
	else {
		jQuery('#ackemail').prop('disabled',false);
	}
}

function flipPlaces(select) {
	if(select.selectedIndex) {
		//change to NO
		jQuery('#merge').show();
		jQuery('#mergeexpl').show();
		jQuery('#convert').hide();
		jQuery('#convertexpl').hide();
		jQuery('#placetree').hide();
	}
	else {
		//change to YES
		jQuery('#convert').show();
		jQuery('#convertexpl').show();
		jQuery('#placetree').show();
		jQuery('#merge').hide();
		jQuery('#mergeexpl').hide();
	}
}

function convertPlaces(command) {
	var options = {action:command};
	if(command == "convert")
		options.placetree = jQuery('#placetree').val();
	jQuery('#'+command+'expl').html('<img src="' + cmstngpath + 'img/spinner.gif" style="border:0px;vertical-align:middle;">');

	jQuery.ajax({
		url: 'ajx_placeconvert.php',
		data: options,
		type: 'GET',
		dataType: 'html',
		success: function(req) {
            jQuery('#'+command+'expl').html(req);
        }
    });

	return false;
}

function convertMedia(select) {
	var options = {action:select.val()};
	jQuery('#mediaexpl').html('<img src="' + cmstngpath + 'img/spinner.gif" style="border:0px;vertical-align:middle;"/>');

	jQuery.ajax({
		url: 'ajx_mediaconvert.php',
		data: options,
		type: 'GET',
		dataType: 'html',
		success: function(req) {
            jQuery('#mediaexpl').html(req);
        }
    });

	return false;
}
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<?php
	echo tng_adminlayout();

	$setuptabs[0] = array(1,"admin_setup.php",$admtext['configuration'],"configuration");
	$setuptabs[1] = array(1,"admin_diagnostics.php",$admtext['diagnostics'],"diagnostics");
	$setuptabs[2] = array(1,"admin_setup.php?sub=tablecreation",$admtext['tablecreation'],"tablecreation");
	$setuptabs[3] = array(1,"#",$admtext['configsettings'],"gen");
	$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/config_help.php#modify');\" class=\"lightlink\">{$admtext['help']}</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">{$text['expandall']}</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">{$text['collapseall']}</a>";
	$menu = doMenu($setuptabs,"gen",$innermenu);
	echo displayHeadline($admtext['setup'] . " &gt;&gt; " . $admtext['configuration'] . " &gt;&gt; " . $admtext['configsettings'],"img/setup_icon.gif",$menu,"");
?>

<div class="admin-main">
<form action="admin_updateconfig.php" method="post" name="form1" >

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="adm-rounded-table">
<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus0",0,"db",$admtext['dbsection'],""); ?>

	<div id="db" style="display:none"><br/>
	<table border="0" class="label">
		<tr><td><?php echo $admtext['dbhost']; ?>:</td><td><input type="text" value="<?php echo $database_host; ?>" name="new_database_host" size="20"></td></tr>
		<tr><td><?php echo $admtext['dbname']; ?>:</td><td><input type="text" value="<?php echo $database_name; ?>" name="new_database_name" size="20"></td></tr>
		<tr><td><?php echo $admtext['dbusername']; ?>:</td><td><input type="text" value="<?php echo $database_username; ?>" name="new_database_username" size="20"></td></tr>
		<tr><td><?php echo $admtext['dbpassword']; ?>:</td><td><input type="text" value="<?php echo $database_password; ?>" name="new_database_password" size="20"></td></tr>
		<tr><td><?php echo $admtext['dbport']; ?>:</td><td><input type="text" value="<?php echo $database_port; ?>" name="new_database_port" size="20"></td></tr>
		<tr><td><?php echo $admtext['dbsocket']; ?>:</td><td><input type="text" value="<?php echo $database_socket; ?>" name="new_database_socket" size="20"></td></tr>
<?php
	$query = "SELECT count(userID) as ucount FROM $users_table";
	$uresult = @tng_query($query);
	if( $uresult ) {
		$urow = tng_fetch_assoc($uresult);
		tng_free_result($uresult);
	}
	else
		$urow['ucount'] = 0;
?>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><?php echo $admtext['maintmode']; ?>:</td>
			<td>
				<select class="bigselect" name="maint"<?php if(!$urow['ucount']) echo " disabled=\"disabled\""; ?>>
					<option value=""<?php if( empty($tngconfig['maint']) ) echo " selected=\"selected\""; ?>><?php echo $admtext['off']; ?></option>
					<option value="1"<?php if( !empty($tngconfig['maint']) ) echo " selected=\"selected\""; ?>><?php echo $admtext['on']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus1",0,"tables",$admtext['tablesection'],""); ?>

	<div id="tables" style="display:none"><br/>
	<table border="0" cellspacing="0" cellpadding="0" class="label">
		<tr>
			<td valign="top">
				<table class="label">
					<tr><td><?php echo $admtext['people']; ?>:</td><td><input type="text" value="<?php echo $people_table; ?>" name="people_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['families']; ?>:</td><td><input type="text" value="<?php echo $families_table; ?>" name="families_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['children']; ?>:</td><td><input type="text" value="<?php echo $children_table; ?>" name="children_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['albums']; ?>:</td><td><input type="text" value="<?php echo $albums_table; ?>" name="albums_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['album2entitiestable']; ?>:</td><td><input type="text" value="<?php echo $album2entities_table; ?>" name="album2entities_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['albumlinkstable']; ?>:</td><td><input type="text" value="<?php echo $albumlinks_table; ?>" name="albumlinks_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['media']; ?>:</td><td><input type="text" value="<?php echo $media_table; ?>" name="media_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['medialinkstable']; ?>:</td><td><input type="text" value="<?php echo $medialinks_table; ?>" name="medialinks_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['mediatypes']; ?>:</td><td><input type="text" value="<?php echo $mediatypes_table; ?>" name="mediatypes_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['addresstable']; ?>:</td><td><input type="text" value="<?php echo $address_table; ?>" name="address_table" size="20"></td></tr>
			 		<tr><td><?php echo $admtext['languages']; ?>:</td><td><input type="text" value="<?php echo $languages_table; ?>" name="languages_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['places']; ?>:</td><td><input type="text" value="<?php echo $places_table; ?>" name="places_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['cemeteries']; ?>:</td><td><input type="text" value="<?php echo $cemeteries_table; ?>" name="cemeteries_table" size="20"></td></tr>
				</table>
			</td>
			<td>&nbsp;</td>
			<td valign="top">
				<table class="label">
					<tr><td><?php echo $admtext['statestable']; ?>:</td><td><input type="text" value="<?php echo $states_table; ?>" name="states_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['countriestable']; ?>:</td><td><input type="text" value="<?php echo $countries_table; ?>" name="countries_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['users']; ?>:</td><td><input type="text" value="<?php echo $users_table; ?>" name="users_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['sources']; ?>:</td><td><input type="text" value="<?php echo $sources_table; ?>" name="sources_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['citations']; ?>:</td><td><input type="text" value="<?php echo $citations_table; ?>" name="citations_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['imgtags']; ?>:</td><td><input type="text" value="<?php echo $image_tags_table; ?>" name="image_tags_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['repositories']; ?>:</td><td><input type="text" value="<?php echo $repositories_table; ?>" name="repositories_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['events']; ?>:</td><td><input type="text" value="<?php echo $events_table; ?>" name="events_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['eventtypes']; ?>:</td><td><input type="text" value="<?php echo $eventtypes_table; ?>" name="eventtypes_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['reports']; ?>:</td><td><input type="text" value="<?php echo $reports_table; ?>" name="reports_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['trees']; ?>:</td><td><input type="text" value="<?php echo $trees_table; ?>" name="trees_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['notes']; ?>:</td><td><input type="text" value="<?php echo $xnotes_table; ?>" name="xnotes_table" size="20"></td></tr>
				</table>
			</td>
			<td>&nbsp;</td>
			<td valign="top">
				<table class="label">
					<tr><td><?php echo $admtext['notelinkstable']; ?>:</td><td><input type="text" value="<?php echo $notelinks_table; ?>" name="notelinks_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['saveimporttable']; ?>:</td><td><input type="text" value="<?php echo $saveimport_table; ?>" name="saveimport_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['branches']; ?>:</td><td><input type="text" value="<?php echo $branches_table; ?>" name="branches_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['brlinkstable']; ?>:</td><td><input type="text" value="<?php echo $branchlinks_table; ?>" name="branchlinks_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['tleventstable']; ?>:</td><td><input type="text" value="<?php echo $tlevents_table; ?>" name="tlevents_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['temptable']; ?>:</td><td><input type="text" value="<?php echo $temp_events_table; ?>" name="temp_events_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['associations']; ?>:</td><td><input type="text" value="<?php echo $assoc_table; ?>" name="assoc_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['mostwanted']; ?>:</td><td><input type="text" value="<?php echo $mostwanted_table; ?>" name="mostwanted_table" size="20"></td></tr>
					<!--<tr><td><?php /*echo $admtext['mhrequests'];*/ ?>:</td><td><input type="text" value="<?php /*echo $mhrequests_table;*/ ?>" name="mhrequests_table" size="20"></td></tr>-->
					<tr><td><?php echo $admtext['dna_tests']; ?>:</td><td><input type="text" value="<?php echo $dna_tests_table; ?>" name="dna_tests_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['dna_groups']; ?>:</td><td><input type="text" value="<?php echo $dna_groups_table; ?>" name="dna_groups_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['dna_links']; ?>:</td><td><input type="text" value="<?php echo $dna_links_table; ?>" name="dna_links_table" size="20"></td></tr>
					<tr><td><?php echo $admtext['templates']; ?>:</td><td><input type="text" value="<?php echo $templates_table; ?>" name="templates_table" size="20"></td></tr>
				</table>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus2",0,"folders",$admtext['foldersection'],""); ?>

	<div id="folders" style="display:none"><br/>
	<table class="label">
		<tr><td class="nw"><?php echo $admtext['rootpath']; ?>:</td><td><input type="text" value="<?php echo $saved_rootpath; ?>" name="newrootpath" class="verylongfield"></td></tr>
<?php
	if(!$saved_rootpath) {
?>
		<tr><td>&nbsp;</td><td><?php echo $admtext['default'] . ": " . $rootpath; ?></td>
<?php
	}
?>
		<tr><td class="nw"><?php echo $admtext['subroot']; ?>*:</td><td><input type="text" value="<?php echo $tngconfig['subroot']; ?>" name="newsubroot" class="verylongfield"></td>
		<tr><td>&nbsp;</td><td>*<?php echo $admtext['srexpl']; ?></td>

		<tr><td class="nw"><?php echo $admtext['photopath']; ?>:</td>
			<td><input type="text" value="<?php echo $photopath; ?>" name="photopath" class="verylongfield"><input type="hidden" id="photos_org" value="<?php echo $photopath; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onclick="makeFolder('photos',document.form1.photopath.value);"> <span id="msg_photos"></span></td></tr>
		<tr><td class="nw"><?php echo $admtext['documentpath']; ?>:</td>
			<td><input type="text" value="<?php echo $documentpath; ?>" name="documentpath" class="verylongfield"><input type="hidden" id="documents_org" value="<?php echo $documentpath; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onClick="makeFolder('documents',document.form1.documentpath.value);"> <span id="msg_documents"></span></td></tr>
		<tr><td class="nw"><?php echo $admtext['historypath']; ?>:</td>
			<td><input type="text" value="<?php echo $historypath; ?>" name="historypath" class="verylongfield"><input type="hidden" id="histories_org" value="<?php echo $historypath; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onClick="makeFolder('histories',document.form1.historypath.value);"> <span id="msg_histories"></span></td></tr>
		<tr><td class="nw"><?php echo $admtext['headstonepath']; ?>:</td>
			<td><input type="text" value="<?php echo $headstonepath; ?>" name="headstonepath" class="verylongfield"><input type="hidden" id="headstones_org" value="<?php echo $headstonepath; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onClick="makeFolder('headstones',document.form1.headstonepath.value);"> <span id="msg_headstones"></span></td></tr>
		<tr><td class="nw"><?php echo $admtext['mediapath']; ?>:</td>
			<td><input type="text" value="<?php echo $mediapath; ?>" name="mediapath" class="verylongfield"><input type="hidden" id="media_org" value="<?php echo $mediapath; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onClick="makeFolder('media',document.form1.mediapath.value);"> <span id="msg_media"></span></td></tr>
		<tr><td class="nw"><?php echo $admtext['modspath']; ?>:</td>
			<td><input type="text" value="<?php echo $modspath; ?>" name="modspath" class="verylongfield"><input type="hidden" id="mods_org" value="<?php echo $modspath; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onClick="makeFolder('mods',document.form1.modspath.value);"> <span id="msg_mods"></span></td></tr>
		<tr><td class="nw"><?php echo $admtext['extspath']; ?>:</td>
			<td><input type="text" value="<?php echo $extspath; ?>" name="extspath" class="verylongfield"><input type="hidden" id="exts_org" value="<?php echo $extspath; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onClick="makeFolder('exts',document.form1.extspath.value);"> <span id="msg_exts"></span></td></tr>
		<tr><td class="nw"><?php echo $admtext['gendex']; ?>:</td>
			<td><input type="text" value="<?php echo $gendexfile; ?>" name="gendexfile" class="verylongfield"><input type="hidden" id="gendex_org" value="<?php echo $gendexfile; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onClick="makeFolder('gendex',document.form1.gendexfile.value);"> <span id="msg_gendex"></span></td></tr>
		<tr><td class="nw"><?php echo $admtext['backuppath']; ?>:</td>
			<td><input type="text" value="<?php echo $backuppath; ?>" name="backuppath" class="verylongfield"><input type="hidden" id="backups_org" value="<?php echo $backuppath; ?>"/>
			<input type="button" class="btn" value="<?php echo $admtext['text_rename']; ?>" onClick="makeFolder('backups',document.form1.backuppath.value);"> <span id="msg_backups"></span></td></tr>
		<tr><td></td><td><input type="checkbox" name="saveconfig" value="1" <?php if( !empty($tngconfig['saveconfig']) ) { echo "checked=\"checked\""; } ?>> <?php echo $admtext['saveincfg']; ?></td></tr>
	</table>
	</div>

</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus3",0,"site",$admtext['sitesection'],""); ?>

	<div id="site" style="display:none"><br/>
	<table class="label">
		<tr><td><?php echo $admtext['homepage']; ?>:</td><td><input type="text" value="<?php echo $homepage; ?>" name="homepage" size="40"></td></tr>
		<tr><td><?php echo $admtext['tngdomain']; ?>:</td><td><input type="text" value="<?php echo $tngdomain; ?>" name="tngdomain" size="40"></td></tr>
		<tr><td><?php echo $admtext['sitename']; ?>:</td><td><input type="text" value="<?php echo $sitename; ?>" name="sitename" size="40"></td></tr>
		<tr><td valign="top"><?php echo $admtext['site_desc']; ?>:</td><td><textarea name="site_desc" rows="4" cols="65"><?php echo $site_desc; ?></textarea></td></tr>
		<tr><td><?php echo $admtext['doctype']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['doctype']; ?>" name="doctype" size="70"></td></tr>
		<tr><td><?php echo $admtext['siteowner']; ?>:</td><td><input type="text" value="<?php echo $dbowner; ?>" name="dbowner" size="40"></td></tr>
		<tr><td><?php echo $admtext['customheader']; ?>:</td><td><input type="text" value="<?php echo $customheader; ?>" name="customheader" size="20"></td></tr>
		<tr><td><?php echo $admtext['customfooter']; ?>:</td><td><input type="text" value="<?php echo $customfooter; ?>" name="customfooter" size="20"></td></tr>
		<tr><td valign="top"><?php echo $admtext['footermsg']; ?>:</td><td><textarea name="tng_footermsg" rows="4" cols="65"><?php echo $tngconfig['footermsg']; ?></textarea></td></tr>
		<tr><td><?php echo $admtext['custommeta']; ?>:</td><td><input type="text" value="<?php echo $custommeta; ?>" name="custommeta" size="20"></td></tr>
		<tr>
			<td><?php echo $admtext['searchchoice']; ?>:</td>
			<td>
				<select class="bigselect" name="searchchoice">
					<option value="0"<?php if( !$tngconfig['searchchoice'] ) echo " selected"; ?>><?php echo $admtext['quicksearch']; ?></option>
					<option value="1"<?php if( $tngconfig['searchchoice'] ) echo " selected"; ?>><?php echo $admtext['advsearch']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['hidechr']; ?>:</td>
			<td>
				<select class="bigselect" name="hidechr">
					<option value="0"<?php if( !$tngconfig['hidechr'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['hidechr'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><?php echo $admtext['altbirthtypes']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['altbirth']; ?>" name="altbirth" class="longfield"></td></tr>
		<tr>
			<td><?php echo $admtext['collapsestd']; ?>:</td>
			<td>
				<select class="bigselect" name="collapsestd" id="collapsestd" onchange="jQuery('#collapsestuff').toggle(200);">
					<option value="0"<?php if( !$tngconfig['collapsestd'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['collapsestd'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr id="collapsestuff" <?php if(!$tngconfig['collapsestd']) echo "style=\"display:none\""; ?>><td><?php echo $admtext['collstdevents']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['collstdevents']; ?>" name="collstdevents" class="longfield"></td></tr>
		<tr><td><?php echo $admtext['defaulttree']; ?>:</td><td>
			<select class="bigselect" name="defaulttree">
				<option value=""></option>
<?php
if( $link && $result ) {
	foreach($treeList as $treerow) {
		echo "	<option value=\"{$treerow['gedcom']}\"";
		if( $defaulttree == $treerow['gedcom'] ) echo " selected";
		echo ">{$treerow['treename']}</option>\n";
	}
}
else
	echo "	<option value=\"$defaulttree\" selected>$defaulttree</option>\n";
?>
			</select>
		</td></tr>
		<tr>
			<td><?php echo $admtext['sortevents']; ?>:</td>
			<td>
				<select class="bigselect" name="sortbydate">
					<option value="0"<?php if( !$tngconfig['sortbydate'] ) echo " selected"; ?>><?php echo $admtext['sortbydate']; ?></option>
					<option value="1"<?php if( $tngconfig['sortbydate'] ) echo " selected"; ?>><?php echo $admtext['sortbytype']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus4",0,"menus",$admtext['menus'],""); ?>

	<div id="menus" style="display:none"><br/>
	<table class="label">
	<tr>
			<td><?php echo $admtext['showmenus']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_menu">
					<option value="0"<?php if( !$tngconfig['menu'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="2"<?php if( $tngconfig['menu'] == 2 ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['showicons']; ?>:</td>
			<td>
				<select class="bigselect" name="showicons">
					<option value="0"<?php if( !$tngconfig['showicons'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['showicons'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	<p class="label"><?php echo $admtext['displaythese']; ?>:</p>
	<table class="label">
		<tr>
			<td valign="top">
				<input type="checkbox" name="tng_menu_surnames" value="1"<?php if( $tngconfig['menu_surnames'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['surnames']; ?><br />
				<input type="checkbox" name="tng_menu_firstnames" value="1"<?php if( $tngconfig['menu_firstnames'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['firstnames']; ?><br />
				<input type="checkbox" name="tng_menu_psearch" value="1"<?php if( $tngconfig['menu_psearch'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['searchnames']; ?><br />
				<input type="checkbox" name="tng_menu_fsearch" value="1"<?php if( $tngconfig['menu_fsearch'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['searchfams']; ?><br />
				<input type="checkbox" name="tng_menu_ssearch" value="1"<?php if( $tngconfig['menu_ssearch'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['searchsitemenu']; ?><br />
				<input type="checkbox" name="tng_menu_dates" value="1"<?php if( $tngconfig['menu_dates'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['dates']; ?><br />
				<input type="checkbox" name="tng_menu_cal" value="1"<?php if( $tngconfig['menu_cal'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['calendar']; ?><br />
				<input type="checkbox" name="tng_menu_wnew" value="1"<?php if( $tngconfig['menu_wnew'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['whatsnew']; ?><br />
				<input type="checkbox" name="tng_menu_mostw" value="1"<?php if( $tngconfig['menu_mostw'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['mostwanted']; ?><br />
				<input type="checkbox" name="tng_menu_reports" value="1"<?php if( $tngconfig['menu_reports'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['reports']; ?><br />
				<input type="checkbox" name="tng_menu_cems" value="1"<?php if( $tngconfig['menu_cems'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['cemeteries']; ?><br />
			</td>
			<td>&nbsp;</td>
			<td valign="top">
				<input type="checkbox" name="tng_menu_places" value="1"<?php if( $tngconfig['menu_places'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['places']; ?><br />
				<input type="checkbox" name="tng_menu_stats" value="1"<?php if( $tngconfig['menu_stats'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['onstats']; ?><br />
				<input type="checkbox" name="tng_menu_trees" value="1"<?php if( $tngconfig['menu_trees'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['trees']; ?><br />
				<input type="checkbox" name="tng_menu_branches" value="1"<?php if( $tngconfig['menu_branches'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['branches']; ?><br />
				<input type="checkbox" name="tng_menu_bmarks" value="1"<?php if( $tngconfig['menu_bmarks'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['bookmarks']; ?><br />
				<input type="checkbox" name="tng_menu_notes" value="1"<?php if( $tngconfig['menu_notes'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['notes']; ?><br />
				<input type="checkbox" name="tng_menu_sources" value="1"<?php if( $tngconfig['menu_sources'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['sources']; ?><br />
				<input type="checkbox" name="tng_menu_repos" value="1"<?php if( $tngconfig['menu_repos'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['repositories']; ?><br />
				<input type="checkbox" name="tng_menu_dna" value="1"<?php if( $tngconfig['menu_dna'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['dna_tests']; ?><br />
				<input type="checkbox" name="tng_menu_admin" value="1"<?php if( $tngconfig['menu_admin'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['administration']; ?><br />
				<input type="checkbox" name="tng_menu_log" value="1"<?php if( $tngconfig['menu_log'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['mnushowlog']; ?><br />
				<input type="checkbox" name="tng_menu_contact" value="1"<?php if( $tngconfig['menu_contact'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['contactus']; ?><br />
				<input type="checkbox" name="tng_menu_profile" value="1"<?php if( $tngconfig['menu_profile'] ) echo " checked=\"checked\""; ?> /> <?php echo $text['editprofile']; ?><br />
			</td>
			<td>&nbsp;</td>
			<td valign="top">
				<input type="checkbox" name="showhome" value="0"<?php if( !$tngconfig['showhome'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['showhome']; ?><br />
				<input type="checkbox" name="showsearch" value="0"<?php if( !$tngconfig['showsearch'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['search']; ?><br />
				<input type="checkbox" name="showlogin" value="0"<?php if( !$tngconfig['showlogin'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['showlogin']; ?><br />
				<input type="checkbox" name="showshare" value="1"<?php if( $tngconfig['showshare'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['showshare']; ?><br />
				<input type="checkbox" name="showprint" value="0"<?php if( !$tngconfig['showprint'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['showprint']; ?><br />
				<input type="checkbox" name="showbmarks" value="0"<?php if( !$tngconfig['showbmarks'] ) echo " checked=\"checked\""; ?> /> <?php echo $admtext['showbmarks']; ?><br />
			</td>
		</tr>
	</table>
	</div>
</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus5",0,"media",$admtext['media'],""); ?>

	<div id="media" style="display:none"><br/>
	<table class="label">
		<tr>
			<td><?php echo $admtext['photosext']; ?>:</td>
			<td>
				<select class="bigselect" name="photosext">
					<option value="jpg"<?php if( $photosext == "jpg" ) echo " selected"; ?>>.jpg</option>
					<option value="gif"<?php if( $photosext == "gif" ) echo " selected"; ?>>.gif</option>
					<option value="png"<?php if( $photosext == "png" ) echo " selected"; ?>>.png</option>
					<option value="webp"<?php if( $photosext == "webp" ) echo " selected"; ?>>.webp</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['showextended']; ?>:</td>
			<td>
				<select class="bigselect" name="showextended">
					<option value="1"<?php if( $showextended ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$showextended ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><?php echo $admtext['imgmaxh']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['imgmaxh']; ?>" name="imgmaxh" size="20"></td></tr>
		<tr><td><?php echo $admtext['imgmaxw']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['imgmaxw']; ?>" name="imgmaxw" size="20"></td></tr>
		<tr><td><?php echo $admtext['thumbprefix']; ?>:</td><td><input type="text" value="<?php echo $thumbprefix; ?>" name="thumbprefix" size="20"></td></tr>
		<tr><td><?php echo $admtext['thumbsuffix']; ?>:</td><td><input type="text" value="<?php echo $thumbsuffix; ?>" name="thumbsuffix" size="20"></td></tr>
		<tr><td><?php echo $admtext['thumbmaxh']; ?>:</td><td><input type="text" value="<?php echo $thumbmaxh; ?>" name="thumbmaxh" size="20"></td></tr>
		<tr><td><?php echo $admtext['thumbmaxw']; ?>:</td><td><input type="text" value="<?php echo $thumbmaxw; ?>" name="thumbmaxw" size="20"></td></tr>
		<tr>
			<td><?php echo $admtext['usedefthumbs']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_usedefthumbs">
					<option value="0"<?php if( !$tngconfig['usedefthumbs'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['usedefthumbs'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><?php echo $admtext['maxnoteprev']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['maxnoteprev']; ?>" name="tng_maxnoteprev" size="20"></td></tr>
		<tr>
			<td><?php echo $admtext['ssenabled']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_ssdisabled">
					<option value="0"<?php if( !$tngconfig['ssdisabled'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['ssdisabled'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['ssrepeat']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_ssrepeat">
					<option value="1"<?php if( $tngconfig['ssrepeat'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$tngconfig['ssrepeat'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['imgviewer']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_imgviewer">
					<option value="0"<?php if( !$tngconfig['imgviewer'] ) echo " selected"; ?>><?php echo $admtext['ldson']; ?></option>
					<option value="documents"<?php if( $tngconfig['imgviewer'] == "documents" ) echo " selected"; ?>><?php echo $admtext['docsonly']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['imgvheight']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_imgvheight">
					<option value="0"<?php if( $tngconfig['imgvheight'] == 0 ) echo " selected"; ?>><?php echo $admtext['flex']; ?></option>
					<option value="640"<?php if( $tngconfig['imgvheight'] == "640" ) echo " selected"; ?>><?php echo $admtext['setheight']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['hidemedia']; ?>:</td>
			<td>
				<select class="bigselect" name="hidemedia">
					<option value="1"<?php if( $tngconfig['hidemedia'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$tngconfig['hidemedia'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['mediadel']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_mediadel">
					<option value="0"<?php if( !$tngconfig['mediadel'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['mediadel'] == 1 ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="2"<?php if( $tngconfig['mediadel'] == 2 ) echo " selected"; ?>><?php echo $admtext['onrequest']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['mediathumbs']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_mediathumbs">
					<option value="1"<?php if( $tngconfig['mediathumbs'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$tngconfig['mediathumbs'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['docthumbs']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_docthumbs">
					<option value="1"<?php if( $tngconfig['docthumbs'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$tngconfig['docthumbs'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['histhumbs']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_histhumbs">
					<option value="1"<?php if( $tngconfig['histhumbs'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$tngconfig['histhumbs'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['mediatrees']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_mediatrees" id="tng_mediatrees">
					<option value="0"<?php if( !$tngconfig['mediatrees'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['mediatrees'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
				<input type="button" class="btn" value="<?php echo $admtext['convert']; ?>" id="convertmedia" onclick="convertMedia(jQuery('#tng_mediatrees'));"/>
				<div id="mediaexpl" style="display:inline-block"></div>
			</td>
		</tr>
		<tr><td>Favicon:</td><td><input type="text" value="<?php echo $tngconfig['favicon']; ?>" name="favicon" size="20"></td></tr>
	</table>
	</div>

</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus6",0,"lang",$admtext['language'],""); ?>

	<div id="lang" style="display:none"><br/>
	<table class="label">
		<tr>
			<td><?php echo $admtext['langfolder']; ?>:</td>
			<td>
				<select class="bigselect" name="language">
<?php
	@chdir($rootpath . $endrootpath . $languages_path);
	if( $handle = @opendir('.') ) {
		$dirs = array();
		while ($filename = readdir( $handle )) {
			if(is_dir($filename) && $filename != '..' && $filename != '.' && $filename != '@eaDir')
				array_push($dirs, $filename);
		}
		natcasesort( $dirs );
		$found_current = 0;
		foreach( $dirs as $dir ) {
			echo "<option value=\"$dir\"";
			if($dir == $language) {
				echo " selected=\"selected\"";
				$found_current = 1;
			}
			echo ">$dir</option>\n";
		}
		if(!$found_current)
			echo "<option value=\"$language\" selected=\"selected\">$language</option>\n";
		closedir( $handle );
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['charset']; ?>:</td>
			<td>
				<select class="bigselect" name="charset">
					<option value="UTF-8"<?php if( strtoupper($charset) == "UTF-8" ) echo " selected"; ?>>UTF-8</option>
					<option value="ISO-8859-1"<?php if( strtoupper($charset) == "ISO-8859-1" ) echo " selected"; ?>>ISO-8859-1 (ANSI)</option>
					<option value="ISO-8859-2"<?php if( strtoupper($charset) == "ISO-8859-2" ) echo " selected"; ?>>ISO-8859-2</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['chooselang']; ?>:</td>
			<td>
				<select class="bigselect" name="chooselang">
					<option value="1"<?php if( $chooselang ) echo " selected"; ?>><?php echo $admtext['allow']; ?></option>
					<option value="0"<?php if( !$chooselang ) echo " selected"; ?>><?php echo $admtext['disallow']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['norels']; ?>:</td>
			<td>
				<select class="bigselect" name="norels">
					<option value=""<?php if( !$norels ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $norels ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus7",0,"priv",$admtext['privsection'],""); ?>

	<div id="priv" style="display:none"><br/>
	<table class="label">
		<tr>
			<td><?php echo $admtext['requirelogin']; ?>:</td>
			<td>
				<select class="bigselect" name="requirelogin" onchange="flipTreeRestrict(this.options[this.selectedIndex].value);">
					<option value="1"<?php if( $requirelogin ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$requirelogin ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['treerestrict']; ?>: &nbsp;&nbsp;</td>
			<td><span id="trdisabled"<?php if( $requirelogin ) echo " style=\"display:none\""; ?>><?php echo $admtext['reqloginset']; ?></span>
				<select class="bigselect" name="treerestrict" id="treerestrict"<?php if( !$requirelogin ) echo " style=\"display:none\""; ?>>
					<option value="0"<?php if( !$treerestrict ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $treerestrict ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['ldsdefault']; ?>:</td>
			<td>
				<select class="bigselect" name="ldsdefault">
					<option value="0"<?php if( !$ldsdefault ) echo " selected"; ?>><?php echo $admtext['ldson']; ?></option>
					<option value="1"<?php if( $ldsdefault == 1 ) echo " selected"; ?>><?php echo $admtext['ldsoff']; ?></option>
					<option value="2"<?php if( $ldsdefault == 2 ) echo " selected"; ?>><?php echo $admtext['ldspermit']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['livedefault']; ?>:</td>
			<td>
				<select class="bigselect" name="livedefault">
					<option value="2"<?php if( $livedefault == 2 ) echo " selected"; ?>><?php echo $admtext['ldson']; ?></option>
					<!-- this line and the "never" (1) option will be removed in the future -->
					<?php
						if($livedefault == 1) {
							echo "<option value=\"1\" selected>{$admtext['ldsoff']}</option>\n";
						}
					?>
					<option value="0"<?php if( !$livedefault ) echo " selected"; ?>><?php echo $admtext['ldspermit']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['shownames']; ?>:</td>
			<td>
				<select class="bigselect" name="nonames">
					<option value="0"<?php if( !$nonames ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $nonames == 1 ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="2"<?php if( $nonames == 2 ) echo " selected"; ?>><?php echo $admtext['initials']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['shownamespr']; ?>:</td>
			<td>
				<select class="bigselect" name="nnpriv">
					<option value="0"<?php if( !$tngconfig['nnpriv'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['nnpriv'] == 1 ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="2"<?php if( $tngconfig['nnpriv'] == 2 ) echo " selected"; ?>><?php echo $admtext['initials']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['cookieapproval']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_cookieapproval">
					<option value="0"<?php if( !$tngconfig['cookieapproval'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['cookieapproval'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['dataprotectmsg']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_dataprotect">
					<option value="0"<?php if( !$tngconfig['dataprotect'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['dataprotect'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['askconsent']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_askconsent">
					<option value="0"<?php if( !$tngconfig['askconsent'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['askconsent'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['livingchecked']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_livingunchecked">
					<option value="0"<?php if( !$tngconfig['livingunchecked'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['livingunchecked'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['allowsuggest']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_nosuggest">
					<option value="0"<?php if( !$tngconfig['nosuggest'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['nosuggest'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['allowcsv']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_allowcsv">
					<option value="0"<?php if( !$tngconfig['allowcsv'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['allowcsv'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><?php echo $admtext['sitekey']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['sitekey']; ?>" name="rcsitekey" class="longfield"></td></tr>
		<tr><td><?php echo $admtext['secret']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['secret']; ?>" name="rcsecret" class="longfield"></td></tr>
	</table>
	</div>

</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus8",0,"names",$admtext['namesection'],""); ?>

	<div id="names" style="display:none"><br/>
	<table class="label">
		<tr>
			<td><?php echo $admtext['nameorder']; ?>:</td>
			<td>
				<select class="bigselect" name="nameorder">
					<option value=""></option>
					<option value="1"<?php if( $nameorder == 1 ) echo " selected"; ?>><?php echo $admtext['western']; ?></option>
					<option value="2"<?php if( $nameorder == 2 ) echo " selected"; ?>><?php echo $admtext['oriental']; ?></option>
					<option value="3"<?php if( $nameorder == 3 ) echo " selected"; ?>><?php echo $admtext['lnfirst']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['ucsurnames']; ?>:</td>
			<td>
				<select class="bigselect" name="ucsurnames">
					<option value="0"<?php if( !$tngconfig['ucsurnames'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['ucsurnames'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['lnprefixes']; ?>:</td>
			<td>
				<select class="bigselect" name="lnprefixes">
					<option value="0"<?php if( !$lnprefixes ) echo " selected"; ?>><?php echo $admtext['lntogether']; ?></option>
					<option value="1"<?php if( $lnprefixes ) echo " selected"; ?>><?php echo $admtext['lnapart']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td colspan="2"><?php echo $admtext['detectpfx']; ?>:</td></tr>
		<tr>
			<td>&nbsp;&nbsp;<?php echo $admtext['lnpfxnum']; ?>:</td>
			<td><input type="text" value="<?php echo $lnpfxnum; ?>" name="lnpfxnum" size="5"/></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;<?php echo $admtext['specpfx']; ?>*:</td>
			<td><input type="text" value="<?php echo stripslashes($specpfx); ?>" name="specpfx" class="verylongfield"/></td>
		</tr>
		<tr><td colspan="2">*<?php echo $admtext['commas']; ?></td></tr>
	</table>
	</div>

</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus9",0,"cemeteries",$admtext['cemeteries'],""); ?>

	<div id="cemeteries" style="display:none"><br/>
	<table class="label">
		<tr><td><?php echo $admtext['cemrows']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $tngconfig['cemrows']; ?>" name="cemrows" size="5"></td></tr>
		<tr>
			<td><?php echo $admtext['cemblanks']; ?>:</td>
			<td>
				<select class="bigselect" name="cemblanks">
					<option value="0"<?php if( !$tngconfig['cemblanks'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['cemblanks'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>
</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus10",0,"mailreg",$admtext['mailreg'],""); ?>

	<div id="mailreg" style="display:none"><br/>
	<table class="label">
		<tr><td><?php echo $admtext['emailaddress']; ?>:</td><td><input type="text" value="<?php echo $emailaddr; ?>" name="emailaddr" size="40"></td></tr>
		<tr>
			<td><?php echo $admtext['fromadmin']; ?>:</td>
			<td>
				<select class="bigselect" name="fromadmin">
					<option value="0"<?php if( !$tngconfig['fromadmin'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['fromadmin'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['allowreg']; ?>:</td>
			<td>
				<select class="bigselect" name="disallowreg" onchange="toggleAllowReg();">
					<option value="0"<?php if( !$tngconfig['disallowreg'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['disallowreg'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['revmail']; ?>:</td>
			<td>
				<select class="bigselect" name="revmail">
					<option value="0"<?php if( !$tngconfig['revmail'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['revmail'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['autotree']; ?>:</td>
			<td>
				<select class="bigselect" name="autotree" id="autotree"<?php if( $tngconfig['disallowreg'] ) echo " disabled"; ?>>
					<option value="0"<?php if( !$tngconfig['autotree'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['autotree'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['autoapp']; ?>:</td>
			<td>
				<select class="bigselect" name="autoapp" id="autoapp" onchange="toggleAutoApprove();"<?php if( $tngconfig['disallowreg'] ) echo " disabled"; ?>>
					<option value="0"<?php if( !$tngconfig['autoapp'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['autoapp'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['ackemail']; ?>:</td>
			<td>
				<select class="bigselect" name="ackemail" id="ackemail"<?php if( $tngconfig['disallowreg'] || $tngconfig['autoapp'] ) echo " disabled"; ?>>
					<option value="0"<?php if( !$tngconfig['ackemail'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['ackemail'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['inclpwd']; ?>:</td>
			<td>
				<select class="bigselect" name="omitpwd" id="omitpwd"<?php if( $tngconfig['disallowreg'] ) echo " disabled"; ?>>
					<option value="0"<?php if( !$tngconfig['omitpwd'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['omitpwd'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['usesmtp']; ?>:</td>
			<td>
				<select class="bigselect" name="usesmtp" id="usesmtp" onchange="jQuery('#smtpstuff').toggle(200);">
					<option value="0"<?php if( !$tngconfig['usesmtp'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['usesmtp'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
    </table>
	<table class="normal" style="margin-left:5px;<?php if(!$tngconfig['usesmtp']) echo " display:none"; ?>" id="smtpstuff">
        <tr><td><?php echo $admtext['sendingemail']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['sendingemail']; ?>" name="sendingemail" size="40"></td></tr>
        <tr><td><?php echo $admtext['mailhost']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['mailhost']; ?>" name="mailhost" size="40"></td></tr>
		<tr><td><?php echo $admtext['mailuser']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['mailuser']; ?>" name="mailuser" size="40"></td></tr>
		<tr><td><?php echo $admtext['mailpass']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['mailpass']; ?>" name="mailpass" size="40"></td></tr>
		<tr><td><?php echo $admtext['mailport']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['mailport']; ?>" name="mailport" size="40"></td></tr>
		<tr><td><?php echo $admtext['mailenc']; ?>:</td><td>
			<select class="bigselect" name="mailenc">
				<option value=""<?php if( $tngconfig['mailenc'] != "ssl" && $tngconfig['mailenc'] != "tls" ) echo " selected=\"selected\""; ?>></option>
				<option value="ssl"<?php if( $tngconfig['mailenc'] == "ssl" ) echo " selected=\"selected\""; ?>>ssl</option>
				<option value="tls"<?php if( $tngconfig['mailenc'] == "tls" ) echo " selected=\"selected\""; ?>>tls</option>
				<option value="starttls"<?php if( $tngconfig['mailenc'] == "starttls" ) echo " selected=\"selected\""; ?>>starttls</option>
			</select>
		</td></tr>
	</table>
	</div>
</td>
</tr>


<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus11",0,"pref",$admtext['prefsection'],""); ?>

	<div id="pref" style="display:none"><br/>
	<table class="label">
		<tr><td><?php echo $admtext['personprefix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['personprefix']; ?>" name="pprefix" size="5"></td></tr>
		<tr><td><?php echo $admtext['personsuffix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['personsuffix']; ?>" name="psuffix" size="5"></td></tr>
		<tr><td><?php echo $admtext['familyprefix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['familyprefix']; ?>" name="fprefix" size="5"></td></tr>
		<tr><td><?php echo $admtext['familysuffix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['familysuffix']; ?>" name="fsuffix" size="5"></td></tr>
		<tr><td><?php echo $admtext['sourceprefix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['sourceprefix']; ?>" name="sprefix" size="5"></td></tr>
		<tr><td><?php echo $admtext['sourcesuffix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['sourcesuffix']; ?>" name="ssuffix" size="5"></td></tr>
		<tr><td><?php echo $admtext['repoprefix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['repoprefix']; ?>" name="rprefix" size="5"></td></tr>
		<tr><td><?php echo $admtext['reposuffix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['reposuffix']; ?>" name="rsuffix" size="5"></td></tr>
		<tr><td><?php echo $admtext['noteprefix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['noteprefix']; ?>" name="nprefix" size="5"></td></tr>
		<tr><td><?php echo $admtext['notesuffix']; ?>:</td><td><input type="text" value="<?php echo $tngconfig['notesuffix']; ?>" name="nsuffix" size="5"></td></tr>
	</table>
	</div>
</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus12",0,"mobile",$admtext['mobilesection'],""); ?>

	<div id="mobile" style="display:none"><br/>
	<table class="label">
		<tr>
			<td><?php echo $admtext['responsivetables']; ?>:</td>
			<td>
				<select class="bigselect" name="responsivetables">
				<option value="1"<?php if( !empty($responsivetables) ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( empty($responsivetables) ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['tabletype']; ?>:</td>
			<td>
				<select class="bigselect" name="tabletype">
					<option value="toggle"<?php if( $tabletype == "toggle" ) echo " selected"; ?>><?php echo (isset($admtext['tt_toggle']) ? $admtext['tt_toggle'] : "toggle"); ?></option>
					<option value="stack"<?php if( $tabletype == "stack" ) echo " selected"; ?>><?php echo (isset($admtext['tt_stack']) ? $admtext['tt_stack'] : "stack"); ?></option>
					<option value="swipe"<?php if( $tabletype == "swipe" ) echo " selected"; ?>><?php echo (isset($admtext['tt_swipe']) ? $admtext['tt_swipe'] : "swipe"); ?></option>
					<option value="tng"<?php if( $tabletype == "tng" ) echo " selected"; ?>>tng</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['enablemodeswitch']; ?>:</td>
			<td>
				<select class="bigselect" name="enablemodeswitch">
					<option value="1"<?php if( $enablemodeswitch ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$enablemodeswitch ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['enableminimap']; ?>:</td>
			<td>
				<select class="bigselect" name="enableminimap">
					<option value="1"<?php if( $enableminimap ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$enableminimap ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>
</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus13",0,"dna",$text['dna_tests'],""); ?>
	<div id="dna" style="display:none"><br/>
	<table class="label">
		<tr>
			<td><?php echo $admtext['hidedna']; ?>:</td>
			<td>
				<select class="bigselect" name="hidedna">
					<option value="0"<?php if( !$tngconfig['hidedna'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['hidedna'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
<?php if(empty($maxdnasearchresults)) $maxdnasearchresults = $maxsearchresults; ?>
		<tr><td><?php echo $admtext['maxsearchresults']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $maxdnasearchresults; ?>" name="maxdnasearchresults" size="3"></td></tr>
		<tr><td><?php echo $admtext['show_test_number']; ?>:</td>
			<td>
				<select class="bigselect" name="showtestnumbers">
					<option value="1"<?php if( $showtestnumbers ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$showtestnumbers ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
	    <tr>
            <td><?php echo $admtext['autofillancsunames']; ?>:</td>
			<td>
				<select class="bigselect" name="autofillancsurnames">
					<option value="1"<?php if( $autofillancsurnames ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$autofillancsurnames ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
	    <tr>
            <td><?php echo $admtext['upperancsunames']; ?>:</td>
			<td>
				<select class="bigselect" name="ancsurnameupper">
					<option value="1"<?php if( $ancsurnameupper ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$ancsurnameupper ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
	    <tr>
            <td><?php echo $admtext['generation_num']; ?>:</td>
			<td>
			  <select class="bigselect" name="numgens">
			  <option value="3">3</option>
<?php
			if( !isset($numgens) ) $numgens = 3;
    	    for( $i = "4"; $i <= "15"; $i++ ) {
		      echo "<option value=\"$i\"";
		     if( $i == $numgens ) echo " selected";
		      echo ">$i</option>\n";
	        }
?>
			  </select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['excludefromancsn']; ?>*:</td>
			<td><input type="text" value="<?php echo stripslashes($surnameexcl); ?>" name="surnameexcl" class="longfield"/></td>
		</tr>
		<tr> <td colspan="2">*<?php echo $admtext['commas']; ?></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2"><strong><?php echo $admtext['dnatestscomparecolors']; ?></strong></tr>
<?php
		$mainclass = $bgmain ? 'center' : 'fieldnameback center';
		$txtmain = $txtmain ? $txtmain : '#FFFFFF';
		$bgmode = $bgmode ? $bgmode : '#D1EEEE';
		$txtmode = $txtmode ? $txtmode : '#000000';
		$bgfastmut = $bgfastmut ? $bgfastmut : '#69001A';
		$txtfastmut = $txtfastmut ? $txtfastmut : '#FFFFFF';
		$bg1_12 = $bg1_12 ? $bg1_12 : '#414E68';
		$txt1_12 = $txt1_12 ? $txt1_12 : '#FFFFFF';
		$bg13_25 = $bg13_25 ? $bg13_25 : '#41678A';
		$txt13_25 = $txt13_25 ? $txt13_25 : '#FFFFFF';
		$bg26_37 = $bg26_37 ? $bg26_37 : '#2E8899';
		$txt26_37 = $txt26_37 ? $txt26_37 : '#FFFFFF';
		$bg38_67 = $bg38_67 ? $bg38_67 : '#44A1B8';
		$txt38_67 = $txt38_67 ? $txt38_67 : '#FFFFFF';
		$bg111 = $bg111 ? $bg111 : '#05B8CC';
		$txt111 = $txt111 ? $txt111 : '#FFFFFF';
?>
		<tr>
			<td><?php echo $admtext['mainbackground']; ?>:</td>
			<td><input type="text" value="<?php echo stripslashes($bgmain); ?>" name="bgmain" size="10">&nbsp;
			<?php echo $admtext['textcolor']; ?>:
			<input type="text" value="<?php echo stripslashes($txtmain); ?>" name="txtmain" size="10">&nbsp;&nbsp;
			<input type="text" class="<?php echo $mainclass;?>" style="background-color:<?php echo $bgmain;?>; color:<?php echo $txtmain;?>;" value="<?php echo $admtext['textcolor']; ?>" id="exmain" disabled></td>
		</tr>
		<tr>
			<td><?php echo $admtext['modebackground']; ?>:</td>
			<td><input type="text" value="<?php echo stripslashes($bgmode); ?>" name="bgmode" size="10">&nbsp;
			<?php echo $admtext['textcolor']; ?>:
			<input type="text" value="<?php echo stripslashes($txtmode); ?>" name="txtmode" size="10">&nbsp;&nbsp;
			<input type="text" class="center" style="background-color:<?php echo $bgmode;?>; color:<?php echo $txtmode;?>;" value="<?php echo $admtext['textcolor']; ?>" name="exmode" disabled></td>
		</tr>
		<tr>
			<td><?php echo $admtext['fastmutbackground']; ?>:</td>
			<td><input type="text" value="<?php echo stripslashes($bgfastmut); ?>" name="bgfastmut" size="10">&nbsp;
			<?php echo $admtext['textcolor']; ?>:
			<input type="text" value="<?php echo stripslashes($txtfastmut); ?>" name="txtfastmut" size="10">&nbsp;&nbsp;
			<input type="text" class="center" style="background-color:<?php echo $bgfastmut;?>; color:<?php echo $txtfastmut;?>;" value="<?php echo $admtext['textcolor']; ?>" name="exfastmut" disabled></td>
		</tr>
		<tr>
			<td><?php echo $admtext['background1_12']; ?>:</td>
			<td><input type="text" value="<?php echo stripslashes($bg1_12); ?>" name="bg1_12" size="10">&nbsp;
			<?php echo $admtext['textcolor']; ?>:
			<input type="text" value="<?php echo stripslashes($txt1_12); ?>" name="txt1_12" size="10">&nbsp;&nbsp;
			<input type="text" class="center" style="background-color:<?php echo $bg1_12;?>; color:<?php echo $txt1_12;?>;" value="<?php echo $admtext['textcolor']; ?>" name="ex1_12" disabled></td>
		</tr>
		<tr>
			<td><?php echo $admtext['background13_25']; ?>:</td>
			<td><input type="text" value="<?php echo stripslashes($bg13_25); ?>" name="bg13_25" size="10">&nbsp;
			<?php echo $admtext['textcolor']; ?>:
			<input type="text" value="<?php echo stripslashes($txt13_25); ?>" name="txt13_25" size="10">&nbsp;&nbsp;
			<input type="text" class="center" style="background-color:<?php echo $bg13_25;?>; color:<?php echo $txt13_25;?>;" value="<?php echo $admtext['textcolor']; ?>" name="ex13_25" disabled></td>
		</tr>
		<tr>
			<td><?php echo $admtext['background26_37']; ?>:</td>
			<td><input type="text" value="<?php echo stripslashes($bg26_37); ?>" name="bg26_37" size="10">&nbsp;
			<?php echo $admtext['textcolor']; ?>:
			<input type="text" value="<?php echo stripslashes($txt26_37); ?>" name="txt26_37" size="10">&nbsp;&nbsp;
			<input type="text" class="center" style="background-color:<?php echo $bg26_37;?>; color:<?php echo $txt26_37;?>;" value="<?php echo $admtext['textcolor']; ?>" name="ex26_37" disabled></td>
		</tr>
		<tr>
			<td><?php echo $admtext['background38_67']; ?>:</td>
			<td><input type="text" value="<?php echo stripslashes($bg38_67); ?>" name="bg38_67" size="10">&nbsp;
			<?php echo $admtext['textcolor']; ?>:
			<input type="text" value="<?php echo stripslashes($txt38_67); ?>" name="txt38_67" size="10">&nbsp;&nbsp;
			<input type="text" class="center" style="background-color:<?php echo $bg38_67;?>; color:<?php echo $txt38_67;?>;" value="<?php echo $admtext['textcolor']; ?>" name="ex38_67" disabled></td>
		</tr>
		<tr>
			<td><?php echo $admtext['background111']; ?>:</td>
			<td><input type="text" value="<?php echo stripslashes($bg111); ?>" name="bg111" size="10">&nbsp;
			<?php echo $admtext['textcolor']; ?>:
			<input type="text" value="<?php echo stripslashes($txt111); ?>" name="txt111" size="10">&nbsp;&nbsp;
			<input type="text" class="center" style="background-color:<?php echo $bg111;?>; color:<?php echo $txt111;?>;" value="<?php echo $admtext['textcolor']; ?>" name="ex111" disabled></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2"><?php echo $admtext['getcolorcodes']; ?>: <a href="https://www.w3schools.com/colors/colors_picker.asp" class="snlink" target="_blank"><?php echo $admtext['colorschemer']; ?></a></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	</table>
	</div>
</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus14",0,"misc",$admtext['miscsection'],""); ?>

	<div id="misc" style="display:none"><br/>
	<table class="label">
		<tr><td><?php echo $admtext['maxsearchresults']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $maxsearchresults; ?>" name="maxsearchresults" size="5"></td></tr>
		<tr><td><?php echo $admtext['searchorder']; ?>:</td>
			<td>
				<select class="bigselect" name="searchorder">
					<option value="0"<?php if( !$tngconfig['searchorder'] ) echo " selected"; ?>><?php echo $admtext['lastfirst']; ?></option>
					<option value="1"<?php if( $tngconfig['searchorder'] ) echo " selected"; ?>><?php echo $admtext['firstlast']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['indstart']; ?>:</td>
			<td colspan="4">
				<select class="bigselect" name="tng_istart">
					<option value="0"<?php if( !$tngconfig['istart'] ) echo " selected"; ?>><?php echo $admtext['allinfo']; ?></option>
					<option value="1"<?php if( $tngconfig['istart'] ) echo " selected"; ?>><?php echo $admtext['persinfo']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['shownotes']; ?>:</td>
			<td colspan="4">
				<select class="bigselect" name="notestogether">
					<option value="0"<?php if( !$notestogether ) echo " selected"; ?>><?php echo $admtext['notesapart']; ?></option>
					<option value="1"<?php if( $notestogether == 1 ) echo " selected"; ?>><?php echo $admtext['notestogether']; ?></option>
					<option value="2"<?php if( $notestogether == 2 ) echo " selected"; ?>><?php echo $admtext['notestogether2']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['scrollcite']; ?>:</td>
			<td>
				<select class="bigselect" name="scrollcite">
					<option value="1"<?php if( $tngconfig['scrollcite'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$tngconfig['scrollcite'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp; <?php echo $admtext['notes']; ?>:</td>
			<td>
				<select class="bigselect" name="scrollnotes">
					<option value="1"<?php if( $tngconfig['scrollnotes'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$tngconfig['scrollnotes'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>

		<tr><td><?php echo $admtext['time_offset']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $time_offset; ?>" name="time_offset" size="5">  <?php echo $admtext['servertime'] . " <strong>" . date("D h:i a") . "</strong> "; $new_U=date("U")+$time_offset*3600; echo $admtext['sitetime'] . " <strong>" . date("D h:i a", $new_U) . "</strong>"; ?></td></tr>
		<tr><td><?php echo $admtext['edit_timeout']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $tngconfig['edit_timeout']; ?>" name="edit_timeout" size="5"></td></tr>
		<tr><td><?php echo $admtext['maxgedcom']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $maxgedcom; ?>" name="maxgedcom" size="5"></td></tr>
		<tr><td><?php echo $admtext['change_cutoff']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $change_cutoff; ?>" name="change_cutoff" size="5"> <?php echo $admtext['nocutoff']; ?></td></tr>
		<tr><td><?php echo $admtext['change_limit']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $change_limit; ?>" name="change_limit" size="5"></td></tr>
		<tr>
			<td><?php echo $admtext['datefmt']; ?>:</td>
			<td colspan="4">
				<select class="bigselect" name="prefereuro">
					<option value="false"<?php if( $tngconfig['preferEuro'] == "false" ) echo " selected"; ?>><?php echo $admtext['monthfirst']; ?></option>
					<option value="true"<?php if( $tngconfig['preferEuro'] == "true" ) echo " selected"; ?>><?php echo $admtext['dayfirst']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['calstart']; ?>:</td>
			<td colspan="4">
				<select class="bigselect" name="calstart">
					<option value="0"<?php if( !isset($tngconfig['calstart']) || $tngconfig['calstart'] == "0" ) echo " selected"; ?>><?php echo $text['sunday']; ?></option>
					<option value="1"<?php if( $tngconfig['calstart'] == "1" ) echo " selected"; ?>><?php echo $text['monday']; ?></option>
					<option value="2"<?php if( $tngconfig['calstart'] == "2" ) echo " selected"; ?>><?php echo $text['tuesday']; ?></option>
					<option value="3"<?php if( $tngconfig['calstart'] == "3" ) echo " selected"; ?>><?php echo $text['wednesday']; ?></option>
					<option value="4"<?php if( $tngconfig['calstart'] == "4" ) echo " selected"; ?>><?php echo $text['thursday']; ?></option>
					<option value="5"<?php if( $tngconfig['calstart'] == "5" ) echo " selected"; ?>><?php echo $text['friday']; ?></option>
					<option value="6"<?php if( $tngconfig['calstart'] == "6" ) echo " selected"; ?>><?php echo $text['saturday']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['pardata']; ?>:</td>
			<td>
				<select class="bigselect" name="pardata">
					<option value="0"<?php if( !$tngconfig['pardata'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['palldata']; ?></option>
					<option value="1"<?php if( $tngconfig['pardata'] == 1 ) echo " selected=\"selected\""; ?>><?php echo $admtext['pstdonly']; ?></option>
					<option value="2"<?php if( $tngconfig['pardata'] == 2 ) echo " selected=\"selected\""; ?>><?php echo $admtext['pnoevents']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><?php echo $admtext['lineending']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $lineendingdisplay; ?>" name="lineending" size="5"></td></tr>
		<tr>
			<td><?php echo $admtext['encrtype']; ?>:</td>
			<td>
				<select class="bigselect" name="password_type">
<?php
	$encrtypes = PasswordTypeList();
	foreach($encrtypes as $encrtype) {
		$display = $encrtype != "none" ? $encrtype : $admtext['none'];
		echo "<option value=\"$encrtype\"";
        if($encrtype == $tngconfig['password_type']) echo " selected=\"selected\"";
        echo ">$display</option>\n";
	}
?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['places1tree']; ?>:</td>
			<td>
				<select class="bigselect" name="places1tree" id="places1tree" onchange="flipPlaces(this);">
					<option value="0"<?php if( !$tngconfig['places1tree'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['places1tree'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
				<input type="button" value="<?php echo $admtext['merge']; ?>" id="merge" onclick="convertPlaces('merge');" style="display:none"/>
				<span id="mergeexpl" style="display:none"><?php echo $admtext['mergeexpl']; ?></span>
				<select class="bigselect" name="placetree" id="placetree" style="display:none">
<?php
	foreach($treeList as $treerow) {
		echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
	}
?>
				</select>
				<input type="button" value="<?php echo $admtext['convert']; ?>" id="convert" onclick="convertPlaces('convert');" style="display:none"/>
				<span id="convertexpl" style="display:none"><?php echo $admtext['convexpl']; ?></span>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['autogeo']; ?>:</td>
			<td>
				<select class="bigselect" name="autogeo">
					<option value="0"<?php if( !$tngconfig['autogeo'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['autogeo'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['reuseids']; ?>:</td>
			<td>
				<select class="bigselect" name="oldids">
					<option value=""<?php if( !$tngconfig['oldids'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['oldids'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['lastimport']; ?>:</td>
			<td>
				<select class="bigselect" name="lastimport">
					<option value=""<?php if( !$tngconfig['lastimport'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['lastimport'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['showtasks']; ?>:</td>
			<td>
				<select class="bigselect" name="hidetasks">
					<option value=""<?php if( !$tngconfig['hidetasks'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['hidetasks'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['showtotals']; ?>:</td>
			<td>
				<select class="bigselect" name="hidetotals">
					<option value=""<?php if( !$tngconfig['hidetotals'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['hidetotals'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><?php echo $admtext['backupdays']; ?>:</td><td colspan="4"><input type="text" value="<?php echo $tngconfig['backupdays']; ?>" name="backupdays" size="5"> <?php echo $admtext['nocutoff']; ?></td></tr>
		<tr>
			<td><?php echo $admtext['nointernet']; ?>:</td>
			<td>
				<select class="bigselect" name="tng_offline">
					<option value=""<?php if( !$tngconfig['offline'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['offline'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
<!--
		<tr>
			<td><?php /*echo $admtext['showmatches'];*/ ?>:</td>
			<td>
				<select class="bigselect" name="webmatches">
					<option value=""<?php /*if( !$tngconfig['webmatches'] ) echo " selected=\"selected\"";*/ ?>><?php /*echo $admtext['yes'];*/ ?></option>
					<option value="1"<?php /*if( $tngconfig['webmatches'] ) echo " selected=\"selected\"";*/ ?>><?php /*echo $admtext['no'];*/ ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php /*echo $admtext['mhmatchtype'];*/ ?>:</td>
			<td>
				<select class="bigselect" name="mhmatchtype">
					<option value="all"<?php /*if( $tngconfig['mhmatchtype'] == "all" ) echo " selected=\"selected\"";*/ ?>><?php /*echo $admtext['all'];*/ ?></option>
					<option value="smart_matches"<?php /*if( $tngconfig['mhmatchtype'] == "smart_matches" ) echo " selected=\"selected\"";*/ ?>>Smart Matches</option>
					<option value="record_matches"<?php /*if( $tngconfig['mhmatchtype'] == "record_matches" ) echo " selected=\"selected\"";*/ ?>>Record Matches</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php /*echo $admtext['mhconfidence'];*/ ?>:</td>
			<td>
				<select class="bigselect" name="mhmatchconf">
				<?php
					/*
					for($c = 20; $c <= 100; $c += 10) {
						echo "<option value=\"$c\"";
						if( $tngconfig['mhmatchconf'] == $c )
							echo " selected=\"selected\"";
						echo ">$c" . "%</option>\n";
					}
					*/
				?>
				</select>
			</td>
		</tr>
-->
	</table>
	</div>
</td>
</tr>

<tr>
<td class="tngshadow databack">
	<input type="submit" name="submit" class="btn" value="<?php echo $admtext['saveback']; ?>">
	<input type="submit" name="submit" class="btn saveret" value="<?php echo $admtext['saveback']; ?>">
	<input type="submit" name="submitx" accesskey="s" class="btn" value="<?php echo $admtext['savereturn']; ?>">
	<input type="submit" name="submitx" accesskey="s" class="btn savestay" value="<?php echo $admtext['savereturn']; ?>">
	<input type="button" name="cancel" class="btn" value="<?php echo $text['cancel']; ?>" onClick="window.location.href='admin_setup.php';">

	<input type="hidden" name="cmssupport" value="<?php echo $cms['support']; ?>">
	<input type="hidden" name="cmsurl" value="<?php echo $cms['url']; ?>">
	<input type="hidden" name="cmstngpath" value="<?php echo $cms['tngpath']; ?>">
	<input type="hidden" name="cmsmodule" value="<?php echo $cms['module']; ?>">
	<input type="hidden" name="cmscloaklogin" value="<?php echo $cms['cloaklogin']; ?>">
	<input type="hidden" name="cmscredits" value="<?php echo $cms['credits']; ?>">

	<input type="hidden" value="1" name="safety">
</td>
</tr>

</table>
</form>
</div>
<?php 
echo tng_adminfooter();
?>