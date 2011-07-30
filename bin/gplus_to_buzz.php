<?php
//
// Copyright (c) 2011 Satoshi Fukutomi <info@fuktommy.com>.
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

require_once dirname(__FILE__) . '/env.php';
require_once 'bootstrap.php';
require_once 'blogconfig.php';


/**
 * リンク情報
 * @param SimpleXMLElement $xml
 * @return array
 */
function getLinks(SimpleXMLElement $xml)
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
function getMap(SimpleXMLElement $xml)
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
function getImages(SimpleXMLElement $xml)
{
    $images = array();
    foreach ($xml->xpath('//*[@class="attachment"]/xhtml:img') as $e) {
        $images[] = array(
            'href' => (string)$e['src'],
            'src' => (string)$e['src'],
            'height' => (string)$e['height'],
            'width' => (string)$e['width'],
        );
    }
    return $images;
}


/**
 * 何もしない
 */
function myNop()
{
}


/**
 * ファイルからXMLを読み込む。
 * XMLの警告を無視する。
 * @param string $file
 * @return SimpleXMLElement
 */
function mySimpleXmlLoadFile($file)
{
    $rawxml = file_get_contents($file);
    set_error_handler('myNop', E_WARNING);
    $xml = simplexml_load_string($rawxml);
    set_error_handler('myHandleError', E_WARNING);
    return $xml;
}


$xml = mySimpleXmlLoadFile('php://stdin');
$xml->registerXPathNamespace('xhtml', 'http://www.w3.org/1999/xhtml');
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

$entry['links'] = getLinks($xml);
$entry['map'] = getMap($xml);
$entry['images'] = getImages($xml);

$context = Web_Context::factory($config);
$smarty = $context->getSmarty();
$smarty->assign('entry', $entry);
$smarty->display('buzzatom.tpl');
