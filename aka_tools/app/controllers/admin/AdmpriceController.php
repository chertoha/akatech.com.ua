<?php

namespace app\controllers\admin;
use app\core\Controller;


class AdmpriceController extends Controller {

    public function priceAction() {
        
        $arr_articles = [];
        if (isset($_POST['export_brands'])) {
            echo $this->model->getBrands();
            exit;
        }       
        
        if (isset($_POST['export_brand_toexcel'])){
            $arr_articles = $this->model->exportArticlesToExcel($_POST['export_brand_id']);
        }   
        
        if (isset($_POST['import_excel'])){
            $arr = $this->model->getArrayFromExcel($_FILES['import_excel_file']['tmp_name']);
            $this->model->setPrices($arr);            
        }
        
        $vars = [
            'arr_articles' => $arr_articles,
        ];        
        $this->view->render('Price', $vars);
    }

}
