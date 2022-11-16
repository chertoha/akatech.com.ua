<?php defined('AKATECH') or die('Access Denied'); ?>

<!--ВЫВОД ПОДКАТЕГОРИЙ ИЗ КАТЕГОРИЙ-->
<?php foreach ($cat_prod_list as $item): ?>
    <div class="col-md-4  text-center block_katalog">
        <a href="?view=sub_category&cat_id=<?= $item['tree_prod_parent_id'] ?>&sub_cat_id=<?= $item['tree_prod_id'] ?>" class="spoiler">
            <img src="<?= TEMPLATE ?>images/overview/<?= $item['tree_prod_img'] ?>" alt="<?= strip_tags($item['tree_prod_name']) ?>">
            <h3><?= $item['tree_prod_name'] ?></h3>                                    
        </a>
        <div class="spoiler_text">
            <hr>
            <p><?= $item['tree_prod_description'] ?></p>
        </div>
    </div>
<?php endforeach; ?>
