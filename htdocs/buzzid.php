<?php
/* バズの誤ったURL指定に対応する。
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
/* バズの誤ったURL指定に対応する。
 * @package Blog
 */
class Blog_Action_BuzzId implements Blog_Action
{
    /**
     * 実行。
     * @param Web_Context $context
     */
    public function execute(Web_Context $context)
    {
        $factory = new Category_Factory();
        $category = $factory->getStorage($context->config['category']['all']);

        $id = $context->get('get', 'id');
        if (! preg_match('|^tag:google.com,\d+|', $id)) {
            $context->putHeader('HTTP/1.0 404 Not Found');
            return;
        }

        $buzz = new StdClass();
        $buzz->entry = $this->_getEntryById($category, $id);

        if (! $buzz->entry) {
            $context->putHeader('HTTP/1.0 404 Not Found');
        }

        $smarty = $context->getSmarty();
        $smarty->assign($context->config);
        $smarty->assign('buzz', $buzz);
        $smarty->display('buzz_entry_html.tpl');
    }

    private function _getEntryById(Category_Storage $category, $id)
    {
        $entry = $category->getEntryById($id);
        if ($entry) {
            return $entry;
        }

        $id2 = str_replace('tag:google.com,2009:buzz', 'tag:google.com,2010:buzz', $id);
        return $category->getEntryById($id2);
    }
}

$context = Web_Context::factory($config);
if ($context->get('server', 'SCRIPT_FILENAME') === __FILE__) {
    Blog_Controller::factory()->run(new Blog_Action_BuzzId(), $context);
}
