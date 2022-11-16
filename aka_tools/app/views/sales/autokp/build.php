<?php
//var_dump($_SESSION);
$data = $_SESSION['autokp_save_data'];
//var_dump($temp);

//echo '<img style="height: 100px" src="' . IMAGES_FOLDER . 'avatars/' . $_SESSION['auth']['user_avatar_image'] . '">';
//echo $_SESSION['auth']['visitcard'];
?>


<h4 class="text-muted">Autokp-build</h4>

<div class="container">

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10 text-center">

        </div>        
        <div class="col-lg-1"></div>
    </div>

    <div class="row">        
        <div class="col-lg-2 text-center">
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/customer" class="btn btn-primary btn-md active" role="button" aria-pressed="true"><< Клиент</a> &nbsp; 
        </div>
        <div class="col-lg-6 "> 
            <form action="" method="POST">
                <input type="submit"  class="btn btn-info"   name="autokp_build" value="Построить / Сбросить">
            </form>
        </div>

        <div class="col-lg-2 "> 
            <form action="" method="POST">
                <?php $disabled = (!isset($_SESSION['autokp_save_data'])) ? 'disabled' : ''; ?>
                <input <?= $disabled ?> type="submit"  class="btn btn-success"   name="autokp_save_pdf" value="Сохранить PDF">
            </form>
        </div> 
        <div class="col-lg-2 text-center"> 
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp" class="btn btn-primary btn-md active" role="button" aria-pressed="true">В начало >></a>
        </div>
    </div>

</div>
<div class="alert alert-info">
  <strong>Info : </strong> <?=$error?>
</div>
<br>

<?php if (isset($data['articles'])): ?>
    <?php foreach ($data['articles'] as $article_id => $article) : ?>
        <form action="" method="POST">
            <div class="container">
                <div class="row">        
                    <div class="col-lg-1 text-center">

                    </div>
                    <div class="col-lg-10 "> 
                        <div class="hide-parent panel panel-default ">

                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $article['article']['val'] ?> <span class="btn btn-sm hide-list">▼</span></h3>
                            </div>
                            <div class="panel-body hide-show-article" data-toggle="toggle">
                                <input type="hidden" name="article_arr_id" value="<?= $article_id ?>">

                                <!-- Картинка-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Картинка</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php foreach ($article['pics'] as $key => $pic) : ?>
                                                <?php $checked = ($pic['on']) ? 'checked' : ''; ?>
                                                <?php $active = ($pic['on']) ? 'active' : ''; ?>
                                                <label class="autokp-build-pic-label btn <?= $active ?>">                                                      
                                                    <input <?= $checked ?> class="autokp_build_pics" type="radio" name="pics" id="option1" autocomplete="off" value="<?= $key ?>"> 
                                                    <img class="autokp-build-img autokp_build_pic" src="<?= $pic['val'] ?>">
                                                    <input type="hidden" name="article_arr_id" value="<?= $article_id ?>">
                                                </label>

                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Чертеж-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Чертеж</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php foreach ($article['draws'] as $key => $drw) : ?>
                                                <?php $checked = ($drw['on']) ? 'checked' : ''; ?>
                                                <?php $active = ($drw['on']) ? 'active' : ''; ?>
                                                <label class="autokp-build-drw-label btn <?= $active ?>">                                                    
                                                    <input <?= $checked ?> type="radio" name="draws" id="option1" autocomplete="off" value="<?= $key ?>"> 
                                                    <img class="autokp-build-img autokp_build_drw" src="<?= $drw['val'] ?>">
                                                    <input type="hidden" name="article_arr_id" value="<?= $article_id ?>">
                                                </label>

                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Артикул-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Артикул / Название / Описание</h3>
                                    </div>
                                    <div class="panel-body"> 
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <?= $article['article']['val'] ?>
                                                <?php $checked = ($article['article']['on']) ? 'checked' : ''; ?>                                                
                                                <input class="autokp_build_info" type="checkbox"  name="article" <?= $checked ?> >
                                                <input type="hidden" name="article_arr_id" value="<?= $article_id ?>">
                                            </div>
                                            <div class="col-lg-2">
                                                <?= $article['name']['val'] ?>
                                                <?php $checked = ($article['name']['on']) ? 'checked' : ''; ?>                                                
                                                <input class="autokp_build_info" type="checkbox"  name="name" <?= $checked ?> >
                                                <input type="hidden" name="article_arr_id" value="<?= $article_id ?>">
                                            </div>
                                            <div class="col-lg-3">
                                                <?= $article['description']['val'] ?>
                                                <?php $checked = ($article['description']['on']) ? 'checked' : ''; ?>                                                
                                                <input class="autokp_build_info" type="checkbox"  name="description" <?= $checked ?> >
                                                <input type="hidden" name="article_arr_id" value="<?= $article_id ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Параметры товара-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Параметры</h3>
                                    </div>
                                    <div class="panel-body"> 
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php foreach ($article['properties'] as $prop => $value) : ?>
                                                <?php $checked = ($value['on']) ? 'checked' : ''; ?>
                                                <?php $active = ($value['on']) ? 'active' : ''; ?>
                                                <label class="autokp-build-prop-label btn btn-default <?= $active ?>">                                                   
                                                    <input class="autokp_build_prop"  <?= $checked ?> type="checkbox" name="<?= $prop ?>"><?= $prop . ' = ' . $value['val'] ?>
                                                    <input type="hidden" name="article_arr_id" value="<?= $article_id ?>">
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Срок поставки-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Срок поставки</h3>
                                    </div>
                                    <div class="panel-body">                                         
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <?= $article['delivery_time']['val'] ?>
                                                <?php $checked = ($article['delivery_time']['on']) ? 'checked' : ''; ?>                                                
                                                <input class="autokp_build_info" type="checkbox"  name="delivery_time" <?= $checked ?> >
                                                <input type="hidden" name="article_arr_id" value="<?= $article_id ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                                <!--<input type="submit"  class="btn btn-success"   name="autokp_build_save_data" value="save">-->
                                                <!--<input type="submit" name="autokp_test" class="btn btn-success" value="test">-->

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </form>
    <?php endforeach; ?>
