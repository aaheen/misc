<?php
include("begin.php");
include("adminlib.php");
$textpart = "photos";
//include("getlang.php");
include("$mylanguage/admintext.php");

$admin_login = 1;
include("checklogin.php");

if( !$allow_edit ) {
	exit;
}

require("adminlog.php");

$display_org = stripslashes($display);

if($session_charset != "UTF-8") {
	$display = tng_utf8_decode($display);
}

$display = addslashes($display);
$localpath = preg_replace('/\\\\/','\\\\\\\\',$localpath);
if(empty($whatsnew)) $whatsnew = 0;
if(empty($statistics)) $statistics = 0;
if(empty($menus)) $menus = 0;

$query = "UPDATE $mediatypes_table 
	SET display=\"$display\", path=\"$path\", liketype=\"$liketype\", icon=\"$icon\", thumb=\"$thumb\", exportas=\"$exportas\", ordernum=\"$ordernum\", localpath=\"$localpath\", whatsnew=\"$whatsnew\", statistics=\"$statistics\", menus=\"$menus\"
	WHERE mediatypeID=\"$collid\"";
$result = @tng_query($query);

if( tng_affected_rows() ) {
	adminwritelog( $admtext['editcoll'] . ": $display_org" );
	echo "1";
}
else
	echo "0";
?>
