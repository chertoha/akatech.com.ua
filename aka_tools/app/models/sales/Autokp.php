<?php

namespace app\models\sales;

use app\core\Model;
use mPDF;

class Autokp extends Model {

    public function getAutokpList($period) {
        $params = [
            'min_date' => (time() - ($period * 24 * 3600)), // days ago 
        ];
        $sql = 'SELECT '
                . 'autokp_id, '
                . 'CONCAT_WS(" ", user_name, user_lastname) user_name, '
                . 'autokp_date, '
                . 'autokp_customer, '
                . 'autokp_agent, '
                . 'autokp_currancy_rate, '
                . 'autokp_total_sum '
                . 'FROM autokp a LEFT JOIN auth_users au ON au.user_id=a.user_id '
                . 'WHERE autokp_date > :min_date';
        $arr = $this->db->row($sql, $params);
        return $arr;
    }

    public function getAutokpProducts($autokp_id) {
        $res = $this->db->row('SELECT * FROM autokp_products WHERE autokp_id =:autokp_id', ['autokp_id' => $autokp_id]);
        $html = '<table border="1" class="autokp_products_tab">';
        $html .= '<tr>'
                . '<th class="text-center">№</th>'
                . '<th class="text-center">Рис</th>'
                . '<th class="text-center">Артикул</th>'
                . '<th class="text-center">К-во</th>'
                . '<th class="text-center">Цена прайс</th>'
                . '<th class="text-center">Скидка</th>'
                . '<th class="text-center">Цена со скидкой</th>'
                . '<th class="text-center">Цена ручная</th>'
                . '<th class="text-center">Сумма</th>'
                . '<th class="text-center">Срок поставки</th>'
                . '</tr>';

        $count = 1;
        foreach ($res as $row) {
            $html .= '<tr>';
            $html .= '<td class="text-center">' . $count++ . '</td>';
            $html .= '<td class="text-center"><img style="height:30px;" src="' . $row['prod_img_path'] . '"></td>';
            $html .= '<td>' . $row['prod_article'] . '</td>';
            $html .= '<td class="text-center">' . $row['prod_qty'] . '</td>';
            $html .= '<td class="text-center">' . $row['prod_price_uah'] . '</td>';
            $html .= '<td class="text-center">' . $row['prod_discount'] . '%</td>';
            $html .= '<td class="text-center">' . $row['prod_price_discounted'] . '</td>';
            $html .= '<td class="text-center">' . $row['prod_handprice'] . '</td>';
            $html .= '<td class="text-center">' . $row['prod_price_sum'] . '</td>';
            $html .= '<td>' . $row['prod_delivery_time'] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        echo $html;
    }

    public function getBrands() {
        $html = '';
        $rows = $this->db_aka->row('SELECT * FROM brands');
        foreach ($rows as $row) {
            $html .= '<option value=' . $row['brand_id'] . '>' . $row['brand_name'] . '</option>';
        }
        return $html;
    }

    public function getBrandById($id) {
        return $this->db_aka->column('SELECT brand_descriptor FROM brands WHERE brand_id= :id', ['id' => $id]);
    }

    public function getSeries($brand_id) {
        $html = '';
        $rows = $this->db_aka->row('SELECT * FROM series WHERE brand_id= :brand_id', ['brand_id' => $brand_id]);
        foreach ($rows as $row) {
            $html .= '<option value=' . $row['serie_id'] . '>' . $row['serie_name'] . '</option>';
        }
        return $html;
    }

    public function getModels($serie_id) {
        $html = '';
        $rows = $this->db_aka->row('SELECT * FROM models WHERE serie_id= :serie_id', ['serie_id' => $serie_id]);
        foreach ($rows as $row) {
            $html .= '<option value=' . $row['model_id'] . '>' . $row['model_public_name'] . '</option>';
        }
        return $html;
    }

    public function getArticles($model_id) {
        return $this->db_aka->row('SELECT * FROM products WHERE prod_model_id= :model_id', ['model_id' => $model_id]);
    }

    public function getModelImagePreview($model_id) {
        $sql = 'SELECT model_image_path FROM models_images WHERE model_id= :model_id AND img_type_id =:img_type_id';
        $params = [
            'model_id' => $model_id,
            'img_type_id' => 3,
        ];
        return $this->db_aka->column($sql, $params);
    }

    public function searchArticles($search_str) {

        $sql = "SELECT * FROM products WHERE (prod_article LIKE :search_str OR prod_description LIKE :search_str)  LIMIT 100";
        $params = [
            'search_str' => '%' . $search_str . '%',
        ];
        return $this->db_aka->row($sql, $params);
    }

    public function setArticlesToKP($arr_id) {
        $arr = implode(',', $arr_id);
        $sql = 'SELECT p.prod_id, p.prod_article, m.model_id, p.prod_inox, '
                . 'mi.model_image_path, m.model_name, m.model_public_name, '
                . 's.serie_id, b.brand_id, b.brand_descriptor, sp.sales_price_value '
                . 'FROM products p LEFT JOIN models_images mi '
                . 'ON p.prod_model_id=mi.model_id '
                . 'LEFT JOIN models m '
                . 'ON m.model_id=p.prod_model_id '
                . 'LEFT JOIN series s '
                . 'ON s.serie_id=m.serie_id '
                . 'LEFT JOIN brands b '
                . 'ON b.brand_id=s.brand_id '
                . 'LEFT JOIN sales_prices sp '
                . 'ON p.prod_id= sp.prod_id '
                . 'WHERE p.prod_id IN (' . $arr . ') AND img_type_id= :img_type';
        $params = [
//            'arr' => $arr,
            'img_type' => 3,
        ];
        $kp_articles = $this->db_aka->row($sql, $params);
//        $_SESSION['test'] = $sql;

        if (isset($_SESSION['autokp'])) {
            foreach ($kp_articles as $article) {
                array_push($_SESSION['autokp'], $article);
            }
        } else {
            $_SESSION['autokp'] = $kp_articles;
        }

        $html = '';
        foreach ($kp_articles as $key => $kp_article) {
            $img_path = IMG_MODELS_AKA . $kp_article['brand_descriptor'] . '/pic_preview/' . $kp_article['model_image_path'];
            $html .= '<div class="row">';
            $html .= '<input type="hidden" name="autokp_article_id" value="' . $key . '">';
            $html .= '<img src="' . $img_path . '" class="autokp-kplist-pic">&nbsp;&nbsp; ';
            $html .= '<span class="autokp_art_kp">' . $kp_article['prod_article'] . '</span> &nbsp;&nbsp;';
            $html .= '<button class="btn btn-sm btn-danger autokp_del_article">x</button>';
            $html .= '</div>';
            $html .= '<hr class="autokp_separator">';
        }
        return $html;
    }

    public function delArticleFromKp($id) {

        foreach ($_SESSION['autokp'] as $key => $article) {
            if ($article['prod_id'] == $id) {
                unset($_SESSION['autokp'][$key]);
                break;
            }
        }
    }

    public function getArrAutokpFromSession() {
        $arr = [];

        if (isset($_SESSION['autokp'])) {
            foreach ($_SESSION['autokp'] as $item) {

                if (!isset($item['img_full_path'])) {
                    $item['img_full_path'] = IMG_MODELS_AKA . $item['brand_descriptor'] . '/pic_preview/' . $item['model_image_path'];
                }
                if (!isset($item['qty'])) {
                    $item['qty'] = '1';
                }
                if (!isset($item['discount'])) {
                    $item['discount'] = '0';
                }
                if (!isset($item['hand_price'])) {
                    $item['hand_price'] = '';
                }
                if (!isset($item['delivery_time'])) {
                    $item['delivery_time'] = '';
                }
                $arr['autokp'][] = $item;
            }
        } else {
            $arr['autokp'] = [];
        }

        if (isset($_SESSION['pricing_data'])) {
            $arr['pricing_data'] = $_SESSION['pricing_data'];
        } else {
            $arr['pricing_data'] = [
                'currency_rate' => 33.0,
                'common_discount_status' => 1,
            ];
        }
//            unset($_SESSION['test']);
        return $arr;
    }

    public function updateSession($post) {
        unset($_SESSION['autokp']);
        unset($_SESSION['pricing_data']);
        $_SESSION['autokp'] = $post['autokp'];
        $_SESSION['pricing_data'] = $post['pricing_data'];
    }

    public function build() {
        if (!isset($_SESSION['autokp'])) {
            return '[no session array: autokp]/ Проверьте, возможно не выбран товар';
        }
        if (!isset($_SESSION['pricing_data'])) {
            return '[no session array: pricing_data]/ Проверьте, возможно не выбран товар';
        }
        if (!isset($_SESSION['customer_data'])) {
            return '[no session array: customer_data]/ Проверьте, возможно не сохранены данные для клиента';
        }
        if (!isset($_SESSION['template'])) {
            return '[no session array: template]/ не определён шаблон КП';
        }

        $arr['autokp'] = $_SESSION['autokp'];
        $arr['pricing_data'] = $_SESSION['pricing_data'];
        $arr['customer_data'] = $_SESSION['customer_data'];

        if (isset($_SESSION['autokp_save_data'])) {
            unset($_SESSION['autokp_save_data']);
            $_SESSION['autokp_save_data'] = $this->getProductsData($arr);
        } else {
            $_SESSION['autokp_save_data'] = $this->getProductsData($arr);
        }

        //user visit card
        $visitcard = $this->db->column('SELECT user_data_value FROM users_data ud LEFT JOIN strings s 
                        ON s.strings_id=ud.string_id 
                        WHERE ud.user_id=:user_id  AND s.string_name=:string', [
            'string' => 'visitcard',
            'user_id' => $_SESSION['auth']['user_id'],
        ]);
        $_SESSION['auth']['visitcard'] = $visitcard;

        return 'Success';
    }

