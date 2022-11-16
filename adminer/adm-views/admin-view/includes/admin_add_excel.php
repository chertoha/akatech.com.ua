<?php defined('ADMINER') or die('Access Denied'); ?>

<?php


if (isset($_POST['add_excel']) && $_FILES['file_excel']['name'] != ''){
    $obj = new AddExcelToDB($_FILES['file_excel']['tmp_name']);
    
    if (!empty($obj->errors)){
        var_dump($obj->errors);
    }
    else {
        echo 'NONE ERRORS!';
    }
    
    if (!empty($obj->success)){
        var_dump($obj->success);
    }
    else {
        echo 'NO SUCCESS!';
    }
    
}//if
else{
    echo 'NO FILE!';
}

//var_dump($_POST);
//var_dump($_FILES);


?>


<div class="container">
    
    <form method="post" action="" enctype="multipart/form-data">
        <label>
            File Excel: 
            <input type="file" name="file_excel">
        </label>
        <input type="submit" name="add_excel" value="Add Excel" class="btn btn-success"> 
        
    </form>
    
    
    
</div>


