<?php
/* 記事の投稿
 *
 * Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>.
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
 * ページの振り分け
 * @package Blog
 */
class Blog_Action_EditDispatcher implements Blog_Action
{
    /**
     * 実行。
     */
    public function execute(Web_Context $context)
    {
        $blog = new Blog($context->config);
        if ($context->get('server', 'QUERY_STRING')) {
            $entry = $blog->getEntry($context->get('server', 'QUERY_STRING'));
            if ($entry->exists()) {
                $context->vars['entry'] = $entry;
                Blog_Action_EditForm::factory()->execute($context);
                return;
            }
        }

        if ((! $context->get('post', 'id')) && (! $context->get('post', 'data'))) {
            Blog_Action_EditForm::factory()->execute($context);
            return;
        }

        $passwordTool = new OneTimePassword($context->config['ticket_file']);
        if (! $passwordTool->verify($context->get('post', 'ticket'))) {
            Blog_Action_EditForm::factory()->execute($context);
            return;
        }

        $next = new Blog_Action_Edit();
        $next->execute($context);
    }
}


/**
 * 設定ページの表示
 * @package Blog
 */
class Blog_Action_EditForm implements Blog_Action
{
    /**
     * ファクトリ。
     * @return Blog_Action_EditForm
     */
    public static function factory()
    {
        return new self();
    }

    /**
     * 実行。
     * @param Web_Context $context $context->vars['entry']
     *                             に記事のオブジェクトを入れる。
     */
    public function execute(Web_Context $context)
    {
        $passwordTool = new OneTimePassword($context->config['ticket_file']);
        $smarty = $context->getSmarty();
        $smarty->assign($context->config);
        $smarty->assign('entry', $context->get('vars', 'entry'));
        $smarty->assign('ticket', $passwordTool->generate());
        $smarty->display('edit_html.tpl');
    }
}


/**
 * 記事の保存
 * @package Blog
 */
class Blog_Action_Edit implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        if (preg_match('/^\d+$/', $context->get('post', 'id'))) {
            $id = $context->get('post', 'id');
        } else {
            $id = '';
        }
        $updater = new Blog_Updater($context->config);
        $updater->update($id, $context->get('post', 'data'), $context->getSmarty());
        $context->putHeader('Location', $context->config['baseuri']);
    }
}


$context = Web_Context::factory($config);
if ($context->get('server', 'SCRIPT_FILENAME') === __FILE__) {
    Blog_Controller::factory()->run(new Blog_Action_EditDispatcher(), $context);
}
