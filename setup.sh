#!/bin/sh -e

cd `dirname $0`

rsync -Cacv --delete \
    --exclude="- /img" \
    --exclude="- /atom.xml" \
    --exclude="- /rss.rdf" \
    --exclude="- /sitemap.txt" \
    --exclude="- /sitemap_buzz.txt" \
    htdocs/ /srv/www/blog.fuktommy.com/

rsync -Cacv --delete libs/ /srv/lib/php/blog.fuktommy.com/
rsync -Cacv --delete plugins/ /srv/lib/php/plugins/
rsync -Cacv --delete templates/ /srv/templates/blog.fuktommy.com/
