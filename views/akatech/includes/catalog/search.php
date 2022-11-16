<?php defined('AKATECH') or die('Access Denied'); ?>
<?php 
//var_dump($arr_search_result);

?>




<div class="search_block">
    
    <div class="row search_row text-left">    
        <!--<p>Число найденых совпадений: <?=count($arr_search_result)?> </p>-->
        <p>Кількість знайдениз збігів: <?=count($arr_search_result)?> </p>
    </div>
    
    
    <?php foreach ($arr_search_result as $arr_model):?>
        <?php 
            $additional_info = '';
            if ($arr_model['model_onsale'] == 1){
                // $additional_info = '<span style="color:red;">Распродажа</span>';
                $additional_info = '<span style="color:red;">Розпродаж</span>';
            }
            else if ($arr_model['model_onstock'] == 1){
                // $additional_info = '<span style="color:green;">В наличии на складе</span>';
                $additional_info = '<span style="color:green;">Є в наявності на складі</span>';
            }
        ?>
        
        <div class="row search_row">
            <a href="?view=models&cat_id=<?=$arr_model['tree_prod_parent_id']?>&sub_cat_id=<?=$arr_model['tree_prod_id']?>&model_id=<?=$arr_model['model_id']?>">
                <div class="col-md-3 search_img">
                    <img class="img-responsive" src="<?=TEMPLATE?>images/models/<?=  strtolower($arr_model['brand_name'])?>/pic_preview/<?=$arr_model['model_image_path']?>" width="100" alt="<?=$arr_model['model_title_name']?>">
                </div>
                <div class="col-md-3">
                    <p><span class="search_black_text"><?=$arr_model['model_public_name']?></span> <?=$arr_model['model_title_name']?></p>
                    <!--<p class="search_black_text">Товарная группа:<br> <?=$arr_model['tree_prod_name']?></p>-->
                    <p class="search_black_text">Товарна група:<br> <?=$arr_model['tree_prod_name']?></p>
                </div>
                <div class="col-md-3">
                    <p><?=$arr_model['model_description']?></p>
                </div>
                <div class="col-md-3">
                    <p><?=$additional_info?></p>
                </div>

            </a>

        </div>

    <?php endforeach;?>

</div>