<?php
$templatenumber = $_GET['templatenumber'];
//echo "testing $templatenumber, going to:" . $_SESSION['demoreturn']; exit;
session_start();
if($templatenumber) {
	$_SESSION['templateidx'] = $templatenumber;
	$_SESSION['templatenumber'] = "template" . $templatenumber;
	$_SESSION['templatepath'] = "templates/template$templatenumber/";
}
else {
	unset($_SESSION['templateidx']);
	unset($_SESSION['templatenumber']);
	unset($_SESSION['templatepath']);
}
if( $_SESSION['demoreturn'] == "admin" ) {
	header( "Location: admin.php" );
	exit;
}

header( "Location: " . $_SESSION['demoreturn'] );
?>