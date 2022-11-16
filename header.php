<?php defined('AKA_TOOLS') or die("Access denied!"); ?>
<?php
$configuration_rights = ($_SESSION['user_data']['user_role_id'] === ADMIN_ROLE_ID) ? true : false;



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <title><?= TITLE ?></title>
        <link href="<?= TEMPLATE ?>css/bootstrap.css" rel="stylesheet">
        <link href="<?= TEMPLATE ?>css/style.css" rel="stylesheet">        

        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>       
        <script src="<?= TEMPLATE ?>js/bootstrap.js"></script>

        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>tinymce.init({selector: 'textarea.tinymce'});</script>  

    </head>
    <body>
        <header id="main_header">

            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="?view=dashboard">AKA-Tools</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Продажи <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="?view=sales/autokp">Коммерческое предложение</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Логистика <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="?view=logistics/tracking">Трекинг перевозок</a></li>

                                </ul>
                            </li>
                            
                            
                                
                            <!--<li><a href="?view=news"></a></li>-->
                            <!--<li><a href="?view=slider">Slider</a></li>-->


                        </ul><!--.nav. navbar-nav-->

                        <ul class="nav navbar-nav navbar-right">
                            
                            <?php if($configuration_rights):?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Config<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="?view=config/config_logistics/config_tracking">Трекинг перевозок config</a></li>

                                </ul>
                            </li>
                            <?php endif;?>
                            
                            <li><a href="#"><?= $_SESSION['user_data']['user_name'] ?></a></li>
                            <li>
                                <form class="navbar-form navbar-right" method="POST" action="?view=dashboard">                            
                                    <button type="submit" name="logout" class="btn btn-default">Выйти</button>
                                </form>
                            </li>

                        </ul>


                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>