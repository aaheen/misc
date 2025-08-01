<?php
include("begin.php");
include("adminlib.php");
$textpart = "events";
//include("getlang.php");
include("$mylanguage/admintext.php");

$admin_login = 1;
include($cms['tngpath'] . "checklogin.php");

$query = "SELECT eventID, age, agency, cause, $events_table.addressID, address1, address2, city, state, zip, country, info, phone, email, www FROM $events_table LEFT JOIN $address_table on $events_table.addressID = $address_table.addressID WHERE parenttag = \"$eventID\" AND $events_table.persfamID = \"$persfamID\" AND $events_table.gedcom = \"$tree\"";
$result = tng_query($query);
$row = tng_fetch_assoc( $result );
tng_free_result($result);
$row['age'] = isset($row['age']) ? preg_replace("/\"/", "&#34;",$row['age']) : "";
$row['agency'] = isset($row['agency']) ? preg_replace("/\"/", "&#34;",$row['agency']) : "";
$row['cause'] = isset($row['cause']) ? preg_replace("/\"/", "&#34;",$row['cause']) : "";
$row['address1'] = isset($row['address1']) ? preg_replace("/\"/", "&#34;",$row['address1']) : "";
$row['address2'] = isset($row['address2']) ? preg_replace("/\"/", "&#34;",$row['address2']) : "";
$row['city'] = isset($row['city']) ? preg_replace("/\"/", "&#34;",$row['city']) : "";
$row['state'] = isset($row['state']) ? preg_replace("/\"/", "&#34;",$row['state']) : "";
$row['zip'] = isset($row['zip']) ? preg_replace("/\"/", "&#34;",$row['zip']) : "";
$row['country'] = isset($row['country']) ? preg_replace("/\"/", "&#34;",$row['country']) : "";
$row['phone'] = isset($row['phone']) ? preg_replace("/\"/", "&#34;",$row['phone']) : "";
$row['email'] = isset($row['email']) ? preg_replace("/\"/", "&#34;",$row['email']) : "";
$row['www'] = isset($row['www']) ? preg_replace("/\"/", "&#34;",$row['www']) : "";
$row['addressID'] = isset($row['addressID']) ? preg_replace("/\"/", "&#34;",$row['addressID']) : "";
$row['eventID'] = isset($row['eventID']) ? preg_replace("/\"/", "&#34;",$row['eventID']) : "";

if($session_charset != "UTF-8") {
	//$row['age']= utf8_encode($row['age']);
	//$row['agency'] = utf8_encode($row['agency']);
	//$row['cause'] = utf8_encode($row['cause']);
	//$row['address1'] = utf8_encode($row['address1']);
	//$row['address2'] = utf8_encode($row['address2']);
	//$row['city'] = utf8_encode($row['city']);
	//$row['state'] = utf8_encode($row['state']);
	//$row['zip'] = utf8_encode($row['zip']);
	//$row['country'] = utf8_encode($row['country']);
}

$helplang = findhelp("more_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="more">
<form action="" name="editmoreform" onsubmit="return updateMore(this);">
<div style="float:right normal"><input type="submit" name="submit" class="btn" style="float:right" value="<?php echo $admtext['save']; ?>"></div>
<p class="subhead"><strong><?php echo "{$admtext['moreinfo']}: $admtext[$eventID]"; ?></strong> |
	<a href="#" onclick="return openHelp('<?php echo $helplang; ?>/more_help.php');"><?php echo $admtext['help']; ?></a></p>
<table border="0" cellpadding="2">
	<tr><td><?php echo $admtext['age']; ?>:</td><td><input type="text" name="age" size="12" maxlength="12" value="<?php echo $row['age']; ?>"></td></tr>
	<tr><td><?php echo $admtext['agency']; ?>:</td><td><input type="text" name="agency" size="50" value="<?php echo $row['agency']; ?>"></td></tr>
	<tr><td><?php echo $admtext['cause']; ?>:</td><td><input type="text" name="cause" size="50" value="<?php echo $row['cause']; ?>"></td></tr>
	<tr><td colspan="2"><strong><?php echo $admtext['address']; ?></strong></td></tr>
	<tr><td><?php echo $admtext['address1']; ?>:</td><td><input type="text" name="address1" size="50" value="<?php echo $row['address1']; ?>"></td></tr>
	<tr><td><?php echo $admtext['address2']; ?>:</td><td><input type="text" name="address2" size="50" value="<?php echo $row['address2']; ?>"></td></tr>
	<tr><td><?php echo $admtext['city']; ?>:</td><td><input type="text" name="city" size="50" value="<?php echo $row['city']; ?>"></td></tr>
	<tr><td><?php echo $admtext['stateprov']; ?>:</td><td><input type="text" name="state" size="50" value="<?php echo $row['state']; ?>"></td></tr>
	<tr><td><?php echo $admtext['zip']; ?>:</td><td><input type="text" name="zip" size="20" value="<?php echo $row['zip']; ?>"></td></tr>
	<tr><td><?php echo $admtext['countryaddr']; ?>:</td><td><input type="text" name="country" size="50" value="<?php echo $row['country']; ?>"></td></tr>
	<tr><td><?php echo $admtext['phone']; ?>:</td><td><input type="text" name="phone" size="30" value="<?php echo $row['phone']; ?>"></td></tr>
	<tr><td><?php echo $admtext['email']; ?>:</td><td><input type="text" name="email" size="50" value="<?php echo $row['email']; ?>"></td></tr>
	<tr><td><?php echo $admtext['website']; ?>:</td><td><input type="text" name="www" size="50" value="<?php echo $row['www']; ?>"></td></tr>
</table>
<input type="hidden" name="eventtypeID" value="<?php echo $eventID; ?>">
<input type="hidden" name="addressID" value="<?php echo $row['addressID']; ?>">
<input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
<input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
</form>

</div>