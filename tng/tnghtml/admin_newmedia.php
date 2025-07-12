<?php
include("begin.php");
include("adminlib.php");
$textpart = "photos";
//include("getlang.php");
include("$mylanguage/admintext.php");

$admin_login = 1;
include("checklogin.php");
include("version.php");
include_once("tngdblib.php");

if( !$allow_media_add ) {
	$message = $admtext['norights'];
	header( "Location: admin_login.php?message=" . urlencode($message) );
	exit;
}

if( empty($tree) ) {
	if( $assignedtree ) {
		$wherestr = "WHERE gedcom = \"$assignedtree\"";
		$tree = $assignedtree;
	}
	else {
		$wherestr = "";
		$tree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
	}
}

if( !isset($wherestr) ) $wherestr = "";
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$treeresult = tng_query($treequery) or die ($admtext['cannotexecutequery'] . ": $treequery");
$treenum = 0;
while( $treerow = tng_fetch_assoc($treeresult) ) {
	$treenum++;
	$trees[$treenum] = $treerow['gedcom'];
	$treename[$treenum] = $treerow['treename'];
}
tng_free_result($treeresult);

$helplang = findhelp("media_help.php");

tng_adminheader( $admtext['addnewmedia'], $flags );

$lastcoll = isset($_COOKIE['lastcoll']) ? $_COOKIE['lastcoll'] : "";
$standardtypes = array();
$moptions = "";
$likearray = "var like = new Array();\n";
foreach( $mediatypes as $mediatype ) {
	if(!$mediatype['type'])
		$standardtypes[] = "\"" . $mediatype['ID'] . "\"";
	$msgID = $mediatype['ID'];
	$moptions .= "	<option value=\"$msgID\"";
	if($lastcoll == $msgID) $moptions .= " selected";
	$moptions .= ">" . $mediatype['display'] . "</option>\n";
	$likearray .= "like['$msgID'] = '{$mediatype['liketype']}';\n";
}
$sttypestr = implode(",",$standardtypes);
?>
</head>

