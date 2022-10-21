#!/bin/bash

curdir="$HOME/.local/firefox_update_dir.tmp"
nightlyURL="https://download.mozilla.org/?product=firefox-nightly-latest-ssl&os=linux64&lang=en-US"
auroraURL="https://download.mozilla.org/?product=firefox-devedition-latest-ssl&os=linux64&lang=en-US"
installto="/usr/lib64"

# Get sudo password now for the cp later on (don't wait for prompt)
pwd | sudo tee "$curdir"
echo "chdir from $(cat "$curdir") to $HOME/Downloads/"
cd "$HOME/Downloads" || exit 1

# /home/<user>/Downloads/

# Nightly
printf "\n==== Beginning Nightly update ====\n"
wget -O nightly.tar.bz2 "$nightlyURL"
printf "Extracting files...\n\n"
tar -xvf nightly.tar.bz2 
mv firefox firefox-nightly
printf "\nInstalling to %s/firefox-nightly/\n" "$installto"
sudo cp -ru firefox-nightly/* $installto/firefox-nightly

printf "\nCleaning up Nightly...\n"
rm nightly.tar.bz2
rm -r firefox-nightly

printf "\n===========================\n"

# Aurora
printf "\n==== Beginning Developer Edition update ====\n"
wget -O aurora.tar.bz2 "$auroraURL"
printf "Extracting files...\n\n"
tar -xvf aurora.tar.bz2
mv firefox firefox-aurora
printf "\nInstalling to %s/firefox-developer/\n" "$installto"
sudo cp -ru firefox-aurora/* $installto/firefox-developer

printf "\nCleaning up Developer Edition...\n"
rm aurora.tar.bz2
rm -r firefox-aurora

# Return to old directory
printf "\n"
echo "Returning to $(cat "$curdir")"
cd "$(cat "$curdir")" || exit 1
sudo rm "$curdir"

printf "Installation complete\n"
