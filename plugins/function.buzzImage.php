<?php
/* バズに含まれる画像情報を読み込む。
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

function smarty_function_buzzImage($params, $smarty)
{
    $entry = $params['entry'];
    $varName = $params['var'];
    $images = array();
    $smarty->assign($varName, $images);

    if (! is_callable(array($entry, 'xpath'))) {
        return;
    }

    try {
        $entry->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
        foreach ($entry->xpath('.//activity:service/atom:title') as $postFrom) {
            if ($postFrom == 'Google Reader') {
                return;
            }
        }

        foreach ($entry->xpath('.//buzz:attachment') as $attach) {
            $img = array();
            foreach ($attach->link as $link) {
                if ($link['rel'] == 'enclosure') {
                    $host = parse_url($link['href'], PHP_URL_HOST);
                    if (preg_match('/[.]images-amazon[.]com$/', $host)) {
                        $img['is_amazon'] = true;
                    } elseif (preg_match('/[.]ggpht[.]com$/', $host)) {
                        $img['is_buzz'] = true;
                    } elseif (preg_match('/[.]googleusercontent[.]com$/', $host)) {
                        $img['is_buzz'] = true;
                    } else {
                        $img = array();
                        break;
                    }
                    $media = $attach->link->attributes('media', true);
                    $img['href'] = (string)$link['href'];
                    $img['src'] = (string)$link['href'];
                    $img['height'] = isset($media['height']) ? (int)$media['height'] : '';
                    $img['width'] = isset($media['width']) ? (int)$media['width'] : '';
                } elseif ($link['rel'] == 'preview') {
                    $img['preview'] = array(
                        'src' => (string)$link['href'],
                    );
                    if (preg_match('/resize_h=(\d+)/', $link['href'], $matches)
                        && isset($img['height']) && isset($img['width'])) {
                        $img['preview']['height'] = $matches[1];
                        $img['preview']['width']
                            = $img['height'] ? intval($img['width'] * $matches[1] / $img['height']) : '';
                    }
                }
            }
            if ($img) {
                $images[] = $img;
            }
        }
    } catch (Exception $e) {
    }

    $smarty->assign($varName, $images);
}
