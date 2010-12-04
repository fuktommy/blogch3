<?php
/* ファイルアップロード
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

require_once 'bootstrap.php';
require_once 'blogconfig.php';


/**
 * 振り分けアクション。
 * @package Blog
 */
class Blog_Action_UploadDispatcher implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        if ($context->get('get', 'files')) {
            $action = new Blog_Action_Upload();
        } else {
            $action = new Blog_Action_UploadForm();
        }
        $action->execute($context);
    }
}


/**
 * 設定ページの表示
 * @package Blog
 */
class Blog_Action_UploadForm implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        $smarty = $context->getSmarty();
        $smarty->assign($context->config);
        $smarty->display('upload_html.tpl');
    }
}


/**
 * アップロードファイルの受け付け。
 * @package Blog
 */
class Blog_Action_Upload implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        // サーバ上の現在の名前
        $tmpName = $context->files['file']['tmp_name'];

        // もともとの名前
        $origName = $context->files['file']['name'];

        if (preg_match("/([-_0-9A-Za-z][-_.0-9A-Za-z]*)$/", $origName, $match)) {
            $origName = $match[0];
        } else {
            $origName = sprintf('%d.txt', time());
        }
        $dstPath = sprintf('%s/%s', $context->config['upload_dir'], $origName);
        move_uploaded_file($tmpName, $dstPath);
        chmod($dstPath, 0644);

        $next = new Blog_Action_UploadForm();
        $next->execute($context);
    }
}


$context = Web_Context::factory($config);
if ($context->get('server', 'SCRIPT_FILENAME') === __FILE__) {
    Blog_Controller::factory()->run(new Blog_Action_UploadDispatcher(), $context);
}
