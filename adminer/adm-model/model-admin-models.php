<?php
defined ('ADMINER') or die('Access Denied');

function ModelAdminFindModels(){
        
    $arr_models = [];
    $brand_id = '';
    $serie_id = '';
    
    SaveImageOverview();// save overview image file
    SaveImagesAndDrawings();// save  full-size images and drawings
    DelImagesAndDrawings(); // delete images and drawings from DB
    SaveModelDescripion(); // save model description to DB
    AddParameter(); // add new parameters and values to specification
    AddParamValue(); // add new value to parameter
    DeleteParamValue(); // delete parameter's values in specification
    SaveModelPublicName();// save model's public name
    AddApplication();// add applcication photos
    SaveTechnicalDescripion();// save technical description
    DelApplication(); //Del Application
    SavePdf();// Save PDF
    Save3d();// Save 3d
    
    
    if (isset($_POST['find'])){
        $brand_id = $_POST['brand_id'];
        $serie_id = $_POST['serie_id'];
        $_SESSION['admin_models']['brand_id'] = $brand_id;
        $_SESSION['admin_models']['serie_id'] = $serie_id;
    }
    else if (isset($_SESSION['admin_models'])){
        $brand_id = $_SESSION['admin_models']['brand_id'];
        $serie_id = $_SESSION['admin_models']['serie_id'];
    }
    else {
        return;
    }
    
    $link = ConnectionDB();  
    
    $query = "  SELECT 
                ms.model_specific_id, 
                m.model_id, 
                ms.model_sp_param_visible param_visible, 
                msp.model_specific_param_id param_id,
                msp.model_specific_param_name param_name, 
                mspv.model_sp_param_val param_value,
                m.model_name,
                m.model_description model_tech_description,
                md.model_description,
                mi.model_info_text info_text,
                mimg.model_image_id,
                mimg.model_image_path,
                mimg.img_type_id,
                b.brand_name,
                m.model_onstock,
                m.model_onsale,
                m.model_public_name,
                map.model_app_photo_id,
                map.model_app_photo_url,
                map.model_app_photo_description,
                pdf.pdf_url,
                m3d.model_3d_url
                
                FROM models m LEFT JOIN model_specifications ms                
                ON ms.model_id=m.model_id LEFT JOIN series s
                ON m.serie_id=s.serie_id LEFT JOIN model_specific_params_values mspv
                ON ms.model_sp_param_val_id=mspv.model_sp_param_val_id LEFT JOIN model_specific_params msp
                ON mspv.model_specific_param_id=msp.model_specific_param_id LEFT JOIN model_descriptions md
                ON m.model_id=md.model_id LEFT JOIN models_information mi
                ON m.model_id=mi.model_id LEFT JOIN models_images mimg
                ON m.model_id=mimg.model_id LEFT JOIN brands b
                ON s.brand_id=b.brand_id LEFT JOIN model_app_photo map
                ON m.model_id=map.model_id LEFT JOIN models_pdf pdf
                ON m.model_id=pdf.model_id LEFT JOIN models_3d m3d
                ON m.model_id=m3d.model_id
                
                
                WHERE m.serie_id='$serie_id' AND s.brand_id='$brand_id'";
                
    $res = $link->query($query);
    
    while($row = $res->fetch_assoc()){
        
//        $arr_models[$row['model_id']][] = $row;
        
        $arr_models[$row['model_id']]['brand_name'] = strtolower($row['brand_name']) ;
        $arr_models[$row['model_id']]['model_name'] = $row['model_name'];
        $arr_models[$row['model_id']]['model_public_name'] = $row['model_public_name'];
        $arr_models[$row['model_id']]['model_description'] = $row['model_description'];
        $arr_models[$row['model_id']]['info_text'] = $row['info_text'];
        $arr_models[$row['model_id']]['model_onstock'] = $row['model_onstock'];
        $arr_models[$row['model_id']]['model_onsale'] = $row['model_onsale'];
        $arr_models[$row['model_id']]['technical_description'] = $row['model_tech_description'];
        $arr_models[$row['model_id']]['pdf_url'] = $row['pdf_url'];
        $arr_models[$row['model_id']]['model_3d_url'] = $row['model_3d_url'];
        
        $arr_models[$row['model_id']]['applications'][$row['model_app_photo_id']]['app_photo_url'] = $row['model_app_photo_url'];        
        $arr_models[$row['model_id']]['applications'][$row['model_app_photo_id']]['app_description'] = $row['model_app_photo_description'];  
        
        $arr_models[$row['model_id']]['img_type_id'][$row['img_type_id']][$row['model_image_id']] = $row['model_image_path'];
        
        $arr_models[$row['model_id']]['params'][$row['param_name']]['param_id'] = $row['param_id'];
        $arr_models[$row['model_id']]['params'][$row['param_name']][$row['param_value']]['model_specific_id'] = $row['model_specific_id'];
        $arr_models[$row['model_id']]['params'][$row['param_name']][$row['param_value']]['param_visible'] = $row['param_visible'];
        
    }//while
    
    $link->close();
    
    return $arr_models;
} //ModelAdminFindModels()



