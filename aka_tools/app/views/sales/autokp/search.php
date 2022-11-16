<?php
//var_dump($_SESSION);
?>


<h4 class="text-muted">Search articles</h4>


<div id="autokp" class="container">
    <div class="row">
        <!--<div class="col-lg-1"></div>-->
        <div class="col-lg-12">
            <form action="" method="POST">
                <label>
                    Brand
                    <select class="form-control input-sm" id="autokp_brands" name="autokp_brand_id" required >
                        <option value="">-Select brand-</option>
                    </select>
                </label>
                <label>
                    Series
                    <select class="form-control input-sm" id="autokp_series" name="autokp_serie_id" required disabled >
                        <option value="">-Select serie-</option>
                    </select>
                </label>
                <label>
                    Models
                    <select class="form-control input-sm" id="autokp_models" name="autokp_model_id" required disabled >
                        <option value="">-Select model-</option>
                    </select>
                </label>
                <input class="btn btn-success btn-sm" type="submit" id="autokp_model_find" name="autokp_model_find"  value="Поиск">
            </form>   
        </div>



    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="POST">
                <label>
                    Search
                    <input class="form-control input-sm" type="text" id="autokp_search" name="autokp_search_value" placeholder="Search" required> 
                </label>
                <input class="btn btn-success btn-sm" type="submit" id="autokp_search_find" name="autokp_search_find"  value="Поиск">
            </form>
        </div>
    </div>
</div>

<div id="autokp_container" class="container">

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-4 text-center"><b>Articles from model</b></div>
        <div class="col-lg-2"></div>
        <div class="col-lg-4 text-center"><b>Articles to KP</b></div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">        
        <div class="col-lg-1">
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp" class="btn btn-primary btn-md active" role="button" aria-pressed="true"><< Main</a> &nbsp; 
            <?php
            $src = ($brand == '' || $model_img == '') ? IMAGES_FOLDER . 'autokp/default-picture.png' : IMG_MODELS_AKA . $brand . '/pic_preview/' . $model_img;
            ?>
            <a href="#"><img src="<?= $src ?>" alt="..." class="img-thumbnail autokp-model-pic"></a>
        </div>
        
        <div class="col-lg-4 autokp-list"> 

            <?php foreach ($articles as $article) : ?>
                <div class="row"> 
                    <label class="auto_kp_found_articles">
                        <input type="checkbox" class="articles_checked" value="<?= $article['prod_id'] ?>"> 
                        <?= $article['prod_article'] . ' ' . $article['prod_description'] ?> 
                    </label>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="col-lg-2 text-center">
            <button id="autokp_add_article" class="btn btn-success">добавить => </button>
        </div>

        <div class="col-lg-4 autokp-list" id="autokp_articles"> 

            <?php if (isset($_SESSION['autokp'])): ?>
                <?php foreach ($_SESSION['autokp'] as $kp_article) : ?>
                    <div class="row">
                        <?php $img_path = IMG_MODELS_AKA . $kp_article['brand_descriptor'] . '/pic_preview/' . $kp_article['model_image_path']; ?>
                        <input type="hidden" name="autokp_article_id" value="<?= $kp_article['prod_id'] ?>">
                        <img src="<?= $img_path ?>" class="autokp-kplist-pic">&nbsp;&nbsp;
                        <span class="autokp_art_kp"><?= $kp_article['prod_article'] ?></span> &nbsp;&nbsp;   
                        <button class="btn btn-sm btn-danger autokp_del_article">x</button>
                    </div>            
                    <hr class="autokp_separator">
                <?php endforeach; ?>
            <?php endif; ?>



        </div>
        <div class="col-lg-1 "> 
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/pricing" class="btn btn-primary btn-md active" role="button" aria-pressed="true">Цены >></a>
            <br>
            <br>
            <br>
            <button class="btn btn-danger" id="autokp_clear_list">Удалить всё</button>
        </div> 
    </div>

</div>

<script>

    /* Ajax filling Brands*/
    $(document).ready(function () {
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                autokp_brands: 'brands'
            },
            success: function (response) {
                $('#autokp_brands').append(response);
            }
        });

    });


    /* Ajax filling Series*/
    $('#autokp_brands').change(function () {

//        $('#SelectAllModels').prop('checked', false);

        if ($(this).val() == 0) {
            $('#autokp_series').prop('disabled', true);
            $('#autokp_series').empty();
            $('#autokp_series').append('<option>-Select serie-</option>');
        } else {
            $('#autokp_series').prop('disabled', false);
            $('#autokp_series').empty();
            $('#autokp_series').append('<option value="0">-Select serie-</option>');
        }

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                autokp_series: 'series',
                brand_id: $(this).val()
            },
            success: function (response) {
                $('#autokp_series').append(response);
            }
        });

    });


    /* Ajax filling Models*/
    $('#autokp_series').change(function () {

//        $('#SelectAllModels').prop('checked', false);

        if ($(this).val() == 0) {
            $('#autokp_models').prop('disabled', true);
            $('#autokp_models').empty();
            $('#autokp_models').append('<option>-Select serie-</option>');
        } else {
            $('#autokp_models').prop('disabled', false);
            $('#autokp_models').empty();
            $('#autokp_models').append('<option value="0">-Select serie-</option>');
        }

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                autokp_models: 'models',
                serie_id: $(this).val()
            },
            success: function (response) {

                $('#autokp_models').append(response);
            }
        });

    });


    /* Ajax add articles to KP*/
    $('#autokp_add_article').click(function () {
        var arr_checked_articles = $(".auto_kp_found_articles input:checked");
        if (arr_checked_articles.length === 0) {            
            return;
        }        
        var arr_articles_id = [];
        for (var i = 0; i < arr_checked_articles.length; i++) {
            arr_articles_id.push(arr_checked_articles[i].value);
        }
        
//        console.log(arr_articles_id);
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                autokp_add_articles: arr_articles_id
            },
            success: function (response) {
//                console.log(response);
                $('#autokp_articles').append(response);
                arr_checked_articles.prop('checked', false);
            }
        });

    });


    /* Clear KP articles List*/
    $('#autokp_clear_list').click(function () {
        $('#autokp_articles').empty();

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                autokp_clear_list: 'clear_all'
            },
            success: function (response) {
//                console.log(response);
//                $('#autokp_articles').append(response);
            }
        });

    });

    $('body').click(function (event) {
        var target = $(event.target);

        /*Delete article from KP list*/
        if (target.hasClass('autokp_del_article')) {
            var article_id = target.parent().children('input[name="autokp_article_id"]').val();
//            console.log(article_id);
            target.parent().remove();

            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    autokp_del_article_id: article_id
                },
                success: function (response) {
                    
                }
            });
        }
        
    });

</script>