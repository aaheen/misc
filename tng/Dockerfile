# Dockerfile for TNG Family Tree Web app
# Originally authored by terrywbrady on GitHub, tweaked by August Heen (heen.dev)
# - https://www.tngsitebuilding.com/
# - Pre-requisites: unzip your download of tng <VERSION NUMBER> into the ./tnghtml folder.
#
# Ideas for this Dockerfile were inspired by
#   https://github.com/sprintcube/docker-compose-lamp/blob/master/bin/webserver/Dockerfile (terrywbrady authoring)
#   https://github.com/terrywbrady/TNG_Docker/blob/master/Dockerfile (aaheen edits)

FROM php:8.4.10-apache

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli

RUN cd /var/www/html && \
    chown -Rv www-data: .
    #adminlog.txt config.php mmconfig.php genlog.txt \
    #    importconfig.php logconfig.php mapconfig.php pedconfig.php \
    #    subroot.php whatsnew.txt \
    #    photos histories documents headstones media gendex backups \
    #    gedcom mods extensions classes  
