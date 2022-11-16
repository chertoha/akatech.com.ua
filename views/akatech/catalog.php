<?php defined('AKATECH') or die('Access Denied'); ?>

<?php require_once 'includes/header.php';?>

<?php 

// Текущий выбранный раздел
$current_sub_category_id = '';
if (isset($_GET['cat_id'])){
   $current_sub_category_id = $_GET['cat_id'];
}

$current_sub_id = '';// Для выделения выбранного подраздела в сайдбаре
if (isset($_GET['sub_cat_id'])){
   $current_sub_id = $_GET['sub_cat_id'];
}


//unset ($_SESSION['cart']);
//var_dump($_SERVER);
//var_dump($_SESSION);
//var_dump($_POST);
//var_dump($arr_breadcrumbs);
//var_dump($arr_tree_products);
//var_dump($arr_model_datails);
//var_dump($sub_cat_prod_list);
?>


        <div id="block_logo_2">
            <?php include 'includes/header2.php'?>
        </div>

        <div id="wrapper">
            <div class="container">
                <div class="row">
                    
                    <?php include 'includes/catalog/sidebar.php'?> <!--SIDEBAR-->
                    
                    <div class="col-md-9 col-xs-8 text-center block_main_catalog">
                        <div class="main_breadcrumb">  
                            <ol class="breadcrumb">
                                <li><a href="index.php">Главная</a></li>
                                
                                <?php for ($i = 0; $i < count($arr_breadcrumbs) - 1; $i++):?>
                                <li><a href="<?=$arr_breadcrumbs[$i]['crumb_href']?>"><?=$arr_breadcrumbs[$i]['crumb_name']?></a></li>
                                <?php endfor;?>
                                
                                <li class="active"><?=$arr_breadcrumbs[count($arr_breadcrumbs)-1]['crumb_name']?></li>
                                
                                
                            </ol>
                        </div>
                        
                        
                        <?php include $catalog_includes;?>
                        
                                              

                    </div>
                </div>
                <div class="row">

                </div>			
            </div>
        </div>

<?php require_once 'includes/subscribe.php';?>

