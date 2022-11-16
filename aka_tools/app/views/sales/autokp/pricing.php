<?php
//var_dump($_SESSION);
?>




<h4 class="text-muted">Autokp-pricing</h4>

<div class="container">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-4">
            <label>
                Курс евро: 
                <input type="text" id="autokp_currency_rate" class="input-lg" name="autokp_currency_rate" value="">
            </label>
        </div>
        <div class="col-lg-5">
            <label>
                Итого: 
                <input type="text" id="autokp_total_sum" disabled class="input-lg" name="autokp_total_sum" value="">
                 грн
            </label>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-1">
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/search" class="btn btn-primary btn-md active" role="button" aria-pressed="true"><< Поиск</a> &nbsp; 
        </div>
        <div class="col-lg-10">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><b>Спецификация коммерческого предложения</b></div>
                <table class="table" id="autokp_table">
                    <tr>
                        <th class="text-center">№</th>
                        <th class="text-center">Рис</th>
                        <th class="text-center">Артикул</th>         
                        <th class="text-center">К-во</th>          
                        <th class="text-center">Прайс</th>
                        <th class="text-center">Скидка % <input type="checkbox" id="oneDiscountForAll" ></th>
                        <th class="text-center">Цена</th>
                        <th class="text-center">Ручная цена</th>
                        <th class="text-center">Сумма</th>
                        <th class="text-center">Срок поставки</th>
                        <th class="text-center">▲▼</th>

                    </tr>
                    
                    <!-- append rows from pricing.js-->


                </table>
            </div>




        </div>
        <div class="col-lg-1">
            <a href="<?= HOME_DIRECTORY_URL ?>sales/autokp/templates" class="btn btn-primary btn-md active" role="button" aria-pressed="true">Шаблоны >></a> &nbsp;
        </div>
    </div>

</div>

<script src="<?= SCRIPTS_FOLDER ?>pricing.js"></script>

