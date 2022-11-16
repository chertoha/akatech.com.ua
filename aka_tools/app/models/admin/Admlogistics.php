<?php

namespace app\models\admin;

use app\core\Model;

class Admlogistics extends Model {

    public function getCarriers() {
        return $this->db->row('SELECT * FROM logist_carrier');
    }

    public function getStatuses() {
        return $this->db->row('SELECT * FROM logist_shipment_statuses');
    }

    public function getShipments($period) {
        $params = [
            'min_date' => (time() - ($period * 24 * 3600)), // days ago 
        ];
        return $this->db->row('SELECT * FROM logist_shipments WHERE shipment_start_date > :min_date', $params);
    }

    public function addShipment() {
        $params = [
            'date' => time(),
        ];
        $this->db->query('INSERT INTO logist_shipments SET shipment_start_date = :date', $params);
    }

    public function deleteShipment($id) {
        $params = [
            'id' => $id,
        ];
        $this->db->query('DELETE FROM logist_shipments WHERE shipment_id= :id', $params);
    }

    public function saveShipment($shipment) {
        $params = [
            'shipment_descriptor' => $shipment['shipment_descriptor'],
            'shipment_start_date' => strtotime($shipment['shipment_start_date']),
            'shipment_track_num' => $shipment['shipment_track_num'],
            'shipment_request_num' => $shipment['shipment_request_num'],
            'shipment_request_num' => $shipment['shipment_request_num'],
            'shipment_status_id' => (int) $shipment['shipment_status_id'],
            'shipment_carrier_id' => (int) $shipment['shipment_carrier_id'],
//            'shipment_link' => $shipment['shipment_link'],
            'shipment_comment' => $shipment['shipment_comment'],
            'shipment_id' => (int) $shipment['shipment_id'],
        ];

        $sql = 'UPDATE logist_shipments SET '
                . 'shipment_descriptor = :shipment_descriptor, '
                . 'shipment_start_date = :shipment_start_date, '
                . 'shipment_track_num = :shipment_track_num, '
                . 'shipment_request_num = :shipment_request_num, '
                . 'shipment_status_id = :shipment_status_id, '
                . 'shipment_carrier_id = :shipment_carrier_id, '
//                . 'shipment_link = :shipment_link, '
                . 'shipment_comment = :shipment_comment '
                . 'WHERE shipment_id =:shipment_id ';

        $this->db->query($sql, $params);
        // send email
        $this->sendEmail($shipment['shipment_id']);
    }

    public function sendEmail($shipment_id) {
        $sql = 'SELECT * FROM logist_shipments ls LEFT JOIN logist_carrier lc '
                . 'ON ls.shipment_carrier_id=lc.carrier_id LEFT JOIN logist_shipment_statuses ss '
                . 'ON ls.shipment_status_id=ss.status_id WHERE shipment_id= :id';
        $result = $this->db->row($sql, ['id' => $shipment_id]);
        $shipment = $result[0];
        
        if ($shipment['shipment_descriptor'] == '' || $shipment['shipment_track_num'] == ''){
            return;
        }
        
        $to_list = $this->db->row('SELECT email_value FROM staff_emails WHERE email_available="1"');
        $subject = 'TRACKING';
        $message = '<html> 
                                 <head> 
                                     <title>' . $shipment['shipment_descriptor'] . '</title> 
                                 </head> 
                                 <body> 
                                    <h3>' . $shipment['shipment_descriptor'] . '</h3>
                                     
                                    <table border="1">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Дата отправки</th>
                                            <th class="text-center">Track номер</th>
                                            <th class="text-center">Статус</th>
                                            <th class="text-center">Перевозчик</th>
                                            <th class="text-center">Комментарий</th>
                                        </tr>
                                        <tr>
                                            <td>' . $shipment['shipment_descriptor'] . '</td>
                                            <td>' . date('d.m.Y', $shipment['shipment_start_date']) . '</td>
                                            <td><a href="' . $shipment['carrier_track_link'] . $shipment['shipment_track_num'] . '">' . $shipment['shipment_track_num'] . '</a></td>
                                            <td style="background: #FF7F50;">' . $shipment['status_name'] . '</td>
                                            <td>' . $shipment['carrier_name'] . '</td>
                                            <td>' . $shipment['shipment_comment'] . '</td>
                                        </tr>
                                        
                                    </table>

                                 </body> 
                             </html>';
        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: AKA-tools <sendphpmailserver@akatech.com.ua>\r\n";

        foreach ($to_list as $to) {
            mail($to['email_value'], $subject, $message, $headers);
        }
    }

}
