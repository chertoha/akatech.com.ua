<?php defined('AKATECH') or die('Access Denied'); ?>
<?php 
//var_dump($arr_slider);

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <meta name="keywords" content="<?=$meta_keywords?>">
        <meta name="description" content="<?=$meta_description?>">
        <!--<meta name="author" content="">-->
        <link rel="shortcut icon" href="<?= TEMPLATE ?>images/favicon.ico" type="image/x-icon">
	
	
	
	
        <title><?=$title ?></title>

        <link href="<?= TEMPLATE ?>css/bootstrap.css" rel="stylesheet">
        <link href="<?= TEMPLATE ?>css/nivo-lightbox.css" rel="stylesheet" >
	<link href="<?= TEMPLATE ?>css/nivo_lightbox_themes/default/default.css" rel="stylesheet" >
        <link href="<?= TEMPLATE ?>css/owl.carousel.css" rel="stylesheet">
        <link href="<?= TEMPLATE ?>css/owl.theme.css" rel="stylesheet">        
        <link href="<?= TEMPLATE ?>css/style.css" rel="stylesheet">
        
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        
        <script src="<?=TEMPLATE?>js/bootstrap.js"></script>
        <script src="<?=TEMPLATE?>js/owl.carousel.js"></script>
        
        <script src="<?=TEMPLATE?>js/nivo-lightbox.min.js"></script>
	<script src="<?=TEMPLATE?>js/jquery.totemticker.js"></script>
        
        <script src="<?=TEMPLATE?>js/jquery.maskedinput.min.js"></script>
        
        

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        
        
         <!--GoogleAnalytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-43823160-1', 'akatech.com.ua');
          ga('send', 'pageview');

        </script>
        <!--/GoogleAnalytics -->
        
        
        <!-- Yandex.Metrika counter --> 
        <!--<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter36440045 = new Ya.Metrika({ id:36440045, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); -->
        <!--</script> -->
        <!--<noscript><div><img src="https://mc.yandex.ru/watch/36440045" style="position:absolute; left:-9999px;" alt="" /></div></noscript> -->
        <!-- /Yandex.Metrika counter -->
		
		
		<!--ReCaptcha Google-->
        <script src='https://www.google.com/recaptcha/api.js'></script>
	    
	    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MLQS2M8');</script>
        <!-- End Google Tag Manager -->

    </head>
    <body>
        
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MLQS2M8"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        
        
        <header id="main_header">
            <div class="container">
                <div class="row pre_header">
                    <div class="col-md-4 col-xs-5 soc_seti">  
                        <!--<a href="adminer/"><i class="reg"></i></a>Авторизация&nbsp; &nbsp;&nbsp;-->
                        <a href="adminer/"><i class="reg"></i></a>Авторизація&nbsp; &nbsp;&nbsp;
                        <a href="https://www.facebook.com/AKATech-Group-LLC-647463895335022/?ref=hl"><i class="fb"></i></a>
                        <a href="https://vk.com/akatech"><i class="vk"></i></a>                        
                        <a href="https://plus.google.com/b/101059798307937913739/101059798307937913739?hl=ru"><i class="google"></i></a>
                        <a href="#"><i class="youtube"></i></a>
                    </div>
                    <div class="col-md-8 col-xs-7 menu">  
                        <div class="navbar" role="navigation">						
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>				 
                            </div>
                            <div class="navbar-collapse collapse" style="height: 0px;">
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="menu_search">
                                        <form class="form-search" method="get">
                                            <input type="hidden" name="view" value="search" class="input-medium search-query sear">
                                            <input type="text" name="search_text" class="input-medium search-query sear">
                                            <button type="submit" class="btn_search"><i class="search"></i></button>
                                        </form>
                                    </li>
                                    <li><a href="#"><i class="home"></i></a></li>
                                    <!--<li><a href="?view=catalogs">Каталоги</a></li>-->
                                    <!--<li><a href="?view=news">Новости</a></li>-->
                                    <!--<li><a href="?view=gallery">Галерея</a></li>-->
                                    <!--<li><a href="?view=contacts">Контакты</a></li>-->
                                    <li><a href="?view=catalogs">Каталоги</a></li>
                                    <li><a href="?view=news">Новини</a></li>
                                    <li><a href="?view=gallery">Галерея</a></li>
                                    <li><a href="?view=contacts">Контакти</a></li>
                                </ul>
                            </div>						
                        </div>       
                    </div>
                </div>
            </div>
        </header>