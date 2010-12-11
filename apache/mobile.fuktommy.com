<VirtualHost *>
    ServerAdmin webmaster@fuktommy.com
    DocumentRoot /srv/www/mobile.fuktommy.com
    ServerName mobile.fuktommy.com
    ErrorLog /var/log/httpd/mobile.fuktommy.com.error.log
    CustomLog /var/log/httpd/mobile.fuktommy.com.access.log combined

    <Directory "/srv/www/mobile.fuktommy.com">
        AddCharset Shift_JIS .html
	AddType text/xml .rdf

        Options Multiviews ExecCGI FollowSymLinks
        AllowOverride None
        MultiviewsMatch Handlers
        DirectoryIndex index

        RewriteEngine on
        RewriteCond %{HTTP_USER_AGENT} DoCoMo/2.0
        RewriteCond %{LA-F:REQUEST_FILENAME} \.html
        RewriteRule .* - "[T=application/xhtml+xml; charset=shift_jis]"
    </Directory>

    <Directory "/srv/www/mobile.fuktommy.com/blog">
        AddHandler php5-script .php
        RewriteEngine on
        RewriteRule ^([0-9]{4}-[0-9]{2})$ /blog/blog.php?month=$1
        RewriteRule ^([0-9]+)$ /blog/blog.php?entry=$1

        php_value include_path "/usr/share/php:/srv/lib/php:/srv/lib/php/blog.fuktommy.com:/srv/lib/php/blog.fuktommy.com/buzz"
    </Directory>
</VirtualHost>
