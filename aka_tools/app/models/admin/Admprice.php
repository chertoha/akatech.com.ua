<?php

namespace app\models\admin;

use app\core\Model;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Reader_Excel2007;

/**
 * Description of Admprice
 *
 * @author Anton
 */
class Admprice extends Model {

    public function getBrands() {
        $html = '';
        $rows = $this->db_aka->row('SELECT * FROM brands');
        foreach ($rows as $row) {
            $html .= '<option value=' . $row['brand_id'] . '>' . $row['brand_name'] . '</option>';
        }
        return $html;
    }

    public function exportArticlesToExcel($brand_id) {
        $brand_name = $this->db_aka->column(
                'SELECT brand_descriptor FROM brands WHERE brand_id =:id',
                ['id' => $brand_id]);
        
        $params = [
            'id' => $brand_id,
        ];
        $sql = 'SELECT p.prod_id, p.prod_article, p.prod_description '
                . 'FROM products p LEFT JOIN models m '
                . 'ON p.prod_model_id=m.model_id LEFT JOIN series s '
                . 'ON m.serie_id=s.serie_id '
                . 'WHERE s.brand_id=:id';
        $arr = $this->db_aka->row($sql, $params);

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'id')
                ->setCellValue('B1', 'article')
                ->setCellValue('C1', 'descr');

        $count = 2;
        foreach ($arr as $article) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $count, $article['prod_id'])
                    ->setCellValue('B' . $count, $article['prod_article'])
                    ->setCellValue('C' . $count, $article['prod_description']);
            $count++;
        }        

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//        $objWriter->save(ROOT . PUBLIC_FOLDER . 'downloads/'.$brand_name.'.xlsx');
        $objWriter->save(DOWNLOADS.$brand_name.'.xlsx');

        return $arr;
    }

    public function getArrayFromExcel($file_path) {
        $objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($file_path);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        $arr = [];

        for ($i = 2; $i <= count($sheetData); $i++) {
            foreach ($sheetData[$i] as $key => $value) {
                if ($value !== null) {
                    if (is_float($value)) {
                        $value = (string) $value;
                    }
                    $new_key = $sheetData[1][$key];
                    $arr[$i - 1]["$new_key"] = $value;
                }
            }//foreach
        }//for $i
        return $arr;
    }

    public function setPrices($arr) {

        foreach ($arr as $article) {
            $prod_id = $article['id'];
            $price = (float) $article['price'];
            $currency_id = $article['currency_id'];

            $res = $this->db_aka->row(
                    'SELECT * FROM sales_prices WHERE prod_id =:prod_id', ['prod_id' => $prod_id]);

            if (count($res) != 0) {
                $params = [
                    'prod_id' => $prod_id,
                    'price' => $price,
                    'currency_id' => $currency_id,
                ];
                $sql = 'UPDATE sales_prices SET '
                        . 'sales_price_value=:price, '
                        . 'currency_id=:currency_id '
                        . 'WHERE prod_id=:prod_id';
                $this->db_aka->query($sql, $params);
            } else {
                $params = [
                    'prod_id' => $prod_id,
                    'price' => $price,
                    'currency_id' => $currency_id,
                ];
                $sql = 'INSERT INTO sales_prices SET '
                        . 'prod_id=:prod_id, '
                        . 'sales_price_value=:price, '
                        . 'currency_id=:currency_id';
                $this->db_aka->query($sql, $params);
            }
        }
    }

}
