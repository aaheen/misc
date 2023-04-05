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
printf "\n================= Beginning Nightly update =================\n"

wget -O nightly.tar.bz2 "$nightlyURL"
printf "Extracting files...\n\n"
tar -xvf nightly.tar.bz2 
mv firefox nightly-download

printf "\nRemoving old binaries"
sudo rm $installto/firefox-nightly/firefox*

printf "\nInstalling to %s/firefox-nightly/\n" "$installto"
sudo cp -ru nightly-download/* $installto/firefox-nightly

printf "\nCleaning up Nightly\n"
rm nightly.tar.bz2
rm -r nightly-download

printf "\n=============== Nightly successfully updated ===============\n"


# Aurora
printf "\n================= Beginning Aurora update ==================\n"

wget -O aurora.tar.bz2 "$auroraURL"
printf "Extracting files...\n\n"
tar -xvf aurora.tar.bz2
mv firefox aurora-download

printf "\nRemoving old binaries"
sudo rm $installto/firefox-developer/firefox*

printf "\nInstalling to %s/firefox-developer/\n" "$installto"
sudo cp -ru aurora-download/* $installto/firefox-developer

printf "\nCleaning up Aurora\n"
rm aurora.tar.bz2
rm -r aurora-download

printf "\n=============== Aurora successfully updated ================\n"


# Return to old directory
printf "\n"
echo "Returning to $(cat "$curdir")"
cd "$(cat "$curdir")" || exit 1
sudo rm "$curdir"

printf "Installation complete\n"
