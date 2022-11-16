<?php


namespace app\controllers;
use app\core\Controller;

class DashboardController extends Controller{

    public function indexAction(){
        $this->view->render("Dashboard");      
    }
    
}
