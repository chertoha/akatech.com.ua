<?php
defined ('ADMINER') or die('Access Denied');

// Домен
//define('PATH','http://192.168.205.111/akatech.com.ua/Release/adminer');



// Библиотеки
define('ADM_LIB','adm-lib/');

// Модель
define('ADM_MODEL','adm-model/adm-model.php');

// Контроллер
define('ADM_CONTROLLER','adm-controller/adm-controller.php');

// Виды
define('ADM_VIEW','adm-views/');

// Активный шаблон
define('ADM_TEMPLATE',ADM_VIEW.'admin-view/');


// Путь к картинкам сайта
define ('ADM_SITE_IMAGES', '../views/akatech/images/');

//Корневая папка
define ('ROOT', $_SERVER['DOCUMENT_ROOT'].'/akatech.com.ua/Release/');

// Сервер базы данных
define('ADM_HOST','localhost');

// Пользователь, который имеет доступ к базе данных
define('ADM_USER','root');

// Пароль пользователя к базе данных
define('ADM_PASS','root');

// База данных
define('ADM_DB','akatech_db');

// Название сайта - title
define('ADM_TITLE','Adminer');


//Проверка подключения к базе данных
$link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS);
if (!empty($link->connect_error)) {   
    die('No connection to server, error: ' . $link->connect_error);    
}
$link->select_db(ADM_DB) or die('No connect to DB');
$link->query("SET NAMES 'UTF8'") or die('Cant set charset');
$link->close();