#!/bin/sh
dnf clean all --color true

dnf install --color true \
	fish lsd neofetch seahorse \
	dua-cli htop smartmontools speedtest-cli\
	hyprland-devel \
	fwupd fzf sassc \
	vlc ffmpeg-free youtube-dl \
	gstreamer1-vaapi gstreamer1-plugin-openh264 gstreamer1-libav libavcodec-free lame \
	alsa-lib-devel.x86_64 alsa-lib.x86_64 pipewire-alsa.x86_64 alsa-plugins-pulseaudio.x86_64 portaudio-devel \
	gedit neovim code git gh \
	@development-tools clang rust rustup cargo golang hugo python3 nodejs \
	krita inkscape \
	gnome-tweaks gnome-extensions-app libappindicator \
	gnome-shell-extension-blur-my-shell gnome-shell-extension-caffeine gnome-shell-extension-user-theme \
	papirus-icon-theme \
	calibre playerctl-devel rhythmbox \
	syncthing transmission


# for Wine
#dnf install \
#	alsa-plugins-pulseaudio.i686 glibc-devel.i686 glibc-devel libgcc.i686 libX11-devel.i686 freetype-devel.i686 libXcursor-devel.i686 libXi-devel.i686 libXext-devel.i686 libXxf86vm-devel.i686 libXrandr-devel.i686 libXinerama-devel.i686 mesa-libGLU-devel.i686 mesa-libOSMesa-devel.i686 libXrender-devel.i686 libpcap-devel.i686 ncurses-devel.i686 libzip-devel.i686 lcms2-devel.i686 zlib-devel.i686 libv4l-devel.i686 libgphoto2-devel.i686 cups-devel.i686 libxml2-devel.i686 openldap-devel.i686 libxslt-devel.i686 gnutls-devel.i686 libpng-devel.i686 flac-libs.i686 json-c.i686 libICE.i686 libSM.i686 libXtst.i686 libasyncns.i686 liberation-narrow-fonts.noarch libieee1284.i686 libogg.i686 libsndfile.i686 libuuid.i686 libva.i686 libvorbis.i686 libwayland-client.i686 libwayland-server.i686 llvm-libs.i686 mesa-dri-drivers.i686 mesa-filesystem.i686 mesa-libEGL.i686 mesa-libgbm.i686 nss-mdns.i686 ocl-icd.i686 pulseaudio-libs.i686 sane-backends-libs.i686 tcp_wrappers-libs.i686 unixODBC.i686 samba-common-tools.x86_64 samba-libs.x86_64 samba-winbind.x86_64 samba-winbind-clients.x86_64 samba-winbind-modules.x86_64 mesa-libGL-devel.i686 fontconfig-devel.i686 libXcomposite-devel.i686 libtiff-devel.i686 openal-soft-devel.i686 mesa-libOpenCL-devel.i686 alsa-lib-devel.i686 gsm-devel.i686 libjpeg-turbo-devel.i686 pulseaudio-libs-devel.i686 pulseaudio-libs-devel gtk3-devel.i686 libattr-devel.i686 libva-devel.i686 libexif-devel.i686 libexif.i686 glib2-devel.i686 mpg123-devel.x86_64 libcom_err-devel.i686 libcom_err-devel.x86_64 libFAudio-devel.i686 libFAudio-devel.x86_64 \

# for Steam / Lutris / League
dnf install \
	amd-gpu-firmware \
	mesa-vulkan-drivers mesa-vulkan-drivers.i686 \
	dxvk-native dxvk-native.i686 \
	vulkan-loader vulkan-loader.i686 \
	wine wine.i686

dnf install \
	lutris steam prismlauncher

