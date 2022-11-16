<?php
header('Content-Type: text/html; charset=utf-8');
define('ADMINER',TRUE);
session_start();

// Подключение файла конфигурации
require_once 'adm-config.php';
// Подключение контроллера
require_once ADM_CONTROLLER;


//if (!isset($_SESSION['auth'])) {
//    header('location: authorization.php');
//    exit;
//}





