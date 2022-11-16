<?php

namespace app\controllers\sales;

use app\core\Controller;

/**
 * Description of SalesController
 *
 * @author Anton
 */
class AutokpController extends Controller {

    public function indexAction() {
        $period = 60; //default period - days
        
        if (isset($_POST['autokp_id'])){
            $this->model->getAutokpProducts($_POST['autokp_id']);           
            exit;
        }
        if (isset($_POST['autokp_clear'])){
            $this->model->clearAutokp();
        }
        
        if (isset($_POST['period'])) {
            $_SESSION['all']['autokp']['period'] = $_POST['period'];
        } 
        if (isset($_SESSION['all']['autokp']['period'])) {
            $period = $_SESSION['all']['autokp']['period'];
        }
        
        $autokp_list = $this->model->getAutokpList($period);
        
        
        
        
        
        $vars = [
            'period' => $period,
            'autokp_list' => $autokp_list,            
        ];
        $this->view->render('Auto KP', $vars);
    }
    

    public function searchAction() {
        $articles = [];
        $brand = '';
        $model_img = '';

        if (isset($_POST['autokp_brands'])) {
            echo $this->model->getBrands();
            exit;
        }

        if (isset($_POST['autokp_series'])) {
            echo $this->model->getSeries($_POST['brand_id']);
            exit;
        }

        if (isset($_POST['autokp_models'])) {
            echo $this->model->getModels($_POST['serie_id']);
            exit;
        }

        if (isset($_POST['autokp_model_id'])) {
            $articles = $this->model->getArticles($_POST['autokp_model_id']);
            $brand = $this->model->getBrandById($_POST['autokp_brand_id']);
            $model_img = $this->model->getModelImagePreview($_POST['autokp_model_id']);
        }

        if (isset($_POST['autokp_search_find'])) {
            $articles = $this->model->searchArticles($_POST['autokp_search_value']);
        }

        if (isset($_POST['autokp_add_articles'])) {
            echo $this->model->setArticlesToKP($_POST['autokp_add_articles']);
            exit;
        }

        if (isset($_POST['autokp_clear_list'])) {
            $this->model->clearAutokp();
            exit;
        }

        if (isset($_POST['autokp_del_article_id'])) {
            $this->model->delArticleFromKp($_POST['autokp_del_article_id']);
            exit;
        }

        $vars = [
            'articles' => $articles,
            'brand' => $brand,
            'model_img' => $model_img,
        ];
        $this->view->render('Auto KP- Search', $vars);
    }

    public function pricingAction() {

        if (isset($_POST['getArrFromSession'])) {
            $res = $this->model->getArrAutokpFromSession();
            if (!empty($res)) {
                echo json_encode($res);
            } else {
                echo -1;
            }
            exit;
        }

        if (isset($_POST['update_session'])) {
            $this->model->updateSession($_POST);
            exit;
        }

        $this->view->render('Auto KP- Pricing');
    }

    public function templatesAction() {

        $templates = [
            
            'default_ukr' => [
                'name' => 'default_ukr',
                'path' => ROOT . PUBLIC_FOLDER . 'autokp/templates/default_template_ukr.php',
                'img_preview_path' => IMAGES_FOLDER . 'templates/templlate_std.jpg',
            ],
            
            'simple_ukr' => [
                'name' => 'simple_ukr',
                'path' => ROOT . PUBLIC_FOLDER . 'autokp/templates/simple_template_ukr.php',
                'img_preview_path' => IMAGES_FOLDER . 'templates/template_simple.jpg',
            ],
            
            'default' => [
                'name' => 'default_ru',
                'path' => ROOT . PUBLIC_FOLDER . 'autokp/templates/default_template.php',
                'img_preview_path' => IMAGES_FOLDER . 'templates/templlate_std.jpg',
            ],
            
            'simple' => [
                'name' => 'simple_ru',
                'path' => ROOT . PUBLIC_FOLDER . 'autokp/templates/simple_template.php',
                'img_preview_path' => IMAGES_FOLDER . 'templates/template_simple.jpg',
            ],
            
            'default2' => [
                'name' => 'default2_ru',
                'path' => ROOT . PUBLIC_FOLDER . 'autokp/templates/default_template2.php',
                'img_preview_path' => IMAGES_FOLDER . 'templates/templlate_std2.jpg',
            ],
            
            'simple2' => [
                'name' => 'simple2_ru',
                'path' => ROOT . PUBLIC_FOLDER . 'autokp/templates/simple_template2.php',
                'img_preview_path' => IMAGES_FOLDER . 'templates/template_simple2.jpg',
            ],
            
            
        ];

//        unset($_SESSION['template']);
        if (!isset($_SESSION['template'])) {
            $_SESSION['template'] = $templates['default'];
        }

        if (isset($_POST['template_key'])) {
            $template = $_POST['template_key'];
            if (isset($templates[$template])) {
                $_SESSION['template'] = $templates[$template];
            }
            exit;
        }

        $vars = [
            'templates' => $templates,
        ];

        $this->view->render('Auto KP- Templates', $vars);
    }

    public function customerAction() {

        if (isset($_POST['autokp_customer_data'])) {
            if (isset($_SESSION['customer_data'])) {
                unset($_SESSION['customer_data']);
            }
            $_SESSION['customer_data'] = $_POST;
        }

        $this->view->render('Auto KP- Customer');
    }

    public function buildAction() {
        $error = '';

        if (isset($_POST['autokp_build'])) {
            $error = $this->model->build();
        }
        if (isset($_POST['autokp_build_save_data'])) {
            $this->model->saveData($_POST);
            exit;
        }


        if (isset($_POST['autokp_save_pdf'])) {
            if (isset($_SESSION['autokp_save_data'])) {   
                $id = $this->model->saveAutokpToDb();
                $this->model->savePdf($id); 
//                $this->view->redirect(HOME_DIRECTORY_URL . 'sales/autokp');
            } else {                  
                $error = 'No data';
            }
        }

        $vars = [ 
            'error' => $error,
        ];
        $this->view->render('Auto KP- Build', $vars);
    }

}
