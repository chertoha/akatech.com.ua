<?php


namespace app\controllers;
use app\core\Controller;

class LogisticsController extends Controller{
    
    public function trackingAction(){
        $period = 30; //default period - days
        
        if (isset($_POST['period'])) {
            $_SESSION['all']['tracking']['period'] = $_POST['period'];
        } 
        
        if (isset($_SESSION['all']['tracking']['period'])) {
            $period = $_SESSION['all']['tracking']['period'];
        }
        
        $shipments = $this->model->getShipments($period);
                
        $params = [
            'arr_shipments' => $shipments,
            'period' => $period,
        ];
                
        
        $this->view->render('Tracking', $params);
    }
    
}
