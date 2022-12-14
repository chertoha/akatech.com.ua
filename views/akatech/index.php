<?php defined('AKATECH') or die('Access Denied'); ?>
<?php require_once 'includes/header.php';?>

        <div id="block_logo">
            <?php include 'includes/header2.php'?>
        </div>

        <div id="main_slide">		
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->                
               
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $i < count($arr_slider); $i++):?>                       
                        <?php if ($i === 0):?>
                        <li data-target="#carousel-example-generic" data-slide-to="<?= $i ?>" class="active"></li>
                        <?php else :?>
                        <li data-target="#carousel-example-generic" data-slide-to="<?= $i ?>"></li>
                        <?php endif; ?>
                    <?php endfor;?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    
                    <?php foreach ($arr_slider as $key => $slide) :?>
                        <?php $active_slide = ($key === 0) ? 'active' : '' ;?>
                        <div class="item <?= $active_slide ?>">
                            <!--<a href="#">-->
                                <img src="<?=TEMPLATE?>images/slider/<?= $slide['slide_img_url'] ?>" alt="<?= $slide['slide_img_alt'] ?>">
                                <div class="carousel-caption">
                                    <?= $slide['slide_html'] ?>
                                </div>
                            <!--</a>-->
                        </div>
                    <?php endforeach ;?>
                    
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon icon_prev"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon icon_next"></span>
                </a>
            </div>
        </div>

        <div id="main_wrapper">
            <h1 style="font-size: 20px; color: #636363; padding: 0; margin: 0; text-align: center;">???????????????????????? ??????????????????????????</h1>
            <div class="container">
                
                <div class="row">
                <?php foreach ($arr_overview as $key=>$arr_subj):?>                
                    
                    <div class="col-md-3 col-xs-6 text-center block_katalog">
                        <a href="?view=category&category_id=<?=$arr_subj['tree_prod_id']?>" class="spoiler">
                            <img src="<?=TEMPLATE?>images/overview/<?=$arr_subj['tree_prod_img']?>" alt="<?=$arr_subj['tree_prod_name']?>" title="<?=$arr_subj['tree_prod_name']?>">
                            <h3><?=$arr_subj['tree_prod_name']?></h3>						
                        </a>
                        <div class="spoiler_text">
                            <hr>
                            <p><?=$arr_subj['tree_prod_description']?></p>
                        </div>
                    </div>
                    
                    <?php 
                    if (($key+1)%4 === 0 && ($key+1) !== count($arr_overview)) {
                        echo '</div><!--.row--> '
                        . '<div class="row">';
                    }                    
                    ?>                
                
                <?php endforeach;?>
                </div><!--.row-->
                

            </div><!--.container-->
        </div><!--#main_wrapper-->
        