<?php require_once 'includes/footer.php';?>
        


        <!--НАЧАЛО Всплывающее окно СКАЧАТЬ КАТАЛОГ-->    

        <div class="modal fade" id="modal_form_catalogs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel0" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                    <div class="modal-header text-center">
                        <h3 class="modal-title" id="myModalLabel0">Загрузить каталог</h3>
                        <p>Для того, чтобы загрузить каталог<br /> заполните форму</p>

                    </div>
                    <div class="modal-body text-center">
                        <form id="form_contact_order_sheet0" class="" role="form" method="post" onsubmit="FormSendOK()">																																					
                            <input type="text" name="name_order_sheet" class="write_contact form-control" id="name_contact0" required="required" placeholder="Ваше имя">
                            <input type="email" name="email_order_sheet" class="write_contact form-control" id="email_contact0" required="required" placeholder="Ваш e-mail">													
                            <button type="submit" name="btn_order_sheet" class="btn_write_review">отправить</button>										
                        </form>
                    </div>		  
                </div>
            </div>
        </div>

        <!--КОНЕЦ Всплывающее окно СКАЧАТЬ КАТАЛОГ-->

        
        
        <!--НАЧАЛО - КОРЗИНА ЗАПРОСА ТОВАРОВ-->
        <div id="main_cart">
            <div class="chat"><img class="img-responsive" src="<?=TEMPLATE?>/images/chat.png" alt=""></div>
            <div class="cart_big" data-toggle="modal" data-target="#myModal_inquiry"><img class="img-responsive" src="<?=TEMPLATE?>/images/cart_big.png" alt=""></div>		
        </div>

        <!--НАЧАЛО Всплывающее окно ЗАПРОС СТОИМОСТИ-->    
        <div class="modal fade" id="myModal_inquiry" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                
                
                <form id="form_contact_order_sheet" class="text-center" role="form" method="post" onsubmit="FormSendOK()">	 

                    <div class="modal-content" id="modal_inquiry">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                        <div class="modal-header text-center">
                            <h3 class="modal-title" id="myModalLabel">список товаров для запроса стоимости</h3>					
                        </div>
                        <div class="modal-body main_modal-cart"><!--vertical-ticker/carouselv-->
                            <!--<div class="carouselv-item">-->
                            <a href="#" id="ticker-previous"></a>
                            <ul id="vertical-ticker">

                                <!--dynamic content-->

                            </ul>
                            <a href="#" id="ticker-next"></a>
                            <!--</div>-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn_write_review" data-dismiss="modal">Продолжить выбор</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn_write_review"  data-toggle="collapse" data-parent="#modal_inquiry" data-target="#forms_cart">Сделать запрос</button>
                            <!--<a class="btn_write_review" data-toggle="collapse" data-parent="#modal_inquiry" href="#forms_cart" role="button">Сделать запрос</a>-->
                        </div>
                        <div class="modal-body panel-collapse collapse" id="forms_cart">
                            <img class="pol img-responsive" src="<?= TEMPLATE ?>/images/polosa.png" alt="">
                            <p class="zagolov_contact_order_sheet text-left">Укажите Ваши контактные данные:</p>
                            
                            
                            <?php 
                                $form_name = '';
                                $form_email = '';
                                $form_phone = '';
                                $form_company = '';
                                if (isset($_SESSION['guest_form_info'])){
                                    $form_name = $_SESSION['guest_form_info']['name'];
                                    $form_email = $_SESSION['guest_form_info']['email'];
                                    $form_phone = $_SESSION['guest_form_info']['phone'];
                                    $form_company = $_SESSION['guest_form_info']['company'];
                                }                            
                            ?>
                            <input type="text" name="name_order_sheet" value="<?= $form_name ?>" class="write_contact form-control" id="name_contact" required="required" placeholder="Ваше имя *">
                            <input type="email" name="email_order_sheet" value="<?= $form_email ?>" class="write_contact form-control" id="email_contact" required="required" placeholder="Ваш e-mail *">
                            <input type="tel" name="phone_order_sheet" value="<?= $form_phone ?>" class="write_contact form-control" id="phone_contact" required="required" placeholder="Ваш телефон *">
                            <input type="text" name="text_comp_order_sheet" value="<?= $form_company ?>" class="write_contact form-control" id="name_comp_contact" required="required" placeholder="Название компании">
                            <textarea name="text_comment_order_sheet" class="write_contact form-control" id="name_comment_contact" placeholder="Ваш комментарий"></textarea>
                            
							<!--
                            <p class="required text-left">Поля, отмеченные * , обязательны для заполнения</p>
                            <p class="text-center">После отправки запроса специалист в кратчайший срок ответит Вам!</p>
							-->
							
							<p class="required text-left">Подтвердите, что Вы человек, чтобы запрос был отправлен!</p>
                            
                            
                            <!--ReCaptcha Google-->
                            <div class="g-recaptcha" data-sitekey="6Le9HlAUAAAAALIMYj82VC1gAwAW-XNrm9JrpSyo"></div>
							
                            <button type="submit" name="btn_order_sheet" class="btn_write_review text-center" id="btn_order_sheet">Отправить</button>													

                        </div>
                    </div>
                </form>
                
                
            </div>
        </div>
        <!--КОНЕЦ Всплывающее окно ЗАПРОС СТОИМОСТИ-->        
        <!--КОНЕЦ - КОРЗИНА ЗАПРОСА ТОВАРОВ-->

        


<script type="text/javascript">
    
    //CHANGE ICONS IN MENU-LIST   
    $('.menu-list li').click(function(){  
        if (!$(this).next('ul.sub-menu').hasClass('in')){
            $(this).find('i.glyphicon').removeClass('glyphicon-triangle-right').addClass('glyphicon-triangle-bottom');
        }
        else {
            $(this).find('i.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-right');
        }
    });
    
    
// SPOILER
    $(document).ready(function () {
        $('.spoiler').mouseover(function () {
            $(this).parent().children('div.spoiler_text').toggle();
            return false;
        });
        $('.spoiler').mouseout(function () {
            $(this).parent().children('div.spoiler_text').toggle();
            return false;
        });
    });


    
// TELEPHONE MASK +38()___-__-__
    jQuery(function($){       
       $("#phone_contact").mask("+38(999) 999-99-99");
    });



</script>	




<!-- Карусель картинок и чертежей в model_details-->
<script src="<?=TEMPLATE?>js/model_details/drawpics_owlCarousel.js"></script>

<!-- Скрипт взаимодействия с корзиной-->
<script src="<?=TEMPLATE?>js/model_details/cart.js"></script>

     
<?php require_once 'includes/end_body.php';?>
