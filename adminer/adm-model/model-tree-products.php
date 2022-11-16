<?php
defined ('ADMINER') or die('Access Denied');


/*----Получение массива главных разделов----*/
function adminMainListOverview(){        
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    
    $arr_main_list[0]= [
        'tree_prod_id' => '0' ,
        'tree_prod_name' => 'ОСНОВНЫЕ РАЗДЕЛЫ'];
        
    $res = $link->query("SELECT * FROM tree_products WHERE tree_prod_parent_id=0 ORDER BY tree_prod_order");
    while ($row = $res->fetch_assoc()){
            $arr_main_list[]= $row;
//        $arr_main_list[$row['tree_prod_id']] = $row['tree_prod_name'];
    }//while
    $link->close();
    return $arr_main_list;
}//adminMainListOverview()



/*----Получение массива выбранного раздела----*/
function adminOverviewArray($tree_prod_parent_id){
    
    //Подключение к БД
    $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    
    
    //1)Перемещение элемента вверх/вниз по списку
    if (isset($_POST['moveup']) || isset($_POST['movedown'])){
        $id1 = $_POST['tree_prod_id'];
        $id2 = '';
        $order_val_id1 = $_POST['tree_prod_order'];
        $order_val_id2 = '';
        
        if (isset($_POST['moveup'])){
            $query = "SELECT * FROM tree_products WHERE tree_prod_order < $order_val_id1 AND tree_prod_parent_id=$tree_prod_parent_id ORDER BY tree_prod_order DESC LIMIT 1";
        }
        else if (isset($_POST['movedown'])){
          $query = "SELECT * FROM tree_products WHERE tree_prod_order > $order_val_id1 AND tree_prod_parent_id=$tree_prod_parent_id ORDER BY tree_prod_order LIMIT 1";
        }
        
        $res = $link->query($query);
        
        if ($res->num_rows !== 0){
            $res = $res->fetch_assoc();
            $id2 = $res['tree_prod_id'];  
            $order_val_id2 = $res['tree_prod_order'];
            $link->query("UPDATE tree_products SET tree_prod_order=$order_val_id1 WHERE tree_prod_id=$id2");
            $link->query("UPDATE tree_products SET tree_prod_order=$order_val_id2 WHERE tree_prod_id=$id1");               
        }//if        
    }//if  UP/DOWN
    
       
    //Сохранить 
    if (isset($_POST['save'])){
                
        $tree_prod_id = $_POST['tree_prod_id'];
        $tree_prod_name = $_POST['tree_prod_name'];
        $tree_prod_img = '';
        
        if (!empty($_FILES['pic']['name'])){
            $tree_prod_img = saveFileImg(ROOT.'views/akatech/images/overview/');
        }        
        if (empty($tree_prod_img)){
            $tree_prod_img = $_POST['tree_prod_img'];
        }       
        
        $tree_prod_description = $_POST['tree_prod_description'];
        if (isset($_POST['tree_prod_visible'])){
            $tree_prod_visible = 1; 
        }
        else{
            $tree_prod_visible = 0;
        }
        $output_type_id = $_POST['output_type_id'];
        
        $meta_keywords = $_POST['meta_keywords'];
        $meta_description = $_POST['meta_description'];
        
        
        $query = "UPDATE tree_products "
                . "SET "
                . "tree_prod_name='$tree_prod_name', "
                . "tree_prod_img='$tree_prod_img', "
                . "tree_prod_description='$tree_prod_description', "
                . "tree_prod_visible='$tree_prod_visible',"
                . "output_type_id ='$output_type_id' "
                . "WHERE tree_prod_id='$tree_prod_id'";
        $link->query($query);

        //Установить видимость подразделов в соответствии с видимостью раздела
        $link->query("UPDATE tree_products SET tree_prod_visible='$tree_prod_visible' WHERE tree_prod_parent_id='$tree_prod_id'");
        
        // Запись мета тегов в таблицу meta_tags
        $temp = $link->query("SELECT meta_tags_id FROM meta_tags WHERE meta_tree_prod_id='$tree_prod_id' LIMIT 1");
        if ($temp->num_rows !== 0){
            $link->query("UPDATE meta_tags SET meta_description='$meta_description', meta_keywords='$meta_keywords' WHERE meta_tree_prod_id='$tree_prod_id'");
        }
        else {
            $link->query("INSERT INTO meta_tags SET meta_description='$meta_description', meta_keywords='$meta_keywords', meta_tree_prod_id='$tree_prod_id'");
        }        
        
        echo $link->error;
        
    }//if SAVE
       
    
    //Удалить
    if (isset($_POST['delete'])){
        $del_id = $_POST['tree_prod_id'];
        $link->query("DELETE FROM tree_products WHERE tree_prod_id='$del_id'");
        
    }//if DELETE
    
    
    //Добавить
    if(isset($_POST['add'])){    
        $item_contents = $_POST['item_contents'];
        $res = $link->query("SELECT MAX(tree_prod_order) max_order_value  FROM tree_products WHERE tree_prod_parent_id='$item_contents'");
        $res = $res->fetch_assoc();
        $max_order_value = $res['max_order_value']+1;
                
        $link->query("INSERT INTO tree_products "
                . "SET tree_prod_parent_id='$item_contents', tree_prod_order='$max_order_value', output_type_id='2'");    
    }//if  ADD
    
        
    // Получение массива из БД для вывода
    $arr_overview = [];
    $res = $link->query("   SELECT *
                            FROM tree_products tp LEFT JOIN prod_groups_output_type pgot
                            ON tp.output_type_id=pgot.output_type_id LEFT JOIN meta_tags meta
                            ON tp.tree_prod_id=meta.meta_tree_prod_id
                            WHERE tree_prod_parent_id='$tree_prod_parent_id' 
                            ORDER BY tree_prod_order");
    while ($row = $res->fetch_assoc()){
        $arr_overview[] = $row;
    }//while
    $link->close();
    return $arr_overview;
}//getOverviewArray




//Получение массива типов вывода моделей (список, плитка и т.д.)
function adminGetOutputTypes(){
    $arr_output_types = [];
    $link = ConnectionDB();
    $res = $link->query("SELECT * FROM prod_groups_output_type");
    while ($row = $res->fetch_assoc()){
        $arr_output_types[] = $row;
    }    
    $link->close();
    return $arr_output_types;
}//adminGetOutputTypes