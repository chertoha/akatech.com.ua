<?php


/*Заполнение списка категорий*/
if (isset($_POST['input'])){
    
    if ($_POST['input'] === 'cat'){
        $html_text = '';
        
        $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
        $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
        if (!empty($link->connect_error)) {
            die('No connection to server, error: ' . $link->connect_error);
        }
        
        $res = $link->query("SELECT * FROM tree_products WHERE tree_prod_parent_id=0 ORDER BY tree_prod_order");
        while($row = $res->fetch_assoc()){
            $html_text.= '<option value='.$row['tree_prod_id'].'>'.$row['tree_prod_name'].'</option>';
        }
        
        $link->close();
        if ($html_text !== ''){
           echo $html_text; 
        }
        else {
            echo -1;
        }
    }//CATEGORIES    
    
}//CATEGORIES



/*Заполнение списка под-категорий*/
if (isset($_POST['input'])){
    
    if ($_POST['input'] === 'subCat'){
        $html_text = '';
        $cat_id = $_POST['cat_id'];
        
        $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
        $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
        if (!empty($link->connect_error)) {
            die('No connection to server, error: ' . $link->connect_error);
        }
        
        $res = $link->query("SELECT * FROM tree_products WHERE tree_prod_parent_id='$cat_id' ORDER BY tree_prod_order");
        while($row = $res->fetch_assoc()){
            $html_text.= '<option value='.$row['tree_prod_id'].'>'.$row['tree_prod_name'].'</option>';
        }
        
        $link->close();
        if ($html_text !== ''){
           echo $html_text; 
        }
        else {
            echo -1;
        }
    }//CATEGORIES    
    
}//PROD_GROUPS


/*Заполнение списка Брендов*/
if (isset($_POST['input'])){
    
    if ($_POST['input'] === 'brands'){
        $html_text = '';
        
        $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
        $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
        if (!empty($link->connect_error)) {
            die('No connection to server, error: ' . $link->connect_error);
        }
        
        $res = $link->query("SELECT * FROM brands");
        while($row = $res->fetch_assoc()){
            $html_text.= '<option value='.$row['brand_id'].'>'.$row['brand_name'].'</option>';
        }
        
        $link->close();
        if ($html_text !== ''){
           echo $html_text; 
        }
        else {
            echo -1;
        }
    }//if
    
}//BRANDS   


/*Заполнение списка Серий*/
if (isset($_POST['input'])){
    
    if ($_POST['input'] === 'series'){
        $html_text = '';
        $brand_id = $_POST['brand_id'];
        
        $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
        $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
        if (!empty($link->connect_error)) {
            die('No connection to server, error: ' . $link->connect_error);
        }
        
        $res = $link->query("SELECT * FROM series WHERE brand_id='$brand_id'");
        while($row = $res->fetch_assoc()){
            $html_text.= '<option value='.$row['serie_id'].'>'.$row['serie_name'].'</option>';
        }
        
        $link->close();
        if ($html_text !== ''){
           echo $html_text; 
        }
        else {
            echo -1;
        }
    }//if  
    
}//SERIES LIST



/*Заполнение чекбоксов моделей*/
if (isset($_POST['input'])){
    
    if ($_POST['input'] === 'models'){
        $html_text = '';
        $serie_id = $_POST['serie_id'];
        
        $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
        $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
        if (!empty($link->connect_error)) {
            die('No connection to server, error: ' . $link->connect_error);
        }
        
        $res = $link->query("SELECT * FROM models WHERE serie_id='$serie_id'");
        while($row = $res->fetch_assoc()){
            $html_text.= '<div class=""><label><input class="" type="checkbox" name="mods_id[]" value="'.$row['model_id'].'" >'.$row['model_name'].'</label></div>';
            
        }
        
        $link->close();
        if ($html_text !== ''){
           echo $html_text; 
        }
        else {
            echo -1;
        }
    }//if  
    
}//MODELS LIST