<?php
	echo tng_adminlayout();

	$mediatabs[0] = array(1,"admin_media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_media_add,"admin_newmedia.php",$admtext['addnew'],"addmedia");
	$mediatabs[2] = array($allow_media_edit,"admin_ordermediaform.php",$admtext['text_sort'],"sortmedia");
	$mediatabs[3] = array($allow_media_edit,"admin_thumbnails.php",$admtext['thumbnails'],"thumbs");
	$mediatabs[4] = array($allow_media_add && !$assignedtree,"admin_photoimport.php",$admtext['import'],"import");
	$mediatabs[5] = array($allow_media_add,"admin_mediaupload.php",$admtext['upload'],"upload");
	$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/media_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a> ";
	$innermenu .= "&nbsp;|&nbsp;<a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">{$text['expandall']}</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">{$text['collapseall']}</a>";
	$menu = doMenu($mediatabs,"addmedia",$innermenu);
	echo displayHeadline($admtext['media'] . " &gt;&gt; " . $admtext['addnewmedia'], "img/photos_icon.gif",$menu,"");

	if(isset($familyID)) {
		$personID = $familyID;
		$nameresult = getFamilyData($tree, $familyID);
		$namerow = tng_fetch_assoc($nameresult);
		$namestr = getFamilyName($namerow) . " ($familyID)";
		tng_free_result($nameresult);
	}
	elseif(isset($personID)) {
		if($linktype == "I") {
			$nameresult = getPersonSimple($tree, $personID);
			$namerow = tng_fetch_assoc($nameresult);
			$righttree = checktree($tree);
			$rightbranch = $righttree ? checkbranch($namerow['branch']) : false;
			$rights = determineLivingPrivateRights($namerow, $righttree, $rightbranch);
			$namerow['allow_living'] = $rights['living'];
			$namerow['allow_private'] = $rights['private'];
			$namestr = getName( $namerow );
			tng_free_result($nameresult);
		}
		elseif($linktype == "S") {
			$query = "SELECT title, shorttitle FROM $sources_table WHERE sourceID = \"$personID\" AND gedcom = \"$tree\"";
			$nameresult = tng_query($query);
			$namerow = tng_fetch_assoc( $nameresult );
			$namestr = $namerow['title'] ? $namerow['title'] : $namerow['shorttitle'];
			tng_free_result($nameresult);
		}
		elseif($linktype == "R") {
			$query = "SELECT reponame FROM $repositories_table WHERE repoID = \"$personID\" AND $repositories_table.gedcom = \"$tree\"";
			$nameresult = tng_query($query);
			$namerow = tng_fetch_assoc( $nameresult );
			$namestr = $namerow['reponame'];
			tng_free_result($nameresult);
		}
	}
	elseif(isset($place))
		$personID = $namestr = $place;
	else
		$namestr = "";
?>

<div class="admin-main">
<form action="admin_addmedia.php" method="post" name="form1" id="form1"  ENCTYPE="multipart/form-data" onSubmit="return validateForm();">
<input type="hidden" name="link_persfamID" value="<?php if(!empty($personID)) { echo $personID; } ?>">
<input type="hidden" name="link_tree" value="<?php if(!empty($tree)) { echo $tree; } ?>">
<input type="hidden" name="link_linktype" value="<?php if( isset($linktype) ) echo $linktype; ?>">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="adm-rounded-table">
<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus0",1,"mediafile",$admtext['imagefile'],$admtext['uplsel']); ?>

	<div id="mediafile">
	<br/>
	<table class="label">
	<tr>
		<td><?php echo $admtext['mediatype']; ?>:</td>
		<td>
			<select name="mediatypeID" onChange="switchOnType(this.options[this.selectedIndex].value)">
<?php
			echo $moptions;
?>
			</select>
<?php
	if(!$assignedtree && $allow_add && $allow_edit && $allow_delete) {
?>
			<input type="button" name="addnewmediatype" value="<?php echo $admtext['addnewcoll']; ?>" class="aligntop" onclick="tnglitbox = new LITBox('admin_newcollection.php?field=mediatypeID',{width:600,height:600});">
			<input type="button" name="editmediatype" id="editmediatype" value="<?php echo $admtext['edit']; ?>" style="vertical-align:top;display:none" onclick="editMediatype(document.form1.mediatypeID);">
			<input type="button" name="delmediatype" id="delmediatype" value="<?php echo $admtext['text_delete']; ?>" style="vertical-align:top;display:none" onclick="confirmDeleteMediatype(document.form1.mediatypeID);">
<?php
	}
?>
		</td>
	</tr>
	<tr><td valign="top" colspan="2"><input type="checkbox" name="abspath" value="1" onClick="toggleMediaURL();"> <?php echo $admtext['abspath']; ?></td></tr>
	<tr><td colspan="2"><strong><br/><?php echo $admtext['imagefile']; ?></strong></td></tr>
	<tr id="imgrow"><td><?php echo $admtext['imagefiletoupload']; ?>*:</td><td><input type="file" name="newfile" size="60" onchange="populatePath(document.form1.newfile,document.form1.path);prepopulateThumb();"></td></tr>
	<tr id="pathrow">
		<td><?php echo $admtext['pathwithinphotos']; ?>**:</td>
		<td><input type="text" name="path" id="path" size="60" onchange="prepopulateThumb();"><input type="hidden" id="path_org"><input type="hidden" id="path_last"> <input type="button" class="btn" value="<?php echo $admtext['select'] . "..."; ?>" name="photoselect" onclick="javascript:var folder = document.form1.usecollfolder[0].checked ? document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value : 'media';FilePicker('path',folder);"></td>
	</tr>
	<tr id="abspathrow" style="display:none"><td valign="top"><?php echo $admtext['mediaurl']; ?>:</td><td><input type="text" name="mediaurl" size="60"></td></tr>

<!-- history section -->
	<tr id="bodytextrow"><td valign="top"><?php echo $admtext['bodytext']; ?>:</td><td valign="top"><textarea wrap cols="90" rows="12" name="bodytext" id="bodytext"></textarea></td></tr>

<?php
	if( function_exists( "imageJpeg" ) ) {
?>
	<tr>
		<td valign="top"><strong><br/><?php echo $admtext['thumbnailfile']; ?></strong></td>
		<td valign="top"><br/>
			<input type="radio" name="thumbcreate" value="auto" checked onClick="document.form1.newthumb.style.visibility='hidden'; document.form1.thumbselect.style.visibility='hidden'; prepopulateThumb(); document.form1.abspath.checked=false;"> <?php echo $admtext['autoimg']; ?> &nbsp;
			<input type="radio" name="thumbcreate" value="specify" onClick="document.form1.newthumb.style.visibility='visible'; document.form1.thumbselect.style.visibility='visible';"> <?php echo $admtext['specifyimg']; ?>
		</td>
	</tr>
<?php
	}
	else {
?>
	<tr>
		<td colspan="2"><strong><br/><?php echo $admtext['thumbnailfile']; ?></strong><br />
		<span class="red"><?php echo $admtext['imglib']; ?></span></td>
	</tr>
<?php
	}
?>
	<tr><td><?php echo $admtext['imagefiletoupload']; ?>*:</td><td><input type="file" name="newthumb" size="60" style="visibility:hidden" onChange="populatePath(document.form1.newthumb,document.form1.thumbpath);"></td></tr>
	<tr>
		<td><?php echo $admtext['pathwithinphotos']; ?>**:</td>
		<td><input type="text" name="thumbpath" id="thumbpath" size="60"><input type="hidden" id="thumbpath_org"><input type="hidden" id="thumbpath_last"> <input type="button" class="btn" value="<?php echo $admtext['select'] . "..."; ?>" name="thumbselect" OnClick="javascript:var folder = document.form1.usecollfolder[0].checked ? document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value : 'media';FilePicker('thumbpath',folder);"></td>
	</tr>
	<tr>
		<td valign="top"><strong><br/><?php echo $admtext['put_in']; ?></strong></td>
		<td valign="top"><br/>
			<input type="radio" name="usecollfolder" value="1" checked> <?php echo $admtext['usecollect']; ?> &nbsp;
			<input type="radio" name="usecollfolder" value="0"> <?php echo $admtext['usemedia']; ?>
		</td>
	</tr>
	<tr id="vidrow1">
		<td colspan="2">
			<br/>
			<?php echo $admtext['width']; ?>: <input type="text" name="width" value="0" size="5"> &nbsp;
			<?php echo $admtext['height']; ?>: <input type="text" name="height" value="0" size="5"> &nbsp;
			<p><?php echo "({$admtext['controller']})"; ?></p>
		</td>
	</tr>
	</table>
	<p class="smaller">
<?php
	echo "*{$admtext['leaveblankphoto']}<br/>\n";
	echo "**{$admtext['requiredphoto']}\n";
?>
	</p>
	</div>
</td>
</tr>

<tr>
<td class="tngshadow databack">
	<?php echo displayToggle("plus1",1,"details",$admtext['newmediainfo'],$admtext['minfosubt']); ?>

	<div id="details">
	<br/>
	<table class="label">
	<tr><td valign="top"><?php echo $admtext['title2']; ?>:</td><td><textarea wrap cols="70" rows="3" name="description"><?php echo $namestr; ?></textarea></td></tr>
	<tr><td valign="top"><?php echo $admtext['description']; ?>:</td><td><textarea wrap cols="70" rows="5" name="notes"></textarea></td></tr>
	<tr><td><?php echo $admtext['photoowner']; ?>:</td><td><input type="text" name="owner" size="40"></td></tr>
	<tr><td><?php echo $admtext['datetaken']; ?>:</td><td><input type="text" name="datetaken" size="40" onblur="checkDate(this);"></td></tr>
	<tr>
		<td><?php echo $admtext['tree']; ?>: </td>
		<td>

<?php
	echo "<select name=\"tree\" class=\"bigselect\">";
	echo "	<option value=\"\">{$admtext['alltrees']}</option>\n";
	$treeresult = tng_query($treequery) or die ($admtext['cannotexecutequery'] . ": $treequery");
	while( $treerow = tng_fetch_assoc($treeresult) ) {
		echo "	<option value=\"{$treerow['gedcom']}\"";
		if( $treerow['gedcom'] == $tree ) echo " selected";
		echo ">{$treerow['treename']}</option>\n";
	}
	tng_free_result($treeresult);
?>
			</select>
		</td>
	</tr>

<!-- headstone section -->
<tr id="cemrow">
		<td><?php echo $admtext['cemetery']; ?>: </td>
		<td>
			<input type="hidden" id="cemeteryID" name="cemeteryID" value="" />
			<span id="cemname"></span>
			<input type="button" class="btn" value="<?php echo $admtext['select']; ?>" onclick="return openFindCemeteryForm('cemname');" />
			</div>
		</td>
	</tr>
	<tr id="hsplotrow"><td valign="top"><?php echo $admtext['plot']; ?>:</td><td><textarea wrap cols="70" rows="2" name="plot"></textarea></td></tr>
	<tr id="hsstatrow">
		<td><?php echo $admtext['status']; ?>:</td>
		<td>
			<select name="status" class="bigselect">
				<option value="">&nbsp;</option>
				<option value="notyetlocated"><?php echo $admtext['notyetlocated']; ?></option>
				<option value="located"><?php echo $admtext['located']; ?></option>
				<option value="unmarked"><?php echo $admtext['unmarked']; ?></option>
				<option value="missing"><?php echo $admtext['missing']; ?></option>
				<option value="moved"><?php echo $admtext['moved']; ?></option>
				<option value="cremated"><?php echo $admtext['cremated']; ?></option>
				<option value="atsea"><?php echo $admtext['atsea']; ?></option>
			</select>
		</td>
	</tr>

	<tr><td valign="top" colspan="2"><input type="checkbox" name="alwayson" value="1" id="img_alwayson" onchange="if($(this).is(':checked')){$('#img_private').prop('checked',false);}"> <?php echo $admtext['alwayson']; ?></td></tr>
	<tr><td valign="top" colspan="2"><input type="checkbox" name="newwindow" value="1"> <?php echo $admtext['newwin']; ?></td></tr>
	<tr><td valign="top" colspan="2"><input type="checkbox" name="private" value="1" id="img_private" onchange="if($(this).is(':checked')){$('#img_alwayson').prop('checked',false);}"> <?php echo $admtext['private']; ?></td></tr>

<!-- headstone section -->
	<tr id="linktocemrow"><td colspan="2" valign="top"><input type="checkbox" name="linktocem" value="1"> <?php echo $admtext['linktocem']; ?></td></tr>
	<tr id="maprow"><td colspan="2" valign="top"><input type="checkbox" name="showmap" value="1"> <?php echo $admtext['showmap']; ?></td></tr>

	</table>
	</div>
</td>
</tr>

<tr>
<td class="tngshadow databack">
	<p><strong><?php echo $admtext['medlater']; ?></strong></p>
	<input type="hidden" name="usenl" value="0" />
	<input type="hidden" value="<?php if( isset($cw) ) echo $cw; /*stands for "close window" */ ?>" name="cw">
	<input type="hidden" name="numlinks" value="1"><input type="submit" name="submitbtn" class="btn" accesskey="s" value="<?php echo $admtext['savecont']; ?>">
	<input type="button" name="cancel" class="btn" value="<?php echo $text['cancel']; ?>" onClick="window.location.href='admin_media.php';">
</td>
</tr>

</table>
</form>
</div>

<script type="text/javascript">
var tree = "<?php echo $tree; ?>";
var tnglitbox;
var trees = new Array();
var treename = new Array();
var selectmsg = "<?php echo $admtext['selecttree']; ?>";
<?php
	for($i = 1; $i <= $treenum; $i++ ) {
		echo "trees[$i] = \"$trees[$i]\";\n";
		echo "treename[$i] = \"$treename[$i]\";\n";
	}
	echo "var thumbprefix = \"$thumbprefix\";\n";
	echo "var thumbsuffix = \"$thumbsuffix\";\n";
	echo "var treemsg = \"{$admtext['tree']}\";\n";
	echo "var personmsg = \"{$admtext['person']}\";\n";
	echo "var idmsg = \"{$admtext['id']}\";";
	echo "var familymsg = \"{$admtext['family']}\";\n";
	echo "var sourcemsg = \"{$admtext['source']}\";\n";
	echo "var repositorymsg = \"{$admtext['repository']}\";\n";
	echo "var placemsg = \"{$admtext['place']}\";\n";
	echo "var findmsg = \"{$admtext['find']}\";\n";
	echo "var altdescmsg = \"{$admtext['alttitle']}\";\n";
	echo "var altnotesmsg = \"{$admtext['altdesc']}\";\n";
	echo "var makedefaultmsg = \"{$admtext['makedefault']}\";\n";
	echo "var eventlinkmsg = \"{$admtext['eventlink']}\";\n";
	echo "var eventmsg = \"{$admtext['event']}\";\n";
	echo "var manage = 0;\n";
	echo $likearray;
?>
var linkcount = 1;
var entercollid = "<?php echo $admtext['entercollid']; ?>";
var entercolldisplay = "<?php echo $admtext['entercolldisplay']; ?>";
var entercollipath = "<?php echo $admtext['entercollpath']; ?>";
var entercollicon = "<?php echo $admtext['entercollicon']; ?>";
var confmtdelete = "<?php echo $admtext['confmtdelete']; ?>";
var confdeletefile = "<?php echo $admtext['confdeletefile']; ?>";
var stmediatypes = new Array(<?php echo $sttypestr; ?>);
var allow_edit = <?php echo ($allow_edit ? "1" : "0"); ?>;
var allow_delete = <?php echo ($allow_delete ? "1" : "0"); ?>;

function validateForm( ) {
	var rval = true;

	var frm = document.form1;
	//var nictext = $$('div .nicEdit-main')[0];
	var selectedType = frm.mediatypeID.options[frm.mediatypeID.selectedIndex].value;
	if(!frm.notes.value.length && !frm.description.value) {
		alert("<?php echo $admtext['enterphotodesc']; ?>");
		rval = false;
	}
	else if( frm.thumbpath.value.length > 0 && frm.path.value == frm.thumbpath.value ) {
		alert("<?php echo $admtext['samepaths']; ?>");
		rval = false;
	}
	else {
		frm.path.value = frm.path.value.replace(/\\/g,"/");
		frm.thumbpath.value = frm.thumbpath.value.replace(/\\/g,"/");
	}
	if(rval && frm.newfile.value) {
		rval = false;
		var usecollfolder = frm.usecollfolder[0].checked ? 0 : 1;
		var mediatypeID = frm.mediatypeID.options[frm.mediatypeID.selectedIndex].value;
		var thumbpath = frm.newthumb.value ? frm.thumbpath.value : "";
		var params = {path: frm.path.value, thumbpath: thumbpath, usecollfolder: usecollfolder, mediatypeID: mediatypeID};
		jQuery.ajax({
			url: 'admin_checkfile.php',
			data: params,
			dataType: 'json',
			success: function(vars){
				frm.path.value = vars.path;
				if(vars.thumbpath)
					frm.thumbpath.value = vars.thumbpath;
				document.form1.submit();
			}
		});
	}
	return rval;
}

var gsControlName = "";

function toggleAll(display) {
	toggleSection('mediafile','plus0',display);
	toggleSection('details','plus1',display);
	return false;
}
</script>
<script type="text/javascript" src="js/net.js?v<?php echo $tng_version; ?>"></script>
<script type="text/javascript" src="js/mediautils.js?v<?php echo $tng_version; ?>"></script>
<script type="text/javascript" src="js/selectutils.js?v<?php echo $tng_version; ?>"></script>
<script type="text/javascript" src="js/admin.js?v<?php echo $tng_version; ?>"></script>
<script type="text/javascript" src="js/datevalidation.js?v<?php echo $tng_version; ?>"></script>
<script type="text/javascript">
	var preferEuro = <?php echo ($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
	var preferDateFormat = '<?php if( isset($preferDateFormat) ) echo $preferDateFormat; ?>';
	switchOnType(document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value);
<?php
    include("niceditmsgs.php");
?>
</script>
<script type="text/javascript" src="js/nicedit.js"></script>
<script type="text/javascript">
//<![CDATA[
bkLib.onDomLoaded(function() {
    new nicEditor({fullPanel : true, maxHeight: 300}).panelInstance('bodytext');
});
//]]>
</script>
<?php 
echo tng_adminfooter();
?>