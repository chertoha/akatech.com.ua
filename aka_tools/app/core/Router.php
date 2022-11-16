<?php

namespace app\core;

use app\core\View;

class Router {
    protected $arr_routes =[];
    protected $routes = [];
    protected $params = [];

    public function __construct() {
        $this->arr_routes = require 'app/config/routes.php';
        foreach ($this->arr_routes as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add($route, $params) {
        $route = '#^' . $route . "$#";
        $this->routes[$route] = $params;
    }

    public function match() {
        $matches = [];
        $url = str_replace(HOME_DIRECTORY_URL, '', $_SERVER['REQUEST_URI']);
//        $url = trim($url, '.php');
        $url = str_replace('.php', '', $url);
//        var_dump($url);
        $url = trim($url, '/');

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run() {
        
        if (isset($_SESSION['auth'])) {
            if ($this->match()) {
                if (isset($this->params['folder'])){
                    $path = 'app\controllers\\'. $this->params['folder'] . '\\' . ucfirst($this->params['controller']) . 'Controller';
                }
                else{
                    $path = 'app\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
                }
                if (class_exists($path)) {
                    $action = $this->params['action'] . 'Action';
                    if (method_exists($path, $action)) {
                        $controller = new $path($this->params);
                        $controller->$action();
                    } else {
                        echo 'not found method Action ' . $action;
                        View::errorCode(404);
                    }
                } else {
                    echo 'not found Class ' . $path;
                    View::errorCode(404);
                }
            } else {
                echo 'not found route ';
                View::errorCode(404);
            }
        } else {
            $controller = new \app\controllers\AuthController($this->arr_routes['auth']);
            $controller->indexAction();
        }
    }

}
