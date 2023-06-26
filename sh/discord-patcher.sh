#!/bin/bash

if [ "$EUID" -ne 0 ]
  then echo "Please run as root"
  exit
fi

tmpdir="/tmp/discord-update"
installto="/usr/lib64"
tarballURL="https://discord.com/api/download/stable?platform=linux&format=tar.gz"

mkdir -p $tmpdir
cd $tmpdir

# /tmp/discord-update/

printf "\n================= Beginning Discord update =================\n"

killall Discord

wget -O discord.tar.gz "$tarballURL"
printf "Extracting files...\n\n"
tar -xvf discord.tar.gz

# I have no idea why this doesn't like to be overwritten with copy
# but if I just yeet it first then it works :D
rm /usr/lib64/discord/chrome-sandbox

printf "\nInstalling to %s/discord/\n" "$installto"
cp -ru $tmpdir/Discord/* $installto/discord/

printf "\nCleaning up\n"
rm -r $tmpdir

printf "\n=============== Discord successfully updated ===============\n"

