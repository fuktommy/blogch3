<?php
/* -*- coding: utf-8 -*- */
/* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. */

setlocale(LC_ALL, 'en_US.UTF-8');
date_default_timezone_set('Asia/Tokyo');
ini_set('user_agent', 'User-Agent: http://fuktommy.com/'); 

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
    'log_dir'        => '/var/local/log/blog',

    'blogtitle'      => '福冨諭の福冨論',
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

    'gplus_cache_dir' => '/var/local/cache/gplusfeed',

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

    'gplusfeed_default_userid' => '104787602969620799839', // Fuktommy

    'gplusfeed_userids' => array(
        '100234116023959363815',    // Shin Iwata
        '100890200991479840634',    // Tomoe Fukutomi
        '101341483406792705086',    // ssig33
        '101469377131638204516',    // Hiromi Ogata
        '102183698010783593298',    // 横田真俊
        '102354460982682319775',    // 赤井猫
        '104787602969620799839',    // Fuktommy
        '105684442055166146866',    // Hikaru Shimasaki
        '107002572043873162468',    // Masaki Yamada
        '108007043574812149024',    // 井原健紘
        '108378184626168830206',    // Spider job Kumowaza
        '110399375715564974173',    // ひろしにしざわ
        '110737960632793111269',    // Masafumi Otsune
        '112667774340108374584',    // hiroyuki yamanaka
        '114835769462966948273',    // skame
        '118232482862277429111',    // Satoshi Endo
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
