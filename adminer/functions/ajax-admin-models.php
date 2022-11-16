<?php


//CHANGE PARAMETER VALUE
if (isset($_POST['change_param_value'])){
    
    $new_param_value = $_POST['change_param_value'];
    $model_specific_id = $_POST['model_specific_id'];
    $param_id = $_POST['param_id'];
    $model_sp_param_val_id = '';
    
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
        
    }
    
    
    
    $res = $link->query("SELECT model_sp_param_val_id FROM model_specific_params_values WHERE "
            . "model_specific_param_id='$param_id' AND "
            . "model_sp_param_val='$new_param_value' LIMIT 1");
    
    
    
    if ($res->num_rows !== 0){
        $res = $res->fetch_assoc();
        $model_sp_param_val_id = $res['model_sp_param_val_id'];
        
    }//if
    else {
        $link->query("INSERT INTO model_specific_params_values SET "
                . "model_specific_param_id='$param_id',"
                . "model_sp_param_val='$new_param_value'");
        $model_sp_param_val_id = $link->insert_id;
    }
    
    $link->query("UPDATE model_specifications SET "
            . "model_sp_param_val_id='$model_sp_param_val_id' WHERE model_specific_id='$model_specific_id'");
    
    $link->close();
    
}//CHANGE PARAMETER VALUE


//VISIBILITY OF PARAMETER'S VALUES
if (isset($_POST['param_val_visibility'])){
    
    $param_val_visibility = $_POST['param_val_visibility'];
    $model_specific_id = $_POST['model_specific_id'];
    
    if ($param_val_visibility != '1'){
        $param_val_visibility = '0';
    }    
    
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
        
    }    
    $link->query("UPDATE model_specifications SET model_sp_param_visible='$param_val_visibility' WHERE model_specific_id='$model_specific_id'");
    $link->close();
        
}//VISIBILITY OF PARAMETER'S VALUES



//CHANGE MODEL INFORMATION
if (isset($_POST['change_model_info'])){
    
    $model_id = $_POST['model_id'];
    $new_model_info = $_POST['change_model_info'];
    $model_info_id = '';
    
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
        
    }    
    
    
    $res = $link->query("SELECT model_info_id FROM models_information WHERE model_id='$model_id'");
    if ($res->num_rows !== 0){      
      $link->query("UPDATE models_information SET model_info_text='$new_model_info' WHERE model_id='$model_id'");
    }
    else {
        $link->query("INSERT INTO models_information SET model_id='$model_id', model_info_text='$new_model_info' ");
    }
    
        
    $link->close();
    
}//CHANGE MODEL INFORMATION



// ONSALE-ONSTOCK
if (isset($_POST['sale_stock'])){
    
    $model_id = $_POST['model_id'];
    $check_value = $_POST['checkVal'];
    $sale_or_stock = $_POST['sale_stock'];
    
    
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
        
    }  
    
    if ($sale_or_stock === 'onstock'){
        $link->query("UPDATE models SET model_onstock='$check_value' WHERE model_id='$model_id'");
    }
    else if ($sale_or_stock === 'onsale'){
        $link->query("UPDATE models SET model_onsale='$check_value' WHERE model_id='$model_id'");
    }
        
    $link->close();
    
}// ONSALE-ONSTOCK