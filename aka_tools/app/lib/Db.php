<?php

namespace app\lib;

use PDO;
//use PDOStatement;

class Db {

    protected $db;

    function __construct($db_config) {

        $config = require $db_config;
//        $config = require 'app/config/db.php';
        
        $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . '', $config['user'], $config['password']);
    }

    public function query($sql, $params = []) {
        $this->db->query("SET NAMES 'UTF8'") or die('Cant set charset');
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
    
    public function error(){
        return $this->db->errorInfo();
    }
    
    public function lastInsertId(){
        return $this->db->lastInsertId();
    }

}
