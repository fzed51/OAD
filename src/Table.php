<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace fzed51\OAD;

use fzed51\OAD\AccessDB;

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
        return $statement->fetchAll(\PDO::FETCH_CLASS, $this->entityClass);
    }

    final function getId(int $id) {
        $this->db->connect();
        $statement = $this->db->prepare("select * from {$this->tableName} where {$this->primaryKey} = ?");
        $statement->execute([$id]);
        return $statement->fetch(\PDO::FETCH_CLASS, $this->entityClass);
    }

}
