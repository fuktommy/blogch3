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
 * エントリの表示
 * @package Blog
 */
class Blog_Action_Entry implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        // 記事のID
        $id = $context->get('get', 'entry');

        $blog = new Blog($context->config);
        $entry = $blog->getEntry($id);

        if (! $entry->exists()) {
            $this->_printNotFound($context, $id);
        } else {
            $this->_printEntry($context, $entry);
        }
    }

    private function _printNotFound(Web_Context $context, $id)
    {
        $context->vars['resource'] = $id;
        $notFound = new Blog_Action_NotFound();
        $notFound->execute($context);
    }

    private function _printEntry(Web_Context $context, $entry)
    {
        $smarty = $context->getSmarty();
        $smarty->assign($context->config);
        $smarty->assign('entry', $entry);
        $smarty->assign('pathname', $entry->id);
        $smarty->assign('entry_html_mode', true);
        $smarty->display('entry_html.tpl');
    }
}
