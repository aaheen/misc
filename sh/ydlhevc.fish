#!/usr/bin/fish

function ydlhevc -a url outfile ydl_format
		# prepend -f to ydl_format if specified
		if test -n "$ydl_format"
			set ydl_opts -f $ydl_format
		end

		# get tmp name for outfile & download
		mkdir -p ~/.cache/ydlhevc/
		set _tmp_outfile ~/.cache/ydlhevc/(yt-dlp $ydl_opts $url --get-filename)
		yt-dlp $url -o $_tmp_outfile

		# set ffmpeg opions & remux to hevc at desired location
		set _ffmpeg_opts1 -hwaccel cuda
		set _ffmpeg_opts2 -c:v hevc_nvenc
		ffmpeg $_ffmpeg_opts1 -i "$_tmp_outfile" $_ffmpeg_opts2 "$outfile"

		# clean up
		rm "$_tmp_outfile"
		echo "Download finished! Video saved to \"$outfile\" and re-encoded to HEVC"
end
