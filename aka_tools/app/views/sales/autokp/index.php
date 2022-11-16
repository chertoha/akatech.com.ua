<?php
//var_dump($_POST);
//var_dump($_SESSION);
//var_dump($autokp_list);

echo "<h3>КП</h3>";
?>


<div class="container">
    <div class="row">
        <div class="col-lg-2 buttons"> 

        </div>

        <div class="col-lg-6 buttons">
            <form method="POST" action="">
                <label for="period">Период</label>
                <input type="number" class="config-tracking-period" name="period" value="<?= $period ?>" size="10">
                <label >дней</label> &nbsp;
                <input type="submit" class="btn btn-sm btn-success" name="set_period" value="Ok">

            </form>
        </div>
        <div class="col-lg-2 buttons"> 
            <form method="POST" action="">
                <input type="submit" name="autokp_clear" class="btn btn-md btn-danger" id="autokp_clear" value="Очистить КП">
            </form>
        </div>
        <div class="col-lg-2 buttons"> 

            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/search" class="btn btn-primary btn-md active" role="button" aria-pressed="true">Редактировать КП >></a> &nbsp;
        </div>
    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center ">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Коммерческие предложения</div>
                <table class="table">
                    <tr>

                        <th class="text-center">#</th>
                        <th class="text-center">Дата</th>
                        <th class="text-center">Ответственный</th>
                        <th class="text-center">Клиент</th>          
                        <th class="text-center">Сумма</th>
                        <th class="text-center">Курс</th>
                        <th class="text-center">Операции</th>

                    </tr>

                    <?php foreach ($autokp_list as $key => $item) : ?>
                        <tr>
                            <td><?= $item['autokp_id'] ?></td>
                            <td><?= date('d.m.Y', $item['autokp_date']) ?></td>
                            <td><?= $item['user_name'] ?></td>
                            <td><?= $item['autokp_customer'] . ' [' . $item['autokp_agent'] . ']' ?></td>
                            <td><?= $item['autokp_total_sum'] . ' грн' ?></td>
                            <td><?= $item['autokp_currancy_rate'] ?></td>
                            <td class="text-left">
                                <button type="button" class="btn btn-default btn-md specification">
                                    <input type="hidden" name="autokp_id" value="<?= $item['autokp_id'] ?>">
                                    <span class="glyphicon glyphicon-zoom-in specification" aria-hidden="true"></span>
                                </button>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    </div>
</div>


<div id="specification_box" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Спецификация</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                <!--Содержимое модального окна...-->
            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ок</button>
                <!--<button type="button" class="btn btn-primary">Сохранить изменения</button>-->
            </div>
        </div>
    </div>
</div>

<!--<p>На этой странице (управление созданными КП):</p>
<p>- выбор существующих КП для редактирования и просмотра</p>
<p>- кнопка создания нового КП</p>
<p>- (возможно) отправка КП по эл. почте</p>-->



<script>


    $('.specification').click(function (event) {
        var target = event.target;

        var id;
        console.log(target);
        console.log(target.tagName);

        if (target.tagName == 'SPAN') {
            id = $(target).parent().children('input[name="autokp_id"]').val();
        } else if (target.tagName == 'BUTTON') {
            id = $(target).children('input[name="autokp_id"]').val();
        }
        console.log(id);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                autokp_id: id
            },
            success: function (response) {
                $('.modal-body').empty();
                $('.modal-body').append(response);
                $("#specification_box").modal('show');
            }
        });





    });






</script>