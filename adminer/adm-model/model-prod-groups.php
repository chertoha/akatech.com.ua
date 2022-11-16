<?php
defined ('ADMINER') or die('Access Denied');


// Массив моделей
function getModelsArray(){
    $link = ConnectionDB();   
    
    $arr_models = [];       
    $res = $link->query("SELECT model_id, model_name FROM models");
    while ($row = $res->fetch_assoc()){
        $arr_models[] = $row;
    }//while
        
    $link->close();
    return $arr_models;
}//getModelsArray



// Добавление/Удаление моделей в PRODUCT_GROUPS
function ProdGroups(){
    
    //DELETE ALL MODELS
    if (isset($_POST['delAllModels'])){
        $tree_prod_id = $_POST['selectSubCat'];
        
        $link = ConnectionDB();        
        $link->query("DELETE FROM product_groups WHERE tree_prod_id='$tree_prod_id'");
        $link->close();
    }//if
    
        
    //ADD MODELS
    if (isset($_POST['add']) && !empty($_POST['tree_prod_id']) && !empty($_POST['mods_id'])) {
        
        $link = ConnectionDB();
        
        $arr_models = $_POST['mods_id'];
        $tree_prod_id = $_POST['tree_prod_id'];
        
        
        foreach($arr_models as $model_id){
            $res = $link->query("SELECT * FROM product_groups WHERE tree_prod_id='$tree_prod_id' AND model_id='$model_id'");
            if ($res->num_rows === 0 ){
                
                $res = $link->query("SELECT MAX(prod_groups_order) max_order_value  FROM product_groups WHERE tree_prod_id='$tree_prod_id'");
                $res = $res->fetch_assoc();
                $max_order_value = $res['max_order_value'] + 1;

                $query = "INSERT INTO product_groups SET "
                        . "tree_prod_id='$tree_prod_id', "
                        . "model_id='$model_id', "
                        . "prod_groups_order='$max_order_value',"
                        . "prod_groups_visible='1'";
                $link->query($query);
            }
        }//foreach
        
        $link->close();
    }//if 
    
    
}//AddProdGroups


