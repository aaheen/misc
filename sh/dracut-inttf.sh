#!/bin/bash

## Backup old initramfs nouveau image ##
mv /boot/initramfs-$(uname -r).img /boot/initramfs-$(uname -r)-bkup-$(date +"%Y-%m-%d").img
 
## Create new initramfs image ##
dracut /boot/initramfs-$(uname -r).img $(uname -r)

