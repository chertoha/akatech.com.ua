<?php defined('ADMINER') or die('Access Denied'); ?>
<?php
//Список разделов для оглавления и их id
$arr_main_list = adminMainListOverview();



//Сохранение предыдущего выбора
$item_contents = 0;
if (isset($_SESSION['checked_item_contents'])){
    $item_contents = $_SESSION['checked_item_contents'];
}
if (isset($_POST['ovewrview_contents'])){
   $item_contents = $_POST['group_products'];
   $_SESSION['checked_item_contents'] = $item_contents;
}

//Построение выбранного раздела
$arr_overview = adminOverviewArray($item_contents); 


// Смещение фокуса на товар с которым работает администратор
$focus_element_id = 0;
if (isset($_POST['save']) || isset($_POST['moveup']) || isset($_POST['movedown'])){
    $focus_element_id = $_POST['tree_prod_id'];
}


//Получение массива типов вывода моделей (список, плитка и т.д.)
$arr_output_types = adminGetOutputTypes();


//var_dump($arr_overview);
//var_dump($_POST);
//var_dump($_FILES);
//echo '<br> '.ROOT.'views/akatech/images/overview/';
?>

<div class="row ">
    <div class="container">
        <label><span class="hide-list glyphicon glyphicon-chevron-down" aria-hidden="true"> СОДЕРЖАНИЕ</span></label>
               
        <form method="POST" action="" name="contents">
            <ul class="list-group overview-main-list" data-toggle="toggle">
<!--                <li class="list-group-item"><label><input type="radio" name="group_products" value="0"> OVERVIEW </label></li>                      -->
                <?php foreach ($arr_main_list as $props): ?>
                    <?php $checked = ($props['tree_prod_id'] === $item_contents) ? 'checked' : ''; ?>
                    <li class="list-group-item" >
                        <label>
                            <input <?=$checked?> type="radio" name="group_products" value="<?= $props['tree_prod_id'] ?>"> <?= strip_tags($props['tree_prod_name']) ?> 
                        </label>
                    </li>
                <?php endforeach; ?>
                    <input type="submit" name="ovewrview_contents" value="submit" class="btn btn-success">
            </ul>
            
        </form>
                  
        <hr>  
        
    </div>    
</div>

<div class="row overviews" >
    
    <input class="" type="hidden" name="parent_id" value="" >
    
    <div class="adm-overview col-lg-12">           
            <div class="container">
                <div class="row">
                    <div class="col-lg-11 buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="item_contents" value="<?=$item_contents?>">
                            <input type="submit" class="btn btn-success" name="add" value="Add">
                        </form>
                    </div>
                    <div class="col-lg-1 buttons">
                        <button id="delete_overview" class="btn btn-danger">delete</button>
                    </div>
                </div>
                
            </div>
            <br>
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Section Name</th>
                    <th class="text-center">Visibilty</th>
                    <th class="text-center">Order Number</th>
                    <th class="text-center">Image Name</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Delete</th>
                </tr>
                
                <?php foreach ($arr_overview as $prop):?>
                
                
                <tr>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <!--ID-->
                        <td class="text-center"><?= $prop['tree_prod_id'] ?></td>

                        <!--VIEW-->
                        <td class="text-center">
                            
                            <img src="<?= ADM_SITE_IMAGES ?>overview/<?= $prop['tree_prod_img'] ?>" width="50%">
                        </td>

                        <!--NAME-->
                        <td class="text-center">
                            <input type="text" name="tree_prod_name" value="<?= $prop['tree_prod_name'] ?>" size="40%">
                            
                            <?php if ($prop['tree_prod_parent_id'] != 0):?>
                                <label><br>
                                    Тип вывода моделей
                                    <select name="output_type_id">   
                                        <?php foreach ($arr_output_types as $output_type):?>
                                            <?php $selected_output_type = ($prop['output_type_id'] == $output_type['output_type_id']) ? 'selected' : '' ;?>
                                            <option <?=$selected_output_type?> value="<?=$output_type['output_type_id'] ?>"><?=$output_type['output_type_descriptor']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </label>
                            <?php endif;?>
                            
                        </td>

                        <!--VISIBILITY-->
                        <td class="text-center">                      
                            <input type="checkbox" name="tree_prod_visible" <?= ($prop['tree_prod_visible']) ? 'checked' : '' ?>>
                        </td>

                        <!--ORDER-->
                        <td class="text-center">                        
                            <button type="submit" name="moveup" class="btn btn-info btn-xs ">
                                <input type="hidden" name="tree_prod_id" value="<?= $prop['tree_prod_id'] ?>">
                                <span class="glyphicon glyphicon-triangle-top" ></span>
                            </button><br><br>  

                            <?= $prop['tree_prod_order'] ?><br><br> 
                            <input type="hidden" name="tree_prod_order" value="<?=$prop['tree_prod_order']?>">

                            <button type="submit" name="movedown" class="btn btn-info btn-xs ">
                                <input type="hidden" name="tree_prod_id" value="<?= $prop['tree_prod_id'] ?>">
                                <span class="glyphicon glyphicon-triangle-bottom" ></span>
                            </button>  

                        </td>

                        <!--IMAGE PATH-->
                        <td class="text-center">
                            <br>
                            <span><?= $prop['tree_prod_img'] ?></span><br> 
                            <input type="hidden" name="tree_prod_img" value="<?= $prop['tree_prod_img'] ?>">
                            <input type="file" name="pic" class="btn">
                        </td>

                        <!--DESCRIPTION-->
                        <?php $focused = ($focus_element_id == $prop['tree_prod_id']) ? 'class=focus' : '' ;?>
                        <td class="text-center">
                            <textarea <?=$focused?> name="tree_prod_description" rows="3" cols="30"><?= $prop['tree_prod_description'] ?> </textarea>
                        
                            <label> meta keywords <textarea name="meta_keywords" placeholder="keywords" cols="30" rows="2"><?=$prop['meta_keywords']?></textarea></label>
                            <label> meta description <textarea name="meta_description" placeholder="description" cols="30" rows="2"><?=$prop['meta_description']?></textarea></label>
                        
                        
                        </td>

                        <!--DELETE-->
                        <td class="text-center">
                            <button type="submit" name="save" class="btn btn-success">save</button><br><br>
                            <button type="submit" name="delete" data-toggle="toggle" class="delbutton btn btn-danger">x</button>
                            <!--<button type="submit" name="test" class="btn btn-info">TEST</button><br><br>-->
                            
                        </td>
                    </form>
                </tr>
                <?php endforeach;?>
                
            </table>
            
    </div><!--.adm-overview-->

</div><!--.row-->






<script>
    
//FOCUS ON SAVED
$('.focus').focus();



//HIDE CONTENTS
$('.hide-list').click(function(){   
   $('.overview-main-list').toggle('slow');   
});


//DELETE
$('#delete_overview').click(function(){
    $('button.delbutton').toggle('fast');
});


//ENABLE ROW
$('tr').find('input').prop('disabled',true);
$('tr').find('textarea').prop('disabled',true);
$('tr').find('button').prop('disabled',true);
$('tr').click(function(){
    $('tr').find('input').prop('disabled',true);
    $('tr button').prop('disabled',true);
    $(this).find('input').prop('disabled',false);
    $(this).find('textarea').prop('disabled',false);
    $(this).find('button').prop('disabled',false);
});


//HIDE OVERVIEWS
//$('.list-group-item').click(function(){
//   $('div.overviews').addClass('hide');
//   var value = $(this).find('input').val();   
//   $('div.overviews input[value='+value+']').parent().removeClass('hide');
//   
//   
//   
//});




</script>