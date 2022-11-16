<?php

namespace app\lib;
use app\lib\Db;

class Logging {

    private $db;

    public function __construct() {
        $this->db = new Db(DB_CONFIG_PATH);
    }

    public function logData($user_id, $data) {
        $params = [
            'id' => $user_id,
            'time' => time(),
            'text' => $data,
        ];
        $this->db->query('INSERT INTO logs SET log_user_id= :id, log_time= :time, log_text= :text', $params);
        
        $this->db = null;
    }

}
