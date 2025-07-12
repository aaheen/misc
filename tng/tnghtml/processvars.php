<?php
$register_globals = (bool) ini_get('register_globals');

if(isset($_GET['cms']) || isset($_POST['cms'])) pageForbidden();
if(isset($_GET['nologin']) || isset($_POST['nologin'])) pageForbidden();

if( !$register_globals ) {
	if( $_SERVER && is_array( $_SERVER ) ) {
		foreach( $_SERVER as $key=>$value ) {
			${$key} = $value;
		}
	}
	if( $_ENV && is_array( $_ENV ) ) {
		foreach( $_ENV as $key=>$value ) {
			${$key} = $value;
		}
	}
	if( $_FILES && is_array( $_FILES ) ) {
		foreach( $_FILES as $key=>$value ) {
			${$key} = $value['tmp_name'];
		}
	}
}
if( $_GET && is_array( $_GET ) ) {
	foreach( $_GET as $key=>$value ) {
		if($key == 'lang' || $key == 'mylanguage') pageForbidden();
		if(is_string($value)) {
			if(strpos($value,"php://") !== false || strpos($value,".iconv") !== false)
				pageForbidden();
			${$key} = strip_tags($value);
		}
	}
}
if( $_POST && is_array( $_POST ) ) {
	foreach( $_POST as $key=>$value ) {
		if($key == 'lang' || $key == 'mylanguage') pageForbidden();
		if(is_string($value) && (strpos($value,"php://") !== false || strpos($value,".iconv") !== false))
			pageForbidden();
		${$key} = $value;
	}
}
if(isset($personID)) $personID = preg_replace("/[^A-Za-z0-9_\-. ]/", '', $personID);
if(isset($familyID)) $familyID = preg_replace("/[^A-Za-z0-9_\-. ]/", '', $familyID);
if(isset($sourceID)) $sourceID = preg_replace("/[^A-Za-z0-9_\-. ]/", '', $sourceID);
if(isset($repoID)) $repoID = preg_replace("/[^A-Za-z0-9_\-. ]/", '', $repoID);
if(isset($tree)) $tree = preg_replace("/[^A-Za-z0-9\._\-]/", '', $tree);
if(isset($branch)) $branch = preg_replace("/[^A-Za-z0-9\._\-]/", '', $branch);
if(isset($offset)) (int)$offset = preg_replace("/[^0-9].*$/", '', $offset);
if(isset($foffset)) (int)$foffset = preg_replace("/[^0-9].*$/", '', $foffset);
if(isset($ioffset)) (int)$ioffset = preg_replace("/[^0-9].*$/", '', $ioffset);
?>