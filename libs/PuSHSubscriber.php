<?php
/* PubSubHubbub の購読機能。
 *
 * http://d.hatena.ne.jp/tokuhirom/20100307/push および
 * http://github.com/lxbarth/PuSHSubscriber を参考にしました。
 *
 * Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>.
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
 * PubSubHubbub の購読機能。
 *
 * 1つのクラスにまとめた。
 * 規模によってはリクエスト、レスポンス、コントローラの3つに分けるべきか。
 *
 * TODO: ログを出す。
 */
class PuSHSubscriber
{
    /**
     * @var string  購読するAtomフィードのURL。
     */
    private $topic;

    /**
     * @var string  秘密の文字列。
     */
    private $secret;

    /**
     * コンストラクタ。
     */
    private function __construct(array $config)
    {
        $this->topic = $config['hub.topic'];
        $this->secret = $config['hub.secret'];
    }

    /**
     * ファクトリ。
     * @param array $config  中身は
     *      hub.topic: 購読するAtomフィードのURL。
     *      hub.secret: 秘密の文字列。
     */
    public static function factory(array $config)
    {
        return new self($config);
    }

    /**
     * プッシュを受け取って、処理を行う。
     *
     * もし確認リクエストなら、適切なレスポンスを返す。
     * それ以外なら、受け取った文字列を引数にして $callback を実行する。
     *
     * @param callable $callback
     */
    public function execute($callback)
    {
        if ($this->isSubscribeMode()) {
            $this->executeSubscribe();
        } else {
            $this->executePush($callback);
        }
    }

    /**
     * 登録モードか。
     * @return bool
     */
    private function isSubscribeMode()
    {
        $mode = array('subscribe', 'unsubscribe');
        return isset($_GET['hub_mode'])
            && in_array($_GET['hub_mode'], $mode, true);
    }

    /**
     * 登録モードを処理する。
     */
    private function executeSubscribe()
    {
        if (! isset($_GET['hub_challenge'])) {
            $this->returnFail('No Challenge');
            return;
        }
        $topicIsValid = isset($_GET['hub_topic'])
                     && ($_GET['hub_topic'] === $this->topic);
        if (! $topicIsValid) {
            $this->returnFail('Unknown Feed');
            return;
        }
        $this->returnSuccess($_GET['hub_challenge']);
    }
 
    /**
     * フィードのプッシュを処理する。
     * @param callable $callback
     */
    private function executePush($callback)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->returnFail('Invalid Method');
            return;
        }
        if (! isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
            $this->returnFail('No Signature');
            return;
        }

        $input = file_get_contents('php://input');
        $signature = array();
        parse_str($_SERVER['HTTP_X_HUB_SIGNATURE'], $signature);

        $hash = hash_hmac('sha1', $input, $this->secret);
        $isValidHash = isset($signature['sha1'])
                  && ($signature['sha1'] === $hash);
        if (! $isValidHash) {
            $this->returnFail('Invalid Signature');
            return;
        }
        if (! @simplexml_load_string($input)) {
            $this->returnFail('Invalid XML');
            return;
        }

        call_user_func($callback, $input);
    }

    /**
     * 成功を返す。
     * @param string $message
     */
    private function returnSuccess($message = 'OK')
    {
        header('HTTP/1.1 200 OK', null, 200);
        header('Content-Type: text/plain');
        header('Content-Length: ' . strlen($message));
        echo $message;
    }

    /**
     * 失敗を返す。
     * @param string $message
     */
    private function returnFail($message = 'Fail')
    {
        header('HTTP/1.1 500 Internal Server Error', null, 500);
        header('Content-Type: text/plain');
        header('Content-Length: ' . strlen($message));
        echo $message;
    }
}
