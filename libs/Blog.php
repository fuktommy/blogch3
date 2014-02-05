<?php
/* ブログのデータ
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

/**
 * ブログのデータの抽象化。
 * @package Blog
 */
class Blog
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $dataDir;

    /**
     * コンストラクタ
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->dataDir = $this->config['data_dir'];
    }

    /**
     * 月の一覧
     * @return Blog_Index    月の一覧
     */
    public function getIndex()
    {
        $index = new Blog_Index($this->config);
        $index->load();
        return $index;
    }

    /**
     * 月に含まれる記事の一覧
     * @param string $month     年と月(YYYY-MM)
     * @return Blog_Month       月に含まれる記事の一覧
     */
    public function getMonth($month)
    {
        $instance = new Blog_Month($this->config, $month);
        $instance->load();
        return $instance;
    }

    /**
     * 記事
     * @param string    $id     記事のID
     * @param string    $title  記事のタイトル(任意)
     * @param string    $body   記事の本文(任意)
     * @return Blog_Entry       記事
     */
    public function getEntry($id, $title = '', $body = '')
    {
        $entry = new Blog_Entry($this->config, $id, $title, $body);
        if (! ($title && $body)) {
            $entry->load();
        }
        return $entry;
    }

    /**
     * 最新の記事
     * @return array    最新の記事の配列
     */
    public function getRecentEntries()
    {
        $path = sprintf('%s/new.txt', $this->dataDir);
        if (! file_exists($path)) {
            return [];
        }
        $ids = explode("\n", file_get_contents($path));
        array_pop($ids);
        $entries = array();
        foreach ($ids as $id) {
            $entries[] = $this->getEntry($id);
        }
        return $entries;
    }

    /**
     * 最新の記事の更新
     * @param array $entries  最新の記事の配列
     */
    public function setRecentEntries($entries)
    {
        $path = sprintf('%s/new.txt', $this->dataDir);
        $ids = '';
        foreach ($entries as $entry) {
            $ids .= $entry->id . "\n";
        }
        file_put_contents($path, $ids);
    }
}
