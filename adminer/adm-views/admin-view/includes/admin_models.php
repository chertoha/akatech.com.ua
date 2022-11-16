<?php defined('ADMINER') or die('Access Denied'); ?>
<?php
$arr_models = ModelAdminFindModels();
//phpinfo();
//var_dump($arr_models);
//var_dump($_POST);
//var_dump($_FILES);
//var_dump($_SESSION['admin_models']);
?>

<div class="container">
    <form method="POST" action="">
        <label>
            Brand
            <select class="form-control" id="brands" name="brand_id" required >
                <option value="">-Select Brand-</option>
            </select>
        </label>
        <label>
            Series
            <select class="form-control" id="series" name="serie_id" required disabled >
                <option value="">-Select serie-</option>
            </select>
        </label>
        <input type="submit" class="btn btn-success" name="find" value="Find">
    </form>
</div>


<!--MODEL BLOCK-->
<?php foreach ($arr_models as $key => $arr_param): ?>
    <?php $anchor = ($key == $_POST['model_id']) ? 'admin_models_anchor' : ''; ?>
    <div id="<?= $anchor ?>" class="container" style="border: 1px solid grey; margin-bottom: 20px;">


        <div class="admin-models-main row">

            <div class="admin-models-block col-md-3" >

                <span><b>ID</b>: <?= $key ?> </span>
                <?php
                $checked_onstock = ($arr_param['model_onstock'] == 1) ? 'checked' : '';
                $checked_onsale = ($arr_param['model_onsale'] == 1) ? 'checked' : '';
                ?>
                <div class="check_models">
                    
                    <label style="margin-right:30px;">                        
                        <input class="check_onstock form-control" type="checkbox" value="<?= $key ?>" name="model_stock" <?=$checked_onstock?>>
                        ON STOCK
                    </label>
                    <label>
                        <input class="check_onsale form-control" type="checkbox"  value="<?= $key ?>" name="model_sale" <?=$checked_onsale?>>
                        ON SALE
                    </label>
                </div>
                
                <!--DOWNLOAD 3D-->
                <form method="POST" action="#admin_models_anchor" enctype="multipart/form-data">
                    <span><b>Download 3D</b></span>                                   
                    <input type="hidden" name="model_id" value="<?= $key ?>">
                    <input type="hidden" name="brand_name" value="<?= $arr_param['brand_name'] ?>">
                    <input type="file" id="file_3d" name="model_3d" value="">
                    <h5><?= $arr_param['model_3d_url']?></h5>    
                    <input type="submit" name="save3d" value="Save 3D" class="btn btn-success btn-xs">
                </form> 
                
            </div>


            
            <div class="admin-models-block col-md-3">
                
                <!--PREVIEW IMAGE-->
                <form method="POST" action="#admin_models_anchor" enctype="multipart/form-data">
                    <span><b>Preview Image</b></span>
                    <input type="hidden" name="img_type_id" value="3">                 
                    <input type="hidden" name="model_id" value="<?= $key ?>">
                    <input type="hidden" name="brand_name" value="<?= $arr_param['brand_name'] ?>">
                    <input type="file" id="file_preview" name="model_preview_img" value="">
                    <img src="<?= ADM_SITE_IMAGES ?>/models/<?= $arr_param['brand_name'] ?>/pic_preview/<?= current($arr_param['img_type_id']['3']) ?>" width="100">
                    <h5><?= current($arr_param['img_type_id']['3']) ?></h5>    
                    <input type="submit" name="saveOverview" value="Save" class="btn btn-success btn-xs">
                </form>   
                <br><br>
                
                <!--DOWNLOAD PDF-->
                <form method="POST" action="#admin_models_anchor" enctype="multipart/form-data">
                    <span><b>Download PDF</b></span>                                   
                    <input type="hidden" name="model_id" value="<?= $key ?>">
                    <input type="hidden" name="brand_name" value="<?= $arr_param['brand_name'] ?>">
                    <input type="file" id="file_pdf" name="model_pdf" value="">
                    <h5><?= $arr_param['pdf_url']?></h5>    
                    <input type="submit" name="savePDF" value="Save PDF" class="btn btn-success btn-xs">
                </form> 
            </div>
            
           


            <!--MODEL NAME-->
            <div class="admin-models-block col-md-3">            
                <h4 class="text-center"><b>Model Name:</b> <?= $arr_param['model_name'] ?></h4> 
                <hr>
                <div class="text-center">
                    <h4><b>Model Public Name</b></h4>
                     <form method="POST" action="#admin_models_anchor">
                        <input type="hidden" name="model_id" value="<?= $key ?>">
                        <input type="text" name="model_public_name" value="<?= $arr_param['model_public_name'] ?>" size="30">
                        <input type="submit" name="saveModelPublicName" class="btn btn-success btn-xs" value="Save Public Name">
                    </form>
                </div>
                
                
            </div>


            <!--MODEL DESCRIPTION-->
            <div class="admin-models-block col-md-3">
                <h4><b>Model Description</b></h4>
                <form method="POST" action="#admin_models_anchor">
                    <input type="hidden" name="model_id" value="<?= $key ?>">
                    <textarea name="model_description" rows="3" cols="30"><?= $arr_param['model_description'] ?></textarea>  
                    <input type="submit" name="saveDescription" class="btn btn-success btn-xs" value="Save Description">
                </form>
                
                <h4><b>Technical description (model_details)</b></h4>
                <form method="POST" action="#admin_models_anchor">
                    <input type="hidden" name="model_id" value="<?= $key ?>">
                    <textarea name="technical_description" rows="3" cols="30"><?= $arr_param['technical_description'] ?></textarea>  
                    <input type="submit" name="saveTechDescription" class="btn btn-success btn-xs" value="Save tech-description">
                </form>                

            </div>

        </div>


        <hr>

        
        <!--IMAGES AND DRAWS-->
        <div class="admin-models-personal row">
           
            <!--FULL-SIZE IMAGES-->
            <div class="col-md-6">
                    <h4><b>Full Images</b></h4>

                    <?php foreach ($arr_param['img_type_id'][1] as $model_image_id => $img_name) : ?>
                        <div class="admin-models-block col-md-3">
                            <h5><?= $img_name ?></h5>
                            <img src="<?= ADM_SITE_IMAGES ?>/models/<?= $arr_param['brand_name'] ?>/pic_fullsize/<?= $img_name ?>" width="100">                

                            <form method="POST" action="#admin_models_anchor">
                                <input type="hidden" name="model_id" value="<?= $key ?>">
                                <input type="hidden" name="model_image_id" value="<?= $model_image_id ?>">
                                <input type="hidden" name="thumbnail_img_type_id" value="4">
                                <input type="submit" name="delImg" class="delModel btn btn-danger" value="x">
                            </form>
                        </div>
                    <?php endforeach; ?>
                    <form method="POST" action="#admin_models_anchor" enctype="multipart/form-data">
                        <input type="hidden" name="img_type_id" value="1">     
                        <input type="hidden" name="img_type_name" value="pic_fullsize">                
                        <input type="hidden" name="model_id" value="<?= $key ?>">
                        <input type="hidden" name="brand_name" value="<?= $arr_param['brand_name'] ?>">
                        <input type="file" name="modelFullImg[]" value="" multiple="">  
                        <input type="submit" name="saveImgDrw" value="Save" class="btn btn-success btn-xs"> 
                    </form>
                </div><!--FULL-SIZE IMAGES-->


                    <!--DRAWINGS-->
                    <div class="admin-models-personal row">
                        <h4><b>Drawings</b></h4>
                        <?php foreach ($arr_param['img_type_id'][2] as $model_image_id => $drw_name) : ?>
                            <div class="admin-models-block col-md-3">
                                <h5><?= $drw_name ?></h5>
                                <img src="<?= ADM_SITE_IMAGES ?>/models/<?= $arr_param['brand_name'] ?>/draw_fullsize/<?= $drw_name ?>" width="100">                
                                <form method="POST" action="#admin_models_anchor">
                                    <input type="hidden" name="model_id" value="<?= $key ?>">
                                    <input type="hidden" name="model_image_id" value="<?= $model_image_id ?>">
                                    <input type="hidden" name="thumbnail_img_type_id" value="5">
                                    <input type="submit" name="delImg" class="delModel btn btn-danger" value="x">
                                </form>
                            </div>
                        <?php endforeach; ?>
                        <form method="POST" action="#admin_models_anchor" enctype="multipart/form-data">
                            <input type="hidden" name="img_type_id" value="2">     
                            <input type="hidden" name="img_type_name" value="draw_fullsize">                
                            <input type="hidden" name="model_id" value="<?= $key ?>">
                            <input type="hidden" name="brand_name" value="<?= $arr_param['brand_name'] ?>">
                            <input type="file" name="modelFullImg[]" value="" multiple="">  
                            <input type="submit" name="saveImgDrw" value="Save" class="btn btn-success btn-xs"> 
                        </form>

                    </div><!--DRAWINGS-->
                
            </div><!--IMAGES AND DRAWS-->
            
            
            

        <hr>
            
        <!--APPLICATION PHOTOS-->