function SaveImageOverview(){
    
    if (!isset($_POST['saveOverview']) || !isset($_FILES['model_preview_img']) || $_FILES['model_preview_img']['name'] === '' ){
        return;
    }
    

    
    $model_id = $_POST['model_id'];
    $img_type_id = $_POST['img_type_id'];
    $brand_name = $_POST['brand_name'];
    
    $folder = ROOT.'views/akatech/images/models/'.$brand_name.'/pic_preview/';
    if (!file_exists($folder)){
        mkdir($folder);
    }  
    
    $pic = getimagesize($_FILES['model_preview_img']['tmp_name']);
    $file_ext = image_type_to_extension($pic[2], false);
    
    if ($file_ext === 'jpeg' || $file_ext === 'png' || $file_ext === 'jpg' || $file_ext === 'gif' || $file_ext === 'bmp') {
        $save_filename = $_FILES['model_preview_img']['name'];
        $path = ROOT.'views/akatech/images/models/'.$brand_name.'/pic_preview/'.$save_filename;
        move_uploaded_file($_FILES['model_preview_img']['tmp_name'], $path);
        
        $link = ConnectionDB();  
        
        $res = $link->query("SELECT model_image_id FROM models_images WHERE model_id='$model_id' AND img_type_id='$img_type_id'");
        if ($res->num_rows !== 0 ){
            $link->query("UPDATE models_images SET model_image_path='$save_filename' WHERE model_id='$model_id' AND img_type_id='$img_type_id'");
        }
        else {
            $link->query("INSERT INTO models_images SET model_image_path='$save_filename', model_id='$model_id', img_type_id='$img_type_id'");
        }
        
        
        $link->close();
        
    }
}//SaveImageOverview()


function SaveImagesAndDrawings(){
    
    if (!isset($_POST['saveImgDrw']) || !isset($_FILES['modelFullImg'])){
        return;
    }
    
    $model_id = $_POST['model_id'];
    $img_type_id = $_POST['img_type_id'];
    $brand_name = $_POST['brand_name'];
    $img_type_name = $_POST['img_type_name'];
    
    $folder = ROOT.'views/akatech/images/models/'.$brand_name.'/'.$img_type_name;
    if (!file_exists($folder)){
        mkdir($folder);
    }  
    
    
    $arr_pics = $_FILES['modelFullImg'];
    
    for ($i = 0; $i < count($arr_pics['name']); $i++){
        
        $pic = getimagesize($arr_pics['tmp_name'][$i]);
        $file_ext = image_type_to_extension($pic[2], false);
        
        if ($file_ext === 'jpeg' || $file_ext === 'png' || $file_ext === 'jpg' || $file_ext === 'gif' || $file_ext === 'bmp') {
            $save_filename = $arr_pics['name'][$i];
            $path = ROOT.'views/akatech/images/models/'.$brand_name.'/'.$img_type_name.'/'.$save_filename;
            move_uploaded_file($arr_pics['tmp_name'][$i], $path);
            
            
            $thumbnail_img_type_id = '';
            $thumbnail_folder_path = '';
            if ($img_type_id == 1){
                $thumbnail_img_type_id = 4;
                $thumbnail_folder_path = ROOT.'views/akatech/images/models/'.$brand_name.'/'.'pic_minific';
            }
            else if ($img_type_id == 2){
                $thumbnail_img_type_id = 5;
                $thumbnail_folder_path = ROOT.'views/akatech/images/models/'.$brand_name.'/'.'draw_minific';
            }            
            
            $thumbnail_prefix = 'min_';
            $thumbnail_name = $thumbnail_prefix.$save_filename;
            if (CreateThumbnail($path, $thumbnail_folder_path, $thumbnail_prefix)){                               
                $link = ConnectionDB();          
                $link->query("INSERT INTO models_images SET model_image_path='$save_filename', model_id='$model_id', img_type_id='$img_type_id'");
                $link->query("INSERT INTO models_images SET model_image_path='$thumbnail_name', model_id='$model_id', img_type_id='$thumbnail_img_type_id'");
                $link->close();
            }
            
                        
        }//if      
    }//for
    
}//SaveImagesAndDrawings()


