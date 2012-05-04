<VirtualHost *:80>
    ServerAdmin webmaster@fuktommy.com
    DocumentRoot /srv/www/blog.fuktommy.com
    ServerName blog.fuktommy.com
    ErrorLog /var/log/apache2/blog.fuktommy.com.error.log
    CustomLog /var/log/apache2/blog.fuktommy.com.access.log combined

    <Directory "/srv/www/blog.fuktommy.com">
        RemoveHandler .sh .pl .py
        AddHandler php5-script .php
        AddType text/plain sh pl py doc
        AddType text/xml;charset=UTF-8   rdf
        AddType text/xml;charset=UTF-8   xml
        AddType text/html php
        AddEncoding bzip2 bz2

        Options Indexes Multiviews -ExecCGI SymLinksIfOwnerMatch
        DirectoryIndex index
        MultiviewsMatch Handlers

        AllowOverride None

        RewriteEngine on
        RewriteRule ^([0-9]{4}-[0-9]{2})$ /blog?month=$1
        RewriteRule ^([0-9]+)$ /blog?entry=$1
        RewriteRule ^(tag:google.com,.*) /buzzid?id=$1
        RewriteRule ^rss http://feeds.feedburner.com/fuktommy [R,L]
        RewriteRule ^xml/rss http://feeds.feedburner.com/fuktommy [R,L]
        RewriteRule ^urllist.txt$ /sitemap_buzz.txt
        RewriteRule ^gplusfeed$ http://gpf.fuktommy.com/ [R=301,L]
        RewriteRule ^gplusfeed/([0-9]+)$ http://gpf.fuktommy.com/$1 [R=301,L]

        RewriteCond %{HTTP_USER_AGENT} ^livedoor [OR]
        RewriteCond %{HTTP_USER_AGENT} ^HanRSS [OR]
        RewriteCond %{HTTP_USER_AGENT} ^MagpieRSS [OR]
        RewriteCond %{HTTP_USER_AGENT} ^blogmuraBot [OR]
        RewriteCond %{HTTP_USER_AGENT} ^Bloglines [OR]
        RewriteCond %{HTTP_USER_AGENT} ^Voyager [OR]
        RewriteCond %{HTTP_USER_AGENT} ^Plagger [OR]
        RewriteCond %{HTTP_USER_AGENT} ^FreshReader
        RewriteRule ^atom http://feeds.feedburner.com/fuktommy [R,L]

        php_value include_path "/usr/share/php:/srv/lib/php:/usr/share/php/smarty/libs:/srv/lib/php/blog.fuktommy.com"
    </Directory>

    <Directory "/srv/www/blog.fuktommy.com/admin">
        Include /etc/apache2/acl.d/private
        AuthUserFile    /srv/passwd/blog.fuktommy.com
        AuthGroupFile   /dev/null
        AuthName        "BlogAdmin"
        AuthType        Digest
        Require         valid-user
    </Directory>

    <Directory "/srv/www/blog.fuktommy.com/img">
        Options -ExecCGI
        RemoveHandler .php
    </Directory>

    <Location "/push_subscriber.php">
        Allow from All
    </Location>
</VirtualHost>
