<?php defined('ADMINER') or die('Access Denied'); ?>



<?php

$arr_edit_products = GetProductsForEdit();
//var_dump($arr_edit_products);
var_dump($_POST);

?>



<div class="container">
    <form method="POST" action="">
        
        <input type="text" name="prod_name" placeholder="Product article">
               
        <input type="submit" class="btn btn-success" name="edit_product" value="Find Products">
    </form>
</div>

<br><br>

<div class="container table_del_products">
    
    <?php foreach ($arr_edit_products as $prod_id => $arr_props) :?>
        
    <div class="row">
        <form method="post">
            <input type="hidden" name="prod_id" value="<?=$prod_id?>">
            <label>Article <input type="text" name="prod_article" value="<?=$arr_props['prod_article']?>"></label><br>
            <label>Description <input type="text" name="prod_description" value="<?=$arr_props['prod_description']?>"></label><br>
            <label>Inox 
                <select name="prod_inox" value="<?=$arr_props['prod_inox']?>">
                    <?php if ($arr_props['prod_inox'] == 0) :?>
                    <option selected>0</option> <option>1</option>
                    <?php elseif ($arr_props['prod_inox'] == 1):?>
                    <option>0</option> <option selected>1</option>
                    <?php endif;?>
                </select>
            </label><br>
            <input type="submit" name="change_prod_info" value="Edit product" class="btn btn-info">
        </form>        
    </div>
        
    <br>
    
        <?php foreach ($arr_props['dimensions'] as $prod_prop_value_id => $prop_info) :?>
        <form method="POST" action="">
            <input type="hidden" name="prod_prop_value_id" value="<?=$prod_prop_value_id?>">
            <input type="hidden" name="prop_id" value="<?=$prop_info['prop_id']?>">
            <label>
                <?=$prop_info['prop_name']?>
                <?php if (strlen($prop_info['prop_value']) <= 20):?>
                    <input type="text" name="prop_value" value="<?=$prop_info['prop_value']?>">
                <?php else:?>
                    <textarea name="prop_value" cols="30" rows="3"><?=$prop_info['prop_value']?></textarea> 
                <?php endif;?>
            </label>  
            <input type="submit" name="edit_product" value="edit" class="btn-xs btn-danger">
            <br>
        </form>
        <?php endforeach;?>   
        
        
    

    <?php endforeach;?>
    
</div>

