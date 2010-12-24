<?php
/* 全てのバズのフィードを取得する。
 *
 * usage: php get_all_buzz.php \
 *          -d ~/tmp/buzzfeeds \
 *          -f "https://www.googleapis.com/buzz/v1/activities/104787602969620799839/@public?alt=atom&max-results=100"
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

require_once dirname(__FILE__) . '/env.php';
require_once 'bootstrap.php';
require_once 'blogconfig.php';

$httpOptions = array(
    'header' => "User-Agent: Buzz-Reader/2010-12-25\r\n",
    'timeout' => 60,
);

$options = getopt('d:f:');
$outputDir = $options['d'];
$feedUrl = $options['f'];

if (! is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

$count = 0;
while (true) {
    printf("%4d %s\n", $count, $feedUrl);
    $xml = file_get_contents(
                $feedUrl, false,
                stream_context_create(array('http' => $httpOptions)));
    file_put_contents(sprintf('%s/atom%04d.xml', $outputDir, $count++), $xml);
    $xmlobj = simplexml_load_string($xml);
    $xmlobj->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
    $next = $xmlobj->xpath('atom:link[@rel="next"]');
    if (! $next) {
        break;
    }
    $feedUrl = (string)$next[0]['href'];
    usleep(1.0 * 1000 * 1000);
}
