ip --json a | jq '.[] | select(.link_type == "ether")'