    public function saveData($post) {
        if (!isset($_SESSION['autokp_save_data'])) {
            return 'No data';
        }

        if ($post['autokp_build_save_data'] == 'pics' || $post['autokp_build_save_data'] == 'draws') {
            $article_id = $post['article_id'];
            $pic_id = $post['pic_id'];
            $pic_type = $post['autokp_build_save_data']; // pics or draws
            foreach ($_SESSION['autokp_save_data']['articles'][$article_id]["$pic_type"] as $key => $pic) {
                $_SESSION['autokp_save_data']['articles'][$article_id]["$pic_type"][$key]['on'] = ($key == $pic_id) ? true : false;
            }
        }

        if ($post['autokp_build_save_data'] == 'info') {
            $on = $_SESSION['autokp_save_data']['articles'][$post['article_id']][$post['info_name']]['on'];
            $_SESSION['autokp_save_data']['articles'][$post['article_id']][$post['info_name']]['on'] = !$on;
        }

        if ($post['autokp_build_save_data'] == 'properties') {
            $on = $_SESSION['autokp_save_data']['articles'][$post['article_id']]['properties'][$post['prop_name']]['on'];
            $_SESSION['autokp_save_data']['articles'][$post['article_id']]['properties'][$post['prop_name']]['on'] = !$on;
        }
    }

