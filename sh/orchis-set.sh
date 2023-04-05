#!/bin/bash

orchisSRC="$HOME/code/src/github.com/vinceliuice/Orchis-theme"
th="$HOME/.themes/Orchis-Compact-Nord/gtk-4.0"
thLite="$HOME/.themes/Orchis-Light-Compact-Nord/gtk-4.0"
thDark="$HOME/.themes/Orchis-Dark-Compact-Nord/gtk-4.0"
gtk4CFG="$HOME/.config/gtk-4.0"

unlink "$gtk4CFG/assets" \
  && ln -s "$th/assets" "$gtk4CFG/assets"
unlink "$gtk4CFG/gtk.css" \
  && ln -s "$th/gtk.css" "$gtk4CFG/gtk.css"
unlink "$gtk4CFG/gtk-dark.css" \
  && ln -s "$thDark/gtk-dark.css" "$gtk4CFG/gtk-dark.css"

