	<tr><td><?php echo $admtext['shorttitle']; ?>:</td><td><input type="text" name="shorttitle" size="60"></td></tr>
	<tr><td><?php echo $admtext['longtitle']; ?>:</td><td><input type="text" name="title" size="60"></td></tr>
	<tr><td><?php echo $admtext['author']; ?>:</td><td><input type="text" name="author" size="60"></td></tr>
	<tr><td><?php echo $admtext['callnumber']; ?>:</td><td><input type="text" name="callnum" size="60"></td></tr>
	<tr><td><?php echo $admtext['publisher']; ?>:</td><td><input type="text" name="publisher" size="60"></td></tr>
	<tr>
		<td><?php echo $admtext['repository']; ?>:</td>
		<td>
			<select name="repoID" class="bigselect">
				<option value=""></option>
<?php
$query = "SELECT repoID, reponame, gedcom FROM $repositories_table $wherestr ORDER BY reponame";
$reporesult = tng_query($query);
while( $reporow = tng_fetch_assoc($reporesult) ) {
	if( !$assignedtree && (!isset($numtrees) || $numtrees > 1) )
		echo "		<option value=\"{$reporow['repoID']}\">{$reporow['reponame']} ({$admtext['tree']}: {$reporow['gedcom']})</option>\n";
	else
		echo "		<option value=\"{$reporow['repoID']}\">{$reporow['reponame']}</option>\n";
}
tng_free_result( $reporesult );
?>
			</select>
		</td>
	</tr>
	<tr><td valign="top" style="padding-top:10px"><?php echo $admtext['actualtext']; ?>:</td><td><textarea cols="<?php echo $cols; ?>" rows="14" name="actualtext"></textarea></td></tr>
