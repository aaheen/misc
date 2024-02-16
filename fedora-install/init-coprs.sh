# Visual Studio Code
rpm --import https://packages.microsoft.com/keys/microsoft.asc && \
	sh -c 'echo -e "[code]\nname=Visual Studio Code\nbaseurl=https://packages.microsoft.com/yumrepos/vscode\nenabled=0\ngpgcheck=1\ngpgkey=https://packages.microsoft.com/keys/microsoft.asc" > /etc/yum.repos.d/vscode.repo'

# PrismLauncher
dnf copr enable g3tchoo/prismlauncher
