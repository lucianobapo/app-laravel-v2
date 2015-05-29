#!/bin/sh
chgrp www-data -R storage/
chmod -R g+w storage/
chmod -R u+w storage/
chmod -R o-w ./

find storage/ -type f -exec chmod u-x {} \;
find storage/ -type d -exec chmod u+x {} \;

find storage/ -type f -exec chmod g-x {} \;
find storage/ -type d -exec chmod g+x {} \;

find storage/ -type f -exec chmod g-s {} \;
find storage/ -type d -exec chmod g+s {} \;

setfacl -dR -m u::rwx storage/
setfacl -dR -m g::rwx storage/