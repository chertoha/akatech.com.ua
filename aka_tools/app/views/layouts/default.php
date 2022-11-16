<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $title ?></title>
         
        <link href="<?= CSS_FOLDER ?>bootstrap.css" rel="stylesheet">
        <link href="<?= CSS_FOLDER ?>style.css" rel="stylesheet">  

        <script src="<?= SCRIPTS_FOLDER ?>jquery-3.4.1.min.js"></script>
        <script src="<?= SCRIPTS_FOLDER ?>bootstrap.js"></script>
        
        <!--<script src="<?php // echo SCRIPTS_FOLDER ?>form.js"></script>-->
        

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
                        <a class="navbar-brand" href="<?= HOME_DIRECTORY_URL ?>dashboard">AKA-Tools</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Продажи <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= HOME_DIRECTORY_URL ?>sales/autokp">Коммерческое предложение</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Логистика <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= HOME_DIRECTORY_URL ?>logistics/tracking">Трекинг перевозок</a></li>

                                </ul>
                            </li>
                            
                            
                                
                            <!--<li><a href="?view=news"></a></li>-->
                            <!--<li><a href="?view=slider">Slider</a></li>-->


                        </ul><!--.nav. navbar-nav-->

                        <ul class="nav navbar-nav navbar-right">
                            
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Config<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= HOME_DIRECTORY_URL ?>admin/tracking">Трекинг перевозок config</a></li>
                                    <li><a href="<?= HOME_DIRECTORY_URL ?>admin/logging">Логи</a></li>
                                    <li><a href="<?= HOME_DIRECTORY_URL ?>admin/price">Прайсы</a></li>
                                    <li><a href="<?= HOME_DIRECTORY_URL ?>admin/test">Тест</a></li>

                                </ul>
                            </li>
                            
                            
                            <li><a href="<?= HOME_DIRECTORY_URL ?>profile"><?=$_SESSION['auth']['user_name'].' '.$_SESSION['auth']['user_lastname']?></a></li>
                            <li>
                                <form class="navbar-form navbar-right" method="POST" action="<?= HOME_DIRECTORY_URL ?>auth">                            
                                    <button type="submit" name="logout" class="btn btn-default">Выйти</button>
                                </form>
                            </li>

                        </ul>


                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>
        
        <div class="main-adminer container-fluid">
            
            <?= $content ?>
            
        </div><!--main-adminer--><img src=""/>

        
    </body>
</html>



