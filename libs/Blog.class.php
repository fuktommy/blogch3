<?php
/* ブログのデータ
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
require_once('Entry.class.php');
require_once('Month.class.php');
require_once('Index.class.php');

class Blog
{
    /**
     * コンストラクタ
     */
    public function Blog()
    {
        $this->config   = blogconfig();
        $this->data_dir = $this->config['data_dir'];
    }

    /**
     * 月の一覧
     * @return Index    月の一覧
     */
    public function getIndex()
    {
        return new Index();
    }

    /**
     * 月に含まれる記事の一覧
     * @param string $month     年と月(YYYY-MM)
     * @return Month            月に含まれる記事の一覧
     */
    public function getMonth($month)
    {
        return new Month($month);
    }

    /**
     * 記事
     * @param string    $id     記事のID
     * @return Entry            記事
     */
    public function getEntry($id)
    {
        return new Entry($id);
    }

    /**
     * 最新の記事
     * @return array    最新の記事の配列
     */
    public function getRecentEntries()
    {
        $path = sprintf('%s/new.txt', $this->data_dir);
        $ids = explode("\n", file_get_contents($path));
        array_pop($ids);
        $entries = array();
        foreach ($ids as $id) {
            $entries[] = new Entry($id);
        }
        return $entries;
    }

    /**
     * 最新の記事の更新
     * @param array $entries  最新の記事の配列
     */
    public function setRecentEntries($entries)
    {
        $path = sprintf('%s/new.txt', $this->data_dir);
        $ids = '';
        foreach ($entries as $entry) {
            $ids .= $entry->id . "\n";
        }
        file_put_contents($path, $ids);
    }
}

?>
