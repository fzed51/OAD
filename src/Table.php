<?php

/*
 * The MIT License
 *
 * Copyright 2015 fabien.sanchez.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace fzed51\OAD;

use PDO;

/**
 * Description of Table
 *
 * @author fabien.sanchez
 */
abstract class Table {

    /**
     * @var fzed51\OAD\DB\AccessDB
     */
    protected $db;

    /**
     * @var string
     */
    protected $tableClass;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var string
     */
    protected $primaryKey;

    final function __construct(AccessDB $db) {
        $this->db = $db;
        $this->tableClass = static::class;
        if (empty($this->tableName)) {
            $this->tableName = preg_replace("/^(.*\\\\)*/", '', $this->tableClass);
            $this->tableName = preg_replace("/Table$/", '', $this->tableName);
        }
        if (empty($this->entityClass)) {
            $this->entityClass = preg_replace("/Table$/", '', $this->tableClass);
            $this->entityClass = preg_replace("/s$/", '', $this->entityClass);
        }
        if (empty($this->primaryKey)) {
            $this->primaryKey = 'id';
        }
    }

    final function getAll() {
        $this->db->connect();
        $statement = $this->db->prepare("select * from {$this->tableName}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, $this->entityClass, [$this]);
    }

    final function getId(int $id) {
        $this->db->connect();
        $statement = $this->db->prepare("select * from {$this->tableName} where {$this->primaryKey} = ?");
        $statement->execute([$id]);
        return $statement->fetchObject($this->entityClass, [$this]);
    }

    final function getDb() {
        return $this->db;
    }

    final function getNew() {
        $entityClass = $this->entityClass;
        return new $entityClass($this);
    }

    final function accept(Entity $entity) {
        if (get_class($entity) == $this->entityClass) {
            return true;
        }
        return false;
    }

    final function getPrimaryKey() {
        return $this->primaryKey;
    }

    final function save(Entity $entity) {
        if (empty($entity->{$this->primaryKey})) {
            $fields = array_diff($entity->getFields(), [$this->primaryKey]);
            $listField = implode(', ', $fields);
            $listNoValue = implode(', ', array_fill(0, count($fields), '?'));
            $sql = "insert into {$this->tableName} ({$listField}) values ({$listNoValue})";
            echo $sql . PHP_EOL;
            $statement = $this->db->prepare($sql);
            $values = [];
            foreach ($fields as $field) {
                $values[] = $entity->{$field};
            }
            $statement->execute($values);
        } else {

        }
    }

}
