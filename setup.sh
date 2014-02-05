#!/bin/sh -e

cd `dirname $0`
app_root=/srv/www/item.fuktommy.com

rsync -Cacv --delete \
    --exclude="*.template" \
    --exclude="- /conf" \
    --exclude="- /setup.sh" \
    ./ $app_root/app/

rsync -CacvL --exclude="*.template" conf/ $app_root/conf/

mkdir -v -m 0777 -p $app_root/contents
mkdir -v -m 0777 -p $app_root/contents/img
mkdir -v -m 0777 -p $app_root/data
mkdir -v -m 0777 -p $app_root/log
mkdir -v -m 0777 -p $app_root/tmp
mkdir -v -m 0777 -p $app_root/tmp/smarty_cache
mkdir -v -m 0777 -p $app_root/tmp/templates_c
