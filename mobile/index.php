<?php
/* モバイル用Buzz整形表示。
 *
 * Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>.
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
 * モバイル用Buzz整形表示。
 * @package Blog
 */
class Blog_Action_MobileIndex implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        $factory = new Category_Factory();
        $category = $factory->getCategory($context->config['category']['all']);

        $page = (int)$context->get('get', 'page');

        $buzz = new StdClass();
        $buzz->entry = $category->select($page * 30, 30);

        $mobileUtls = new Blog_MobileUtils();
        $context->vars['mobile'] = true;
        $context->vars['ua'] = $mobileUtls->getMobileAgentOptions($context);

        $headerAction = new Blog_Action_MobileHeader();
        $headerAction->execute($context);

        $smarty = $context->getSmarty();
        $smarty->assign($context->config);
        $smarty->assign('ua', $context->vars['ua']);
        $smarty->assign('buzz', $buzz);
        $smarty->assign('page', $page);
        $smarty->assign('title', $context->config['blogtitle']);
        $smarty->display('mobile_buzz.tpl');
    }
}


$context = Web_Context::factory($config);
if ($context->get('server', 'SCRIPT_FILENAME') === __FILE__) {
    Blog_Controller::factory()->run(new Blog_Action_MobileIndex(), $context);
}