<?php require_once 'includes/subscribe.php';?>

        <div id="block_about">
            <div class="container">
                <div class="row text-center ">
                    <div class="title_about">
                        <h2>?????? "???????????? ????????"</h2>
                        <!--<h3>???????? ???????????????????????? ???????????? ???????? ????????????!</h3>-->
                        <h3>???????? ???????????????????? ?????? ???????? ??????????????????</h3>
                    </div>
                </div>
                <div class="row txt_about">
                    <div class="col-md-6">
                        <!--<p style="text-align: justify;">                            -->
                        <!--    ???????? ???????? ??? ???????????? ???????????????????? ???????????????????????? ?????????? ???? ?????????????????????? ?????????? ?????????????? ????????????????????????. -->
                        <!--    ???? ???????????????? ???? ?????????????? ?????????? ?????????? ?? ?????????????????? ???????? ?? ?????????????????????? ????????????????????????, -->
                        <!--    ???????????????? ???????????????????????????? ???????????????????????? ?????????????????????????? ?????????????????? ??? -->
                        <!--    ?????????????????? ?????????????????? ???? ?????????????????? ?? ?????????????????????? ??????????????????. -->
                        <!--    ???????????????????????? ?????????????????? ?????????????????? ?????????????????? ?????????????????? ?????????????????????? ?? ?????????????????????????????????????? -->
                        <!--    ????????????????????????: ??????????????????????????, ???????????????? ?? ?????????????? ?????? ??????????????????????????. -->
                        <!--    ?????????? ????????, ?? ???? ?????????????? ???????????????????????????????????? ?????????????????????? ??????????: -->
                        <!--    ???????????????????????????? ???????????????????????? ?? ?????????????????????????????? ????????????????, -->
                            
                        <!--</p>-->
                         <p style="text-align: justify;">
                            ???????? ???????? - ?????????????????? ?????????????????????? ?????????????????????????? ?????????????? ???????????? ???????????? ?????????? ??????????????????????.
                            ???? ?????????????????? ???????????????? ???????? ?????????? ???? ?????????????????? ???????? ???? ?????????????????????????? ????????????????????,
                            ?????? ???????????????? ???????????????????? ???????????????? ?????????????????????? ?????????????????? -
                            ???????????????? ???????????????? ?????????????????? ???? ?????????????????????? ??????????????????.
                            ??????????????????, ???? ?????????????????????????? ?????????? ??????????????????, ???????????????? ?????????????????? ?????????????? ?? ??????????????????????????????????????
                            ????????????????????: ????????????????????????, ?????????????? ???? ???????????? ?????? ????????????????????????.
                            ???????? ????????, ???? ???? ?????????????????? ?????????????????????????? ???????????????????????? ????????????:
                            ???????????????????????? ?????????????????????? ???? ???????????????????????? ??????????????,
                        </p>
                    </div>
                    <div class="col-md-6">
                        <!--<p style="text-align: justify;">-->
                        <!--    ?????????????????? ???????????????????????????????? ??????????????,-->
                        <!--    ???????????????? ???????????????? ???????????????????????? ?? ?????????????????? ?????? ????????????????????????.-->
                        <!--    ???????? ?????????????????? ?? ?????????????????? ???????????????? ???? ?????????????????????? ?? ??????????????????????????????. -->
                        <!--    ???? ???? ???????????????????????????? ???????????????????? ???????????????????????????????????? ??????????????????????????, -->
                        <!--    ?? ???????????? ?????????????????????? ??????????????????????-?????????????????? ?????????????????? ??????????????, -->
                        <!--    ???????????????????????? ???? ???????????????????????? ?????????? ?? ???????????????? ???????????????? ????????????????. -->
                        <!--    ?? ???????? ?????????? ???? ?????????????????????????? ???????????????? ?????????????????????? ????????????????????????, -->
                        <!--    ?????????????????????????????????? ???????????? ?? ?????????????? ?????????????????????? ??????????????????, -->
                        <!--    ???????????????????????? ???????????? ?? ???????????????????????????? ??????????????????. -->
                        <!--</p>-->
                         <p style="text-align: justify;">
                            ???????????????? ?????????????????? ??????????????,
                            ?????????????????? ???????????? ???????????????????? ???? ?????????????????? ???????? ????????????????????????????.
                            ???????? ?????????????????? ?? ?????????????????? ?????????????????? ???? ?????????????????????? ???? ??????????????????????????????.
                            ???? ???? ?????????????????????? ?????????????????????? ???????????????????????????? ??????????????????????????,
                            ?? ?????????????????? ?????????????? ??????????????????????-?????????????????? ????????????????????,
                            ???????????????????????????? ?????? ???????????????? ?????????????? ???? ???????????????????? ???????????????? ????????????????.
                            ?? ???????? ?????????? ???? ?????????????? ???????????????? ????????????????????????,
                            ?????????????????????????? ???????????????? ?? ?????????????? ???????????????????? ??????????????????,
                            ?????????????????????? ???????????? ???? ???????????????????????? ??????????????????.
                        </p>
                            

                        
                    </div>
                </div>
            </div>
        </div>
        <div id="block_logos">
            <div class="container">
                <div class="row text-center" style="height: 99px;">
                    <div id="owl-demo" class="">
                        
                        <!--
                        <div class="item">
                           
                        </div>
                        -->
                        
                        <div class="item">
                            <a href="http://www.boteco.it/default.aspx?l=EN"><img src="<?=TEMPLATE?>images/logoBotecoColor.png" alt="???????????????????????? ?????????????????? Boteco"></a>
                        </div>
                        <div class="item"><a href="http://www.speedyblock.com/home_en.html"><img src="<?=TEMPLATE?>images/logoSpeedyColor.png" alt="?????????????? ?????? ???????????? Speedy Block"></a></div>
                        
                        <div class="item"><a href="http://www.dirak.com/index.php?pid=21&languageid=6"><img src="<?=TEMPLATE?>images/logoDirakColor.png" alt="?????????? ?? ?????????????????? Dirak"></a>
                        </div>
                         <div class="item"><a href="https://www.fiama.it/en/"><img src="<?=TEMPLATE?>images/logoFiama.png" alt="???????????????? ????????????????, ???????????????????? ??????????????????"></a>
                        </div>
                        
                    
                        <!--<div class="item"><a href="http://www.rosta.ch/"><img src="<?=TEMPLATE?>images/logoRostaColor.png" alt="?????????????????????????????????????? ???????????????? Rosta"></a>
                        </div> -->			
                    </div>
                    <div class="customNavigation">
                        <a  class="prev"></a>
                        <a  class="next"></a>				  
                    </div>					
                </div>
            </div>
        </div>
        
