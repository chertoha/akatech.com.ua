<?php

namespace app\models\admin;

use app\core\Model;
use PHPExcel_Reader_Excel2007;
use PHPExcel;
use PHPExcel_IOFactory;

class Admtest extends Model {

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

    public function getCustomers2013($arr) {
        $arr_customers_2013 = [];
        $arr_temp = [];
        foreach ($arr as $realization) {
            if (strtotime($realization['date']) <= strtotime('2013-12-31')) {
//                $arr_customers_2013[$realization['contragent']]['charge'][] = $realization['charge'];
                $arr_temp[$realization['contragent']]['charge'][] = $realization['charge'];
            }
        }
        $arr_customers_2013 = array_keys($arr_temp);
        return $arr_customers_2013;
    }

    public function getNewCustomersPerMonthSince2014($arr_customers_2013, $arr) {
        $arr_months = [];
        $arr_customers_base = $arr_customers_2013;

        $date = strtotime('2014-01-01');
        $date_finish = strtotime($arr[count($arr) - 1]['date']);
        while ($date < $date_finish) {
            $arr_temp = [];
            foreach ($arr as $item) {
                if (strtotime($item['date']) > $date && strtotime($item['date']) < strtotime('+1 month', $date)) {
                    if (!in_array($item['contragent'], $arr_customers_base)) {
                        $arr_months["$date"][$item['contragent']] = round($this->totalSum($arr, $item['contragent']), 2);
                        $arr_temp[$item['contragent']] = $item['contragent'];
                    }
                }
            }
            $arr_customers_base = array_merge($arr_customers_base, array_keys($arr_temp));
            $date = strtotime('+1 month', $date);
        }
        return $arr_months;
    }

    public function totalSum($arr, $customer) {
        $sum = 0;
        foreach ($arr as $item) {
            if ($item['contragent'] == $customer) {
                $sum += $item['charge'];
            }
        }
        return $sum;
    }

    public function saveNewCustomerToExcel($arr) {
        $objPHPExcel = new PHPExcel();

        $count = 1;
        foreach ($arr as $date => $month) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $count++, date('Y-m', $date))
                    ->setCellValue('A' . $count++, 'Число новых клиентов = ' . count($month));
            
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $count, 'Клиент')
                        ->setCellValue('B' . $count, 'Сумма за всё время');
            $count++;
            foreach ($month as $customer => $sum) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $count, $customer)
                        ->setCellValue('B' . $count, $sum);
                $count++;
            }
            $count++;

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save(DOWNLOADS.'New_customers.xlsx');
        }
    }
}