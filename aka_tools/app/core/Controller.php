<?php

namespace app\core;

use app\core\View;

abstract class Controller {

    public $route;
    public $view;
    public $model;
    public $acl;

    function __construct($route) { 
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
        
        //Logs
        if (isset($_SESSION['auth']['user_id'])){            
           $log = new \app\lib\Logging();
           $log->logData($_SESSION['auth']['user_id'], $_SERVER['REQUEST_URI']);
        }
    }

    public function loadModel($name) {
        if (isset($this->route['folder'])) {
            $path = 'app\models\\'. $this->route['folder']. '\\'. ucfirst($name);
        }
        else {
            $path = 'app\models\\' . ucfirst($name);
        }        
        
        if (class_exists($path)) {
            return new $path();
        }
    }

    public function checkAcl() {
        if (isset($this->route['folder'])) {
            $this->acl = require 'app/acl/' . $this->route['folder'] . '/' . $this->route['controller'] . '.php';
        }
        else {
            $this->acl = require 'app/acl/' . $this->route['controller'] . '.php';
        }
        
        if ($this->isAcl('all')) {
            return true;
        }
//        elseif (isset($_SESSION['auth']['user_id']) && $this->isAcl('authorize')){
//            return true;
//        }
//        elseif (!isset($_SESSION['auth']['user_id']) && $this->isAcl('guest')){
//            return true;
//        }
        elseif ($_SESSION['auth']['role_name'] == 'admin' && $this->isAcl('admin')) {
            return true;
        }
        return false;
    }

    public function isAcl($key) {
        return in_array($this->route['action'], $this->acl[$key]);
    }

}
