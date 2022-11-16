<?php defined('AKATECH') or die('Access Denied'); ?>

<div class="col-md-3 col-xs-4 block_sidebar">
    <div class="products_menu">
        <!--<h3>ПРОДУКЦИЯ</h3>-->
        <h3>ПРОДУКЦІЯ</h3>
        <div class="main_menu-list">
            <ul class="menu-list">  

                <?php foreach ($arr_tree_products as $tree_prod_id => $product): ?>
                    <li  data-toggle="collapse" data-target="#<?= 'item' . $tree_prod_id ?>" class="collapsed">
                        <a href="javascript:void(0)"><i class="fa glyphicon glyphicon-triangle-right fa-lg"></i> <?= strip_tags($product[0]) ?> </a>
                    </li>
                    
                    <?php if (isset($product['sub'])): ?>
                    <li class="not_menu_item"><!--chertok css class not_menu_item-->
                        <?php $sub_menu_collapsed = ($current_sub_category_id == $tree_prod_id) ? 'in' : ''; ?>
                        <ul class="sub-menu collapse <?= $sub_menu_collapsed ?>" id="<?= 'item' . $tree_prod_id ?>">

                            <?php foreach ($product['sub'] as $sub_tree_prod_id => $tree_prod_name): ?>
                                <?php if ($sub_tree_prod_id == $current_sub_id):?>
                            <li><a href="?view=sub_category&cat_id=<?= $tree_prod_id ?>&sub_cat_id=<?= $sub_tree_prod_id ?>"><span  class="sidebar_current_subcat_chosen"><?= strip_tags($tree_prod_name) ?></span></a></li>
                                <?php else :?>
                                    <li><a href="?view=sub_category&cat_id=<?= $tree_prod_id ?>&sub_cat_id=<?= $sub_tree_prod_id ?>"><?= strip_tags($tree_prod_name) ?></a></li>
                                <?php endif;?>
                            <?php endforeach; ?>

                        </ul>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>    

            </ul><!--.menu-list-->
        </div>
        
        <a class="news_ankor" href="?view=news">
        <!--<h3>Последние новости</h3>        -->
        <h3>Останні новини</h3>        
        <div class="main_news">            
            <h4><u><?= $arr_last_news['news_title'] ?></u></h4>
            <p> <?= $arr_last_news['news_text'] ?> </p>
            <span class="user_news"><img src="<?= TEMPLATE ?>images/icon_news_user.png" alt="Новости"></span>
        </div>
        </a>
        <h3>Галерея</h3>
        <div class="main_gallery">
            <a href="?view=gallery"><img src="<?= TEMPLATE ?>images/img_galery_1.png" alt="Галерея"></a>
            <a href="?view=gallery"><img src="<?= TEMPLATE ?>images/img_galery_2.png" alt="Галерея"></a>
            <a href="?view=gallery"><img src="<?= TEMPLATE ?>images/img_galery_3.png" alt="Галерея"></a>
            <a href="?view=gallery"><img src="<?= TEMPLATE ?>images/img_galery_4.png" alt="Галерея"></a>								
        </div>
    </div>
</div>