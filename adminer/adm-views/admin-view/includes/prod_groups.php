<?php defined('ADMINER') or die('Access Denied'); ?>
<?php
//$arr_models = getModelsArray();

//var_dump($_POST);

ProdGroups();
?>


<div class="row ">
    <form method="POST" action="" name="form_category">


        <div class="container">
            <label>
                Category
                <select class="form-control" id="selectCat" name="selectCat" required >
                    <option value="">-Select Category-</option>
                </select>
            </label>
            <label>
                Sub Category
                <select class="form-control" id="selectSubCat" name="selectSubCat" disabled required >
                    <option>-Select Sub-category-</option>
                </select>
            </label>

        </div>

        <div class="container " id="prodGroups">

        </div>
        
        <div class="container">
            <br>
            <input type="submit" name="delAllModels" class="btn btn-danger " value="Delete All">
        </div>


    </form>

    <hr>

    <form method="POST" action="" name="form_models">
        
        <input type="hidden" value="" name="tree_prod_id" id="subCatValue">
        
        <div class="container">
            <label>
                Brand
                <select class="form-control" id="brands" name="brand_id" required >
                    <option value="">-Select Brand-</option>
                </select>
            </label>
            <label>
                Series
                <select class="form-control" id="series" name="serie_id" required  >
                    <option value="">-Select serie-</option>
                </select>
            </label>
            <label>
                &nbsp;
                <input  id="SelectAllModels" type="checkbox">Select All
            </label>

            <div class="container" id="models">

            </div>

        </div>



        <div class="container">
            <input id="addButton" type="submit" name="add" class="btn btn-success " value="Add" disabled="">
        </div>

    </form>
</div>



<script>
    
    /*Ajax Перемещение/Удаление моделей в prod_groups*/
    $('body').click(function(event){
        var target = $(event.target);
        
        //move left & move right
        if (target.hasClass('moveOrder')){
            var prod_groups_id = target.parent().children('input[name="prod_groups_id"]').val(); 
            var prod_groups_order = target.parent().children('input[name="prod_groups_order"]').val();
            var tree_prod_id = target.parent().children('input[name="tree_prod_id"]').val();
            var orderDirection = '';
            
            if (target.hasClass('leftOrder')){
                orderDirection = 'leftOrder';
            }
            else if(target.hasClass('rightOrder')){
                orderDirection = 'rightOrder';
            }
            
            $.ajax({
                url: 'functions/ajax.php',
                type: 'POST',
                data: {
                    'move': orderDirection,
                    'tree_prod_id': tree_prod_id,
                    'prod_groups_id': prod_groups_id,
                    'prod_groups_order':prod_groups_order
                    
                },
                success: function (response) {                    
                    AjaxRequestProdGroups(tree_prod_id);
                }//success
            });//ajax
        
        }//if
        
        
        //Del model
        if (target.hasClass('delModel')){
            var prod_groups_id = target.parent().children('input[name="prod_groups_id"]').val(); 
            var tree_prod_id = target.parent().children('input[name="tree_prod_id"]').val();
            $.ajax({
                url: 'functions/ajax.php',
                type: 'POST',
                data: {
                    'delModel': 'delModel',
                    'prod_groups_id': prod_groups_id                    
                },
                success: function (response) {                    
                    AjaxRequestProdGroups(tree_prod_id);
                }//success
            });//ajax
        }//if
        
        
        //Visibility of models
        if (target.hasClass('visibleModel')){
            var prod_groups_id = target.parent().children('input[name="prod_groups_id"]').val(); 
            var tree_prod_id = target.parent().children('input[name="tree_prod_id"]').val();
            var prod_groups_visible = target.parent().children('input[name="prod_groups_visible"]').val();
            
            prod_groups_visible = (prod_groups_visible === '1') ? '0' : '1';
            
            $.ajax({
                url: 'functions/ajax.php',
                type: 'POST',
                data: {
                    'visibility': prod_groups_visible,
                    'prod_groups_id': prod_groups_id                    
                },
                success: function (response) {                    
                    AjaxRequestProdGroups(tree_prod_id);
                }//success
            });//ajax
           
        }//if
        
        
    });//click
    
    
    
    
    
    
      /*SelectAll checkboxes of models*/
    $('#SelectAllModels').change(function(){
        
        if ($(this).prop("checked")){
            $('#models input[type="checkbox"]').prop('checked', true);
            
        }
        else {
            $('#models input[type="checkbox"]').prop('checked', false);
        }
        
    });





    /* Ajax filling Category*/
    $(document).ready(function () {

        $.ajax({
            url: 'functions/ajax.php',
            type: 'POST',
            data: {
                input: 'cat'
            },
            success: function (response) {
                $('#selectCat').append(response);
            }
        });

    });


    /* Ajax filling Sub Category*/
    $('#selectCat').change(function () {
        
        

        if ($(this).val() == 0) {
            $('#selectSubCat').prop('disabled', true);
            $('#selectSubCat').empty();
            $('#selectSubCat').append('<option>-Select Sub-category-</option>');
        } else {
            $('#selectSubCat').prop('disabled', false);
            $('#selectSubCat').empty();
            $('#selectSubCat').append('<option value="0">-Select Sub-category-</option>');
        }


        $.ajax({
            url: 'functions/ajax.php',
            type: 'POST',
            data: {
                input: 'subCat',
                cat_id: $(this).val()
            },
            success: function (response) {
                $('#selectSubCat').append(response);
                $('#addButton').prop('disabled', false);
            }
        });

    });


    /* Ajax filling Product Groups*/
    $('#selectSubCat').change(function(){
        $('#subCatValue').val($(this).val());        
        AjaxRequestProdGroups($(this).val());
        
    });//PROD GROUPS
    
    function AjaxRequestProdGroups(id){
        $('#prodGroups').empty();
        
        $.ajax({
            url: 'functions/ajax.php',
            type: 'POST',
            data: {
                input: 'prodGroups',
                subCatId: id
            },
            success: function (response) {
                $('#prodGroups').append(response);
            }
        });
    }//AjaxRequestProdGroups()
    
    


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



    /* Ajax filling Models*/
    $('#series').change(function () {
        $('#SelectAllModels').prop('checked', false);
        $('#models').empty();

        $.ajax({
            url: 'functions/ajax.php',
            type: 'POST',
            data: {
                input: 'models',
                serie_id: $(this).val()
            },
            success: function (response) {
//                alert(response);
                $('#models').append(response);
            }
        });

    });


</script>