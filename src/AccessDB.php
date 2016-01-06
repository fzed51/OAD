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
 * Description of AccessDB
 *
 * @author fabien.sanchez
 */
class AccessDB extends \PDO {

    /**
     * @var Connexion
     */
    private $connexion;

    /**
     * @var bool
     */
    private $connected;

    /**
     * @var string
     */
    private $nameSpaceAnalyse;

    public function __construct(Connexion $connexion) {
        $this->nameSpaceAnalyse = "\\App\\Data\\";
        $this->connexion = $connexion;
        $this->connected = false;
    }

    function connect() {
        if (!$this->connected) {
            parent::__construct($this->connexion->getDns(), $this->connexion->getUserName(), $this->connexion->getPassWord(), $this->connexion->getOptions());
            $this->connected = true;
        }
        return $this;
    }

    function setNameSpaceAnalyse(string $nameSpaceAnalyse) {
        if (substr($nameSpaceAnalyse, -1) != "\\") {
            $nameSpaceAnalyse .= "\\";
        }
        $this->nameSpaceAnalyse = $nameSpaceAnalyse;
        return $this;
    }

    /**
     *
     * @param string $table
     * @return \fzed51\OAD\Table
     * @throws \fzed51\OAD\Exception
     */
    function getTable($table) {

        $classTable = $this->nameSpaceAnalyse . $table . 'Table';
        if (!class_exists($classTable, true) || !is_subclass_of($classTable, "\\fzed51\\OAD\\Table")) {
            throw new Exception("La table <{$table}> n'a pas été déclarée");
        }
        return new $classTable($this);
    }

}
