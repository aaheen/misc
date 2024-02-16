#!/usr/bin/fish

set _ffmpeg_opts1_default '-hwaccel cuda'
set _ffmpeg_opts2_default '-c:v hevc_nvenc'

function ydlhevc_csv -a indexfile ffmpeg_opts1 ffmpeg_opts2
		# test for a little validity
		if not test -f $indexfile
				echo "$indexfile doesn't exist" 
				exit 1
		end
		# move over the header line of the csv and start at line 2
		# reads in the csv line by line
		tail -n +2 $indexfile | while read --line --export lines
				# separates each line into its arguments
				echo $lines | read --delimiter , --function --export url outfile
				#echo "$url  to be saved as:  $outfile"
				ydlhevc $url $outfile
		end
end



function ydlhevc -a url outfile ffmpeg_opts1 ffmpeg_opts2
		# set ffmpeg_opts if it's not already set
		if test -z $ffmpeg_opts1; set ffmpeg_opts1 $_ffmpeg_opts1_default; end 
		if test -z $ffmpeg_opts2; set ffmpeg_opts2 $_ffmpeg_opts2_default; end
		#echo "ffmpeg $ffmpeg_opts1 -i \"$outfile.tmp.mp4\" $ffmpeg_opts2 \"$outfile\""
		#finally do the downloading
		yt-dlp -f original $url -o "$outfile.tmp.mp4"
		ffmpeg $ffmpeg_opts1 -i "$outfile.tmp.mp4" $ffmpeg_opts2 "$outfile"
		rm "$outfile.tmp.mp4"
		echo "Download finished! Video saved to \"$outfile\" and re-encoded to HEVC"
end
