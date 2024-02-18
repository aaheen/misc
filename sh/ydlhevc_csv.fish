#!/usr/bin/fish

function ydlhevc_csv -a indexfile ydl_format
		# test for a little validity
		if not test -f $indexfile
				echo "$indexfile doesn't exist" 
				return 1
		end

		# move over the header line of the csv and start at line 2
		# reads in the csv line by line
		tail -n +2 $indexfile | while read --line --export lines
				# separates each line into its arguments
				echo $lines | read --delimiter , --function --export url outfile
				# call remuxing function for each video
				ydlhevc $url $outfile $ydl_format
		end
		# clean up any straggler files in the event of an error
		rm ~/.cache/ydlhevc/*
end
