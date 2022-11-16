<?php
//var_dump($_SESSION['autokp_save_data']);
$data = $_SESSION['autokp_save_data'];
//var_dump($_SESSION);
?>


<div id=inner_pdf>  
    <div id=header_pdf>
        <div class="logo" style="background-image: url(<?= PUBLIC_FOLDER ?>/autokp/templates/logo.png);"></div> 
        <div class="adress_head">03027, с.Новосёлки,Киево-Святошинский р-н, ул. Садовая 26, тел.: (067)463 35 23, info@akatech.com.ua, <a href="http://www.akatech.com.ua">www.akatech.com.ua</a></div>
        <hr>
    </div> 

    <div id=greeting_pdf>
        <div>
            <div class="date">
                <p><?= $data['common_data']['date'] ?></p>
            </div> 
            <div class="contact">
                <p><?= $data['common_data']['customer'] ?></p>
                <p><?= $data['common_data']['agent'] ?></p>
            </div>
        </div>
        <div class="commercial">
            <h3>КОММЕРЧЕСКОЕ ПРЕДЛОЖЕНИЕ</h3>
        </div>
    </div> 
    <div id="prod_pdf">
        <hr>
        <?php
        $div_products_html = '<div class="products_simple">';
        $div_products_html .= '<table class="dim_table" border="1" >';
        $div_products_html .= '<tr>';
        $div_products_html .= '<th>№</th>';
        $div_products_html .= '<th>Рис</th>';
        $div_products_html .= '<th>Артикул</th>';
        $div_products_html .= '<th>Описание</th>';
        $div_products_html .= '<th>К-во</th>';
        $div_products_html .= '<th>Цена, грн с НДС</th>';
        $div_products_html .= '<th>Сумма, грн с НДС</th>';
        $div_products_html .= '<th>Срок поставки</th>';
        $div_products_html .= '</tr>';


        foreach ($data['articles'] as $key => $article) {
            $div_products_html .= '<tr>';
            $div_products_html .= '<td>' . ($key + 1) . '</td>';
            $div_products_html .= '<td>' . getPicHtml($article) . '</td>';
            $div_products_html .= '<td>' . $article['article']['val'] . '</td>';
            $div_products_html .= '<td>' . $article['name']['val'] . ' ' . $article['description']['val'] . '</td>';
            $div_products_html .= '<td>' . $article['qty'] . '</td>';
            $div_products_html .= '<td>' . $article['price'] . '</td>';
            $div_products_html .= '<td>' . $article['sum'] . '</td>';
            $div_products_html .= '<td>' . $article['delivery_time']['val'] . '</td>';
            $div_products_html .= '</tr>';
        }

        $div_products_html .= '</table>';
        $div_products_html .= '</div>'; //.products
//        $div_products_html .= '<hr>';
        echo $div_products_html;

        function getPicHtml($article) {
            $pic_path = '';
            foreach ($article['pics'] as $pic) {
                if ($pic['on']) {
                    $pic_path = $pic['val'];
                    break;
                }
            }
            return '<img style="height: 50px;" src="' . $pic_path . '">';
        }
        ?>
        
        <div class="total_sum">
            <h2> Итого: <?= number_format($data['common_data']['total_sum'], 2, ',', ' ') ?> грн с НДС</h2>
        </div>


    </div> 
    <div id="comment">
<?= $data['common_data']['comment'] ?>

    </div> 

    <div id="visitcard">
        <?php
        if ($_SESSION['auth']['user_avatar_image'] != '') {
            echo '<img style="height: 100px" src="' . IMAGES_FOLDER . 'avatars/' . $_SESSION['auth']['user_avatar_image'] . '">';
            echo $_SESSION['auth']['visitcard'];
        }
        ?>
    </div>
    <div id="footer_pdf">
        <div class="distance"></div>
        <div class="adress">
            03027, с.Новосёлки, Киево-Святошинский р-н, ул. Садовая 26, тел: (067)463 35 23, info@akatech.com.ua, <a href="http://www.akatech.com.ua">www.akatech.com.ua</a>
        </div>

    </div> 
</div> 






