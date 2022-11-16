<?php
defined ('AKATECH') or die('Access Denied');


// Домен
//define('PATH','http://192.168.205.111/akatech.com.ua/Release/');

// Модель
define('MODEL','model/model.php');

// Контроллер
define('CONTROLLER','controller/controller.php');

// Виды
define('VIEW','views/');

// Активный шаблон
define('TEMPLATE',VIEW.'akatech/');

// Сервер базы данных
define('HOST','localhost');

// Пользователь, который имеет доступ к базе данных
define('USER','root');

// Пароль пользователя к базе данных
define('PASS','root');

// База данных
define('DB','akatech_db');

// Название сайта - title
//define('TITLE','Комплектующие для машиностроения');


//Проверка подключения к базе данных
$link = new mysqli(HOST, USER, PASS);
if (!empty($link->connect_error)) {   
    die('No connection to server, error: ' . $link->connect_error);    
}
$link->select_db(DB) or die('No connect to DB');
$link->query("SET NAMES 'UTF8'") or die('Cant set charset');
$link->close();


// Адрес электронной почты для запросов по умолчанию
define('REQUEST_EMAIL', 'a.chertok@akatech.com.ua');