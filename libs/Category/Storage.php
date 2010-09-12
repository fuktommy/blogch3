<?php
/* Blog Category Storage.
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

require_once 'Migration.php';

/**
 * Blog Category Storage.
 */
class Category_Storage
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var PDO
     */
    private $db;

    /**
     * @var PDOStatement
     */
    private $insertState;

    /**
     * @var PDOStatement
     */
    private $countState;

    /**
     * @var string
     */
    private $xmlHeader;

    /**
     * @var string
     */
    private $xmlFooter = '</feed>';

    /**
     * Constructor.
     * @param string $table
     * @param PDOS $db
     * @param SimpleXMLElement $root
     * @throws PDOException
     */
    public function __construct($table, PDO $db, SimpleXMLElement $root)
    {
        $this->table = $table;
        $this->db = $db;
        $this->setUp($table, $db);
        $this->countState = $this->getCountState($table, $db);
        $this->insertState = $this->getInsertState($table, $db);
        $this->xmlHeader = $this->getHeader($root);
    }

    private function setUp($table, PDO $db)
    {
        $migration = new Migration($db);
        $migration->execute(
            "CREATE TABLE IF NOT EXISTS `{$table}`"
            . " (`id` CHAR PRIMARY KEY NOT NULL,"
            . "  `date` CHAR NOT NULL,"
            . "  `body` TEXT NOT NULL)"
        );
        $migration->execute(
            "CREATE INDEX `date` ON `{$table}` (`date`)"
        );
    }

    private function getCountState($table, PDO $db)
    {
        return $db->prepare(
            "SELECT COUNT(*) FROM `{$table}` WHERE `id` = :id"
        );
    }

    private function getInsertState($table, PDO $db)
    {
        return $db->prepare(
            "INSERT INTO `{$table}` (`id`,`date`, `body`)"
            . " VALUES (:id, :date, :body)"
        );
    }

    private function getHeader(SimpleXMLElement $root)
    {
        $header = "<feed";
        foreach ($root->getDocNamespaces() as $k => $v) {
            $header .= sprintf(" xmlns%s%s='%s'", ($k ? ':' : ''), $k, $v);
        }
        $header .= '>';
        return $header;
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
        $state = $this->db->query(
            "SELECT `body` FROM `{$this->table}` ORDER BY `date` DESC"
            . sprintf(" LIMIT %d,%d", $offset, $length)
        );
        $state->setFetchMode(PDO::FETCH_ASSOC);
        $ret = array();
        foreach ($state as $row) {
            $tmp = simplexml_load_string($row['body']);
            $ret[] = $tmp->entry;
        }
        return $ret;
    }

    /**
     * Append the enrty to the category.
     * @param SimpleXMLElement $entry
     * @throws PDOException
     * @throws UnexpectedValueException
     */
    public function append(SimpleXMLElement $entry)
    {
        $id = (string)$entry->id;
        $date = (string)$entry->updated;
        $body = $this->xmlHeader . $entry->asXML() . $this->xmlFooter;
        if (! simplexml_load_string($body)) {
            throw new UnexpectedValueException($body . ' is not XML.');
        }
        $this->countState->execute(array('id' => $id));
        if ((int)$this->countState->fetchColumn()) {
            return;
        }
        $this->insertState->execute(array(
            'id' => $id,
            'date' => $date,
            'body' => $body
        ));
    }
}
