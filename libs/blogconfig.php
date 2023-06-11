<?php
/* -*- coding: utf-8 -*- */
/* Copyright (c) 2007-2022 Satoshi Fukutomi <info@fuktommy.com>. */

setlocale(LC_ALL, 'en_US.UTF-8');
date_default_timezone_set('Asia/Tokyo');
ini_set('user_agent', 'User-Agent: https://fuktommy.com/'); 

/**
 * 設定。
 * @return array    設定項目の連想配列
 */
$config = array(
    'homepage'       => 'https://fuktommy.com/',
    'rssuri'         => 'https://blog.fuktommy.com/rss',
    'atomuri'        => 'https://blog.fuktommy.com/atom',
    'baseuri'        => 'https://blog.fuktommy.com/',
    'domain'         => 'fuktommy.com',
    'data_dir'       => '/srv/data/blog.fuktommy.com/data',
    'ticket_file'    => '/srv/data/blog.fuktommy.com/data/ticket.txt',

    'upload_dir'     => '/srv/www/blog.fuktommy.com/img',
    'log_dir'        => '/var/local/log/blog',

    'blogtitle'      => 'blog.fuktommy.com',
    'rss_path'       => '/srv/www/blog.fuktommy.com/rss.rdf',
    'atom_path'      => '/srv/www/blog.fuktommy.com/atom.xml',
    'sitemap'        => '/srv/www/blog.fuktommy.com/sitemap.txt',
    'w3ctimezone'    => '+09:00',
    'description'    => 'Fuktommyの日記',
    'creator'        => 'Fuktommy',
    'rsssize'        => 15,
    'recentsize'     => 5,

    'buzz_atom_path' => '/srv/data/blog.fuktommy.com/buzz/00atom.xml',

    'smarty_template_dir' => '/srv/templates/blog.fuktommy.com',
    'smarty_plugins_dir' => array('/srv/lib/php/plugins'),
    'smarty_compile_dir' => '/var/cache/smarty/templates_c/blog.fuktommy.com',
    'smarty_cache_dir' => '/var/cache/smarty/cache/blog.fuktommy.com',

    'category' => array(
        'all' => array(
            'rule' => 'Category_Rule_All',
            'path' => '/srv/data/blog.fuktommy.com/category/all.db',
            'table' => 'entries',
        ),
        'article' => array(
            'rule' => 'Category_Rule_Article',
            'path' => '/srv/data/blog.fuktommy.com/category/article.db',
            'table' => 'entries',
        ),
        'tanuki' => array(
            'rule' => 'Category_Rule_Tanuki',
            'path' => '/srv/data/blog.fuktommy.com/category/tanuki.db',
            'table' => 'entries',
        ),
        'photo' => array(
            'rule' => 'Category_Rule_Photo',
            'path' => '/srv/data/blog.fuktommy.com/category/photo.db',
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
