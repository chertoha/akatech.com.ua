<?php
defined ('ADMINER') or die('Access Denied');

function GetProductsByModel(){
    $arr_products = [];
    
    if (isset($_POST['del_find_products'])){
        
        $model_name = $_POST['model_name'];

        $link = ConnectionDB();

        $query = "  SELECT *
                    FROM products p LEFT JOIN models m
                    ON p.prod_model_id=m.model_id
                    WHERE model_name='$model_name'";
        $res = $link->query($query);
        while ($row = $res->fetch_assoc()){
            $arr_products[$row['prod_id']]['article'] = $row['prod_article'];
            $arr_products[$row['prod_id']]['model_id'] = $row['model_id'];
            $arr_products[$row['prod_id']]['model_name'] = $row['model_name'];
        }

        $link->close();
    }// CREATE ARRAY PRODUCTS BY MODEL
    
    
    
    
    if (isset($_POST['del_products'])){
        
        $arr_del_products_id = $_POST['del_prod_check'];
        
        foreach ($arr_del_products_id as $prod_id){
            $link = ConnectionDB();
            $res = $link->query("DELETE FROM prod_prop_values WHERE prod_id='$prod_id'");
            if ($res){
                $link->query("DELETE FROM products WHERE prod_id='$prod_id'");
            }            
            $link->close();
        }    
        
    }//DELETE
    
       
    
    return $arr_products;
}//GetProductsByModel