<?php
/* 記事の投稿
 *
 * Copyright (c) 2007,2008 Satoshi Fukutomi <info@fuktommy.com>.
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

require_once('MySmarty.class.php');
require_once('Blog.class.php');
require_once('OneTimePassword.class.php');
require_once('blogconfig.php');

$blog = new Blog();
$passwordTool = new OneTimePassword();
$config = blogconfig();
if ($_SERVER['QUERY_STRING']) {
    $entry = $blog->getEntry($_SERVER['QUERY_STRING']);
    if ($entry->exists()) {
        print_edit_html($entry);
    } else {
        print_edit_html();
    }
} elseif ((! isset($_REQUEST['ticket'])) || (! $passwordTool->verify($_REQUEST['ticket']))) {
    print_edit_html();
} elseif (isset($_REQUEST['data'])) {
    if (isset($_REQUEST['id']) && preg_match("/^\d+$/", $_REQUEST['id'])) {
        save_data($_REQUEST['id'], $_REQUEST['data']);
    } else {
        save_data('', $_REQUEST['data']);
    }
    header('Location: ' . $config['baseuri']);
} else {
    print_edit_html();
}
exit(0);


/**
  * 設定ページの表示
  * @param Entry    $entry  記事(任意)
  */
function print_edit_html($entry = null)
{
    $config = blogconfig();
    $passwordTool = new OneTimePassword();
    $smarty = new MySmarty();
    $smarty->assign($config);
    $smarty->assign('entry', $entry);
    $smarty->assign('ticket', $passwordTool->generate());
    $smarty->display('edit_html.tpl');
}

/**
 * 記事の保存
 * @param int       $id     記事のID。''の場合は現在時刻で置き換える
 * @param string    $data   記事のタイトルと本文。1行目がタイトル
 */
function save_data($id, $data)
{
    if (! $id) {
        $id = time();
    }
    $blog = new Blog();
    $entry = $blog->getEntry($id);
    $month = $blog->getMonth($entry->month());
    if ((! $data) && $entry->exists()) {
        $entry->remove();
        $month->update();
        if ($month->size() == 0) {
            $month->remove();
        }
    } else {
        $lines = preg_split("/\n/", $data);
        $entry->title = trim(array_shift($lines));
        $entry->body  = trim(implode('', $lines)) . "\n";
        $entry->sync();
        $month->update();
    }
    update_recent();
    update_sitemap();
}

/**
 * 記事のソートに用いる比較関数
 * @param Entry $a    記事
 * @param Entry $b    記事
 * @return int        大小
 */
function cmp_entries($a, $b)
{
    if ($a->id < $b->id) {
        return 1;
    } elseif ($a->id == $b->id) {
        return 0;
    } else {
        return -1;
    }
}

/**
 * 最新の記事とRSSの更新
 */
function update_recent()
{
    $config = blogconfig();
    $blog = new Blog();
    $entries = array();
    foreach ($blog->getIndex() as $m) {
        foreach ($blog->getMonth($m) as $row) {
            $entries[] = $blog->getEntry($row[0]);
            if ($config['rsssize'] < count($entries)) {
                break;
            }
        }
        if ($config['rsssize'] < count($entries)) {
            break;
        }
    }
    usort($entries, 'cmp_entries');
    $blog->setRecentEntries(array_slice($entries, 0, $config['recentsize']));

    // RSS の更新
    $smarty = new MySmarty();
    $smarty->assign($config);
    $smarty->assign('entries', $entries);
    ob_start();
    $smarty->display('rss1.tpl');
    file_put_contents($config['rss_path'], ob_get_contents());
    ob_end_clean();
}

/**
 * サイトマップの更新
 */
function update_sitemap()
{
    $config = blogconfig();
    $blog = new Blog();
    $f = fopen($config['sitemap'], 'wb');
    $mf = fopen($config['mobile_sitemap'], 'wb');
    fwrite($f, $config['baseuri'] . "\n");
    fwrite($mf, $config['mobile_baseuri'] . "\n");
    foreach ($blog->getIndex() as $m) {
        foreach ($blog->getMonth($m) as $row) {
            fprintf($f, "%s%d\n", $config['baseuri'], $row[0]);
            fprintf($mf, "%s%d\n", $config['mobile_baseuri'], $row[0]);
        }
    }
    fclose($f);
    fclose($mf);
}

?>
