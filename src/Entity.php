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

/**
 * Description of Entity
 *
 * @author fabien.sanchez
 */
abstract class Entity {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    protected $fk = [];
    private $constructed = false;
    private $modified = false;

    final function __construct(\fzed51\OAD\Table $table) {
        $this->table = $table;
        $this->constructed = true;
        $this->modified = false;
    }

    private function setData($dataField, $value) {
        if ($this->constructed && $dataField == $this->table->getPrimaryKey()) {
            if (isset($this->data[$dataField]) && !empty($this->data[$dataField])) {
                throw new Exception("Impossible de modifier '$dataField' car c'est une clé primaire !");
            }
        }
        $this->data[$dataField] = $value;
        $this->modified = true;
    }

    final function __set($name, $value) {
        if (!$this->has($name)) {
            throw new Exception("La propriete {$name} n'est pa connue");
        }
        if (array_key_exists($name, $this->fk)) {
            list($field, $tableName) = $this->fk[$name];
            $db = $this->table->getDb();
            $table = $db->getTable($tableName);
            if ($table->accept($value)) {
                $this->setData($field, $value->getId());
            }
        }
        $this->setData($name, $value);
    }

    final function __get($name) {
        if (!$this->has($name)) {
            throw new Exception("La propriete {$name} n'est pa connue");
        }
        if (array_key_exists($name, $this->fk)) {
            list($field, $table) = $this->fk[$name];
            $db = $this->table->getDb();
            return $db->getTable($table)->getId($this->data[$field]);
        }
        return $this->data[$name];
    }

    final function has($name) {
        if (in_array($name, $this->fields)) {
            return true;
        }
        if (array_key_exists($name, $this->fk)) {
            return true;
        }
        return false;
    }

    final function getId() {
        $fieldNameId = $this->table->getPrimaryKey();
        return $this->data[$fieldNameId];
    }

    final function saveData() {
        if ($this->modified) {
            $this->table->save($this);
        }
    }

}
