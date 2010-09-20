<VirtualHost *>
    ServerAdmin webmaster@fuktommy.com
    DocumentRoot /srv/www/blog.fuktommy.com
    ServerName blog.fuktommy.com
    ErrorLog /var/log/httpd/blog.fuktommy.com.error.log
    CustomLog /var/log/httpd/blog.fuktommy.com.access.log combined

    <Directory "/srv/www/blog.fuktommy.com">
        RemoveHandler .sh .pl .py
        AddType text/plain sh pl py doc
        AddType text/xml;charset=UTF-8   rdf
        AddType text/xml;charset=UTF-8   xml
        AddEncoding bzip2 bz2

        Options Indexes Multiviews -ExecCGI SymLinksIfOwnerMatch
        DirectoryIndex index
        MultiviewsMatch Handlers

        AllowOverride None

        RewriteEngine on
        RewriteRule ^([0-9]{4}-[0-9]{2})$ /?month=$1
        RewriteRule ^([0-9]+)$ /?entry=$1
        RewriteRule ^xml/rss http://blog.fuktommy.com/rss [R=301,L]

        php_value include_path "/usr/share/php:/srv/lib/php:/srv/lib/php/blog.fuktommy.com:/srv/lib/php/blog.fuktommy.com/buzz"
    </Directory>

    <Directory "/srv/www/blog.fuktommy.com/admin">
        AuthUserFile    /srv/passwd/blog.fuktommy.com
        AuthGroupFile   /dev/null
        AuthName        "BlogAdmin"
        AuthType        Digest
        Require         valid-user

        Order Deny,Allow
        Deny from All
        Allow from 192.168.2.1
        Allow from .example.com
    </Directory>

    <Directory "/srv/www/blog.fuktommy.com/img">
        Options -ExecCGI
    </Directory>
</VirtualHost>
