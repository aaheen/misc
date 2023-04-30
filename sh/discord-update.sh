#!/bin/bash

tmpdir="$HOME/.local/tmp/discord-update"
tarballURL="https://discord.com/api/download/stable?platform=linux&format=tar.gz"
installto="/usr/lib64"

mkdir -p $tmpdir || exit 1
cd $tmpdir

# $HOME/.local/tmp/discord-update/

printf "\n================= Beginning Discord update =================\n"

wget -O discord.tar.gz "$tarballURL"
printf "Extracting files...\n\n"
tar -xvf discord.tar.gz

sudo rm /usr/lib64/discord/chrome-sandbox || exit 1

printf "\nInstalling to %s/discord/\n" "$installto"
sudo cp -ru $tmpdir/Discord/* $installto/discord/ || exit 1

printf "\nCleaning up\n"
rm -r $tmpdir

printf "\n=============== Discord successfully updated ===============\n"

