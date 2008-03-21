<?php
/* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. */

require_once('Smarty/Smarty.class.php');

class MySmarty extends Smarty
{
    public function __construct()
    {
        parent::Smarty();
        $this->template_dir  = '/srv/templates/blog.fuktommy.com';
        $this->plugins_dir[] = '/srv/lib/php/plugins';
        $this->compile_dir   = '/var/cache/smarty/templates_c/blog.fuktommy.com';
        $this->cache_dir     = '/var/cache/smarty/cache/blog.fuktommy.com';
    }
}

?>
