<?php
echo 'price';
?>


<form method="POST" action="">
    <select name="export_brand_id" id="export_brands" ></select>
    <input type="submit" value="Экспорт" name="export_brand_toexcel">
</form>

<div class="container">

    <form method="post" action="" enctype="multipart/form-data">
        <label>
            File Excel: 
            <input type="file" name="import_excel_file">
        </label>
        <input type="submit" name="import_excel" value="Add Excel" class="btn btn-success"> 

    </form>


</div>

<table class="" border="1">
<?php foreach ($arr_articles as $article) : ?>
        <tr>
            <td><?= $article['prod_id'] ?></td>
            <td><?= $article['prod_article'] ?></td>
            <td><?= $article['prod_description'] ?></td>
        </tr>
<?php endforeach; ?>
</table>

<p>END</p>


<script>

    /* Ajax filling Brands*/
    $(document).ready(function () {
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                export_brands: 'brands'
            },
            success: function (response) {
                $('#export_brands').append(response);
            }
        });
    });





</script>