<?php
/* Google+ のフィード
 *
 * Copyright (c) 2011 Satoshi Fukutomi <info@fuktommy.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHORS AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHORS OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 */

require_once 'bootstrap.php';
require_once 'blogconfig.php';


/**
 * バズ全体表示。
 * @package Blog
 */
class Blog_Action_GplusFeed implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        $allowedUserIds = $context->config['gplusfeed_userids'];
        if (! array_key_exists('PATH_INFO', $context->server)) {
            // Fuktommy
            $userId = $context->config['gplusfeed_default_userid'];
        } else {
            $userId = substr($context->server['PATH_INFO'], 1);
        }
        if ((! is_numeric($userId)) || (! in_array($userId, $allowedUserIds))) {
            $context->putHeader('HTTP/1.0 404 Not Found');
            $context->putHeader('Content-Type', 'text/html; charset=utf-8');
            $smarty = $context->getSmarty();
            $smarty->assign($context->config);
            $smarty->display('gplusfeed_top.tpl');
            return;
        }

        $options = array(
            'cacheDir' => $context->config['gplus_cache_dir'],
            'log' => $context->getLog('gplusfeed'),
        );
        $feedFetcher = new GplusJsonFeed($options);
        $feed = $feedFetcher->getFeed($userId);

        if ($context->get('get', 'debug')) {
            $context->putHeader('Content-Type', 'text/plain; charset=utf-8');
            var_dump($feed);
            return;
        }

        $context->putHeader('Content-Type', 'text/xml; charset=utf-8');
        $smarty = $context->getSmarty();
        $smarty->assign($context->config);
        $smarty->assign('feed', $feed);
        $smarty->display('gplusfeed_atom.tpl');
    }
}


$context = Web_Context::factory($config);
if ($context->get('server', 'SCRIPT_FILENAME') === __FILE__) {
    Blog_Controller::factory()->run(new Blog_Action_GplusFeed(), $context);
}
