<?php
header('Content-Type: text/html; charset=utf-8');

// Запрет прямого обращения 
define('AKATECH',TRUE);

// Открытие новой сессии
session_start();

// Подключение файла конфигурации
require_once 'config.php';

// Подключение контроллера
require_once CONTROLLER;


