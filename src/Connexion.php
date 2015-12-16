<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace fzed51\OAD;

/**
 * Description of connexion
 *
 * @author fabien.sanchez
 */
class Connexion {

    /**
     * @var array
     */
    protected $Options;
    protected $PassWord;
    protected $UserName;
    protected $Dns;

    public function __construct($Dns, $UserName = null, $PassWord = null, array $Options = []) {
        $this->Dns = $Dns;
        $this->UserName = $UserName;
        $this->PassWord = $PassWord;
        $this->Options = $Options;
    }

    function getDns() {
        return $this->Dns;
    }

    function getUserName() {
        return $this->UserName;
    }

    function getPassWord() {
        return $this->PassWord;
    }

    function getOptions() {
        return $this->Options;
    }

}
