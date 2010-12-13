#!/bin/sh -e

alias mget='wget -q --random-wait --header="Accept-Language: ja; q=1.0, en;q=0.5" -U "Buzz-Reader/2010-04-26" -w 2 -t 10 -T 20'

cd "/srv/data/blog.fuktommy.com/buzz" || exit 1

DATE=`date +%Y-%m-%d_%H-%M-%S`
OUTFILE=$DATE.xml
mget -O $OUTFILE https://www.googleapis.com/buzz/v1/activities/104787602969620799839/@public
cp $OUTFILE 00atom.xml

BATCH=/srv/stage/blogch3/bin/
export TERM=dumb
cat 00atom.xml | php $BATCH/update_category.php

php $BATCH/make_sitemap.php -b http://blog.fuktommy.com/buzz/ \
    > /srv/www/blog.fuktommy.com/sitemap_buzz.txt
php $BATCH/make_sitemap.php -b http://mobile.fuktommy.com/blog/buzz/ \
    > /srv/www/mobile.fuktommy.com/sitemap_buzz.txt