<!--        <div class="admin-models-personal row">            
            
            <div class="col-md-6">
                    <h4><b>APPLICATION PHOTOS</b></h4>
                    <form method="POST" action="#admin_models_anchor" enctype="multipart/form-data">
                             
                                     
                        <input type="hidden" name="model_id" value="<?= $key ?>">                        
                        <input type="file" name="appPhotoImg" value="">  
                        <textarea name="appPhotoDescription" rows="4" cols="70"></textarea>
                        <input type="submit" name="addAppPhoto" value="Add Application" class="btn btn-primary "> 
                    </form><br>
                    
            </div>
            
            <?php // foreach ($arr_param['applications'] as $app_id => $application):?>
            <div class="col-md-12" style="border: 1px solid grey;">
                <img src="<?= ADM_SITE_IMAGES ?>/gallery/<?=$application['app_photo_url']?>" width="100px">  
                <textarea rows="4" cols="100"><?=$application['app_description']?></textarea>                 
                <form method="POST" action="#admin_models_anchor">                    
                    <input type="hidden" name="model_app_photo_id" value="<?= $app_id?>">
                    <input class="btn btn-danger btn-xs" type="submit" name="delApplication" value="x">

                </form>
            </div>
            <?php // endforeach; ?>
        </div>APPLICATION PHOTOS    
        
        -->
