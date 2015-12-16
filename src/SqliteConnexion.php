<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace fzed51\OAD;

/**
 * Description of SqliteConnexion
 *
 * @author fabien.sanchez
 */
class SqliteConnexion extends Connexion {

    public function __construct($filepath, $userName = null, $passWord = null, array $options = []) {
        $this->setDns($filepath);
        $this->UserName = $userName;
        $this->PassWord = $passWord;
        $this->Options = $options;
    }

    function setDns($filepath) {
        $path = realpath(dirname($filepath));
        $file = basename($filepath);
        $fullPath = $path . DIRECTORY_SEPARATOR . $file;
        $this->Dns = "sqlite:{$fullPath}";
        return $this;
    }

}
