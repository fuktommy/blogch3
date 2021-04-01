<?php
/* Web入出力の抽象化。
 *
 * Copyright (c) 2010,2014 Satoshi Fukutomi <info@fuktommy.com>.
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
 * Web入出力の抽象化。
 * @package Web
 */
class Web_Context
{
    /**
     * @var array 設定の中身。
     */
    public $config = array();

    /**
     * @var array $_GET
     */
    public $get = array();

    /**
     * @var array $_POST
     */
    public $post = array();

    /**
     * @var array $_COOKIE
     */
    public $cookie = array();

    /**
     * @var array $_REQUEST
     */
    public $request = array();

    /**
     * @var array getallheaders()
     */
    public $header = array();

    /**
     * @var array $_SERVER
     */
    public $server = array();

    /**
     * @var array $_FILES
     */
    public $files = array();

    /**
     * @var array プログラム内で作ったデータの引き回し用
     */
    public $vars = array();

    /**
     * コンストラクタ。
     */
    private function __construct()
    {
    }

    /**
     * ファクトリ。
     * @return Web_Context
     */
    public static function factory()
    {
        $config = require __DIR__ . '/../../../conf/blogconfig.php';

        $instance = new self();
        $instance->config = $config;
        $instance->get = $_GET;
        $instance->post = $_POST;
        $instance->cookie = $_COOKIE;
        $instance->request = $_REQUEST;
        $instance->header = is_callable('getallheaders')
                          ? getallheaders() : array();
        $instance->server = $_SERVER;
        $instance->files = $_FILES;
        return $instance;
    }

    /**
     * 情報の取得。
     * @param string $property 'config', 'get' などの、このクラスのプロパティ。
     * @param string $key プロパティのキー。
     * @param mixed $default プロパティがないときの戻値。
     * @return mixed
     */
    public function get($property, $key, $default = null)
    {
        $valueExists = isset($this->$property)
                    && is_array($this->$property)
                    && array_key_exists($key, $this->$property);
        if ($valueExists) {
            return $this->{$property}[$key];
        } else {
            return $default;
        }
    }

    /**
     * ヘッダー出力
     * @param string $key
     * @param string $value
     */
    public function putHeader($key, $value = null)
    {
        if (is_null($value)) {
            header($key);
        } else {
            header("{$key}: {$value}");
        }
    }

    /**
     * 出力エンコーディングを切り替える。
     * @param string $encoding
     */
    public function switchEncoding($encoding)
    {
        mb_http_output($encoding);
        mb_internal_encoding('UTF-8');
        ob_start('mb_output_handler');
    }

    /**
     * Smartyのファクトリ。
     * @return Smarty
     */
    public function getSmarty()
    {
        require_once 'Smarty.class.php';
        $smarty = new Smarty();
        $smarty->template_dir = $this->config['smarty_template_dir'];
        $smarty->plugins_dir = array_merge(
            $smarty->plugins_dir,
            $this->config['smarty_plugins_dir']);
        $smarty->compile_dir = $this->config['smarty_compile_dir'];
        $smarty->cache_dir = $this->config['smarty_cache_dir'];
        return $smarty;
    }

    /**
     * Factory for LoggerInterface
     * @param string $ident
     * @return Psr\Log\LoggerInterface
     */
    public function getLog()
    {
        require_once 'Katzgrau/KLogger/autoload.php';
        return new \Katzgrau\KLogger\Logger($this->config['log_dir'], \Psr\Log\LogLevel::DEBUG, [
            'filename' => strftime('/debug.%Y%m%d.log'),
        ]);
    }
}
