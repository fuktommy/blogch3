<?php
/* 1ヶ月の記事一覧
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


/**
 * 1ヶ月の記事一覧
 * @package Blog
 */
class Blog_Month implements IteratorAggregate
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
     * @var string
     */
    public $months;

    /**
     * @var array
     */
    private $entries = array();

    /**
     * コンストラクタ
     * @param array $config
     * @param string $month  年と月(YYYY-MM)
     */
    public function __construct(array $config, $month)
    {
        $this->config = $config;
        $this->dataDir = $config['data_dir'];
        $this->month = $month;
        $this->entries = array();
    }

    /**
     * イテレータ
     * @return ArrayIterator    記事の一覧
     */
    public function getIterator()
    {
        return new ArrayIterator($this->entries);
    }

    /**
     * 記事の個数
     * @return  int     記事の個数
     */
    public function size()
    {
        return count($this->entries);
    }

    /**
     * 格納されるディレクトリ名
     * @return string       格納されるディレクトリ名
     */
    protected function dirname()
    {
        return sprintf('%s/%s', $this->dataDir, $this->month);
    }

    /**
     * 記事一覧のパス
     * @return string       記事一覧のパス
     */
    protected function path()
    {
        return sprintf('%s/index.csv', $this->dirname());
    }

    /**
     * その月が存在するか
     * @return bool     その月が存在するか
     */
    public function exists()
    {
        return is_file($this->path());
    }

    /**
     * 記事一覧を読み込む
     */
    public function load()
    {
        if (is_file($this->path())) {
            $f = fopen($this->path(), 'r');
            while (($row = fgetcsv($f)) !== false) {
                $this->append($row);
            }
            fclose($f);
        }
        usort($this->entries, array('Blog_Month', '_cmp_entries'));
    }

    /**
     * 記事の追加
     * @param array     $data   記事のIDとタイトル
     */
    public function append($data)
    {
        $this->entries[] = $data;
    }

    /**
     * 一覧の保存
     */
    public function sync()
    {
        if (! is_dir($this->dirname())) {
            mkdir($this->dirname());
        }
        $f = fopen($this->path(), 'wb');
        foreach ($this->entries as $entry) {
            fputcsv($f, $entry);
        }
        fclose($f);
    }

    /**
     * 一覧の削除
     */
    public function remove()
    {
        unlink($this->path());
        rmdir($this->dirname());
    }

    /**
     * 一覧の更新
     */
    public function update()
    {
        $blog = new Blog($this->config);
        $this->entries = array();
        $d = dir($this->dirname());
        while (($entry = $d->read()) !== false) {
            if (preg_match("/^(\d+)\.txt$/", $entry, $match)) {
                $id = $match[1];
                $entry = $blog->getEntry($id);
                $this->append(array($entry->id, $entry->title));
            }
        }
        $d->close();
        $this->sync();
    }

    /**
     * 記事のソートに用いる比較関数
     * @param array $a    記事のIDとタイトル
     * @param array $b    記事のIDとタイトル
     * @return int        大小
     */
    protected function _cmp_entries($a, $b)
    {
        if ($a[0] < $b[0]) {
            return 1;
        } elseif ($a[0] == $b[0]) {
            return 0;
        } else {
            return -1;
        }
    }
}
