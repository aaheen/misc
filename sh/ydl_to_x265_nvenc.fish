#!/usr/bin/fish
function ydl_to_x265 -a url outfile
		yt-dlp -f original $url -o "$outfile-big.mp4"
		ffmpeg -hwaccel cuda -i "$outfile-big.mp4" -c:v hevc_nvenc $outfile
		rm "$outfile-big.mp4"
		echo "Download finished! Video saved to \"$outfile\" and re-encoded to HEVC"
end
