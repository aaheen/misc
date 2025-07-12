<?php
include("begin.php");
include($subroot . "mapconfig.php");
include("adminlib.php");
$textpart = "cemeteries";
//include("getlang.php");
include("$mylanguage/admintext.php");

$admin_login = 1;
include("checklogin.php");
include("version.php");

if(!isset($searchstring)) $searchstring = "";
if(!isset($tngpage)) $tngpage = "";

$tng_search_cemeteries = $_SESSION['tng_search_cemeteries'] = 1;
if(!empty($newsearch)) {
	$exptime = 0;
	setcookie("tng_search_cemeteries_post[search]", $searchstring, $exptime);
	setcookie("tng_search_cemeteries_post[offset]", 0, $exptime);
	setcookie("tng_search_cemeteries_post[tngpage]", 1, $exptime);
}
else {
	if(!$searchstring && isset($_COOKIE['tng_search_cemeteries_post']['search']))
		$searchstring = stripslashes($_COOKIE['tng_search_cemeteries_post']['search']);
	if( !isset($offset) ) {
		$tngpage = isset($_COOKIE['tng_search_cemeteries_post']['tngpage']) ? $_COOKIE['tng_search_cemeteries_post']['tngpage'] : 1;
		$offset = isset($_COOKIE['tng_search_cemeteries_post']['offset']) ? $_COOKIE['tng_search_cemeteries_post']['offset'] : 0;
	}
	else {
		$exptime = 0;
		setcookie("tng_search_cemeteries_post[tngpage]", (isset($tngpage) ? $tngpage : 1), $exptime);
		setcookie("tng_search_cemeteries_post[offset]", (isset($offset) ? $offset : 0), $exptime);
	}
}
if(!isset($offset)) $offset = 0;
$searchstring_noquotes = preg_replace("/\"/", "&#34;",$searchstring);
$searchstring = addslashes($searchstring);

if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$tngpage = 1;
}

function addCriteria( $field, $value, $operator ) {
	$criteria = "";

	if( $operator == "=" ) {
		$criteria = " OR $field $operator \"$value\"";
	}
	else {
		$innercriteria = "";
		$terms = explode( ' ',  $value );
		foreach( $terms as $term ) {
			if( $innercriteria ) $innercriteria .= " AND ";
			$innercriteria .= "$field $operator \"%$term%\"";
		}
		if( $innercriteria ) $criteria = " OR ($innercriteria)";
	}

	return $criteria;
}

$showmap_url = getURL( "showmap", 1 );
$frontmod = "LIKE";
$allwhere = "WHERE 1=0";

$allwhere .= addCriteria( "$cemeteries_table.cemeteryID", $searchstring, $frontmod );
$allwhere .= addCriteria( "maplink", $searchstring, $frontmod );
$allwhere .= addCriteria( "cemname", $searchstring, $frontmod );
$allwhere .= addCriteria( "city", $searchstring, $frontmod );
$allwhere .= addCriteria( "state", $searchstring, $frontmod );
$allwhere .= addCriteria( "county", $searchstring, $frontmod );
$allwhere .= addCriteria( "country", $searchstring, $frontmod );

$query = "SELECT cemeteryID,cemname,city,county,state,country,latitude,longitude,zoom FROM $cemeteries_table $allwhere ORDER BY cemname, city, county, state, country LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(cemeteryID) as ccount FROM $cemeteries_table $allwhere";
	$result2 = tng_query($query);
	$row = tng_fetch_assoc( $result2 );
	$totrows = $row['ccount'];
	tng_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("cemeteries_help.php");

tng_adminheader( $admtext['cemeteries'], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confdeletecem']; ?>' ))
		deleteIt('cemetery',ID);
	return false;
}
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<?php
	echo tng_adminlayout();

	$cemtabs[0] = array(1,"admin_cemeteries.php",$admtext['search'],"findcem");
	$cemtabs[1] = array($allow_add,"admin_newcemetery.php",$admtext['addnew'],"addcemetery");
	$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/cemeteries_help.php#modify');\" class=\"lightlink\">{$admtext['help']}</a>";
	$menu = doMenu($cemtabs,"findcem",$innermenu);
	echo displayHeadline($admtext['cemeteries'],"img/cemeteries_icon.gif",$menu,$message);
?>

