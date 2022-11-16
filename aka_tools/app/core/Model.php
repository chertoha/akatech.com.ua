<?php

namespace app\core;
use app\lib\Db;

abstract class Model {
    
    public $db;
    public $db_aka;
    
    public function __construct() {
        $this->db = new Db(DB_CONFIG_PATH);
        $this->db_aka = new Db(DB_AKA_CONFIG_PATH);
    }

    
}
