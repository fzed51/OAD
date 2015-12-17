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
    protected $data = [];

    /**
     * @var array
     */
    protected $fk = [];

    final public function __construct(\fzed51\OAD\Table $table) {
        $this->table = $table;
    }

    public function __set($name, $value) {
        if (!in_array($name, $this->fields)) {
            throw new Exception("La propriete {$name} n'est pa connue");
        }
        $this->data[$name] = $value;
    }

    public function __get($name) {
        if (!in_array($name, $this->fields)) {
            throw new Exception("La propriete {$name} n'est pa connue");
        }
        if (!isset($this->data[$name])) {
            return null;
        }
        if (isset($this->fk[$name])) {
            $table = $this->fk[$name];
            $db = $this->table->db;
            return $db->getTable($table)->getId($this->data[$name]);
        }
        return $this->data[$name];
    }

}
