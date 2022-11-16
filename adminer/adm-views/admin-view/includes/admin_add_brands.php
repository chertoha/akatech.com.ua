<?php defined('ADMINER') or die('Access Denied'); ?>

<?php 
if (isset($_POST['add_brand'])){
    AddNewBrand($_POST['brand_name'], $_POST['brand_descriptor']);
}

$arr_brands = GetBrandsArray();


//var_dump($arr_brands);
var_dump($_POST);
?>

<div class="container">
    
    
    <div class="row">
        <form method="post" action=""> 
            <label>
                Add New Brand
                <input type="text" name="brand_name" placeholder="Brand Name"> 
                <input type="text" name="brand_descriptor" placeholder="Brand Descriptor">
                <input type="submit" name="add_brand" value="+ Brand" class="btn btn-success">
            </label>
        </form>
    </div>
    
    <br><br>
    
    
    <table class="table_del_products" border="1" collapse="collapsed">
        <tr>
            <th>Brand ID</th> <th>Brand Name</th> <th>Brand Descriptor</th>
        </tr>
        <?php foreach ($arr_brands as $brand_id => $brand_arr) :?>

        <tr>
            <td>
                <strong><?=$brand_id?></strong>
            </td>
            <td>
                <?=$brand_arr['brand_name']?>
            </td>
            <td>
                <?=$brand_arr['brand_descriptor']?>
            </td>
        </tr>

        <?php endforeach;?>
    </table>
    
</div>