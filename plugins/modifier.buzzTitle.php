<?php
/* バズのタイトルの定義
 *
 * Copyright (c) 2011 Satoshi Fukutomi <info@fuktommy.com>.
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

function smarty_modifier_buzzTitle($entry)
{
    $title = (string)$entry->title;
    if ($title) {
        return $title;
    }

    $title = strip_tags((string)$entry->content);
    if ($title) {
        return mb_substr($title, 0, 30, 'utf-8');
    }

    if (is_callable(array($entry, 'xpath'))) {
        foreach ($entry->xpath('.//buzz:attachment') as $attach) {
            $title = (string)$attach->title;
            if ($title) {
                return $title;
            }
        }
    }

    if (is_callable(array($entry, 'xpath'))) {
        foreach ($entry->xpath('.//georss:featureName') as $featureName) {
            $title = (string)$featureName;
            if ($title) {
                return $title;
            }
        }
    }

    return '';
}
