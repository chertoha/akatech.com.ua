

<p>test</p>


<form method="POST" action="" enctype="multipart/form-data">
    <label>
        File Excel: 
        <input type="file" name="test_xls_newcustomers">
    </label>
    <input type="submit" name="test_xls_newcustomers" value="Загрузить реализации " class="btn btn-success"> 

</form>


<?php foreach ($arr_months as $date => $month):?>
<h4><?=date('Y-m', $date)?></h4>
<p><b>Число новых клиентов = <?=count($month)?></b></p>
<table>
    <tr>
        <th>Клиент</th>
        <th>Сумма</th>
    </tr>
    
    <?php foreach ($month as $customer => $sum):?>
    <tr>
        <td><?=$customer ?></td>
        <td>&nbsp;&nbsp;</td>
        <td><?=$sum?></td>
    </tr>
    <?php endforeach;?>

</table>
<br>
<br>
<?php endforeach;?>

<?php

//var_dump($arr);
//var_dump($arr_2013);
//var_dump($arr_months);

