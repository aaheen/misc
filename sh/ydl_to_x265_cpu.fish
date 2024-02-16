#!/usr/bin/fish
function ydl_to_x265 -a url outfile
		youtube-dl -f original $url -o "$outfile-big.mp4"
		ffmpeg -i "$outfile-big.mp4" -c:v libx265 $outfile
		rm "$outfile-big.mp4"
		echo "Download finished! Video saved to \"$outfile\" and re-encoded to HEVC"
end
