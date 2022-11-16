<?php defined('ADMINER') or die('Access Denied'); ?>


<?php


$arr_model_products = GetProductsByModel();

//var_dump($arr_model_products);
var_dump($_POST);

?>



<div class="container">
    <form method="POST" action="">
        <label>
            Model
            <input type="text" name="model_name" placeholder="model name">
        </label>
        
        <input type="submit" class="btn btn-success" name="del_find_products" value="Find Products">
    </form>
</div>

<br><br>

<div class="container table_del_products">
    <form method="POST" action="">
        <table border="1" collapse="collapsed" id="tab_del_products">
            <tr>
                <th>
                    <label>*
                        <!--<input id="check_all_delete" type="checkbox" >-->
                    </label>
                </th>
                <th class="text-center">Article</th>
                <th class="text-center">Model Name</th>            
            </tr>

            <?php foreach ($arr_model_products as $prod_id => $arr_prod):?>
            <tr>
                <td>
                    <input type="checkbox" name="del_prod_check[]" value="<?= $prod_id?>">
                </td>
                <td>
                    <p><?=$arr_prod['article']?></p>
                </td>
                <td>
                    <p><?=$arr_prod['model_name']?></p>
                </td>
            </tr>
            <?php endforeach;?>
            
            
        </table>
        <input type="submit" name="del_products" value="Delete" class="btn btn-danger">
    </form>

</div>



