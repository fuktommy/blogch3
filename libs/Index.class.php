<?php
/* 月の一覧
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

class Index implements IteratorAggregate
{
    /**
     * コンストラクタ
     */
    public function Index()
    {
        global $config;
        $this->config   = $config;
        $this->data_dir = $config['data_dir'];
        $this->months   = array();
        $this->load();
    }

    /**
     * イテレータ
     * @return ArrayIterator    月の一覧
     */
    public function getIterator()
    {
        return new ArrayIterator($this->months);
    }

    /**
     * 読み込み
     */
    public function load()
    {
        $d = dir($this->data_dir);
        while (($entry = $d->read()) !== false) {
            if (preg_match("/^\d{4}-\d{2}$/", $entry)) {
                $this->months[] = $entry;
            }
        }
        $d->close();
        rsort($this->months);
    }
}

?>
