<?php
/* モバイル版
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
 * 携帯端末向けの表示オプションを作る
 * @return array UserAgentの性質
 */
function getMobileAgentOptions(Web_Context $context)
{
    $ua = $context->get('server', 'HTTP_USER_AGENT');
    if (preg_match('|^DoCoMo/2[.]0|', $ua)) {
        return array(
            'content' => 'application/xhtml+xml',
            'xhtml' => true,
            'encoding' => 'UTF-8',
            'ads' => 'google',
        );
    } elseif (preg_match('|^DoCoMo/1[.]0|', $ua)) {
        return array(
            'content' => 'text/html',
            'xhtml' => false,
            'encoding' => 'Shift_JIS',
            'ads' => null,
        );
    } else {
        return array(
            'content' => 'text/html',
            'xhtml' => true,
            'encoding' => 'UTF-8',
            'ads' => 'google',
        );
    }
}


/**
 * 携帯電話向けのヘッダーを出力する。
 * @package Blog
 */
class Blog_Action_MobileHeader implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     *              $context->vars['ua'] に携帯電話の表示オプションを入れる。
     */
    public function execute(Web_Context $context)
    {
        $ua = $context->get('vars', 'ua');
        $contentType = sprintf('%s; charset=%s',
                               $ua['content'], $ua['encoding']);
        $context->putHeader('Content-Type', $contentType);
        if ($ua['encoding'] === 'Shift_JIS') {
            $context->switchEncoding('sjis-win');
        }
    }
}


/**
 * モバイル用の振り分けアクション。
 * @package Blog
 */
class Blog_Action_MobileDispatch implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        $context->vars['mobile'] = true;
        $context->vars['ua'] = getMobileAgentOptions($context);

        $headerAction = new Blog_Action_MobileHeader();
        $headerAction->execute($context);

        $dispatchAction = new Blog_Action_Dispatch();
        $dispatchAction->execute($context);
    }
}


$context = Web_Context::factory($config);
if ($context->get('server', 'SCRIPT_FILENAME') === __FILE__) {
    Blog_Controller::factory()->run(new Blog_Action_MobileDispatch(), $context);
}
