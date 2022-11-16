<?php
//var_dump($_POST);
//var_dump($_SESSION);
?>


<h4 class="text-muted">Autokp-customer</h4>

<div class="container">

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10 text-center"><h4>Form data</h4></div>        
        <div class="col-lg-1"></div>
    </div>

    <div class="row">        
        <div class="col-lg-2 text-center">
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/templates" class="btn btn-primary btn-md active" role="button" aria-pressed="true"><< Шаблоны</a> &nbsp; 
        </div>
        <div class="col-lg-8 "> 
            <form method="POST" action="">
                <?php
                $customer_data = [];
                if (isset($_SESSION['customer_data'])) {
                    $customer_data = $_SESSION['customer_data'];
                } else {
                    $customer_data = [
                        'autokp_date' => date('Y-m-d', time()),
                        'autokp_customer_name' => '',
                        'autokp_customer_agent' => '',
                        'autokp_comment' => '',
                    ];
                }
                ?>
                <div class="form-group">
                    <label for="autokp_date">Дата КП</label>
                    <input value="<?=$customer_data['autokp_date']?>" type="date" class="form-control autokp_date" name="autokp_date" aria-describedby="basic-addon1" >
                </div>
                <div class="form-group">
                    <label for="autokp_customer_name">Клиент</label>
                    <input value="<?=$customer_data['autokp_customer_name']?>" type="text" class="form-control" name="autokp_customer_name" placeholder="Название предприятия" aria-describedby="basic-addon1">
                </div>
                <div class="form-group">    
                    <label for="autokp_customer_agent">Кому</label>
                    <input value="<?=$customer_data['autokp_customer_agent']?>" type="text" class="form-control" name="autokp_customer_agent" placeholder="ФИО получателя" aria-describedby="basic-addon1">
                </div>
                <div class="form-group">    
                    <label for="autokp_comment">Комментарий</label>
                    <textarea class="form-control" placeholder="Комментарий" name="autokp_comment"><?=$customer_data['autokp_comment']?></textarea>
                </div>
                <div class="form-group">    
                    <button class="btn btn-success" name="autokp_customer_data" type="submit">Сохранить</button>
                </div>

            </form>
        </div>

        <div class="col-lg-2 "> 
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/build" class="btn btn-primary btn-md active" role="button" aria-pressed="true">Построение КП >></a>

        </div> 
    </div>

</div>
