<?php defined('AKATECH') or die('Access Denied'); ?>


<div class="" id="main_page_product">
    <div class="col-md-12 page_product" >	
        
        <div class="col-md-12 page_product_item" >	
            
            
            <!--ЗАГОЛОВОК-->
            <div class="col-md-5 text-left page_product_title">
                <h1><?= $arr_model_datails['model_info']['model_public_name'] ?></h1>
                <p class="page_product_subtitle"><?=$arr_model_datails['model_info']['model_description']?></p>
                
                <?php if ($arr_model_datails['model_info']['pdf_url'] != '' && !is_null($arr_model_datails['model_info']['pdf_url'])):?>
                    <!--<a href="<?= TEMPLATE ?>pdf/<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>/<?=$arr_model_datails['model_info']['pdf_url']?>" download><img src="<?= TEMPLATE ?>images/icon_pdf.png" alt="Загрузить PDF" title="pdf-каталог"> Загрузить PDF</a>-->
                    <a href="<?= TEMPLATE ?>pdf/<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>/<?=$arr_model_datails['model_info']['pdf_url']?>" download><img src="<?= TEMPLATE ?>images/icon_pdf.png" alt="Загрузить PDF" title="pdf-каталог"> Завантажити PDF</a>
                <?php endif;?>
                  <br>  
                <?php if ($arr_model_datails['model_info']['model_3d_url'] != '' && !is_null($arr_model_datails['model_info']['model_3d_url'])):?>
                    <!--<a href="<?= TEMPLATE ?>3d/<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>/<?=$arr_model_datails['model_info']['model_3d_url']?>" download><img src="<?= TEMPLATE ?>images/3dicon.png" alt="Загрузить 3D модели" title="3D модели"> Загрузить 3D модели</a>-->
                    <a href="<?= TEMPLATE ?>3d/<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>/<?=$arr_model_datails['model_info']['model_3d_url']?>" download><img src="<?= TEMPLATE ?>images/3dicon.png" alt="Загрузить 3D модели" title="3D модели"> Завантажити 3D моделі</a>
                <?php endif;?>
                
            </div>	
            
            
            <!--КАРТИНКИ-->
            <div class="col-md-7">
                <div id="sync1" class="owl-carousel">                    
                    <?php foreach ($arr_model_datails['images']['1'] as $pic) : ?>
                        <div class="item"><img  class="img-responsive" src="<?= TEMPLATE ?>images/models/<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>/pic_fullsize/<?= $pic ?>" alt="<?= $arr_model_datails['model_info']['model_title_name'] ?>"></div>    
                    <?php endforeach; ?>    
                </div>
                
                
                <div id="sync2" class="owl-carousel">
                    <?php if (count($arr_model_datails['images']['1']) > 1) :?>
                        <?php foreach ($arr_model_datails['images']['4'] as $pic) : ?>
                            <div class="item"><img src="<?= TEMPLATE ?>images/models/<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>/pic_minific/<?= $pic ?>" alt="<?= $arr_model_datails['model_info']['model_title_name'] ?>"></div>
                        <?php endforeach; ?>
                    <?php endif;?>
                </div>
                
            </div>
        </div>
        
        <img class="pol text-center" src="<?= TEMPLATE ?>images/polosa.png" alt="">
        
        
        <!--ЧЕРТЕЖИ-->
        <div class="col-md-12 page_product_item_1">										
            <div id="sync3" class="owl-carousel">
                <?php foreach ($arr_model_datails['images']['2'] as $pic) : ?>   
                    <div class="item"><img  class="img-responsive" src="<?= TEMPLATE ?>images/models/<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>/draw_fullsize/<?= $pic ?>" alt="<?= $arr_model_datails['model_info']['model_title_name'] ?>"></div>
                <?php endforeach; ?> 
                
            </div>
            <div id="sync4" class="owl-carousel">
                <?php if (count($arr_model_datails['images']['2']) > 1) :?>
                    <?php foreach ($arr_model_datails['images']['5'] as $pic) : ?>   
                        <div class="item"><img  class="img-responsive" src="<?= TEMPLATE ?>images/models/<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>/draw_minific/<?= $pic ?>" alt="<?= $arr_model_datails['model_info']['model_title_name'] ?>"></div>
                    <?php endforeach; ?>
                <?php endif;?>    
            </div>
        </div>
        
        <?php if (isset($arr_model_datails['images']['2']) && !empty($arr_model_datails['images']['2'])):?>
            <img class="pol text-center" src="<?= TEMPLATE ?>images/polosa.png" alt="">
        <?php endif;?>
        
        <div class="col-md-12 page_product_item_2">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <!--<li class="active"><a href="#dimensions" data-toggle="tab">Размеры</a></li>-->
                <li class="active"><a href="#dimensions" data-toggle="tab">Розміри</a></li>
                
                <?php if (!empty ($arr_model_datails['specification'])):?>
                <!--<li><a href="#specification" data-toggle="tab">Спецификация</a></li>-->
                <li><a href="#specification" data-toggle="tab">Специфікація</a></li>
                <?php endif;?>
                
                <?php if (!empty ($arr_model_datails['applications'])):?>
                <!--<li><a href="#application" data-toggle="tab">Применение</a></li>-->
                <li><a href="#application" data-toggle="tab">Застосування</a></li>
                <?php endif;?>
                
                <?php if (!empty ($arr_model_datails['videos'])):?>
                <!--<li><a href="#video" data-toggle="tab">Видео</a></li>-->
                <li><a href="#video" data-toggle="tab">Відео</a></li>
                <?php endif;?>
            </ul>

            
            <div class="tab-content tab-product">	
                
                <!--ТАБЛИЦА РАЗМЕРОВ-->
                <div class="tab-pane fade in active" id="dimensions">
                    <div class="table-responsive table-product">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Узнать цену</th>
                                    <th>Article</th>
                                    <?php foreach ($arr_model_datails['prod_properties'] as $prop_name): ?>                
                                        <th><?= $prop_name ?></th>                
                                    <?php endforeach; ?>
                                    <th>Inox</th>                                    													
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php foreach ($arr_model_datails['products'] as $prod_id => $product): ?>
                                    <tr>
                                        <td>                                            
                                            <a href="javascript:void(0);" class="product_name_1">                                                
                                                <input type="hidden" name="cart_prod_id" value="<?= $prod_id ?>">    
                                                <input type="hidden" name="cart_brand_name" value="<?= strtolower($arr_model_datails['model_info']['brand_name']) ?>"> 
                                                <input type="hidden" name="cart_prod_name" value="<?= "[".$arr_model_datails['model_info']['model_public_name']."] ".str_replace("\"", "_", $product['prod_article']) ?>">
                                                <input type="hidden" name="cart_prod_descript" value="<?=$arr_model_datails['model_info']['model_title_name'].' '.$product['prod_description']?>">
                                                <input type="hidden" name="cart_prod_img_url" value="<?= $arr_model_datails['images'][3][0] ?>">
                                                <i class="find_of_cost"></i>
                                            </a>
                                        </td> 
                                        <td><?= $product['prod_article'] ?></td>
                                        <?php foreach ($arr_model_datails['prod_properties'] as $prop_id => $prop_name): ?>
                                            <td><?= $product['properties'][$prop_id] ?></td>
                                        <?php endforeach; ?>
                                        <td>
                                            <?php if ($product['prod_inox'] == 1): ?>
                                                <img src="<?= TEMPLATE ?>images/inox_icon.png" title="inox" alt="Нержавеющая сталь">
                                            <?php endif; ?>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            
                            </tbody>
                        </table>
                    </div>
                    
                    <!--Информация красным-->
                    <div class="model_info text-left" style="">
                        <h4><?= $arr_model_datails['model_info']['model_info_text'] ?></h4>
                    </div>
                </div>

                
                <!--СПЕЦИФИКАЦИЯ-->
                <?php if (!empty ($arr_model_datails['specification'])):?>
                <div class="tab-pane fade" id="specification">
                    
                    <?php foreach ($arr_model_datails['specification'] as $parameter => $arr_value): ?>
                        <div class="specification_block text-left">                        
                        <h3 class="model_details_param"><?= $parameter ?></h3>
                            <?php foreach ($arr_value as $value): ?>
                                <p class="model_details_param_value"><?= $value ?></p>
                            <?php endforeach; ?>
                        </div>        
                    <?php endforeach; ?>
                    										
                </div>
                <?php endif;?>
                
                <!--ПРИМЕНЕНИЕ-->
                <?php if (!empty ($arr_model_datails['applications'])):?>
                <div class="tab-pane fade" id="application">
                    
                    <?php foreach ($arr_model_datails['applications'] as $num => $app):?>
                    <?php $img_location = ($num % 2 === 0) ? 'application_img_right' : 'application_img_left'; ?>
                    <div class="application_block">										
                        <img class="<?=$img_location?>" src="<?=TEMPLATE?>images/gallery/<?=$app['application_image']?>" alt="<?= $arr_model_datails['model_info']['model_title_name'] ?>">
                        <p><?=$app['application_text']?></p>
                    </div>                    
                    <?php endforeach;?>   
                </div>
                <?php endif;?>
                
                <!--ВИДЕО-->
                <?php if (!empty ($arr_model_datails['videos'])):?>
                <div class="tab-pane fade" id="video"> 
                    <div class="col-md-12">
                        <?php foreach ($arr_model_datails['videos'] as $video):?>
                        <div class="col-md-4">
                            <div class="video_item">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="<?=$video['video_src']?>" height="375"></iframe>
                                </div>	
                                <p><?=$video['video_name']?></p>
                            </div>
                        </div>
                        <?php endforeach;?>                        
                    </div>   
                    
                    <div class="more_video">
                        <!--<a class="btn btn-primary" href="#">Больше видео от AKATech Group</a>-->
                        <a class="btn btn-primary" href="#">Більше відео від AKATech Group</a>
                        
                    </div>  
                </div>
                <?php endif;?>
                
                
            </div>
        </div>
    </div>
</div>