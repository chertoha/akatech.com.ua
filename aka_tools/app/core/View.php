<?php

namespace app\core;

class View {

    public $path;
    public $route;
    public $layout = 'default';

    function __construct($route) {
        $this->route = $route;
        if (isset($route['folder'])){            
            $this->path = $route['folder']. '/' . $route['controller'] . '/' . $route['action'];                      
        } else {
            $this->path = $route['controller'] . '/' . $route['action'];
        }
        
    }

    public function render($title, $vars = []) {        
        extract($vars);
        $render_path = VIEWS . $this->path . '.php';
//        var_dump($render_path);
        if (file_exists($render_path)) {
            ob_start();
            require $render_path;
            $content = ob_get_clean();
            require 'app/views/layouts/' . $this->layout . '.php';
        }
    }    
       
    public function redirect($url){
        header('location: '.$url);
        exit;
    }


    public static function errorCode($code){
        http_response_code($code);  
        require 'app/views/errors/'.$code.'.php';
        exit();
    }
    
    public function message($status, $message){
        exit(json_encode(['status' => $status, 'message' => $message]));
    }
    
    public function location($url){
        exit(json_encode(['url' => $url]));
    }

}
