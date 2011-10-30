<?php
/* Blog Category "Photo".
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
 * Blog Category "Photo".
 */
class Category_Rule_Photo implements Category_Rule
{
    /**
     * The enrty is grouped in the category or not.
     * @param SimpleXMLElement $entry
     * @return bool
     */
    public function match(SimpleXMLElement $entry)
    {
        try {
            $entry->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
            foreach ($entry->xpath('.//activity:service/atom:title') as $postFrom) {
                if ((string)$postFrom == 'Google Reader') {
                    return false;
                }
            }
            foreach ($entry->xpath('.//buzz:attachment') as $attach) {
                foreach ($attach->link as $link) {
                    if ((string)$link['rel'] != 'enclosure') {
                        continue;
                    }
                    $host = parse_url($link['href'], PHP_URL_HOST);
                    if (strpos($host, '.ggpht.com') !== false) {
                        return true;
                    }
                    if ((strpos($host, '.googleusercontent.com') !== false)
                        && (strpos($link['href'], 'proxy') === false)) {
                        return true;
                    }
                }
            }
        } catch (Exception $e) {
        }

        return false;
    }
}
