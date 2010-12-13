<?php
/* バズの地図情報を読み込む。
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

function smarty_function_buzzMap($params, $smarty)
{
    try {
        $entry = $params['entry'];
        $varName = $params['var'];
        $map = array();
        $smarty->assign($varName, $map);

        if (! is_callable(array($entry, 'xpath'))) {
            return;
        }

        foreach ($entry->xpath('//georss:point') as $point) {
            list($map['lat'], $map['long']) = explode(' ', $point);
        }
        foreach ($entry->xpath('//georss:featureName') as $featureName) {
            $map['featureName'] = (string)$featureName;
        }
        foreach ($entry->xpath('//poco:address/poco:formatted') as $address) {
            $map['address'] = (string)$address;
        }
        if (isset($map['lat']) && isset($map['long'])) {
            $map['href'] = sprintf('http://maps.google.co.jp/maps?q=%s,%s',
                                   urlencode($map['lat']), urlencode($map['long']));
        }

        $smarty->assign($varName, $map);
    } catch (Exception $e) {
    }
}
