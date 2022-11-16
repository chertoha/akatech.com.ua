<?php
header('Content-Type: text/html; charset=utf-8');

// Отображение всех видов ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
// Запрет прямого обращения 
define('AKA_TOOLS',TRUE);

//Константы
require_once 'app/config/const.php';

//Библиотеки
require_once 'app/lib/lib.php';


spl_autoload_register(function($class){
    $class_path = str_replace('\\', '/', $class.'.php');
    if(file_exists($class_path)){
        require $class_path;
    }
});

session_start();

$router = new \app\core\Router();
$router->run();



// MERGED change_MVC to master
// new branch - autokp