function CreateThumbnail($source_path, $folder_path, $prefix = '' ){
    
    $reqired_width = 125;
    $reqired_height = 125;
    $done = false;
    
    if (!file_exists($folder_path)){
        mkdir($folder_path);
    }    
    
    $image_name = basename($source_path);
        
        $temp_img = getimagesize($source_path);
        $ext = image_type_to_extension($temp_img[2],false);
        
        
        $fileinfo = getimagesize($source_path);
        $width = $fileinfo[0];
        $height = $fileinfo[1];

                
        $img_new_path = $folder_path.'/'.$prefix.$image_name;
        
        $new_width = '';
        $new_height = '';
        $coef = '';
        
        if ($width > $height){
            $new_width = $reqired_width;
            $coef = $width/$reqired_width;
            $new_height = (int)($height/$coef);
        }
        else {
            $new_height = $reqired_height;
            $coef = $height/$reqired_height;
            $new_width = (int)($width/$coef);
        }
        
        if ($ext === 'jpeg' || $ext === 'jpg'){
            $img = imagecreatefromjpeg($source_path);
            $img = imagescale($img, $new_width, $new_height);
            imagejpeg($img, $img_new_path);
            $done = true;
        }
        if ($ext === 'png'){
            $img = imagecreatefrompng($source_path);
            $img = imagescale($img, $new_width, $new_height);
            imagepng($img, $img_new_path);
            $done = true;
        }
        
        
        return $done;
}//CreateThumbnail




function DelImagesAndDrawings(){
    
    if (!isset($_POST['delImg'])){
        return;
    }
    
    $model_image_id = $_POST['model_image_id'];
    $thumbnail_img_type_id = $_POST['thumbnail_img_type_id'];
    $model_id = $_POST['model_id'];
    
    $link = ConnectionDB();
    $link->query("DELETE FROM models_images WHERE model_image_id='$model_image_id'");
    $link->query("DELETE FROM models_images WHERE model_id='$model_id' AND img_type_id='$thumbnail_img_type_id'");    
    $link->close();
    
    
}//DelImagesAndDrawings()



function SaveModelPublicName(){
    if (!isset($_POST['saveModelPublicName'])){
        return;
    }    
    $model_id = $_POST['model_id'];
    $model_public_name = $_POST['model_public_name'];   
    
    $link = ConnectionDB();
    $link->query("UPDATE models SET model_public_name='$model_public_name' WHERE model_id='$model_id'");
    $link->close();
    
}//SaveModelPublicName()



function SaveModelDescripion(){
    if (!isset($_POST['saveDescription'])){
        return;
    }
    
    $model_id = $_POST['model_id'];
    $model_description = $_POST['model_description'];
    
    
    $link = ConnectionDB();
    
    $res = $link->query("SELECT model_desc_id FROM model_descriptions WHERE model_id='$model_id'");
    if ($res->num_rows !== 0){
        $link->query("UPDATE model_descriptions SET model_description='$model_description' WHERE model_id='$model_id'");
    }
    else {
        $link->query("INSERT INTO model_descriptions SET model_id='$model_id', model_description='$model_description'");
    }
    $link->close();
    
}//SaveModelDescripion()