<!--        <hr>
        
        <div class="admin-models-personal row">            
             APPLICATION VIDEOS
            <div class="col-md-6">
                    <h4><b>APPLICATION VIDEOS</b></h4>
                    
                    
            </div>APPLICATION VIDEOS            
        </div>

        <hr>-->

        <!--SPECIFICATION AND INFORMATION-->

        <div class="admin-models-specification row">

            <div class="admin-models-block col-md-12">
                
                <div class="text-center"><h4><u><b>Specification<b></u></h4></div>
                <form method="POST" action="#admin_models_anchor">
                    <input type="hidden" name="model_id" value="<?= $key ?>">
                    <label>
                        Parameter <br>
                        <input type="text" name="parameter_name" required="">
                    </label><br>
                    <label>
                        Value <br>
                        <textarea name="parameter_value" required="" rows="3" cols="50"></textarea>                            
                    </label><br>
                    <input type="submit" name="addParameter" class="delModel btn btn-primary" value="Add Parameter">
                </form>
                        
                <hr>

                <?php foreach ($arr_param['params'] as $param => $arr_values): ?>   
                
                    <?php if ($arr_values['param_id'] !=''): ?>
                        <h4><?= $param ?>                                               
                            <form method="POST" action="#admin_models_anchor">
                                <input type="hidden" name="model_id" value="<?= $key ?>">
                                <input type="hidden" name="param_id" value="<?=$arr_values['param_id']?>">
                                <input class="btn btn-success" type="submit" name="addParamValue" value="+ value">
                            </form>
                        </h4>                    

                        <?php foreach ($arr_values as $param_value => $arr_props): ?>
                            <?php if ($param_value !== 'param_id'):?>
                            <?php 
                            $btn_visible = ($arr_props['param_visible'] == 1) ? 'btn-success' : 'btn-default' ;
                            $glyphicon_visible = ($arr_props['param_visible'] == 1) ? 'glyphicon-eye-open' : 'glyphicon-eye-close' ;
                            ?>
                            <p>
                                <form method="POST" action="#admin_models_anchor">
                                    <input type="hidden" name="model_id" value="<?= $key ?>">
                                    <input type="hidden" name="param_id" value="<?= $arr_values['param_id']?>">
                                    <input type="hidden" name="model_specific_id" value="<?=$arr_props['model_specific_id']?>">
                                    <input type="hidden" name="param_val_visibility" value="<?=$arr_props['param_visible']?>">
                                    <textarea class="param_value_text" name="param_value" cols="100" rows="2"><?= $param_value ?></textarea>
                                    <span class="param_val_visible btn <?=$btn_visible?> glyphicon <?=$glyphicon_visible?>"> </span> 
                                    <input class="btn btn-danger" type="submit" name="delParamValue" value="x">
                                </form>



                            </p>
                            <?php endif;?>
                        <?php endforeach; ?>
                    <?php endif; ?>        
                <?php endforeach; ?>
            </div>
        </div>

        <hr>
        <div class="admin-models-additional-info row">

            <div class="admin-models-block col-md-12" style="color:red;">
                <h4>Additional Information</h4><br>
                <input type="hidden" name="model_id" value="<?= $key ?>">
                <textarea class="change_information" name="model_add_info" rows="2" cols="120"><?= $arr_param['info_text'] ?></textarea>   
            </div>

        </div>



    </div><!--.container-->

