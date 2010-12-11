<?php // -*- coding: utf-8 -*-
/* Blog Category "Tanuki".
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

require_once 'Category.php';
require_once 'Category/Storage.php';

/**
 * Blog Category "Tanuki".
 */
class Category_Tanuki implements Category
{
    /**
     * @var Category_Storage
     */
    private $storage;

    /**
     * Constructor.
     * @param PDOS $db
     * @param SimpleXMLElement $root
     * @throws PDOException
     */
    public function __construct(PDO $db, SimpleXMLElement $root)
    {
        $this->storage = new Category_Storage('tanuki', $db, $root);
    }

    /**
     * Select entry by shortid.
     * @param string $shortid
     * @return array
     */
    public function getEntry($shortid)
    {
        return $this->storage->getEntry($shortid);
    }

    /**
     * Select entries.
     * @param int $offset
     * @param int $length
     * @return array
     * @throws PDOException
     */
    public function select($offset, $length)
    {
        return $this->storage->select($offset, $length);
    }

    /**
     * The enrty is grouped in the category or not.
     * @param SimpleXMLElement $entry
     * @return bool
     */
    public function match(SimpleXMLElement $entry)
    {
        return (bool)preg_match('/タヌキ|たぬき|狸|yosshisgarden/i',
                                $entry->asXML());
    }

    /**
     * Append the enrty to the category.
     * @param SimpleXMLElement $entry
     * @throws PDOException
     * @throws UnexpectedValueException
     */
    public function append(SimpleXMLElement $entry)
    {
        return $this->storage->append($entry);
    }
}
