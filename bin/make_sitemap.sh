#!/bin/sh -e

BATCH=/srv/stage/blogch3/bin/
export TERM=dumb

php $BATCH/make_sitemap.php -b https://blog.fuktommy.com/buzz/ \
    > /srv/www/blog.fuktommy.com/sitemap_buzz.txt
