#!/bin/sh
### Fonts ###
# Downloads
mkdir fc && cd fc

curl -sL 'https://github.com/ryanoasis/nerd-fonts/releases/download/v3.0.2/Hermit.tar.xz' -o Hermit.tar.xz
curl -sL 'https://github.com/ryanoasis/nerd-fonts/releases/download/v3.0.2/Mononoki.tar.xz' -o Mononoki.tar.xz
curl -sL 'https://fonts.google.com/download?family=Open%20Sans' -o OpenSans.zip
curl -sL 'https://fonts.google.com/download?family=Overpass' -o Overpass.zip
curl -sL 'https://fonts.google.com/download?family=Crimson%20Pro' -o CrimsonPro.zip 

tar -xvf Hermit.tar.xz
cp -u 'HurmitNerdFont-Regular.otf' ~/.local/share/fonts/
cp -u 'HurmitNerdFont-Bold.otf' ~/.local/share/fonts/
cp -u 'HurmitNerdFont-Italic.otf' ~/.local/share/fonts/
cp -u 'HurmitNerdFont-BoldItalic.otf' ~/.local/share/fonts/

tar -xvf Mononoki.tar.xz
cp -u 'MononokiNerdFont-Regular.ttf' ~/.local/share/fonts/
cp -u 'MononokiNerdFont-Bold.ttf' ~/.local/share/fonts/
cp -u 'MononokiNerdFont-Italic.ttf' ~/.local/share/fonts/
cp -u 'MononokiNerdFont-BoldItalic.ttf' ~/.local/share/fonts/

unzip -nq OpenSans.zip -d ~/.local/share/fonts
unzip -nq Overpass.zip -d ~/.local/share/fonts
unzip -nq CrimsonPro.zip -d ~/.local/share/fonts

cd ..
rm -r fc

# Refresh font cache
fc-cache -fv

# Set GNOME variables
#gsettings set org.gnome.desktop.wm.preferences titlebar-uses-system-font true
gsettings set org.gnome.destkop.interface font-hinting 'medium'
gsettings set org.gnome.desktop.wm.preferences titlebar-font 'Open Sans Bold 11'
gsettings set org.gnome.desktop.interface font-name 'Open Sans 11'
gsettings set org.gnome.desktop.interface monospace-font-name 'Mononoki Nerd Font 11'
gsettings set org.gnome.desktop.interface document-font-name 'Crimson Pro 12'

