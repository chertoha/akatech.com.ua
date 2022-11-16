<?php
defined('ADMINER') or die('Access Denied');

//Create DOM
$html = new DOM('ADMIN ZONE', 'utf8');
$html->AddCSS(ADM_TEMPLATE.'css/adminer.css');

$html->content.= $auth->AuthResult();
$html->Render();
