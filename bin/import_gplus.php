<?php
// Import Gplus expored XHTML to blogch3.
//
// Copyright (c) 2012 Satoshi Fukutomi <info@fuktommy.com>.
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

$xmlCache = loadXmls($config, array_slice($argv, 1));
$factory = new Category_Factory();

foreach ($config['category'] as $categoryConf) {
    $rule = $factory->getRule($categoryConf);
    $storage = $factory->getStorage($categoryConf, $xmlCache[0]);
    $storage->setUp();
    foreach ($xmlCache as $xml) {
        foreach ($xml->entry as $entry) {
            if ($rule->match($entry)) {
                $storage->append($entry);
            }
        }
    }
    $storage->commit();
}


function loadXmls(array $config, array $xmlFiles)
{
    $converter = new Gplus_ToBuzzConverter($config);
    $ret = array();
    foreach ($xmlFiles as $file) {
        try {
            $ret[] = simplexml_load_string($converter->convert($file));
        } catch (DomainException $e) {
            fprintf(STDOUT, "%s\n", $e->getMessage());
            continue;
        }
    }
    return $ret;
}
