<?php defined('AKA_TOOLS') or die("Access denied!"); ?>

<?php
//var_dump($arr_carriers);
//var_dump($arr_statuses);
//var_dump($arr_shipments);
//var_dump($_POST);
//var_dump($_SESSION);

?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 buttons">
            <form method="POST" action="">
                <input type="submit" class="btn btn-sm btn-success" name="add_shipment" value="Add shipment">
            </form>            
        </div>
        <div class="col-lg-8 buttons">
            <form method="POST" action="">
                <label for="period">Период</label>
                <input type="number" class="config-tracking-period" name="period" value="<?= $period ?>" size="10">
                <label> дней</label>
                <input type="submit" class="btn btn-sm btn-success" name="set_period" value="Ok">
                
            </form>
        </div>
        <div class="col-lg-1 buttons">
            <button id="delete_shipment" class="btn btn-sm btn-danger">Delete</button>
        </div>
    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center ">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Перевозки</div>
                <!--  <div class="panel-body">
                    <p>...</p>
                  </div>-->

                <!-- Table -->
                <table class="table">
                    <tr>

                        <th class="text-center">#</th>
                        <th class="text-center">Дата отправки</th>
                        <th class="text-center">Track номер</th>
                        <th class="text-center">Заявка</th>          
                        <th class="text-center">Статус</th>
                        <th class="text-center">Перевозчик</th>
                        <!--<th class="text-center">Ссылка</th>-->
                        <th class="text-center">Комментарий</th>
                        <th class="text-center">Операции</th>

                    </tr>

                    <?php foreach ($arr_shipments as $shipment):?>
                    <?php $received = ($shipment['shipment_status_id'] == SHIPMENT_RECEIVED_ID) ? 'received' : '' ;?>
                    <tr>
                        
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="shipment_id" value="<?= $shipment['shipment_id'] ?>">
                            
                            <td class="text-center">
                                <input class=" <?=$received?> config-tracking-shipment-num" type="text" name="shipment_descriptor" value="<?= $shipment['shipment_descriptor'] ?>" size="5%">                           
                            </td>
                            
                            <td class="text-center">
                                <input class="<?=$received?> config-tracking-date" type="date" name="shipment_start_date" value="<?= date("Y-m-d", $shipment['shipment_start_date'])  ?>"> 
                            </td>
                            
                            <td>
                                <input class="<?=$received?> config-tracking-num" type="text" name="shipment_track_num" value="<?= $shipment['shipment_track_num'] ?>" size="10%">
                            </td>
                            
                            <td>
                                <input class="<?=$received?> config-tracking-num" type="text" name="shipment_request_num" value="<?= $shipment['shipment_request_num'] ?>" size="5%">
                            </td>
                            
                            <td>
                                <select class="<?=$received?> config-tracking-status" name="shipment_status_id">
                                    <?php foreach ($arr_statuses as $status) :?>
                                    <?php $is_selected = ($status['status_id'] == $shipment['shipment_status_id']) ? 'selected' : '' ;?>
                                    <option <?= $is_selected ?> value="<?= $status['status_id'] ?>"><?= $status['status_name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            
                            <td>
                                <select class="<?=$received?> config-tracking-carrier" name="shipment_carrier_id">

                                    <?php foreach ($arr_carriers as $carrier) :?>
                                    <?php $is_selected = ($carrier['carrier_id'] == $shipment['shipment_carrier_id']) ? 'selected' : '' ;?>
                                    <option <?= $is_selected ?> value="<?= $carrier['carrier_id'] ?>" ><?= $carrier['carrier_name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <!-- 
                            <td>
                                <input class="" config-tracking-link" name="shipment_link" value="">
                            </td>
                            -->
                            <td>
                                <textarea class="<?=$received?> config-tracking-comment" name="shipment_comment"size="10%"><?=$shipment['shipment_comment']?></textarea>
                            </td>
                            
                            <td>
                                <button class="config-tracking-button btn btn-success btn-sm" type="submit" name="save">save</button>
                                <button class="config-tracking-button btn btn-danger btn-sm delbutton" data-toggle="toggle" type="submit" name="delete">del</button>
                            </td>
                            
                        </form>
                    </tr>
                    <?php endforeach;?>

                </table>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <a href="<?= HOME_DIRECTORY_URL ?>logistics/tracking">Просмотр</a>
    </div>
</div>


<div style="padding-bottom: 300px;"></div>




<script>

//DELETE
    $('#delete_shipment').click(function () {
        $('button.delbutton').toggle('fast');
    });
    


</script>