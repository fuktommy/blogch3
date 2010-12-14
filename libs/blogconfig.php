<?php
/* -*- coding: utf-8 -*- */
/* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. */

setlocale(LC_ALL, 'en_US.UTF-8');
date_default_timezone_set('Asia/Tokyo');

/**
 * 設定。
 * @return array    設定項目の連想配列
 */
$config = array(
    'homepage'       => 'http://fuktommy.com/',
    'mobileuri'      => 'http://mobile.fuktommy.com/blog/',
    'rssuri'         => 'http://blog.fuktommy.com/rss',
    'atomuri'        => 'http://blog.fuktommy.com/atom',
    'baseuri'        => 'http://blog.fuktommy.com/',
    'domain'         => 'fuktommy.com',
    'data_dir'       => '/srv/data/blog.fuktommy.com/data',
    'ticket_file'    => '/srv/data/blog.fuktommy.com/data/ticket.txt',

    'upload_dir'     => '/srv/www/blog.fuktommy.com/img',
    'adsense_dir'    => '/srv/saku/mobileads',

    'blogtitle'      => 'blog.fuktommy.com',
    'rss_path'       => '/srv/www/blog.fuktommy.com/rss.rdf',
    'atom_path'      => '/srv/www/blog.fuktommy.com/atom.xml',
    'sitemap'        => '/srv/www/blog.fuktommy.com/sitemap.txt',
    'mobile_sitemap' => '/srv/www/mobile.fuktommy.com/blogsitemap.txt',
    'w3ctimezone'    => '+09:00',
    'description'    => 'Fuktommyの日記',
    'creator'        => 'Fuktommy',
    'rsssize'        => 15,
    'recentsize'     => 5,

    'buzz_atom_path' => '/srv/data/blog.fuktommy.com/buzz/00atom.xml',

    'mobile_baseuri' => 'http://mobile.fuktommy.com/blog/',

    'smarty_template_dir' => '/srv/templates/blog.fuktommy.com',
    'smarty_plugins_dir' => array('/srv/lib/php/plugins'),
    'smarty_compile_dir' => '/var/cache/smarty/templates_c/blog.fuktommy.com',
    'smarty_cache_dir' => '/var/cache/smarty/cache/blog.fuktommy.com',

    'category' => array(
        'all' => array(
            'class' => 'All',
            'path' => '/srv/data/blog.fuktommy.com/category/all.db',
            'table' => 'entries',
        ),
        'article' => array(
            'class' => 'Article',
            'path' => '/srv/data/blog.fuktommy.com/category/article.db',
            'table' => 'entries',
        ),
        'tanuki' => array(
            'class' => 'Tanuki',
            'path' => '/srv/data/blog.fuktommy.com/category/tanuki.db',
            'table' => 'entries',
        ),
    ),
);


/**
 * 設定。
 * @return array    設定項目の連想配列
 */
function blogconfig()
{
    return $GLOBALS['config'];
}
