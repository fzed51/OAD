<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require './vendor/autoload.php';

use fzed51\OAD\AccessDB;
use fzed51\OAD\SqliteConnexion;

$db = new AccessDB(new SqliteConnexion('./db.sqlite'));
$db->setNameSpaceAnalyse("\\fzed51\\OAD\\Test");
$users = $db->getTable('Users');
$allUsers = $users->getAll();
var_dump($allUsers);
