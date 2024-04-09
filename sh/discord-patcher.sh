#!/bin/bash

tmpdir="$HOME/.local/tmp/discord-update"
installto="$HOME/.local/lib64"
binloc="$HOME/.local/bin"
tarballURL="https://discord.com/api/download/stable?platform=linux&format=tar.gz"

printf "\nKilling Discord bc it's time to cook\n"
killall discord

mkdir -p $tmpdir
cd $tmpdir

# /tmp/discord-update/

printf "\n================= Beginning Discord update =================\n"

wget -O discord.tar.gz "$tarballURL"
printf "Extracting files...\n\n"
tar -xvf discord.tar.gz

printf "\nInstalling to %s/discord/\n" "$installto"
mkdir -p $installto/discord
cp -ru $tmpdir/Discord/* $installto/discord/

printf "\nCreating symlink in %s" "$binloc"
printf "\n"
unlink $binloc/discord

ln -s $installto/discord/Discord $binloc/discord

printf "\nCleaning up\n"
rm -r $tmpdir

printf "\n=============== Discord successfully updated ===============\n"

