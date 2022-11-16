<?php defined('ADMINER') or die('Access Denied'); 



 var_dump($_POST);
 var_dump($_FILES);


?>




<div class="container">
    
    <form method="post" action="" enctype="multipart/form-data">
        <label>
            File Excel Images: 
            <input type="file" name="file_excel">
        </label>
        <br>
        <label>
            Files Images: 
            <input type="file" name="files_images[]" multiple="">
        </label>
        <input type="submit" name="add_xls_images" value="Add Excel Images" class="btn btn-success"> 
        
        
        
        
        
    </form>
    
    
    
</div>
