<?php
defined ('ADMINER') or die('Access Denied');

// Подключение модели
require_once ADM_MODEL;



$auth = new Auth();
$auth->Authorization();
if (!$auth->authorized){
    require_once ADM_TEMPLATE.'authorization.php'; 
    die;
}

$view = (empty($_GET['view'])) ? 'tree' : $_GET['view'];





require_once ADM_TEMPLATE.'index.php'; 








