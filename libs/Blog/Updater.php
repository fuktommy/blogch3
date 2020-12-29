<?php
/* 記事の更新。
 *
 * Copyright (c) 2007-2020 Satoshi Fukutomi <info@fuktommy.com>.
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

/**
 * 記事の更新。
 * @package Blog
 */
class Blog_Updater
{
    /**
     * @var array
     */
    private $config;

    /**
     * コンストラクタ。
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 更新の実行。
     * @param int $id 記事のID。''の場合は現在時刻で置き換える
     * @param string $data 記事のタイトルと本文。1行目がタイトル
     * @param Smarty $smarty
     */
    public function update($id, $data, Smarty $smarty)
    {
        if (! $id) {
            $id = time();
        }
        $blog = new Blog($this->config);
        $entry = $blog->getEntry($id);
        $month = $blog->getMonth($entry->month());
        if ((! $data) && $entry->exists()) {
            $this->_removeEntry($entry, $month);
        } else {
            $this->_updateEntry($entry, $month, $data);
        }
        $this->_updateRecent($smarty);
        $this->_updateSitemap();
    }

    private function _removeEntry(Blog_Entry $entry, Blog_Month $month)
    {
        $entry->remove();
        $month->update();
        if ($month->size() == 0) {
            $month->remove();
        }
    }

    private function _updateEntry(Blog_Entry $entry, Blog_Month $month, $data)
    {
        $lines = preg_split('/\n/', $data);
        $entry->title = trim(array_shift($lines));
        $entry->body  = trim(implode('', $lines)) . "\n";
        $entry->sync();
        $month->update();
    }

    /**
     * 記事のソートに用いる比較関数
     * @param Blog_Entry $a 記事
     * @param Blog_Entry $b 記事
     * @return int 大小
     */
    protected function _cmpEntries(Blog_Entry $a, Blog_Entry $b)
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
    private function _updateRecent(Smarty $smarty)
    {
        $blog = new Blog($this->config);
        $entries = array();
        foreach ($blog->getIndex() as $m) {
            foreach ($blog->getMonth($m) as $row) {
                $entries[] = $blog->getEntry($row[0]);
                if ($this->config['rsssize'] < count($entries)) {
                    break;
                }
            }
            if ($this->config['rsssize'] < count($entries)) {
                break;
            }
        }
        usort($entries, array($this, '_cmpEntries'));
        $blog->setRecentEntries(array_slice($entries, 0, $this->config['recentsize']));

        // RSS の更新
        $smarty->assign($this->config);
        $smarty->assign('entries', $entries);
        file_put_contents($this->config['rss_path'], $smarty->fetch('rss1.tpl'));
        file_put_contents($this->config['atom_path'], $smarty->fetch('atom.tpl'));
    }

    /**
     * サイトマップの更新
     */
    private function _updateSitemap()
    {
        $blog = new Blog($this->config);
        $f = fopen($this->config['sitemap'], 'wb');
        fwrite($f, $this->config['baseuri'] . "\n");
        foreach ($blog->getIndex() as $m) {
            foreach ($blog->getMonth($m) as $row) {
                fprintf($f, "%s%d\n", $this->config['baseuri'], $row[0]);
            }
        }
        fclose($f);
    }
}
