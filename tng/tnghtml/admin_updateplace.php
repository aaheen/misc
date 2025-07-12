<?php
include("begin.php");
include("adminlib.php");
$textpart = "findplace";
//include("getlang.php");
include("$mylanguage/admintext.php");

$admin_login = 1;
include("checklogin.php");

if( !$allow_edit ) {
	$message = $admtext['norights'];
	header( "Location: admin_login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

$place = addslashes($place);
$placelevel = !empty($placelevel) ? addslashes($placelevel) : 0;
$newlat = convertDMSToDecimal($latitude);
$latitude = $newlat ? $newlat : addslashes($latitude);
$newlong = convertDMSToDecimal($longitude);
$longitude = $newlong ? $newlong : addslashes($longitude);
$zoom = !empty($zoom) ? addslashes($zoom) : 0;
$notes = addslashes($notes);
$orgplace = addslashes($orgplace);

$latitude = preg_replace("/,/",".",$latitude);
$longitude = preg_replace("/,/",".",$longitude);
if($latitude && $longitude && $placelevel && !$zoom)
	$zoom = 13;
if( !$zoom ) $zoom = 0;
if( !$placelevel ) $placelevel = 0;
if( empty($temple) ) $temple = 0;
if( !$tngconfig['places1tree'] && !empty($newtree) ) {
	$newtreestr = ",gedcom=\"$newtree\"";
	$tree = $newtree;
}
else
	$newtreestr = "";

$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

$query = "UPDATE $places_table SET place=\"$place\",placelevel=\"$placelevel\",temple=\"$temple\",latitude=\"$latitude\",longitude=\"$longitude\",zoom=\"$zoom\",notes=\"$notes\",geoignore=\"0\",changedate=\"$newdate\",changedby=\"$currentuser\"$newtreestr WHERE ID=\"$ID\"";
$result = @tng_query_noerror($query);
if( !$result ) {
	$message = $admtext['duplicate'];
	header( "Location: admin_places.php?message=" . urlencode($message) );
	exit;
}

if($tngconfig['places1tree']) {
    $updatetreestr = "";
    $treeurl = "";
}
else {
    $updatetreestr = " AND gedcom=\"$tree\"";
    $treeurl = "&tree=$tree";
}

if( !empty($propagate) ) {
	$trimmed_orgplace = trim($orgplace);
	if( $trimmed_orgplace && (trim($place) != $trimmed_orgplace) ) {
		//people
		$query = "UPDATE $people_table SET birthplace=\"$place\" WHERE birthplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $people_table SET altbirthplace=\"$place\" WHERE altbirthplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $people_table SET deathplace=\"$place\" WHERE deathplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $people_table SET burialplace=\"$place\" WHERE burialplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $people_table SET baptplace=\"$place\" WHERE baptplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $people_table SET confplace=\"$place\" WHERE confplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $people_table SET initplace=\"$place\" WHERE initplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $people_table SET endlplace=\"$place\" WHERE endlplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		
		//families
		$query = "UPDATE $families_table SET marrplace=\"$place\" WHERE marrplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $families_table SET divplace=\"$place\" WHERE divplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		$query = "UPDATE $families_table SET sealplace=\"$place\" WHERE sealplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		
		//events
		$query = "UPDATE $events_table SET eventplace=\"$place\" WHERE eventplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
		
		//children
		$query = "UPDATE $children_table SET sealplace=\"$place\" WHERE sealplace=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);

		//media
		$query = "UPDATE $medialinks_table SET personID=\"$place\" WHERE personID=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);

		$query = "UPDATE $media_table SET placetaken=\"$place\" WHERE placetaken=\"$orgplace\"$updatetreestr";
		$result = tng_query($query);
	}
}

$message = $admtext['changestoplace'] . " $place {$admtext['succsaved']}.";
adminwritelog( "<a href=\"admin_editplace.php?ID=$ID" . htmlspecialchars($treeurl) . "\">{$admtext['modifyplace']}: $place</a>" );

if( isset($_POST['savestay']) )
	header( "Location: admin_editplace.php?ID=$ID$treeurl&ref=1" );
else if( isset($_POST['saveclose']) )
	closeParent("admin_places.php?message=" . urlencode($message));
else {
	header( "Location: admin_places.php?message=" . urlencode($message) );
}
?>