    public function savePdf($id) {
        $html = ':(';
//        $template_path = ROOT . PUBLIC_FOLDER . 'autokp/templates/default_template.php';
        $template_path = $_SESSION['template']['path'];
        if (file_exists($template_path)) {
            ob_start();
            require $template_path;
            $html = ob_get_clean();
        }

        $mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /* задаем формат, отступы и.т.д. */
        $mpdf->charset_in = 'utf-8'; /* не забываем про русский */

        $stylesheet = file_get_contents(ROOT . CSS_FOLDER . 'offerStyle.css'); /* подключаем css */
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html, 2); /* формируем pdf */

        //file name
        $fileName = '';
        $date = '';
        if (isset($_SESSION['autokp_save_data']['common_data'])) {
            $fileName = $_SESSION['autokp_save_data']['common_data']['customer'];
            $date = $_SESSION['autokp_save_data']['common_data']['date'];
        }
        if ($fileName == '') {
            $fileName = $_SESSION['autokp_save_data']['common_data']['agent'];
        }
        if ($fileName == '') {
            $fileName = 'КП';
        }
        if ($date == '') {
            $date = date("d.m.y");
        }

        if ($id != null || $id != '') {
            $id = '[' . $id . ']';
        } else {
            $id = '[-]';
        }

        $fullname = '' . $id . ' ' . $fileName . ' (' . $date . ').pdf'; //моя доработка
        $mpdf->Output(DOWNLOADS . $fullname, 'F');
        $mpdf->Output($fullname, 'D');
    }

    public function saveAutokpToDb() {
        $autokp_params = [
            'user_id' => $_SESSION['auth']['user_id'],
            'date' => strtotime($_SESSION['customer_data']['autokp_date']),
            'customer' => $_SESSION['customer_data']['autokp_customer_name'],
            'agent' => $_SESSION['customer_data']['autokp_customer_agent'],
            'comment' => $_SESSION['customer_data']['autokp_comment'],
            'template' => $_SESSION['template']['name'],
            'currency_rate' => $_SESSION['pricing_data']['currency_rate'],
            'discount_status' => $_SESSION['pricing_data']['common_discount_status'],
            'total_sum' => $_SESSION['pricing_data']['total_sum'],
            'build_json' => json_encode($_SESSION['autokp_save_data']), // to json
//            'filename' => $filename,            
        ];

        $sql = 'INSERT INTO autokp SET '
                . 'user_id =:user_id, '
                . 'autokp_date =:date, '
                . 'autokp_customer =:customer, '
                . 'autokp_agent =:agent, '
                . 'autokp_comment =:comment, '
                . 'autokp_template =:template, '
                . 'autokp_currancy_rate =:currency_rate, '
                . 'autokp_discount_status =:discount_status, '
                . 'autokp_total_sum =:total_sum, '
                . 'autokp_build_json =:build_json '
//                . 'autokp_filename = :filename '
        ;

        $this->db->query($sql, $autokp_params);

        $autokp_id = $this->db->lastInsertId();

        foreach ($_SESSION['autokp'] as $product) {
            $autokp_products_params = [
                'autokp_id' => $autokp_id,
                'prod_id' => $product['prod_id'],
                'prod_article' => $product['prod_article'],
                'img' => $product['img_full_path'],
                'qty' => $product['qty'],
                'price_uah' => $product['price_uah'],
                'discount' => $product['discount'],
                'price_discounted' => $product['price_discounted'],
                'handprice' => $product['hand_price'],
                'price_sum' => $product['price_sum'],
                'delivery_time' => $product['delivery_time'],
            ];
            $sql = 'INSERT INTO autokp_products SET '
                    . 'autokp_id =:autokp_id, '
                    . 'article_id =:prod_id, '
                    . 'prod_article =:prod_article, '
                    . 'prod_img_path =:img, '
                    . 'prod_qty =:qty, '
                    . 'prod_price_uah =:price_uah, '
                    . 'prod_discount =:discount, '
                    . 'prod_price_discounted =:price_discounted, '
                    . 'prod_handprice =:handprice,'
                    . 'prod_price_sum =:price_sum,'
                    . 'prod_delivery_time =:delivery_time ';
            $this->db->query($sql, $autokp_products_params);
        }
        return $autokp_id;
    }

    private function getProductsData($arr) {
        $data = [];

        $data['common_data']['total_sum'] = $arr['pricing_data']['total_sum'];
        $data['common_data']['date'] = date('d.m.Y', strtotime($arr['customer_data']['autokp_date']));
        $data['common_data']['customer'] = $arr['customer_data']['autokp_customer_name'];
        $data['common_data']['agent'] = $arr['customer_data']['autokp_customer_agent'];
        $data['common_data']['comment'] = $arr['customer_data']['autokp_comment'];

        // Array of articles
        foreach ($arr['autokp'] as $key => $item) {

            //model
            $data['articles'][$key]['model'] = $item['model_name'];

            //pictures
            $data['articles'][$key]['pics'] = $this->findImages($item['brand_descriptor'], $item['model_id'], '3,1'); // prod_image_types
            //drawings
            $data['articles'][$key]['draws'] = $this->findImages($item['brand_descriptor'], $item['model_id'], '2'); // prod_image_types
            //article
            $data['articles'][$key]['article'] = ['val' => $item['prod_article'], 'on' => true];

            //product name
            $data['articles'][$key]['name'] = $this->findArticleName($item['model_id']);

            //product description
            $data['articles'][$key]['description'] = $this->findArticleDescription($item['prod_id']);

            //product properties
            $data['articles'][$key]['properties'] = $this->findArticleProperties($item['prod_id']);

            //product quantities
            $data['articles'][$key]['qty'] = $item['qty'];

            //product price
            $data['articles'][$key]['price'] = ($item['hand_price'] == 0 || $item['hand_price'] == '') ? $item['price_discounted'] : $item['hand_price'];

            //product summary price
            $data['articles'][$key]['sum'] = $item['price_sum'];

            //product delivery time
            $data['articles'][$key]['delivery_time'] = ['val' => $item['delivery_time'], 'on' => true];
        }
        return $data;
    }

    private function findImages($brand, $model_id, $img_type) {
        $sql = "SELECT * FROM models_images mi "
                . "LEFT JOIN prod_image_types pit ON pit.img_type_id=mi.img_type_id "
                . "WHERE mi.model_id=:model_id AND mi.img_type_id IN ($img_type)";
        $res = $this->db_aka->row($sql, ['model_id' => $model_id]);
        $pics = [];
        foreach ($res as $key => $item) {
            $pics[$key]['val'] = IMG_MODELS_AKA . $brand . '/' . $item['img_type_name'] . '/' . $item['model_image_path'];
            $pics[$key]['on'] = ($key == 0);
        }
        return $pics;
    }

    private function findArticleName($model_id) {
        $res = $this->db_aka->column('SELECT model_description FROM models WHERE model_id=:model_id', ['model_id' => $model_id]);
        return ['val' => $res, 'on' => true];
    }

    private function findArticleDescription($prod_id) {
        $res = $this->db_aka->column('SELECT prod_description FROM products WHERE prod_id=:prod_id', ['prod_id' => $prod_id]);
        return ['val' => $res, 'on' => true];
    }

    private function findArticleProperties($prod_id) {
        $sql = "SELECT props.prop_name, pv.prop_value
                FROM models m LEFT JOIN products prod
                ON m.model_id=prod.prod_model_id LEFT JOIN prod_prop_values ppv
                ON prod.prod_id=ppv.prod_id LEFT JOIN model_properties mp
                ON ppv.model_prop_id=mp.model_prop_id LEFT JOIN properties_values pv
                ON ppv.prop_value_id=pv.prop_value_id 
                LEFT JOIN properties props ON props.prop_id=pv.prop_id
                WHERE prod.prod_id=:prod_id;";
        $res = $this->db_aka->row($sql, ['prod_id' => $prod_id]);
        $props = [];
        foreach ($res as $item) {
            $props[$item['prop_name']]['val'] = $item['prop_value'];
            $props[$item['prop_name']]['on'] = true;
        }
        return $props;
    }

    public function clearAutokp() {
        if (isset($_SESSION['autokp']) || $_SESSION['autokp'] == null) {
            unset($_SESSION['autokp']);
        }
        if (isset($_SESSION['pricing_data'])) {
            unset($_SESSION['pricing_data']);
        }
        if (isset($_SESSION['template'])) {
            unset($_SESSION['template']);
        }
        if (isset($_SESSION['customer_data'])) {
            unset($_SESSION['customer_data']);
        }
        if (isset($_SESSION['autokp_save_data'])) {
            unset($_SESSION['autokp_save_data']);
        }
    }

}

//Model
