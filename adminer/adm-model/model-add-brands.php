<?php
defined ('ADMINER') or die('Access Denied');


function GetBrandsArray(){
    
    $arr_brands = [];
    
    $link = ConnectionDB();
    
    $res = $link->query("SELECT * FROM brands");
    while ($row = $res->fetch_assoc()){
        $arr_brands[$row['brand_id']]['brand_name'] = $row['brand_name'];
        $arr_brands[$row['brand_id']]['brand_descriptor'] = $row['brand_descriptor'];
    }
    
    $link->close();  
    
    return $arr_brands;
}//GetBrandsArray


function AddNewBrand($brand_name, $brand_descriptor){
    
    //Create Folder for new Brand
    $folder = strtolower($brand_name);
    $folder_path = ROOT.'views/akatech/images/models/'.$folder;
    if (!file_exists($folder_path)){
        mkdir($folder_path);
        mkdir($folder_path.'/pic_preview');
        mkdir($folder_path.'/pic_fullsize');
        mkdir($folder_path.'/draw_fullsize');
    }
    
    $link = ConnectionDB();
    $res = $link->query("SELECT brand_id FROM brands WHERE brand_name='$brand_name'");
    if ($res->num_rows !== 0){
        return false;
    }
    else {
        $link->query("INSERT INTO brands SET brand_name='$brand_name', brand_descriptor='$brand_descriptor'");
        return true;
    }
    $link->close();
     
}//AddNewBrand