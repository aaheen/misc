<?php
$cms = array();
if(isset($cms['support']) || isset($cms['tngpath']) || isset($_GET['lang']) || isset($_GET['mylanguage']) || isset($_GET['language']) || isset($_GET['session_language']) || isset($_GET['rootpath'])) 	pageForbidden();
$tngconfig = array();
include("processvars.php");
include("subroot.php");
include("tngconnect.php");
include($tngconfig['subroot'] . "config.php");
$subroot = $tngconfig['subroot'] ? $tngconfig['subroot'] : $cms['tngpath'];
include($subroot . "importconfig.php");

if( $saveimport ){
	if(!trim($database_port)) $database_port = null;
	if(!trim($database_socket)) $database_socket = null;
	$link = ($database_username && $database_name) ? tng_connect($database_host, $database_username, $database_password, $database_name, $database_port, $database_socket) : "";
	if( $link && tng_select_db($link, $database_name)) {
		$query = "DELETE from $saveimport_table WHERE gedcom = \"$tree\"";
		$result = tng_query($query);
	}
}
echo "1";
?>