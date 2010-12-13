#!/bin/sh -e

cd /srv/stage/blogch3

rsync -Cacv --delete \
    --exclude="- /img" \
    --exclude="- /atom.xml" \
    --exclude="- /rss.rdf" \
    --exclude="- /sitemap.txt" \
    --exclude="- /sitemap_buzz.txt" \
    htdocs/ /srv/www/blog.fuktommy.com/

rsync -Cacv --delete libs/ /srv/lib/php/blog.fuktommy.com/
rsync -Cacv --delete mobile/index.php /srv/www/mobile.fuktommy.com/blog/
rsync -Cacv --delete mobile/blog.php /srv/www/mobile.fuktommy.com/blog/
rsync -Cacv --delete mobile/buzz.php /srv/www/mobile.fuktommy.com/blog/
rsync -Cacv --delete plugins/ /srv/lib/php/plugins/
rsync -Cacv --delete templates/ /srv/templates/blog.fuktommy.com/
