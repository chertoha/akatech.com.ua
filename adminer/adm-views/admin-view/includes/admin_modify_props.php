<?php defined('ADMINER') or die('Access Denied'); ?>
<?php

$arr_empty_props = ModelModifyProperties();

//var_dump($arr_empty_props);
//var_dump($_POST);
//print_r($_POST);
?>

<h4>Поиск пустых параметров моделей</h4>
<form method="post" action="">
    
    <input type="submit" name="search_empty_model_properties" value="Искать">    
    
</form>

<div class="search_empty_properties">
    <?php if (empty($arr_empty_props)) :?>    
        <?php echo '<h4 style="color:red;">Нет пустых параметров. Всё хорошо!</h4>';?>
    <?php else:?>
        <h4>Эти параметры указанных моделей не имеют привязки к товару. Их можно удалить</h4>
        <form method="post" action="">
                <input type="submit" name="delete_empty_props" value="Удалить все указанные параметры">  
                <?php foreach ($arr_empty_props as $model_id => $model_info): ?>
                    <table border="1" collapsed>
                        <tr>
                            <td><?= $model_info['model_name'] ?></td>
                            <?php foreach ($model_info['properties'] as $model_prop_id => $arr_props): ?>


                                <input type="hidden" name="model_prop_id[]" value="<?=$model_prop_id?>">
                                <td><?= $arr_props['prop_name'] ?></td>


                            <?php endforeach; ?>
                        </tr>
                    </table>
                    <br>    
                <?php endforeach; ?>
            
        </form>
    <?php endif;?>
</div>