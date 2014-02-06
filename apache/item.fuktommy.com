<VirtualHost *:80>
    ServerAdmin webmaster@fuktommy.com
    DocumentRoot /srv/www/item.fuktommy.com/app/htdocs
    ServerName item.fuktommy.com
    ErrorLog /var/log/apache2/item.fuktommy.com.error.log
    CustomLog /var/log/apache2/item.fuktommy.com.access.log combined

    <Directory "/srv/www/item.fuktommy.com/app/htdocs">
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
        RewriteRule ^([0-9]{4}-[0-9]{2})$ /?month=$1
        RewriteRule ^([0-9]+)$ /?entry=$1

        php_value include_path "/usr/share/php:/srv/lib/php:/usr/share/php/smarty/libs"
    </Directory>

    <Directory "/srv/www/item.fuktommy.com/app/htdocs/admin">
        Include /etc/apache2/acl.d/private
        AuthUserFile    /srv/passwd/item.fuktommy.com
        AuthGroupFile   /dev/null
        AuthName        "ItemAdmin"
        AuthType        Digest
        Require         valid-user
    </Directory>

    Alias /atom "/srv/www/item.fuktommy.com/contents/atom.xml"
    Alias /img "/srv/www/item.fuktommy.com/contents/img"
    Alias /rss "/srv/www/item.fuktommy.com/contents/rss.rdf"
    Alias /sitemap.txt "/srv/www/item.fuktommy.com/contents/sitemap.txt"
    <Directory "/srv/www/item.fuktommy.com/contents">
        Options -ExecCGI
        RemoveHandler .php
        <FilesMatch "\.ph(p3?|tml)$">
            SetHandler None
            ForceType text/plain
        </FilesMatch>
    </Directory>
</VirtualHost>