function SaveTechnicalDescripion(){
    if (!isset($_POST['saveTechDescription'])){
        return;
    }
    
    $model_id = $_POST['model_id'];
    $tech_description = $_POST['technical_description'];
    
    
    $link = ConnectionDB();
    
    $link->query("UPDATE models SET model_description='$tech_description' WHERE model_id='$model_id' ");
    
    $link->close();
    
}//SaveTechnicalDescripion()



function AddParameter(){
    if (!isset($_POST['addParameter'])){
        return;
    }
    
    $model_id = $_POST['model_id'];
    $parameter_name = $_POST['parameter_name'];
    $parameter_value = $_POST['parameter_value'];
    $model_specific_param_id = '';
    $model_sp_param_val_id = '';
    
    $link = ConnectionDB();
    
    //Param ID
    $res = $link->query("SELECT model_specific_param_id FROM model_specific_params WHERE "
            . "model_specific_param_name='$parameter_name' LIMIT 1");
    
    if ($res->num_rows !== 0){
        $res = $res->fetch_assoc();
        $model_specific_param_id = $res['model_specific_param_id'];
    }//if
    else {
        $link->query("INSERT INTO model_specific_params SET model_specific_param_name='$parameter_name'");
        $model_specific_param_id = $link->insert_id;
    }
    
    
    //Value ID
    $res = $link->query("SELECT model_sp_param_val_id FROM model_specific_params_values WHERE "
            . "model_specific_param_id='$model_specific_param_id' AND "
            . "model_sp_param_val='$parameter_value' "
            . "LIMIT 1");
    if ($res->num_rows !== 0) {
        $res = $res->fetch_assoc();
        $model_sp_param_val_id = $res['model_sp_param_val_id'];
    }//if
    else {
        $link->query("INSERT INTO model_specific_params_values SET "
                . "model_specific_param_id='$model_specific_param_id', "
                . "model_sp_param_val='$parameter_value'");
        $model_sp_param_val_id = $link->insert_id;
    }//else

    
    //Add to specification
    $link->query("INSERT INTO model_specifications SET "
            . "model_id='$model_id', "
            . "model_sp_param_val_id='$model_sp_param_val_id',"
            . "model_sp_param_visible='1'");    
    
    $link->close();
    
    
}//AddParameter()



function AddParamValue(){
    if (!isset($_POST['addParamValue'])){
        return;
    }
    
    $model_id = $_POST['model_id'];
    $param_id = $_POST['param_id'];
    $model_sp_param_val_id = '';
    
    $link = ConnectionDB();
    
    $res = $link->query("SELECT model_sp_param_val_id FROM model_specific_params_values WHERE "
            . "model_specific_param_id='$param_id' AND model_sp_param_val='' LIMIT 1");
    if ($res->num_rows !== 0){
        $res = $res->fetch_assoc();
        $model_sp_param_val_id = $res['model_sp_param_val_id'];
        echo $param_id;
    }
    else {
        $link->query("INSERT INTO model_specific_params_values SET model_specific_param_id='$param_id', model_sp_param_val=''");
        $model_sp_param_val_id = $link->insert_id;
    }
        
    $link->query("INSERT INTO model_specifications SET "
            . "model_id='$model_id', "
            . "model_sp_param_val_id='$model_sp_param_val_id',"
            . "model_sp_param_visible='1'");
    
    $link->close();   
    
}//AddParamValue()



function DeleteParamValue(){
    if (!isset($_POST['delParamValue'])){
        return;
    }    
    $model_specific_id = $_POST['model_specific_id'];    
    $link = ConnectionDB();    
    $link->query("DELETE FROM model_specifications WHERE model_specific_id='$model_specific_id'");    
    $link->close();    
}//DeleteParamValue()





