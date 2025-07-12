<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "search";
include($cms['tngpath'] . "getlang.php");

include($cms['tngpath'] . "checklogin.php");

$anniversaries_url = getURL( "anniversaries", 1 );

$tngyear = $tngyear ?? "";
$tngyear = preg_replace("/[^0-9]/", "", $tngyear );
$tngkeywords = $tngkeywords ?? "";
$tngkeywords = preg_replace("/[^A-Za-z0-9]/", "", $tngkeywords );

if( !isset($offset) ) $offset = "";
if( !isset($tngpage) ) $tngpage = "";

if( !empty($tngevent) ) {
    $querystr = "tngevent=$tngevent";
    if(isset($tngdaymonth)) $querystr .= "&tngdaymonth=$tngdaymonth";
    if(isset($tngmonth)) $querystr .= "&tngmonth=$tngmonth";
    if(!empty($tngyear)) $querystr .= "&tngyear=$tngyear";
    if(!empty($tngkeywords)) $querystr .= "&tngkeywords=$tngkeywords";
    if(isset($tngliving)) $querystr .= "&tngliving=$tngliving";
    if(isset($tngneedresults)) $querystr .= "&tngneedresults=$tngneedresults";
    if(isset($offset)) $querystr .= "&offset=$offset";
    if(isset($tree)) $querystr .= "&tree=$tree";
    if(isset($tngpage)) $querystr .= "&tngpage=$tngpage";
}
else
    $querystr = "";
header( "Location: " . $anniversaries_url . $querystr );
?>