<?php
include("begin.php");
include("adminlib.php");
$textpart = "photos";
//include("getlang.php");
include("$mylanguage/admintext.php");

$admin_login = 1;
include("checklogin.php");

if( !$allow_add ) {
	exit;
}

require("adminlog.php");

$display_org = stripslashes($display);

if($session_charset != "UTF-8") {
	$display = tng_utf8_decode($display);
}

/*
if (get_magic_quotes_gpc() == 0)
	$display = addslashes( $display );
*/
if(empty($whatsnew)) $whatsnew = 0;
if(empty($statistics)) $statistics = 0;
if(empty($menus)) $menus = 0;

$stdcolls = array("photos", "histories", "headstones", "documents", "recordings", "videos");
$collid = cleanID($collid);
$newcollid = 0;
if(!in_array($collid, $stdcolls)) {
	$template = "ssssssssssss";
	$query = "INSERT IGNORE INTO $mediatypes_table (mediatypeID,display,path,liketype,icon,thumb,exportas,ordernum,localpath,whatsnew,statistics,menus) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
	$params = array(&$template, &$collid, &$display, &$path, &$liketype, &$icon, &$thumb, &$exportas, &$ordernum, &$localpath, &$whatsnew, &$statistics, &$menus);
	$affected_rows = tng_execute($query,$params);

	if( $affected_rows > 0 ) {
		adminwritelog( $admtext['addnewcoll'] . ": $display_org" );
		$newcollid = $collid;
	}
}
echo $newcollid;
?>