<?php endif; ?>    

<script>

//HIDE CONTENTS
    $('.hide-list').click(function (event) {
//    console.log($(event.target).closest('.hide-parent').children('.hide-show-article'));
        $(event.target).closest('.hide-parent').children('.hide-show-article').toggle('slow');
//   $('.hide-show-article').toggle('slow');   
    });




    $('body').click(function (event) {
        var target = $(event.target);
//        console.log(event.target);

        /*Change picture*/
        if (target.hasClass('autokp_build_pic') || target.hasClass('autokp-build-pic-label')) {
            var pic_id;
            var article_id;
            if (target.hasClass('autokp_build_pic')) {
                pic_id = $(target).parent().children('input[name="pics"]').val();
                article_id = $(target).parent().children('input[name="article_arr_id"]').val();
            } else {
                pic_id = $(target).children('input[name="pics"]').val();
                article_id = $(target).children('input[name="article_arr_id"]').val();
            }

            setParamAjax({
                autokp_build_save_data: 'pics',
                article_id: article_id,
                pic_id: pic_id
            });
        }


        /*Change drawing*/
        if (target.hasClass('autokp_build_drw') || target.hasClass('autokp-build-drw-label')) {
            var pic_id;
            var article_id;
            if (target.hasClass('autokp_build_drw')) {
                pic_id = $(target).parent().children('input[name="draws"]').val();
                article_id = $(target).parent().children('input[name="article_arr_id"]').val();
            } else {
                pic_id = $(target).children('input[name="draws"]').val();
                article_id = $(target).children('input[name="article_arr_id"]').val();
            }

            setParamAjax({
                autokp_build_save_data: 'draws',
                article_id: article_id,
                pic_id: pic_id
            });
        }

        /*Change articles*/
        if (target.hasClass('autokp_build_info')) {
            var info_name = $(target).attr('name');
            var article_id = $(target).parent().children('input[name="article_arr_id"]').val();

            setParamAjax({
                autokp_build_save_data: 'info',
                article_id: article_id,
                info_name: info_name
            });
        }

        /*Change properties*/
        if (target.hasClass('autokp_build_prop') || target.hasClass('autokp-build-prop-label')) {
            var prop_name;
            var article_id;
            if (target.hasClass('autokp_build_prop')) {
                prop_name = $(target).attr('name');
                article_id = $(target).parent().children('input[name="article_arr_id"]').val();
            } else {
                prop_name = $(target).children('.autokp_build_prop').attr('name');
                article_id = $(target).children('input[name="article_arr_id"]').val();
            }

            setParamAjax({
                autokp_build_save_data: 'properties',
                article_id: article_id,
                prop_name: prop_name
            });
        }

        setParamAjax = function (dataObj) {
            $.ajax({
                url: '',
                type: 'POST',
                data: dataObj,
                success: function (response) {
                    console.log(response);
                }
            });
        };


    });

</script>



