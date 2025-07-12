<?php
function showCustEvents($id) {
	global $tree, $admtext, $events_table, $eventtypes_table, $allow_edit, $allow_delete, $gotnotes, $gotcites, $dims, $mylanguage, $languages_path;

	$query = "SELECT display, eventdate, eventplace, info, $events_table.eventID as eventID 
		FROM $events_table, $eventtypes_table 
		WHERE parenttag = \"\" AND persfamID = \"$id\" AND gedcom = \"$tree\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID 
		ORDER BY eventdatetr, ordernum";
	$evresult = tng_query($query);
	$eventcount = tng_num_rows( $evresult );

	if( $evresult && $eventcount ) {
		while ( $event = tng_fetch_assoc( $evresult ) ) {
			$dispvalues = explode( "|", $event['display'] );
			$numvalues = count( $dispvalues );
			if( $numvalues > 1 ) {
				$displayval = "";
				for( $i = 0; $i < $numvalues; $i += 2 ) {
					$lang = $dispvalues[$i];
					if( $mylanguage == $languages_path . $lang ) {
						$displayval = $dispvalues[$i+1];
						break;
					}
				}
			}
			else
				$displayval = $event['display'];
			$info = cleanIt($event['info']);
			$rowspan = 0;
			if($info) $rowspan++;
			if($event['eventdate'] || $event['eventplace']) $rowspan++;
			if(!$rowspan) {
				$rowspan = 1;
				$info = "&nbsp;";
			}
			$truncated = substr($info,0,90);
			$info = strlen($info) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $info;

			if($allow_edit) {
				$on_click_edit = " onclick=\"return editEvent({$event['eventID']});\"";
				$actionstr = "<td class=\"action-btn\"><a href=\"#\"{$on_click_edit} title=\"{$admtext['edit']}\" class=\"newsmallicon\" style=\"margin-left:4px\"><img src=\"img/pen.png\" alt=\"{$admtext['edit']}\" style=\"padding:4px\"/></a></td>";
			}
			else {
				$actionstr = $on_click_edit = "";
			}
			$actionstr .= $allow_delete ? "<td class=\"action-btn\"><a href=\"#\" onclick=\"return deleteEvent('{$event['eventID']}');\" title=\"{$admtext['text_delete']}\" class=\"newsmallicon\"><img src=\"img/times.png\" alt=\"{$admtext['delete']}\" style=\"padding:4px\"/></a></td>" : "&nbsp;";
			if(isset($gotnotes)) {
				$notesicon = !empty($gotnotes[$event['eventID']]) ? "note_on.png" : "note.png";
				$actionstr .= "<td class=\"action-btn\"><a href=\"#\" onclick=\"return showNotes('{$event['eventID']}','$id');\" title=\"{$admtext['notes']}\" class=\"newsmallicon\"><img id=\"notesicon{$event['eventID']}\" src=\"img/{$notesicon}\" alt=\"{$admtext['notes']}\"/></a></td>";
			}
			if(isset($gotcites)) {
				$citesicon = !empty($gotcites[$event['eventID']]) ? "quotes_on.png" : "quotes.png";
				$actionstr .= "<td class=\"action-btn\"><a href=\"#\" onclick=\"return showCitations('{$event['eventID']}','$id');\" title=\"{$admtext['sources']}\" class=\"newsmallicon\"><img id=\"citesicon{$event['eventID']}\" src=\"img/{$citesicon}\" alt=\"{$admtext['sources']}\"/></a></td>";
			}
			if($event['eventdate'] || $event['eventplace']) {
				echo "<tr class=\"row_{$event['eventID']}\" id=\"row_{$event['eventID']}_top\" valign=\"top\"><td rowspan=\"$rowspan\" class=\"cust-label\">{$displayval}:</td>";
				echo "<td><div class=\"cust-event-field\"{$on_click_edit}>{$event['eventdate']}&nbsp;</div></td><td><div class=\"cust-event-field cust-place\"style=\"width:535px\"{$on_click_edit}>{$event['eventplace']}&nbsp;</div></td>";
				echo "$actionstr</td></tr>\n";
				if($info)
					echo "<tr class=\"row_{$event['eventID']}\" id=\"row_{$event['eventID']}_bot\"><td colspan=\"2\"><div class=\"cust-event-field\"{$on_click_edit}>$info</div></td></tr>\n";
			}
			else {
				echo "<tr class=\"row_{$event['eventID']}\" id=\"row_{$event['eventID']}_top\" valign=\"top\">";
				echo "<td class=\"cust-label\">{$displayval}:</td><td colspan=\"2\"><div class=\"cust-event-field\"{$on_click_edit}>$info</div></td>";
				echo "$actionstr</tr>\n";
			}
			echo "</td>\n";
			echo "</tr>\n";
		}
		tng_free_result($evresult);
	}
}
?>