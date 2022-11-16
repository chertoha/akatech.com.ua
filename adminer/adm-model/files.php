<?php
defined ('ADMINER') or die('Access Denied');

//Перемещение файла в указанную папку
function saveFileImg($destination_path) {
    $file_name = '';   

    if (isset($_FILES['pic'])) {
        $file_name = $_FILES['pic']['name'];
        $img = getimagesize($_FILES['pic']['tmp_name']);
        $extension = image_type_to_extension($img[2],false);
        if ($extension === 'jpeg' || $extension === 'jpg' || $extension === 'png'){
            $path = $destination_path.$file_name;
            move_uploaded_file($_FILES['pic']['tmp_name'], $path);
                        
        }//if              
    }//if isset $_FILES

    return $file_name;
}//saveFile

