<?php defined('AKATECH') or die('Access Denied'); ?>

<div id="block_footer">
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-3 col-xs-6 text-center">
                <h4>Наша продукция</h4>
                <ul class="footer_production text-left">
                    
                    <?php foreach ($arr_overview as $arr_subj):?>
                    <li><a href="?view=category&category_id=<?=$arr_subj['tree_prod_id']?>"><?= strip_tags($arr_subj['tree_prod_name'])?></a></li>
                    <?php endforeach;?> 
                                        
                </ul>
            </div>
            <div class="col-md-3 col-xs-6 text-center">
                <h4>Каталог</h4>
                <ul class="footer_catalog text-left">
                    <li><a href="?view=catalogs">Промышленная фурнитура</a></li>
                    <li><a href="?view=catalogs">Прижимы для сварки</a></li>
                    <li><a href="?view=catalogs">Вибрационные элементы ROSTA</a></li>
                    <li><a href="?view=catalogs">Счетчики оборотов</a></li>
                    <li><a href="?view=catalogs">Элементы приводов</a></li>
                    <li><a href="?view=catalogs">Конструкционный профиль</a></li>
                    <li><a href="?view=catalogs">Промышленные колёса</a></li>
                    <li><a href="?view=catalogs">Конвейрные элементы</a></li>
                    <li><a href="?view=catalogs">Демпферы, отбойники, виброопоры</a></li>
                    <li><a href="?view=catalogs">Мотор-вибраторы</a></li>                    
                </ul>
            </div>
            <div class="col-md-3 col-xs-6  text-center">
                <h4>Меню</h4>
                <ul class="footer_menu text-left">
                    <!--<li><a href="index.php">Главная</a></li>-->
                    <!--<li><a href="?view=catalogs">Каталоги</a></li>-->
                    <!--<li><a href="?view=news">Новости</a></li>-->
                    <!--<li><a href="?view=gallery">Галерея</a></li>-->
                    <!--<li><a href="?view=contacts">Контакты</a></li>-->
                    
                    <li><a href="index.php">Головна</a></li>
                    <li><a href="?view=catalogs">Каталоги</a></li>
                    <li><a href="?view=news">Новини</a></li>
                    <li><a href="?view=gallery">Галерея</a></li>
                    <li><a href="?view=contacts">Контакти</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-xs-6  text-center">
                <h4>Контакты</h4>
                <span><i class="phone_2"></i></span>
                <p class="txt_contact">
                    <!--<a href="tel:+380443843092">(044) 384-30-92</a>, <br />-->
                    <a href="tel:+380674633523">(067) 463-35-23</a>,<br /> 
                    <!--<a href="tel:+380443337903">(044) 333-79-03</a>-->
                    
                </p>
                <span><i class="mail_2"></i></span>
                <p class="txt_contact"><a href="mailto:info@akatech.com.ua">info@akatech.com.ua</a></p>
                <span><i class="location"></i></span>
                <!--<p class="txt_contact">-->
                <!--                03027<br>-->
                <!--                Киево-Святошинский р-н<br>-->
                <!--                с.Новосёлки, ул. Садовая 26-->
                <!--</p>-->
                <p class="txt_contact">
                                03027<br>
                                Києво-Святошинський р-н<br>
                                с.Новосілки, вул. Садова 26
                </p>
                <p  class="txt_contact">
                    <a href="https://www.facebook.com/AKATech-Group-LLC-647463895335022/?ref=hl"><i class="fb"></i></a>
                    <a href="https://vk.com/akatech"><i class="vk"></i></a>                        
                    <a href="https://plus.google.com/b/101059798307937913739/101059798307937913739?hl=ru"><i class="google"></i></a>
                    <a href="#"><i class="youtube"></i></a>
                </p>
            </div>
        </div>
    </div>
</div>
<div id="block_footer_2">
    <div class="container">
        <div class="">
            <p>Copyright © 2017 AKATech Group LLC All Rights Reserved.</p>
        </div>
    </div>
</div>