<?php require_once 'includes/footer.php';?>

        
        
        <!--???????????? ?????????????????????? ???????? ????????????????-->    

        <div class="modal fade" id="myModal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                    <div class="modal-header text-center">
                        <h3 class="modal-title" id="myModalLabel1">???????????????? ??????????</h3>
                        <p>?????? ????????, ?????????? ???????????????? ??????????<br /> ?????????????????? ??????????</p>

                    </div>
                    <div class="modal-body text-center">
                        <form id="form_contact_order_sheet" class="" role="form" method="post" onsubmit="FormSendOK()">																																					
                            <input type="text" name="name_order_sheet" class="write_contact form-control" id="name_contact" required="required" placeholder="???????? ??????">
                            <input type="email" name="email_order_sheet" class="write_contact form-control" id="email_contact" required="required" placeholder="?????? e-mail">													
                            <button type="submit" name="btn_order_sheet" class="btn_write_review">??????????????????</button>										
                        </form>
                    </div>		  
                </div>
            </div>
        </div>

        <!--?????????? ?????????????????????? ???????? ????????????????-->
        

        <script type="text/javascript">
            
            
            /*?????????????????? ????????????????*/
            $(document).ready(function () {

                var owl = $("#owl-demo");

                owl.owlCarousel({
                    items: 5, //10 items above 1000px browser width
                    itemsDesktop: [1000, 5], //5 items between 1000px and 901px
                    itemsDesktopSmall: [900, 3], // betweem 900px and 601px
                    itemsTablet: [600, 2], //2 items between 600 and 0
                    itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
                });

                // Custom Navigation Events
                $(".next").click(function () {
                    owl.trigger('owl.next');
                })
                $(".prev").click(function () {
                    owl.trigger('owl.prev');
                })
                $(".play").click(function () {
                    owl.trigger('owl.play', 1000); //owl.play event accept autoPlay speed as second parameter
                })
                $(".stop").click(function () {
                    owl.trigger('owl.stop');
                })

            });
        </script>

        <script type="text/javascript">
            
            /*???????????????? ?????????? ?????????????? ????????????????*/
            $('.carousel').carousel({
                interval: 10000
            })
        </script>
        
        <script type="text/javascript">
            /*jQuery(document).ready(function(){
             jQuery('.spoiler_text').hide()
             jQuery('.spoiler').hover(
             function(){
             var timeout = setTimeout(function(){
             jQuery ('.spoiler_text').stop(true, true).slideDown()
             },300);
             jQuery(this).data('timeout', timeout);
             },
             function(){
             var timeout = jQuery(this).data('timeout');
             clearTimeout(timeout);
             jQuery('.spoiler_text').stop(true, true).slideUp()
             }
             )
             })*/

            /*$('.block_katalog').hover(function(){
             $(this).find('.spoiler_text').css('display','block').animate({opacity:'1'}, 3000);
             }
             ,function(){$(this).find('.spoiler_text').css('display','none');})*/

             
             
            /*?????????????? ?? ???????????? ??????????????*/
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

        </script>



<?php require_once 'includes/end_body.php';?>