function AddApplication(){
    if (!isset($_POST['addAppPhoto']) || !isset($_FILES['appPhotoImg']) || $_FILES['appPhotoImg']['name'] === '' ){
        return;
    } 
    
    $model_id = $_POST['model_id'];
    $photo_description = $_POST['appPhotoDescription'];
    $file_new_name = '';  
    
    $pic = getimagesize($_FILES['appPhotoImg']['tmp_name']);
    $file_ext = image_type_to_extension($pic[2], false);
    $arr_info = pathinfo($_FILES['appPhotoImg']['name']);
    
    if ($file_ext === 'jpeg' || $file_ext === 'png' || $file_ext === 'jpg' || $file_ext === 'gif' || $file_ext === 'bmp') {
        $path = ROOT . 'views/akatech/images/gallery/';
        $unique_name = tempnam($path, "app_");
        unlink($unique_name);
        $unique_name .='.'.$arr_info['extension'];
        move_uploaded_file($_FILES['appPhotoImg']['tmp_name'], $unique_name);
        $file_new_name = basename($unique_name);
    }
    
    $link = ConnectionDB();
    $link->query("INSERT INTO model_app_photo SET "
            . "model_id='$model_id', "
            . "model_app_photo_url='$file_new_name', "
            . "model_app_photo_description='$photo_description'");
    $link->close();
    
}//AddApplication




function DelApplication(){
    if (!isset($_POST['delApplication'])){
        return;
    } 
   
    $model_app_photo_id = $_POST['model_app_photo_id'];   
    
    $link = ConnectionDB();
    $link->query("DELETE FROM model_app_photo WHERE model_app_photo_id='$model_app_photo_id'");
    $link->close();
    
}//DelApplication



function SavePdf(){
    
    if (!isset($_POST['savePDF']) || !isset($_FILES['model_pdf']) || $_FILES['model_pdf']['name'] === '' ){
        return;
    }
    
    $model_id = $_POST['model_id'];    
    $brand_name = strtolower($_POST['brand_name']);
    
    $pdf = (pathinfo($_FILES['model_pdf']['name']));
    $file_ext = $pdf['extension'];
    
    $folder_path = ROOT.'views/akatech/pdf/'.$brand_name;
    if (!file_exists($folder_path)){
        mkdir($folder_path);
    }  
    
    if ($file_ext === 'pdf') {
        $save_filename = $_FILES['model_pdf']['name'];
        $path = ROOT.'views/akatech/pdf/'.$brand_name.'/'.$save_filename;
        echo move_uploaded_file($_FILES['model_pdf']['tmp_name'], $path);
        
        $link = ConnectionDB();  
        
        $res = $link->query("SELECT pdf_id FROM models_pdf WHERE model_id='$model_id'");
        if ($res->num_rows !== 0 ){
            $link->query("UPDATE models_pdf SET pdf_url='$save_filename' WHERE model_id='$model_id'");
        }
        else {
            $link->query("INSERT INTO models_pdf SET pdf_url='$save_filename', model_id='$model_id'");
        }
        
        
        $link->close();
        
    }
}//SavePdf()



function Save3d(){
    if (!isset($_POST['save3d']) || !isset($_FILES['model_3d']) || $_FILES['model_3d']['name'] === '' ){
        return;
    }
    
    $model_id = $_POST['model_id'];    
    $brand_name = strtolower($_POST['brand_name']);
    
    $folder_path = ROOT.'views/akatech/3d/'.$brand_name;
    if (!file_exists($folder_path)){
        mkdir($folder_path);
    }  
    
    
    $save_filename = $_FILES['model_3d']['name'];
    $path = ROOT.'views/akatech/3d/'.$brand_name.'/'.$save_filename;
    echo move_uploaded_file($_FILES['model_3d']['tmp_name'], $path);

    $link = ConnectionDB();  

    $res = $link->query("SELECT model_3d_id FROM models_3d WHERE model_id='$model_id'");
    if ($res->num_rows !== 0 ){
        $link->query("UPDATE models_3d SET model_3d_url='$save_filename' WHERE model_id='$model_id'");
    }
    else {
        $link->query("INSERT INTO models_3d SET model_3d_url='$save_filename', model_id='$model_id'");
    }

    $link->close();
        
   
}//Save3d