<div class="admin-main">
	<div class="databack admin-block">

	<form action="admin_cemeteries.php" name="form1">
	<div><p class="subhead" style="margin-bottom:10px"><?php echo $admtext['searchfor']; ?>: </p></div>
	<input type="text" name="searchstring" value="<?php echo $searchstring_noquotes; ?>" class="longfield"></td>
	<?php if($sitever == "mobile") echo "<br />\n"; ?>
	<input type="submit" name="submit" class="medbtn btn" value="<?php echo $admtext['search']; ?>" class="aligntop">
	<input type="submit" name="submit" class="medbtn btn" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" class="aligntop">

	<input type="hidden" name="findcemetery" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />

	<form action="admin_deleteselected.php" method="post" name="form2">
		<div class="align-bottom">
	  		<div class="adminnavblock">
<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "admin_cemeteries.php?searchstring=$searchstring&amp;exactmatch=" . (isset($exactmatch) ? $exactmatch : "") . "&amp;offset", $maxsearchresults, 5 );
	echo "<br /><br />";
	if($pagenav)
		echo "<span class=\"adminnav\">$pagenav</span><br />";
?>
			</div>
<?php
	if( $allow_delete ) {
?>
			<div>
				<input type="button" name="selectall" class="btn bigfield" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
				<input type="button" name="clearall" class="btn bigfield" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
		  		<input type="submit" name="xcemaction" class="btn bigfield" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo addslashes($admtext['confdeleterecs']); ?>');">
			</div>
<?php
	}
?>
		</div>

	<table cellpadding="3" cellspacing="1" border="0" class="rounded-table" style="width:100%">
		<tr>
			<td class="fieldnameback fieldname action-btns"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
<?php
	if($allow_delete) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['cemetery']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['location']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['latitude']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['longitude']; ?></b>&nbsp;</nobr></td>
<?php
	if($map['key']) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['zoom']; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
		</tr>

<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"admin_editcemetery.php?cemeteryID=xxx\" title=\"{$admtext['edit']}\" class=\"newsmallericon\"><img src=\"img/pen.png\" /></a>";
		$actionstr .= "<a href=\"" . $showmap_url . "cemeteryID=xxx\" target=\"_blank\" title=\"{$admtext['test']}\" class=\"newsmallericon\"><img src=\"img/play-circle.png\" /></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\" title=\"{$admtext['text_delete']}\" class=\"newsmallericon\"><img src=\"img/times.png\" /></a>";

		while( $row = tng_fetch_assoc($result))
		{
			$location = $row['city'];
			if( $row['county'] ) {
				if( $location ) $location .= ", ";
				$location .= $row['county'];
			}
			if( $row['state'] ) {
				if( $location ) $location .= ", ";
				$location .= $row['state'];
			}
			if( $row['country'] ) {
				if( $location ) $location .= ", ";
				$location .= $row['country'];
			}

			$newactionstr = preg_replace( "/xxx/", $row['cemeteryID'], $actionstr );
			echo "<tr id=\"row_{$row['cemeteryID']}\"><td class=\"lightback\" valign=\"top\"><div class=\"action-btns\">$newactionstr</div></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" valign=\"top\" align=\"center\"><input type=\"checkbox\" name=\"del{$row['cemeteryID']}\" value=\"1\"></td>";
			$editlink = "admin_editcemetery.php?cemeteryID={$row['cemeteryID']}";
			$cemname = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['cemname'] . "</a>" : $row['cemname'];

			echo "<td class=\"lightback\" valign=\"top\">$cemname&nbsp;</td>\n";
			echo "<td class=\"lightback\" valign=\"top\">$location&nbsp;</td>\n";
			echo "<td class=\"lightback\">&nbsp;{$row['latitude']}&nbsp;</td>\n";
			echo "<td class=\"lightback\">&nbsp;{$row['longitude']}&nbsp;</td>\n";
			if($map['key'])
				echo "<td class=\"lightback\">&nbsp;{$row['zoom']}&nbsp;</td>\n";
		}
?>
	</table>
<?php
		if($pagenav)
			echo " &nbsp; <span class=\"adminnav\">$pagenav</span>";
	}
	else
		echo "</table>\n" . $admtext['norecords'];
  	tng_free_result($result);
?>
	</form>

	</div>
</div>
<?php 
echo tng_adminfooter();
?>