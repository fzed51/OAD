<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

    function getTable($table) {

        $classTable = $this->nameSpaceAnalyse . $table . 'Table';
        if (!class_exists($classTable, true) || !is_subclass_of($classTable, "\\fzed51\\OAD\\Table")) {
            throw new \Exception("La table <{$table}> n'a pas été déclarée");
        }
        return new $classTable($this);
    }

}
