<?php
//
// Google+ のフィード
//
// Copyright (c) 2011,2012 Satoshi Fukutomi <info@fuktommy.com>.
// All rights reserved.
//
// Redistribution and use in source and binary forms, with or without
// modification, are permitted provided that the following conditions
// are met:
// 1. Redistributions of source code must retain the above copyright
//    notice, this list of conditions and the following disclaimer.
// 2. Redistributions in binary form must reproduce the above copyright
//    notice, this list of conditions and the following disclaimer in the
//    documentation and/or other materials provided with the distribution.
//
// THIS SOFTWARE IS PROVIDED BY THE AUTHORS AND CONTRIBUTORS ``AS IS'' AND
// ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
// IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
// ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHORS OR CONTRIBUTORS BE LIABLE
// FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
// DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
// OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
// HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
// LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
// OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
// SUCH DAMAGE.
//

/**
 * Google+ のJSONフィードを取得する。
 *
 * キャッシュへの保存とかいろいろやっちゃう。
 */
class GplusJsonFeed
{
    /**
     * @var string
     */
    private $_cacheDir;

    /**
     * @var int
     */
    private $_cacheTime = 600;

    /**
     * @var Log
     */
    private $_log;

    /**
     * コンストラクタ
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->_cacheDir = $options['cacheDir'];
        $this->_log = $options['log'];
    }

    /**
     * フィードを取得する。
     * @param string $userId
     * @param int $length
     * @return array
     * @throws RuntimeException
     */
    public function getFeed($userId, $length = 30)
    {
        if (! preg_match('/^\d+$/D', $userId)) {
            throw new RuntimeException("{$userId} is not numeric");
        }
        $json = $this->_getJsonUsingCache($userId, $length);
        $json = preg_replace('/^\S+[\r\n]+/', '', $json);
        $json = str_replace(',,', ',null,', $json);
        $json = str_replace(',,', ',null,', $json);
        $json = str_replace('[,', '[null,', $json);
        $json = str_replace(',]', ',null]', $json);
        $json = preg_replace('/{(\d+):/', '{"$1":', $json);
        return json_decode($json, true);
    }

    private function _getJsonUsingCache($userId, $length)
    {
        $cacheFile = "{$this->_cacheDir}/{$userId}.txt";
        $readFromCache = is_file($cacheFile)
                      && (time() < filemtime($cacheFile) + $this->_cacheTime);
        if ($readFromCache) {
            return file_get_contents($cacheFile);
        }

        $lock = fopen("{$this->_cacheDir}/lock", 'w');
        $lockSuccess = flock($lock, LOCK_EX|LOCK_NB);
        if ($lockSuccess) {
            // go next
        } elseif (is_file($cacheFile)) {
            fclose($lock);
            $this->_log->warning("lock failed for {$userId}");
            return file_get_contents($cacheFile);
        } else {
            fclose($lock);
            $this->_log->warning("lock failed for {$userId} and not cached");
            return '';
        }

        touch($cacheFile);
        $jsonUrl = sprintf('https://plus.google.com/_/stream/getactivities/'
                           . '?sp=[1,2,"%s",null,null,%d,null,"social.google.com",[]]',
                           $userId, $length);
        $this->_log->info("accessing {$jsonUrl}");
        $json = @file_get_contents($jsonUrl);
        if (empty($json)) {
            $this->_log->warning("empty {$jsonUrl}");
        }
        file_put_contents($cacheFile, $json);
        flock($lock, LOCK_UN);
        fclose($lock);
        return $json;
    }
}
