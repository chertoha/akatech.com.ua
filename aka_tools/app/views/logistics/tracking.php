<?php

//var_dump($arr_shipments);
//var_dump($_SESSION);
//var_dump($_POST);

?>

<h3>Трекинг перевозок</h3>
<div class="container">
    <div class="row">
        <div class="col-lg-3 buttons">  </div>
        
        <div class="col-lg-8 buttons">
            <form method="POST" action="">
                <label for="period">Период</label>
                <input type="number" class="config-tracking-period" name="period" value="<?= $period ?>" size="10">
                <label >дней</label> &nbsp;
                <input type="submit" class="btn btn-sm btn-success" name="set_period" value="Ok">
                
            </form>
        </div>
        
        <div class="col-lg-1 buttons"> </div>
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
                        <th class="text-center">Комментарий</th>
                    </tr>
                   
                    <?php foreach ($arr_shipments as $shipment):?>
                    <?php $received = ($shipment['shipment_status_id'] == SHIPMENT_RECEIVED_ID) ? 'tracking_received' : '' ;?>
                    <tr class="<?= $received ?>">                        
                        <td><?= $shipment['shipment_descriptor'] ?></td>
                        <td><?= date("d.m.Y", $shipment['shipment_start_date']) ?></td>
                        <td><a href="<?= $shipment['carrier_track_link'].$shipment['shipment_track_num'] ?>" target="_blank"><?= $shipment['shipment_track_num'] ?></a></td>
                        <td><?= $shipment['shipment_request_num'] ?></td>
                        <td><?= $shipment['status_name'] ?></td>
                        <td><a href="<?= $shipment['carrier_web'] ?>" target="_blank"><?= $shipment['carrier_name'] ?></a></td>
                        <td><?= $shipment['shipment_comment'] ?></td>                       
                    </tr>
                    <?php endforeach;?>
                    
                    
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <a href="<?= HOME_DIRECTORY_URL ?>admin/tracking">Редактировать</a>
    </div>
</div>