/*Заполнение моделей в PROD GROUPS */
if (isset($_POST['input'])){
    
    if ($_POST['input'] === 'prodGroups'){
        $html_text = '';
        $tree_prod_id = $_POST['subCatId'];
        
        $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
        $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
        if (!empty($link->connect_error)) {
            die('No connection to server, error: ' . $link->connect_error);
        }
        
        $res = $link->query("   SELECT * 
                                FROM product_groups pg LEFT JOIN models m
                                ON pg.model_id=m.model_id
                                WHERE tree_prod_id='$tree_prod_id' ORDER BY prod_groups_order");
        
        while($row = $res->fetch_assoc()){
            $icon_visible = ($row['prod_groups_visible'] == 1) ? 'glyphicon-eye-open' : 'glyphicon-eye-close';
            $button_visible = ($row['prod_groups_visible'] == 1) ? 'btn-success' : 'btn-default';
            
            $html_text.='<div class=""> '
                    . '<span class="moveOrder leftOrder btn btn-default btn-xs"> < </span> '
                    . '<input type="hidden" name="prod_groups_id" value="'.$row['prod_groups_id'].'">'
                    . '<input type="hidden" name="prod_groups_order" value="'.$row['prod_groups_order'].'">'
                    . '<input type="hidden" name="tree_prod_id" value="'.$row['tree_prod_id'].'">'
                    . '<span>'.$row['model_name'].'</span> '
                    . '<input type="hidden" name="prod_groups_visible" value="'.$row['prod_groups_visible'].'">'
                    . '<span class="visibleModel btn '.$button_visible.' btn-xs glyphicon '.$icon_visible.'"> </span> '
                    . '<span class="delModel btn btn-danger btn-xs"> x </span> '
                    . '<span class="moveOrder rightOrder btn btn-default btn-xs"> > </span> '                    
                    . '</div>';
            
            
        }
        
        $link->close();
        if ($html_text !== ''){
           echo $html_text; 
        }
        else {
            echo -1;
        }
    }//if  
    
}//PROD GROUPS MODELS LIST



/*Перемещение элемента вверх/вниз по списку*/
if (isset($_POST['move'])){
    
    $query = '';
    $tree_prod_id = $_POST['tree_prod_id'];
    $id1 = $_POST['prod_groups_id'];
    $id2 = '';
    $order_val_id1 = $_POST['prod_groups_order'];
    $order_val_id2 = '';
    
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
        
    if ($_POST['move'] === 'leftOrder') {
        $query = "SELECT * FROM product_groups WHERE prod_groups_order < $order_val_id1 AND tree_prod_id='$tree_prod_id' ORDER BY prod_groups_order DESC LIMIT 1";
    } else if ($_POST['move'] === 'rightOrder') {
        $query = "SELECT * FROM product_groups WHERE prod_groups_order > $order_val_id1 AND tree_prod_id='$tree_prod_id' ORDER BY prod_groups_order LIMIT 1";
    }
    
    
    $res = $link->query($query);
    
    if ($res->num_rows !== 0){
        $res = $res->fetch_assoc();
        $id2 = $res['prod_groups_id'];  
        $order_val_id2 = $res['prod_groups_order'];
        $link->query("UPDATE product_groups SET prod_groups_order='$order_val_id1' WHERE prod_groups_id='$id2'");
        $link->query("UPDATE product_groups SET prod_groups_order='$order_val_id2' WHERE prod_groups_id='$id1'");               
    }//if        
    
    
}//MOVE



/*Удаление элемента в списке*/
if(isset($_POST['delModel'])){
    $prod_groups_id = $_POST['prod_groups_id'];
    
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    $link->query("DELETE FROM product_groups WHERE prod_groups_id='$prod_groups_id'");
    
    $link->close();
}// DEL MODEL



/* Установка видимости модели*/
if (isset($_POST['visibility'])){
    
    $prod_groups_id = $_POST['prod_groups_id'];
    $prod_groups_visible = $_POST['visibility'];    
    
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    $link->query("UPDATE product_groups SET prod_groups_visible='$prod_groups_visible' WHERE prod_groups_id='$prod_groups_id'");
    
    $link->close();
    
    
}//VISIBILITY

