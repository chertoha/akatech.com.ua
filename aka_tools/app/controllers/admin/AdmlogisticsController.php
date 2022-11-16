<?php

namespace app\controllers\admin;

use app\core\Controller;

class AdmlogisticsController extends Controller {

    public function trackingAction() {
        $period = 30; //default period - days
        
        if (isset($_POST['save'])) {
            $this->model->saveShipment($_POST);
//            $this->view->redirect($this->view->route['action']);
        }
        if (isset($_POST['add_shipment'])) {
            $this->model->addShipment();
            $this->view->redirect($this->view->route['action']);
        }
        if (isset($_POST['delete'])) {
            $this->model->deleteShipment($_POST['shipment_id']);
            $this->view->redirect($this->view->route['action']);
        }
        if (isset($_POST['period'])) {
            $_SESSION['admin']['tracking']['period'] = $_POST['period'];
        } 
        
        if (isset($_SESSION['admin']['tracking']['period'])) {
            $period = $_SESSION['admin']['tracking']['period'];
        }

        $carriers = $this->model->getCarriers();
        $statuses = $this->model->getStatuses();
        $shipments = $this->model->getShipments($period);
        $params = [
            'arr_carriers' => $carriers,
            'arr_statuses' => $statuses,
            'arr_shipments' => $shipments,
            'period' => $period,
        ];
        $this->view->render('Admin Tracking', $params);
    }

}
