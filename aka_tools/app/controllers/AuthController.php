<?php

namespace app\controllers;

use app\core\Controller;

/**
 * Description of AuthController
 *
 * @author Anton
 */
class AuthController extends Controller {

    public function indexAction() {
        
       $this->model->authorization();       
       
        if ($this->model->authorized){
            $this->view->redirect(HOME_DIRECTORY_URL);
        }else{
            $this->view->layout = 'authorization';
            $res = $this->model->getUsers();
            $vars = [
                'arr_all_users' => $res,
                'error' => $this->model->error,
            ];
            $this->view->render('Authorization', $vars);
        }  
    }
}
