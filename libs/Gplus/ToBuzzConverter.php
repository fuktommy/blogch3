<?php // -*- coding: utf-8 -*-
//
// Copyright (c) 2011-2013 Satoshi Fukutomi <info@fuktommy.com>.
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
 * Gplus形式からBuzz形式への変換ツール
 */
class Gplus_ToBuzzConverter
{
    /**
     * @var array
     */
    private $_config;

    public function __construct(array $config)
    {
        $this->_config = $config;
    }

    /**
     * リンク情報
     * @param SimpleXMLElement $xml
     * @return array
     */
    private function _getLinks(SimpleXMLElement $xml)
    {
        $links = array();
        foreach ($xml->xpath('//*[@class="attachment"]/xhtml:a') as $e) {
            $links[] = array(
                'href' => (string)$e['href'],
                'title' => (string)$e,
            );
        }
        return $links;
    }

    /**
     * 位置情報
     * @param SimpleXMLElement $xml
     * @return array
     */
    private function _getMap(SimpleXMLElement $xml)
    {
        $map = array();
        foreach ($xml->xpath('//xhtml:div[@class="vcard geo"]/*[@class="fn"]') as $e) {
            $map['featureName'] = (string)$e;
        }
        foreach ($xml->xpath('//*[@class="adr"]') as $e) {
            $map['formatted'] = (string)$e;
        }
        foreach ($xml->xpath('//*[@class="latitude"]') as $e) {
            $map['lat'] = (string)$e;
        }
        foreach ($xml->xpath('//*[@class="longitude"]') as $e) {
            $map['long'] = (string)$e;
        }
        return $map;
    }

    /**
     * 写真
     * @param SimpleXMLElement $xml
     * @return array
     */
    private function _getImages(SimpleXMLElement $xml)
    {
        $fullImages = array();
        $previewImages = array();
        foreach ($xml->xpath('//*[@class="attachment"]//xhtml:img') as $e) {
            if (
                empty($e['class'])
                && empty($e['width'])
                && empty($e['height'])
                && ! preg_match('/[.]jpg$/', $e['src'])) {
                continue;
            }
            $image = array(
                'href' => preg_replace('/=$/', '', (string)$e['src']),
                'src' => preg_replace('/=$/', '', (string)$e['src']),
                'height' => (string)$e['height'],
                'width' => (string)$e['width'],
            );
            $alt = strval(empty($e['alt']) ? mt_rand() : $e['alt']);
            if ($e['class'] == 'full-image') {
                $fullImages[$alt] = $image;
            } else {
                $previewImages[$alt] = $image;
            }
        }
        if (empty($fullImages)) {
            return array_values($previewImages);
        }
        foreach ($previewImages as $alt => $image) {
            if (isset($fullImages[$alt])) {
                $fullImages[$alt]['preview'] = $image;
            }
        }
        return $fullImages;
    }

    /**
     * 何もしない
     */
    public function nop()
    {
    }

    /**
     * ファイルからXMLを読み込む。
     * XMLの警告を無視する。
     * @param string $file
     * @return SimpleXMLElement
     */
    private function _simpleXmlLoadFile($file)
    {
        $rawxml = file_get_contents($file);
        set_error_handler(array($this, 'nop'), E_WARNING);
        $xml = simplexml_load_string($rawxml);
        set_error_handler('myHandleError', E_WARNING);
        return $xml;
    }

    /**
     * 公開記事かどうかを判定する。
     * @param SimpleXMLElement $xml
     * @return bool
     */
    private function _isPublicEntry(SimpleXMLElement $xml)
    {
        foreach ($xml->xpath('//*[@class="visibility"]') as $e) {
            if (in_array((string)$e, array('一般公開', 'Public'), true)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 変換を実行する
     * @param string $inputFile
     * @return $string
     */
    public function convert($inputFile)
    {
        $xml = $this->_simpleXmlLoadFile($inputFile);
        if (! $xml instanceof SimpleXMLElement) {
            throw new DomainException("{$inputFile} is not valid XML.");
        }
        $xml->registerXPathNamespace('xhtml', 'http://www.w3.org/1999/xhtml');

        if (! $this->_isPublicEntry($xml)) {
            throw new DomainException("{$inputFile} is not public.");
        }

        $entry = array();
        
        $entry['title'] = (string)$xml->head->title;
        foreach ($xml->xpath('//*[@class="published"]') as $e) {
            $entry['published'] = (string)$e['title'];
        }
        foreach ($xml->xpath('//*[@class="updated"]') as $e) {
            $entry['updated'] = (string)$e['title'];
        }
        foreach ($xml->xpath('//xhtml:div[@class="permalink"]/xhtml:a') as $e) {
            $entry['link'] = (string)$e['href'];
        }
        foreach ($xml->xpath('//xhtml:div[@class="entry-content"]') as $e) {
            $entry['content'] = $e->asXml();
        }
        foreach ($xml->xpath('//xhtml:span[@class="id"]') as $e) {
            $entry['id'] = 'tag:google.com,2011:plus:' . (string)$e;
        }
        
        $entry['links'] = $this->_getLinks($xml);
        $entry['map'] = $this->_getMap($xml);
        $entry['images'] = $this->_getImages($xml);
        
        $context = Web_Context::factory($this->_config);
        $smarty = $context->getSmarty();
        $smarty->assign('entry', $entry);
        return $smarty->fetch('buzzatom.tpl');
    }
}
