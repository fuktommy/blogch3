<?php
/* ワンタイムパスワード
 *
 * Copyright (c) 2008 Satoshi Fukutomi <info@fuktommy.com>.
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

class OneTimePassword
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->config     = blogconfig();
        $this->ticketFile = $this->config['ticket_file'];
    }

    /**
     * チケット生成
     * @return string
     */
    public function generate()
    {
        $ticket = (string)mt_rand();
        file_put_contents($this->ticketFile, time() . ' ' . $ticket);
        return $ticket;
    }

    /**
     * チケット確認
     * 使用済みチケットは無効化
     * @param string    $ticket
     * @return bool
     */
    public function verify($ticket)
    {
        list($time, $cached) = preg_split('/ /', file_get_contents($this->ticketFile));
        file_put_contents($this->ticketFile, '');
        if ($time + 600 < $time) {
            return false;
        } elseif (($ticket != '') && ($ticket == $cached)) {
            return true;
        } else {
            return false;
        }
    }
}
