<?php defined('ADMINER') or die('Access Denied'); ?>

<?php

var_dump($_POST);


?>


<div class="row">
    
    <form method="POST" action="" enctype="multipart/form-data">
        
        <input type="file" name="news_img" required><br>
        <div class="col-md-3">            
            <label>
                News Title<br>
                <input type="text" cols="200" name="news_title" required>
            </label>
        </div>
        
        <div class="col-md-3 ">
            <label>
                News Author<br>
                <input type="text" cols="70" name="news_author" required>
            </label>            
        </div>
        
        <div class="col-md-3 ">
            <label>
                News Date<br>
                <input id="datepicker" type="date" cols="70" name="news_date" value="<?=date('d.m.Y')?>" required>
            </label>            
        </div>
        
        <div class="row">
            <div class="col-md-10 news_editor">
                <textarea class="tinymce" rows="15" name="news_text">        </textarea> 
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-10">
                <input class="btn btn-success" type="submit" name="addNews" value="Add News">
            </div>
        </div>
        
        
    
    </form>
</div> 


<script>



</script>