<?php
//var_dump($_SESSION['template']);
?>

<h4 class="text-muted">Autokp templates</h4>

<div class="container">

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-3 text-center"><b>Templates list</b></div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6 text-center"><b>Template preview</b></div>
        <div class="col-lg-1"></div>
    </div>

    <div class="row">        
        <div class="col-lg-1 text-center">
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/pricing" class="btn btn-primary btn-md active" role="button" aria-pressed="true"><< Цены</a> &nbsp; 
        </div>
        <div class="col-lg-3 autokp-templates-list"> 

            <?php foreach ($templates as $key => $template) : ?>
                <?php $checked = ($template['name'] == $_SESSION['template']['name']) ? 'checked' : ''; ?>
                <div class="custom-control custom-radio autokp_template">
                    <input type="hidden" name="img_path" value="<?= $template['img_preview_path'] ?>">
                    <input type="hidden" name="template_key" value="<?= $key ?>">
                    <input type="radio" class="custom-control-input" id="<?= $key ?>" name="defaultExampleRadios" <?= $checked ?>>
                    <label class="custom-control-label" for="<?= $key ?>"><?= $template['name'] ?></label>
                </div>
            <?php endforeach; ?>


        </div>
        <div class="col-lg-1">

        </div>

        <div class="col-lg-6 autokp-templates-preview" id="templates_preview"> 
            <img style="width: inherit;" src="<?= $_SESSION['template']['img_preview_path'] ?>">
        </div>

        <div class="col-lg-1 "> 
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/customer" class="btn btn-primary btn-md active" role="button" aria-pressed="true">Клиент >></a>

        </div> 
    </div>

</div>

<script>
    $('.autokp_template').click(function (event) {
        console.log(event.target);

        var target = event.target;
        var img_path = $(target).parent().children('input[name="img_path"]').val();
        var template_key = $(target).parent().children('input[name="template_key"]').val();
//    console.log(img_path);

        // change image preview
        $('#templates_preview').empty();
        $('#templates_preview').append('<img style="width: inherit;" src="' + img_path + '">');

        // ajax set new template
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                template_key: template_key
            },
            success: function (response) {
                
            }
        });

    });










</script>