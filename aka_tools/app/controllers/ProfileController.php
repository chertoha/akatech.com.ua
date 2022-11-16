<?php

namespace app\controllers;

use app\core\Controller;

class ProfileController extends Controller {

    public function indexAction() {
        $errors = '';
        if (isset($_POST['avatar_download'])) {
            if ($_FILES['avatar_image']['name'] != '') {
                $errors = $this->model->downloadAvatar($_FILES['avatar_image'], $_POST['user_id'] );
            }else{
                $errors = 'Файл не загружен';
            }
        }

          $avatar_image = $this->model->getAvatar($_SESSION['auth']['user_id']);  
//        $profile_data_list = $this->model->getProfileDataList();
//        $profile_data_list = $this->model->orderArrByKey($this->model->getProfileDataList(), 'profile_data_priority');
          
        $vars = [
            'avatar_image' => $avatar_image,
            'errors' => $errors, 
//            'profile_data_list' => $profile_data_list,
                       
        ];
        $this->view->render('Profile', $vars);
    }

}
