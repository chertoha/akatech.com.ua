<?php
//var_dump($_SESSION['autokp_save_data']);
//var_dump($_SESSION['auth']);
$data = $_SESSION['autokp_save_data'];
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
            <h3>ТЕХНИКО-КОММЕРЧЕСКОЕ ПРЕДЛОЖЕНИЕ</h3>
        </div>
    </div> 
    <div id="prod_pdf">
        <hr>
        <?php
        $index = 0;
        while ($index < count($data['articles'])) {

            $div_products_html = '<div class="products">';
            $div_products_html .= getPicHtml($data['articles'][$index]);
            $div_products_html .= getDrwHtml($data['articles'][$index]);
            $div_products_html .= '<table class="dim_table" border="1" >';
            $div_products_html .= getThHtml(getTab($data['articles'][$index]));

            $count_repeat = countRepeated($data['articles'], $index);
            if ($count_repeat > 1) {
                for ($i = $index; $i < ($index + $count_repeat); $i++) {
                    $div_products_html .= getTdHtml(getTab($data['articles'][$i]));
                }
                $index += $count_repeat;
            } else {                
                $div_products_html .= getTdHtml(getTab($data['articles'][$index]));
                $index++;
            }
            $div_products_html .= '</table>';
            $div_products_html .= '</div>'; //.products
            $div_products_html .= '<hr>';
            echo $div_products_html;
        }//while

        function getPicHtml($article) {
            $pic_path = '';
            foreach ($article['pics'] as $pic) {
                if ($pic['on']) {
                    $pic_path = $pic['val'];
                    break;
                }
            }
            return '<div class="pic"><img style="height: 250px;" src="' . $pic_path . '"></div>';
        }

        function getDrwHtml($article) {
            $drw_path = '';
            foreach ($article['draws'] as $drw) {
                if ($drw['on']) {
                    $drw_path = $drw['val'];
                    break;
                }
            }
            return '<div class="draw"><img style="height: 250px;" src="' . $drw_path . '"></div>';
        }

        function getTab($article) {
            $tab = [];
            if ($article['article']['on']) {
                $tab['Артикул'] = $article['article']['val'];
            }
            if ($article['name']['on']) {
                $tab['Описание'] = $article['name']['val'] . ' ';
            }
            if ($article['description']['on']) {
                $tab['Описание'] = '' . $article['description']['val'];
            }
            foreach ($article['properties'] as $prop => $val) {
                if ($val['on']) {
                    $tab[$prop] = $val['val'];
                }
            }
            $tab['К-во'] = $article['qty'];
            $tab['Цена, грн с НДС'] = $article['price'];
            $tab['Сумма, грн с НДС'] = $article['sum'];
            if ($article['delivery_time']['on']) {
                $tab['Срок поставки'] = $article['delivery_time']['val'] . ' ';
            }
            return $tab;
        }

        function getThHtml($tab) {
            $th = '';
            foreach ($tab as $key => $value) {
                $th .= "<th>$key</th>";
            }
            return '<tr>' . $th . '<tr>';
        }

        function getTdHtml($tab) {
            $td = '';
            foreach ($tab as $key => $value) {
                $td .= "<td>$value</td>";
            }
            return '<tr>' . $td . '<tr>';
        }

        function countRepeated($arr, $index) {
            $count_repeat = 1;
            for ($i = $index + 1; $i < count($arr); $i++) {
                if ($arr[$i]['model'] == $arr[$index]['model']) {
                    $count_repeat++;
                } else {
                    break;
                }
            }
            return $count_repeat;
        }
        
        
        ?>



        <div class="total_sum">
            <h3> <b>Итого: <?=$data['common_data']['total_sum']?> грн с НДС</b></h3>
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






