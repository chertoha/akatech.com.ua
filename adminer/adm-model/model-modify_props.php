<?php defined('ADMINER') or die('Access Denied'); ?>
<?php


function ModelModifyProperties(){
    
    $arrEmptyProps = [];
    
    if (isset($_POST['search_empty_model_properties'])){
        
        $link = ConnectionDB();  
        
        $query = "  SELECT  mp.model_prop_id,
                            mp.model_id,
                            mp.prop_id,
                            p.prop_name,
                            m.model_name
                    FROM model_properties mp LEFT JOIN properties p
                    ON mp.prop_id=p.prop_id LEFT JOIN models m
                    ON mp.model_id=m.model_id
                    WHERE mp.model_prop_id NOT IN (SELECT model_prop_id  FROM prod_prop_values)";
        $res = $link->query($query);
        while ($row = $res->fetch_assoc()){
            $arrEmptyProps[$row['model_id']]['model_name'] = $row['model_name'];
            $arrEmptyProps[$row['model_id']]['properties'][$row['model_prop_id']]['prop_id'] = $row['prop_id'];
            $arrEmptyProps[$row['model_id']]['properties'][$row['model_prop_id']]['prop_name'] = $row['prop_name'];
        }
        
        
        $link->close();
        
    }//SEARCH EMPTY PROPERTIES
    
    
    
    if (isset($_POST['delete_empty_props'])){
        $arr_empty_props = $_POST['model_prop_id'];
        $text_process = '';
        echo '!!!!!!!!!!!!!!!!!!!!';
        $link = ConnectionDB();
        foreach ($arr_empty_props as $key => $model_prop_id){
            $res = $link->query("DELETE FROM model_properties WHERE model_prop_id='$model_prop_id'");
            
        }
        
        $link->close();
    }//DELETE EMPTY PROPERTIES
    
    
    return $arrEmptyProps;
    
}//ModelEmptyModelProperties
