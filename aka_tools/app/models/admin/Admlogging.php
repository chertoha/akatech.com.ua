<?php


namespace app\models\admin;
use app\core\Model;

class Admlogging extends Model{
    
    public function getLogs(){
        $sql = 'SELECT * FROM logs l LEFT JOIN auth_users au '
                . 'ON l.log_user_id=au.user_id';
        return $this->db->row($sql);
    }
    
    
}
