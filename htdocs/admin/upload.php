<?php
/* ファイルアップロード
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

require_once('MySmarty.class.php');
require_once('blogconfig.php');

if (isset($_FILES['file'])) {
    save_file($_FILES['file']['tmp_name'], $_FILES['file']['name']);
}
print_upload_html();
exit(0);


/**
  * 設定ページの表示
  */
function print_upload_html()
{
    $config = blogconfig();
    $smarty = new MySmarty();
    $smarty->assign(blogconfig());
    $smarty->display('upload_html.tpl');
}

/**
  * ファイルの保存
  * @param string   $tmp_name     サーバ上の現在の名前
  * @param string   $orig_name    もともとの名前
  */
function save_file($tmp_name, $orig_name)
{
    $config = blogconfig();
    if (preg_match("/([-_0-9A-Za-z][-_.0-9A-Za-z]*)$/", $orig_name, $match)) {
        $orig_name = $match[0];
    } else {
        $orig_name = sprintf('%d.txt', time());
    }
    $dst_path = sprintf('%s/%s', $config['upload_dir'], $orig_name);
    move_uploaded_file($tmp_name, $dst_path);
    chmod($dst_path, 0644);
}

?>
