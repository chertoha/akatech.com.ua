<?php

// main folder
//define('HOME_DIRECTORY_URL', '/akatech.com.ua/aka_tools/'); // for localhost
define('HOME_DIRECTORY_URL', '/aka_tools/'); // for hosting

// folder 'public'
define('PUBLIC_FOLDER', HOME_DIRECTORY_URL . 'public/');


// folder 'public/scripts'
define('SCRIPTS_FOLDER', PUBLIC_FOLDER . 'scripts/');

// folder 'public/css'
define('CSS_FOLDER', PUBLIC_FOLDER . 'css/');

// folder 'public/images'
define('IMAGES_FOLDER', PUBLIC_FOLDER . 'images/');

// folder 'public/fonts'
define('FONTS_FOLDER', PUBLIC_FOLDER . 'fonts/');


// VIEWS
define('VIEWS', 'app/views/');

//LIB
define('LIB', 'app/lib/');


define('ADMIN', 'admin');


// числовые константы для VIEWS
define('SHIPMENT_RECEIVED_ID', 5); // статус "Доставлен" id = 5 . Для logistics/tracking, admin/tracking 
//Значение допуска в БД auth_users 
define('USER_ALLOWED_VALUE', '1');

//Корневая папка на сервере
define('ROOT', $_SERVER['DOCUMENT_ROOT']); //  '/var/www/html'
//DB config path -  db.php
define('DB_CONFIG_PATH', 'app/config/db.php');

//DB config path -  db.php
define('DB_AKA_CONFIG_PATH', 'app/config/db_aka.php');


// Доступ к папкам картинок сайта akatech.com.ua
define('IMG_MODELS_AKA', 'http://akatech.com.ua/views/akatech/images/models/');


// DOWNLOADS FOLDER

define('DOWNLOADS', ROOT . PUBLIC_FOLDER . 'downloads/');
