<?php defined('AKATECH') or die('Access Denied'); ?>


<!--<div class="main_filters text-left">
    <form class="form-inline form_filters" role="form">
        <div class="form-group">
            <label class="" for="select">Сортировать по:</label>
            <select class="form-control input-sm">
                <option>Дате добавления</option>
                <option>Пункт 2</option>
                <option>Пункт 2</option>
            </select>
        </div>
        <div class="form-group radio_btn">								
            <input type="radio" class="" name="optionsRadios" id="optionsRadios1" value="option1" checked>
            <label>Есть в наличии</label>								
        </div>
        <div class="form-group radio_btn">								
            <input type="radio" class="" name="optionsRadios" id="optionsRadios2" value="option2" >
            <label>Склад</label>								
        </div>
        <div class="form-group radio_btn">								
            <input type="radio" class="" name="optionsRadios" id="optionsRadios3" value="option3">
            <label>Распродажа</label>								
        </div>
    </form>	
</div>-->
<?php 


?>

<!--ВЫВОД МОДЕЛЕЙ ИЗ ПОДКАТЕГОРИЙ-->                           

    

    <!--Вывод списком-->    
    <?php if ((strtolower($sub_cat_prod_list[0]['output_type_descriptor']) == 'list')):?>
        <div class="tab-pane fade in active" id="dimensions">
            <div class="table-responsive table-product table_models_list">
                <table class="table">
                    <thead>
                        <tr>
                            <!--<th>Изображение</th>-->
                            <!--<th>Модель</th>                                -->
                            <!--<th>Описание</th> -->
                            <!--<th>Склад/Распродажа</th>     -->
                            
                            <th>Зображення</th>
                            <th>Модель</th>                                
                            <th>Опис</th> 
                            <th>Склад/Розпродаж</th>     
                        </tr>
                    </thead>
                    <tbody>                                
                    <?php foreach ($sub_cat_prod_list as $model): ?>

                        <tr>
                            <td>    
                                <a href="?view=models&cat_id=<?= $model['tree_prod_parent_id'] ?>&sub_cat_id=<?= $model['tree_prod_id'] ?>&model_id=<?= $model['model_id'] ?>">
                                    <img class="img-responsive" width="40" height="" src="<?= TEMPLATE ?>images/models/<?= strtolower($model['brand_name']) ?>/pic_preview/<?= $model['model_image_path'] ?>" alt="<?= strip_tags($model['tree_prod_name']) ?>">
                                </a>    
                            </td> 
                            <td class="text-left">
                                <a class="model_list_links" href="?view=models&cat_id=<?= $model['tree_prod_parent_id'] ?>&sub_cat_id=<?= $model['tree_prod_id'] ?>&model_id=<?= $model['model_id'] ?>">
                                <?= $model['model_public_name'] ?></td>
                            </a> 
                            <td class="text-left">
                                <p><?= $model['model_description'] ?></p>
                            </td>
                            <td>
                                <?php if ($model['model_onsale'] == 1) : ?>
                                    <!--<p style="color: red;">Распродажа</p>                                                                          -->
                                    <p style="color: red;">Розпродаж</p>                                                                          
                                <?php elseif ($model['model_onstock'] == 1) : ?>
                                    <p style="color: green;">Склад</p>                                    
                                <?php endif; ?>                                
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

        </div>
    
    
    <?php else:?>

    <!--Вывод плиткой-->  
        <?php foreach ($sub_cat_prod_list as $model): ?>
        <div class="col-md-4  text-center block_katalog">
            <a href="?view=models&cat_id=<?= $model['tree_prod_parent_id'] ?>&sub_cat_id=<?= $model['tree_prod_id'] ?>&model_id=<?= $model['model_id'] ?>" class="spoiler">

                <div class="img_block_katalog">                
                    <img class="img-responsive" src="<?= TEMPLATE ?>images/models/<?= strtolower($model['brand_name']) ?>/pic_preview/<?= $model['model_image_path'] ?>" alt="<?= strip_tags($model['tree_prod_name']) ?>">
                </div>

                <h3><?= $model['model_public_name'] ?></h3>

                <?php if ($model['model_onsale'] == 1) : ?>
                    <br />
                    <img class="sale" src="<?= TEMPLATE ?>images/sale.png" alt="Распродажа">                                        
                <?php elseif ($model['model_onstock'] == 1) : ?>
                    <br />
                    <img class="stock" src="<?= TEMPLATE ?>images/stock.png" alt="В наличие на складе">
                <?php endif; ?>

            </a>
            <div class="spoiler_text">
                <hr>
                <p><?= $model['model_description'] ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif;?>



<!--<div class="col-md-4  text-center block_katalog">
    <a href="#" class="spoiler">
        <div class="img_block_katalog">
            <img class="img-responsive" src="images/prom_furnitur_5.jpg" alt="">  
        </div>
        <h3>Заглушки для труб</h3>
        <br />
        <img class="stock" src="images/stock.png" alt="">

    </a>
    <div class="spoiler_text">
        <p>Краткое описание. Ведущие предприятия Украины, Европы и Азии продемонстрировали новинки технологии машиностроения, комплектующие, инструмент. Краткое описание. Ведущие предприятия Украины, Европы и Азии продемонстрировали новинки технологии </p>
    </div>
</div>-->