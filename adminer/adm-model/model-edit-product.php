<?php
defined ('ADMINER') or die('Access Denied');


function GetProductsForEdit(){
    $arr_products = [];
    
    if (isset($_POST['edit_product'])){
        
        $prod_article = $_POST['prod_name'];

        $link = ConnectionDB();

        $query = "  SELECT p.prod_id, 
                    p.prod_article, 
                    p.prod_model_id, 
                    p.prod_inox, 
                    p.prod_description, 
                    ppv.prod_prop_value_id,  
                    props.prop_id, 
                    props.prop_name,
                    propval.prop_value
                    
                    FROM products p LEFT JOIN prod_prop_values ppv
                    ON p.prod_id=ppv.prod_id LEFT JOIN model_properties mp
                    ON ppv.model_prop_id=mp.model_prop_id LEFT JOIN properties props
                    ON mp.prop_id=props.prop_id LEFT JOIN properties_values propval
                    ON ppv.prop_value_id=propval.prop_value_id
                    WHERE p.prod_article='$prod_article'";
        
        $res = $link->query($query);
        while ($row = $res->fetch_assoc()){
            $arr_products[$row['prod_id']]['prod_article'] = $row['prod_article'];
            $arr_products[$row['prod_id']]['prod_model_id'] = $row['prod_model_id'];
            $arr_products[$row['prod_id']]['prod_inox'] = $row['prod_inox'];
            $arr_products[$row['prod_id']]['prod_description'] = $row['prod_description'];
            $arr_products[$row['prod_id']]['prod_model_id'] = $row['prod_model_id'];
                        
            $arr_products[$row['prod_id']]['dimensions'][$row['prod_prop_value_id']]['prop_id'] = $row['prop_id'];
            $arr_products[$row['prod_id']]['dimensions'][$row['prod_prop_value_id']]['prop_name'] = $row['prop_name'];
            $arr_products[$row['prod_id']]['dimensions'][$row['prod_prop_value_id']]['prop_value'] = $row['prop_value'];
        }

        $link->close();
    }// CREATE ARRAY PRODUCTS FOR EDIT
    
    
    
    if (isset($_POST['edit_product'])){
        
        $prod_prop_value_id = $_POST['prod_prop_value_id'];
        $prop_id = $_POST['prop_id'];
        $prop_value = $_POST['prop_value'];
        $prop_value_id = '';
        
        
        $link = ConnectionDB();
        
        //PROP_VALUE_ID
        $temp = $link->query("SELECT prop_value_id FROM properties_values WHERE prop_id='$prop_id' and prop_value='$prop_value' LIMIT 1");
        if ($temp->num_rows !== 0) {
            $temp = $temp->fetch_assoc();
            $prop_value_id = $temp['prop_value_id'];
        } 
        else {
            $link->query("INSERT INTO properties_values SET prop_id='$prop_id', prop_value='$prop_value'");
            $prop_value_id = $link->insert_id;            
        }
        
        //PROD_PROP_VALUES
        $link->query("UPDATE prod_prop_values SET prop_value_id='$prop_value_id' WHERE prod_prop_value_id='$prod_prop_value_id'");
        
        $link->close();
        
        
    }//EDIT PROPERTY
    
    
    if (isset ($_POST['change_prod_info'])){
                
        $prod_id = $_POST['prod_id'];
        $prod_article = $_POST['prod_article'];
        $prod_description = $_POST['prod_description'];
        $prod_inox = $_POST['prod_inox'];
        
        $link = ConnectionDB();        
        $link->query("UPDATE products SET prod_article='$prod_article', prod_inox='$prod_inox', prod_description='$prod_description' WHERE prod_id='$prod_id'");
        $link->close();
    }//CHANGE DESCRIPTION, INOX, ARTICLE
    
    
       
    
    return $arr_products;
}//GetProductsByModel