#!/bin/sh -e

alias mget='wget -q --random-wait --header="Accept-Language: ja; q=1.0, en;q=0.5" -U "Buzz-Reader/2010-04-26" -w 2 -t 10 -T 20'

cd "/srv/data/blog.fuktommy.com/buzz" || exit 1

DATE=`date +%Y-%m-%d_%H-%M-%S`
OUTFILE=$DATE.xml
mget -O $OUTFILE http://buzz.googleapis.com/feeds/104787602969620799839/public/posted
cp $OUTFILE 00atom.xml

export TERM=dumb
cat 00atom.xml | sudo -u apache php /srv/stage/blogch3/bin/update_category.php
