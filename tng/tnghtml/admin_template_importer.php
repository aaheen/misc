<?php
include("begin.php");
include("adminlib.php");
$textpart = "templates";
include("$mylanguage/admintext.php");

$admin_login = true;
include("checklogin.php");
include("version.php");

$filename = $_FILES['form_newtemplate']['name']; 
$pathinfo = pathinfo($filename);
$templatename = $pathinfo['filename'];
$newpath = "{$rootpath}templates";
$newfile = $newpath . "/$filename";

if( $form_newtemplate && $form_newtemplate != "none" ) {
	if( @move_uploaded_file($form_newtemplate, $newfile) ) 
		@chmod( $newfile, 0644 );
	else {
	//improper permissions or folder doesn't exist (root path may be wrong)
		$message = $admtext['notcopied'] . " $newfile {$admtext['improperpermissions']}.";
		header( "Location: admin_templateconfig.php?message=" . urlencode($message) );
		exit;
	}
}
$success = tng_extract($newfile);

function tng_extract($path) {
	global $rootpath;

	if(class_exists('ZipArchive')) {
		$zip = new ZipArchive; 
        $res = $zip->open($path);
        if ($res === TRUE) {
            $zip->extractTo("$rootpath/templates");
            $zip->close();
        }
        return $res;
	}
    else
        return false;
}

$helplang = findhelp("people_help.php");

tng_adminheader( $admtext['modifytemplatesettings'], $flags );

	echo tng_adminlayout();

	$setuptabs[0] = array(1,"admin_setup.php",$admtext['configuration'],"configuration");
	$setuptabs[1] = array(1,"admin_diagnostics.php",$admtext['diagnostics'],"diagnostics");
	$setuptabs[2] = array(1,"admin_setup.php?sub=tablecreation",$admtext['tablecreation'],"tablecreation");
	$setuptabs[3] = array(1,"admin_templateconfig.php",$admtext['templateconfigsettings'],"template");
	$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/templateconfig_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
	$menu = doMenu($setuptabs,"template",$innermenu);
	echo displayHeadline($admtext['setup'] . " &gt;&gt; " . $admtext['configuration'] . " &gt;&gt; " . $admtext['templateconfigsettings'],"img/setup_icon.gif",$menu,$message);
?>

<div class="admin-main">
    <div class="tngshadow databack normal" style="border-radius:20px;padding-left:20px">
<?php

$templatenum = substr($templatename,strpos($templatename,"template")+8);

if(file_exists("{$rootpath}templates/{$templatename}/templatemsgs.php")) {
    include("{$rootpath}templates/{$templatename}/templatemsgs.php");
    echo "<p>{$admtext['importingvars']}: $templatenum ...</p>\n";
    if(empty($no_delete)) {
        $query = "DELETE FROM $templates_table WHERE template = \"$templatenum\"";
        $result = tng_query($query);
    }
    
    $query = "INSERT IGNORE INTO $templates_table (template,ordernum,keyname,language,value) VALUES ";
    $values = "";
    $orders = array();
    foreach($tmp as $key => $value) {
        $keyparts = explode("_",$key);
        $template = substr($keyparts[0],1);
        if(!isset($orders[$template]))
            $orders[$template] = 1;
        else
            $orders[$template]++;
        $keyname = $keyparts[1];
        $num_keyparts = count($keyparts);
        $language = $num_keyparts > 2 ? $keyparts[$num_keyparts-1] : "";
        if($values) $values .= ", ";
        $values .= "(\"$template\",\"{$orders[$template]}\",\"$keyname\",\"$language\",\"" . addslashes($value) . "\")";
    }
    $query .= $values;
    $result = tng_query($query);
    echo "<p>{$admtext['varsimported']}<a href =\"admin_templateconfig.php\">{$admtext['goback']}</a>.</p>\n";
} else {
    echo "<p>{$admtext['notimported']}<a href =\"admin_templateconfig.php\">{$admtext['goback']}</a>.</p>\n";
}
?>
    </div>
</div>
<?php 
echo tng_adminfooter();
?>