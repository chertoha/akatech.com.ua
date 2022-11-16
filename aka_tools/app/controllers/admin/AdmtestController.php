<?php

namespace app\controllers\admin;

use app\core\Controller;


class AdmtestController extends Controller {

    public function testAction() {
        
        $arr = [];
        $arr_2013 = [];
        $arr_months = [];
        if (isset($_POST['test_xls_newcustomers'])){
            $arr = $this->model->getArrayFromExcel($_FILES['test_xls_newcustomers']['tmp_name']);    
            $arr_2013 = $this->model->getCustomers2013($arr);
            $arr_months = $this->model->getNewCustomersPerMonthSince2014($arr_2013, $arr);
            $this->model->saveNewCustomerToExcel($arr_months); 
            
        }
        
        
        
        $vars = [
            'arr' => $arr,
            'arr_2013' => $arr_2013,
            'arr_months' => $arr_months,
        ];

        $this->view->render('Test', $vars);
    }

}
