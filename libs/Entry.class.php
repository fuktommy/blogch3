<?php
/* ブログの1記事
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
require_once('blogconfig.php');

$config = blogconfig();

class Entry
{
    /**
     * コンストラクタ
     * @param int       $id     記事のID
     * @param string    $title  記事のタイトル(任意)
     * @param string    $body   記事の本文(任意)
     */
    public function Entry($id, $title = '', $body = '')
    {
        $this->config   = blogconfig();
        $this->data_dir = $this->config['data_dir'];
        $this->id    = $id;
        $this->title = $title;
        $this->body  = $body;
        if (! ($title && $body)) {
            $this->load();
        }
    }

    /**
     * その記事が存在するかどうか
     * @return bool     その記事が存在するかどうか
     */
    public function exists()
    {
        return is_file($this->path());
    }

    /**
     * 記事からファイルパスへの変換
     * @return string   ファイルのパス
     */
    protected function path()
    {
        return sprintf('%s/%d.txt', $this->dirname(), $this->id);
    }

    /**
     * 記事がどのディレクトリに含まれるか
     * @return string   ディレクトリ名
     */
    protected function dirname()
    {
        return sprintf('%s/%s', $this->data_dir, $this->month());
    }

    /**
     * 記事が何年何月か
     * @return string   年と月(YYYY-MM)
     */
    public function month()
    {
        return date('Y-m', $this->id);
    }

    /**
     * 記事の読み込み
     */
    public function load()
    {
        if ($this->exists()) {
            $data = file($this->path());
            $this->title = trim(array_shift($data));
            $this->body  = trim(implode('', $data));
        }
    }

    /**
     * 記事の保存
     */
    public function sync()
    {
        if (! is_dir($this->dirname())) {
            mkdir($this->dirname());
        }
        file_put_contents($this->path(), $this->title . "\n" . $this->body);
    }

    /**
     * 記事の削除
     */
    public function remove()
    {
        unlink($this->path());
    }
}

?>
