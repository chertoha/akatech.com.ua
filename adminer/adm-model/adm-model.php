<?php
defined ('ADMINER') or die('Access Denied');

set_time_limit(0);

include ADM_LIB.'PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
/** PHPExcel_Writer_Excel2007 */
include ADM_LIB.'PHPExcel_1.8.0_doc/Classes/PHPExcel/Writer/Excel2007.php';
/** PHPExcel_IOFactory */
include ADM_LIB.'PHPExcel_1.8.0_doc/Classes/IOFactory.php';

require_once ADM_LIB.'classHtml1.03.php';
require_once ADM_LIB.'auth.php';
require_once 'model-tree-products.php';
require_once 'files.php';
require_once 'model-prod-groups.php';
require_once 'model-admin-models.php';
require_once 'model-news.php';
require_once 'model-modify_props.php';
require_once 'model-del-product.php';
require_once 'model-edit-product.php';
require_once 'model-add-brands.php';
require_once 'model-add-excel.php';
require_once 'model-add-images.php';


function ConnectionDB() {
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    return $link;
}//ConnectionDB