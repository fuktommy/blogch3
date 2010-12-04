<?php
/* モバイル版
 *
 * Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>.
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
require_once('MySmarty.class.php');

if (array_key_exists('month', $_REQUEST)) {
    print_month_html($_REQUEST['month']);
} elseif (array_key_exists('entry', $_REQUEST)) {
    print_entry_html(intval($_REQUEST['entry']));
} else {
    print_top_html();
}
exit(0);


/**
 * 404 Not Found
 * @param string $resource  見つからならかったファイル
 */
function print_not_found_html($resource)
{
    header("HTTP/1.0 404 Not Found", true, 404);
    $smarty = new MySmarty();
    $smarty->assign(blogconfig());
    $smarty->assign('resource', $resource);
    $smarty->display('mobile_not_found_html.tpl');
}

/**
 * HTTPヘッダの出力
 * @return array    UserAgentの性質
 */
function print_http_header()
{
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match("/DoCoMo\/2\.0/", $ua)) {
        header('Content-Type: application/xhtml+xml; charset=UTF-8');
        return array('xhtml' => true, 'encoding' => 'UTF-8', 'ads' => 'google');
    } elseif (preg_match("/DoCoMo\/1\.0/", $ua)) {
        mb_http_output('sjis-win');
        mb_internal_encoding('UTF-8');
        ob_start('mb_output_handler');
        header('Content-Type: text/html; charset=Shift_JIS');
        return array('xhtml' => false, 'encoding' => 'Shift_JIS', 'ads' => null);
    } else {
        header('Content-Type: text/html; charset=UTF-8');
        return array('xhtml' => true, 'encoding' => 'UTF-8', 'ads' => 'google');
    }
}

/**
  * トップページの表示
  */
function print_top_html()
{
    $blog = new Blog();
    $index = $blog->getIndex();
    $ua = print_http_header();
    $smarty = new MySmarty();
    $smarty->assign(blogconfig());
    $smarty->assign('ua', $ua);
    $smarty->assign('index', $index);
    $smarty->display('mobile_top_html.tpl');
}

/**
 * 月のエントリ一覧の表示
 * @param string    $month      年と月(YYYY-MM)
 */
function print_month_html($month)
{
    $blog = new Blog();
    $entries = $blog->getMonth($month);
    $ua = print_http_header();
    if ($entries->exists()) {
        $smarty = new MySmarty();
        $smarty->assign(blogconfig());
        $smarty->assign('ua', $ua);
        $smarty->assign('entries', $entries);
        $smarty->display('mobile_month_html.tpl');
    } else {
        print_not_found_html($month);
    }
}

/**
  * エントリの表示
  * @param int  $id     記事のID
  */
function print_entry_html($id)
{
    $blog = new Blog();
    $entry = $blog->getEntry($id);
    $ua = print_http_header();
    if ($entry->exists()) {
        $smarty = new MySmarty();
        $smarty->assign(blogconfig());
        $smarty->assign('ua', $ua);
        $smarty->assign('entry', $entry);
        $smarty->display('mobile_entry_html.tpl');
    } else {
        print_not_found_html($id);
    }
}

?>
