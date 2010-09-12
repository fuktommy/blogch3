<?php
/* カテゴリ「タヌキ」
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

require_once 'Category/Tanuki.php';
require_once 'MySmarty.class.php';
require_once 'blogconfig.php';

$config = blogconfig();
$db = new PDO('sqlite:' . $config['category_tanuki_path']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$xml = simplexml_load_file($config['buzz_atom_path']);

$tanuki = new Category_Tanuki($db, $xml);

$page = 0;
if (preg_match('|^/p(\d+)|', @$_SERVER['PATH_INFO'], $matches)) {
    $page = (int)$matches[1];
}

$buzz = new StdClass();
$buzz->entry = $tanuki->select($page * 50, 50);

$smarty = new MySmarty();
$smarty->assign($config);
$smarty->assign('buzz', $buzz);
$smarty->assign('xmlns_media', 'http://search.yahoo.com/mrss/');
$smarty->assign('category_id', 'tanuki');
$smarty->assign('category_name', 'タヌキ');
$smarty->assign('page', $page);
$smarty->display('buzz_top.tpl');
