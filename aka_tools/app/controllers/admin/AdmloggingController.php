<?php

namespace app\controllers\admin;
use app\core\Controller;

class AdmloggingController extends Controller {
    
    
    public function loggingAction(){
//        $result = $this->model->getLogs();
        $vars = [
//            'arr_logs' => $result,
        ];
        $this->view->render('Logging', $vars);
    }
    
    
}
