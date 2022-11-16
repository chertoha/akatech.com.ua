<?php

namespace app\models;
use app\core\Model;


class Logistics extends Model {
    
    public function getShipments($period) {
        
        $params = [
            'min_date' => (time() - ($period * 24 * 3600)), // days ago 
        ];
        
        $sql = 'SELECT * FROM logist_shipments sh LEFT JOIN logist_shipment_statuses st '
                . 'ON st.status_id = sh.shipment_status_id LEFT JOIN logist_carrier car '
                . 'ON car.carrier_id = sh.shipment_carrier_id '
                . 'WHERE shipment_start_date > :min_date';
        
        return $this->db->row($sql, $params);
    }
    
}
