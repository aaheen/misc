#!/bin/sh

curl -fsSL https://tailscale.com/install.sh | sh
tailscale up

curl -Lo /usr/bin/theme.sh 'https://git.io/JM70M' 
chmod +x /usr/bin/theme.sh
echo "/usr/bin/theme.sh helios" >> ~/.config/fish/config.fish

neofetch

gsettings set org.gnome.desktop.interface icon-theme \'Papirus-Dark\'
gsettings set org.gnome.mutter experimental-features "['scale-monitor-framebuffer']"

