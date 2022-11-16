<?php defined('ADMINER') or die('Access Denied'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <title><?= ADM_TITLE ?></title>


        <link href="<?= ADM_TEMPLATE ?>css/bootstrap.css" rel="stylesheet">
        <link href="<?= ADM_TEMPLATE ?>css/adm-style.css" rel="stylesheet">
        
        
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>       
        <script src="<?= ADM_TEMPLATE ?>js/bootstrap.js"></script>
        
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea.tinymce' });</script>
        
  
        

    </head>
    <body>
        <header id="main_header">
            <!--            <div class="container-fluid header">
                            
                        </div>-->

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
                        <a class="navbar-brand" href="#">AKATech-adminer</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="?view=tree">Products Tree <span class="sr-only">(current)</span></a></li>
                                    <li><a href="?view=prod_groups">Product Groups</a></li>
                                    <li><a href="?view=admin_models">Admin Models</a></li>
                                    <li><a href="?view=admin_modify_props">Modify Model Properties</a></li>
                                    <li><a href="?view=admin_del_product">Delete Products</a></li>
                                    <li><a href="?view=admin_edit_product">Edit Product</a></li>
                                    <li><a href="?view=admin_add_brands">Add Brand</a></li>
                                    <li><a href="?view=admin_add_excel">Add Excel</a></li>
                                    <!--<li><a href="?view=admin_add_images">Add Images</a></li>-->
                                </ul>
                            </li>
                            
                            
                            
                            <li><a href="?view=news">News</a></li>
                            <li><a href="?view=slider">Slider</a></li>
                            
                            
                            
                            
                        </ul><!--.nav. navbar-nav-->
                                               
                        
                        
                        <form class="navbar-form navbar-right" method="POST" action="">
                            <button type="submit" name="logout" class="btn btn-default">Log Out</button>
                        </form>
                        
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>