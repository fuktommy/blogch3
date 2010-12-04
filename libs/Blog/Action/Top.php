<?php
/* Blogch3.
 * とてもシンプルなブログツール。
 *
 * Copyright (c) 2007,2010 Satoshi Fukutomi <info@fuktommy.com>.
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

/**
 * トップページの表示
 * @package Blog
 */
class Blog_Action_Top implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        $blog = new Blog($context->config);
        $index = $blog->getIndex();
        $smarty = $context->getSmarty();
        $smarty->assign($context->config);
        $smarty->assign('index', $index);
        $smarty->assign('entry_html_mode', false);

        if ($context->get('vars', 'mobile')) {
            $smarty->assign('ua', $context->get('vars', 'ua'));
            $smarty->display('mobile_top_html.tpl');
        } else {
            $smarty->assign('entries', $blog->getRecentEntries());
            $smarty->display('top_html.tpl');
        }
    }
}