<?php endforeach; ?>

<script>
    
        
    // SET|CHANGE INFORMATION     
    $('body').change(function(e){
       
       var target = $(e.target);
       
       if (target.hasClass('change_information')){
           var model_id = $(target).parent().children('input[name="model_id"]').val();
           
           $.ajax({
                url: 'functions/ajax.php',
                type: 'POST',
                data: {                    
                    'model_id': model_id,
                    change_model_info: target.val()
                    
                },
                success: function (response) {
                    
                }
            });
           
       }//if
       
    });//SET|CHANGE INFORMATION 
    
    
    
    
    
    
    
    
    // PARAM VALUE VISIBILITY || ONSALE-ONSTOCK
    $('body').click(function(e){
        
        var target = $(e.target);
        
        //VISIBILITY
        if (target.hasClass('param_val_visible')){
            
            if (target.hasClass('glyphicon-eye-open')){
                target.removeClass('glyphicon-eye-open').removeClass('btn-success');
                target.addClass('glyphicon-eye-close').addClass('btn-default');
            }
            else if(target.hasClass('glyphicon-eye-close')){
                target.removeClass('glyphicon-eye-close').removeClass('btn-default');
                target.addClass('glyphicon-eye-open').addClass('btn-success');
            }
            
            
            var model_specific_id = $(target).parent().children('input[name="model_specific_id"]').val();
            var param_val_visibility = $(target).parent().children('input[name="param_val_visibility"]').val();
            
            param_val_visibility = (param_val_visibility === '1') ? '0' : '1';
            
            $.ajax({
                url: 'functions/ajax.php',
                type: 'POST',
                data: {                    
                    'model_specific_id': model_specific_id,
                    param_val_visibility: param_val_visibility
                    
                },
                success: function (response) {
                    $(target).parent().children('input[name="param_val_visibility"]').val(param_val_visibility);
                }
            });                      
        }//if
        
        
     // ONSALE - ONSTOCK            
        if (target.hasClass('check_onsale') || target.hasClass('check_onstock')){
            var checkVal = '';             
            var check_name = '';
            var model_id = target.val();
            
            if (target.hasClass('check_onsale')){
                checkVal = (target.prop('checked')) ? '1' : '0';
                check_name = 'onsale';
            }
            
            if (target.hasClass('check_onstock')){
                checkVal = (target.prop('checked')) ? '1' : '0';
                check_name = 'onstock';
            }            
            
            $.ajax({
                url: 'functions/ajax.php',
                type: 'POST',
                data: {
                    'sale_stock':check_name,
                    'model_id':model_id,
                    'checkVal':checkVal                    
                },
                success: function (response) {

                }
            });
            
        }//if

        
        
    });// PARAM VALUE VISIBILITY

    
    
    
    
    
    
    //CHANGE PARAM VALUE
    $('body').change(function(e){
       
       var target = $(e.target);
             
       
       if (target.hasClass('param_value_text')){
           
           var model_specific_id = $(target).parent().children('input[name="model_specific_id"]').val();
           var param_id = $(target).parent().children('input[name="param_id"]').val();
           
            $.ajax({
                url: 'functions/ajax.php',
                type: 'POST',
                data: {
                    'param_id':param_id,
                    'model_specific_id':model_specific_id,
                    change_param_value: target.val()
                },
                success: function (response) {

                }
            });
       }//if
    });//CHANGE PARAM VALUE






    /* Ajax filling Brands*/
    $(document).ready(function () {

        $.ajax({
            url: 'functions/ajax.php',
            type: 'POST',
            data: {
                input: 'brands'
            },
            success: function (response) {
                $('#brands').append(response);
            }
        });

    });



    /* Ajax filling Series*/
    $('#brands').change(function () {

        $('#SelectAllModels').prop('checked', false);

        if ($(this).val() == 0) {
            $('#series').prop('disabled', true);
            $('#series').empty();
            $('#series').append('<option>-Select serie-</option>');
        } else {
            $('#series').prop('disabled', false);
            $('#series').empty();
            $('#series').append('<option value="0">-Select serie-</option>');
        }


        $.ajax({
            url: 'functions/ajax.php',
            type: 'POST',
            data: {
                input: 'series',
                brand_id: $(this).val()
            },
            success: function (response) {
//                alert(response);
                $('#series').append(response);
            }
        });

    });


</script>