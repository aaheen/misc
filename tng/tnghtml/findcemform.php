<?php
include("begin.php");
include("adminlib.php");
$textpart = "cemeteries";
//include("getlang.php");
include("$mylanguage/admintext.php");

include($cms['tngpath'] . "checklogin.php");

$bailtext = $admtext['cancel'];

$applyfilter = "applyFilter({form:'findform1',fieldId:'mycemetery', type:'G', destdiv:'cemresults'});";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="finddiv">
	<form action="" method="post" name="findform1" id="findform1" onsubmit="return <?php echo $applyfilter; ?>">
    <p class="subhead"><strong><?php echo $admtext['findcem']; ?></strong><br/>
    <span class="normal">(<?php echo $admtext['partcem']; ?>)</span></p>
	<table border="0" cellspacing="0" cellpadding="2" class="normal">
		<tr>
		   	<td><?php echo $admtext['cemeteryname']; ?>: </td>
			<td><input type="text" name="mycemetery" class="medfield" id="mycemetery" onkeyup="filterChanged(event, {form:'findform1',fieldId:'mycemetery', type:'G', destdiv:'cemresults'});"/></td>
			<td><input type="submit" class="btn" value="<?php echo $admtext['search']; ?>"/> <input type="button" class="btn" value="<?php echo $bailtext; ?>" onclick="gotoSection(seclitbox, null);"/></td>
		</tr>
		<tr>
			<td colspan="3">
				<input type="radio" name="filter" value="s" onclick="<?php echo $applyfilter; ?>" /> <?php echo $text['startswith']; ?> &nbsp;&nbsp; <input type="radio" name="filter" value="c" checked="checked" onclick="<?php echo $applyfilter; ?>" /> <?php echo $text['contains']; ?>
			</td>
		</tr>
	</table>
	</form>

	<br/>
	<span class="normal"><strong><?php echo $admtext['searchresults']; ?></strong> (<?php echo $admtext['clicktoselect']; ?>)</span>

    <div id="cemresults" style="width:660px;height:385px;overflow:auto"></div>
</div>