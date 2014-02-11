<?php // -*- coding: utf-8 -*-
// Copyright (c) 2007-2014 Satoshi Fukutomi <info@fuktommy.com>.

// local variables
$appRoot = __DIR__ . '/..';
$baseUri = 'http://item.fuktommy.com/';

// global settings
setlocale(LC_ALL, 'en_US.UTF-8');
date_default_timezone_set('Asia/Tokyo');
ini_set('user_agent', 'User-Agent: http://fuktommy.com/'); 

// configration
return [
    'homepage'       => 'http://fuktommy.com/',
    'rssuri'         => "{$baseUri}rss",
    'atomuri'        => "{$baseUri}atom",
    'baseuri'        => $baseUri,
    'domain'         => 'fuktommy.com',
    'data_dir'       => "{$appRoot}/data",
    'ticket_file'    => "{$appRoot}/data/ticket.txt",

    'log_dir'        => "{$appRoot}/log",

    'blogtitle'      => 'Fuktommyがこんなの買いました',
    'rss_path'       => "{$appRoot}/contents/rss.rdf",
    'atom_path'      => "{$appRoot}/contents/atom.xml",
    'sitemap'        => "{$appRoot}/contents/sitemap.txt",
    'w3ctimezone'    => '+09:00',
    'description'    => '時系列が適当な日記です',
    'creator'        => 'Fuktommy',
    'rsssize'        => 15,
    'recentsize'     => 5,

    'smarty_template_dir' => "{$appRoot}/app/templates",
    'smarty_plugins_dir' => ["{$appRoot}/app/plugins"],
    'smarty_compile_dir' => "{$appRoot}/tmp/templates_c",
    'smarty_cache_dir' => "{$appRoot}/tmp/smarty_cache",
];
