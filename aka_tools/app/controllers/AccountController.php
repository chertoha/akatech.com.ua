<?php
namespace app\controllers;
use app\core\Controller;

class AccountController extends Controller{

    public function loginAction(){
//        $this->view->redirect('/akatech.com.ua/aka_tools/');
        
        if (!empty($_POST)){
//            $this->view->message('success1', 'message text');
            $this->view->location('/akatech.com.ua/aka_tools/account/register');
        }
        $this->view->render("Log-in");
    }
    
    public function registerAction(){
        $this->view->render("Registration");      
    }
    
}
