blogch3
=======

* Author(s):
    * (main) Satoshi Fukutomi <info@fuktommy.com>
* WebSite:
    * http://item.fuktommy.com/

blogch3 is a simple blog system
includes PubSubHubbub subscriver.

Install
-------

1. Install PHP5 and Smarty.
2. Modify setup.sh and run it.
3. Modify mode of /srv/www/item.fuktommy.com/data
4. Modify libs/blogconfig.php
5. Modify css and templates. Default template has ads for Fuktommy.

Blog Editor
-----------
1. Use admin/edit.php and write HTML.
2. First line of textarea become h2 element.
3. To edit entry, access /acmin/edit?{timestamp}. ex: /admin/edit?12345
4. Empty HTML delete the entry.

Acknowledgement
---------------
* XLST
    * http://sonic64.com/2005-03-16.html
* Google Blog Search
    * http://blogsearch.google.com/
* RSS icon
    * http://www.mozilla.org/
    * http://feedicons.com/
