<?php
defined ('ADMINER') or die('Access Denied');


class AddExcelToDB{
    public $errors = [];
    public $success = [];
    public $arr_excel = []; 
    public $arr_required_properties = [
            'brand_id',
            'serie',
            'model',
            'article'            
        ];
    public $arr_minus_words = [
            'serie',
            'brand_id',
            'model',
            'article',
            'description',
            'title',
            'path_pic',
            'path_draw',
            'pic_fullsize',
            'draw_fullsize',
            'pic_preview',
            'pdf',
            'inox',
            'price',
            'standart_sale_coef',
            'retail_coef',
            'id',
            'name',
            'pdf',
            'description_model',
            'description_model_details',
            'model_public_name'
            
    ];
    
    public function __construct($file_path) {
        $this->CreateArrayFromExcel($file_path);
        if (empty($this->arr_excel)){
            $this->errors['existing_array'][] = 'НЕ удалось создать массив товаров. Возможно файл пуст или имеет неверный тип';
        }
               
        $this->CheckArray();
        
        if (empty($this->errors['check_array']) || !isset($this->errors['check_array'])){
            $this->AddToDB($this->arr_excel);
        }
                
    }//c-tor
    
    
    
    //Содание массива из файла excel
    public function CreateArrayFromExcel($file_path){
        $objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($file_path);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 2; $i <= count($sheetData); $i++) {        
            foreach ($sheetData[$i] as $key => $value) {            
                if ($value !== null){
                    if (is_float($value)){
                        $value = (string)$value;             
                    }
                    $new_key = $sheetData[1][$key];
                    $this->arr_excel[$i - 1]["$new_key"] = $value;
                }            
            }//foreach
        }//for $i
    }//CreateArrayFromExcel
    
    
    //Проверка массива 
    public function CheckArray(){
                
        foreach ($this->arr_excel as $key => $properties){
            
            foreach ($this->arr_required_properties as $requiered_property) {
                if (!isset($properties[$requiered_property])){
                    $this->errors['check_array'][] = 'Отсутствует '.$requiered_property;
                }
            }            
        }        
        
    }//CheckArray
    
    
    
    //Запись массива в базу данных
    public function AddToDB($arr){
        
        $link = ConnectionDB();

        foreach ($arr as $arr_prop) {
            $brand_id = $arr_prop['brand_id'];
            $serie_id = '';
            $model_id = '';
            $model_title_id = '';
            $prod_id = '';
            $prop_id = '';
            $model_prop_id = '';
            $prop_value_id = '';
            
            $serie_name = $arr_prop['serie'];
            $model_name = $arr_prop['model'];
            $model_title = $arr_prop['title'];
            $prod_article = $arr_prop['article'];
            $prod_description = $arr_prop['description'];
            $prod_inox = $arr_prop['inox'];
            
            $model_pic_fullsize = '';
            $model_draw_fullsize = '';
            $model_pic_preview = '';            
            $model_pdf =  '';
            $model_public_name = '';
            $description_model = ''; // Description model in spoiler
            $description_model_details = ''; // Description model in model_details
            
                       
            //SERIE_ID
            $temp = $link->query("SELECT serie_id FROM series WHERE BINARY serie_name='$serie_name' AND brand_id='$brand_id'");
            if ($temp->num_rows !== 0) {
                $temp = $temp->fetch_assoc();
                $serie_id = $temp['serie_id'];
                $this->success[] = $serie_name.': серия сущесвует в БД';
            } else {
                $link->query("INSERT INTO series SET serie_name='$serie_name', brand_id='$brand_id'");
                $serie_id = $link->insert_id;
                $this->success[] = $serie_name.': новая серия добавлена в БД';
            }

            //MODEL_TITLE_ID
            $temp = $link->query("SELECT model_title_id FROM models_titles WHERE BINARY model_title_name='$model_title'");
            if ($temp->num_rows !== 0) {
                $temp = $temp->fetch_assoc();
                $model_title_id = $temp['model_title_id'];
                $this->success[] = $model_title.': название модели сущесвует в БД';
            } else {
                $link->query("INSERT INTO models_titles SET model_title_name='$model_title'");
                $model_title_id = $link->insert_id;
                $this->success[] = $model_title.': новое название модели добавлено в БД';
            }

            //MODEL_ID
            $temp = $link->query("SELECT model_id FROM models WHERE BINARY model_name='$model_name' AND serie_id='$serie_id'");
            if ($temp->num_rows !== 0) {
                $temp = $temp->fetch_assoc();
                $model_id = $temp['model_id'];
                $link->query("UPDATE models SET model_title_id='$model_title_id' WHERE model_id='$model_id'");
                $this->success[] = $model_name.': модель сущесвует в БД';                
            } else {
                $link->query("INSERT INTO models SET model_name='$model_name', serie_id='$serie_id', model_title_id='$model_title_id', model_public_name='$model_name', model_description='$model_title', model_onstock=0, model_onsale=0");
                $model_id = $link->insert_id;
                $this->success[] = $model_name.': новая модель добавлена в БД';
            }
            
            //MODEL PUBLIC NAME
            if (isset($arr_prop['model_public_name']) && !empty($arr_prop['model_public_name']) && $arr_prop['model_public_name'] != ''){
                $model_public_name = $arr_prop['model_public_name'];
                $link->query("UPDATE models SET model_public_name='$model_public_name' WHERE model_id='$model_id'");
                $this->success[] = $model_public_name.': публичное имя модели обновлено в БД';
            }   
            
            //MODEL DESCRIPTION IN MODEL_DETAILS
            if (isset($arr_prop['description_model_details']) && !empty($arr_prop['description_model_details']) && $arr_prop['description_model_details'] != ''){
                $description_model_details = $arr_prop['description_model_details'];
                $link->query("UPDATE models SET model_description='$description_model_details' WHERE model_id='$model_id'");
                $this->success[] = $description_model_details.': Описание model_details обновлено в БД';
            }
            
            //MODEL DESCRIPTION IN model_descriptions DB
            if (isset($arr_prop['description_model']) && !empty($arr_prop['description_model']) && $arr_prop['description_model'] != ''){
                $description_model = $arr_prop['description_model'];
                $temp = $link->query("SELECT model_desc_id FROM model_descriptions WHERE model_id='$model_id' LIMIT 1");
                if ($temp->num_rows !== 0) {                    
                    $link->query("UPDATE model_descriptions SET model_description='$description_model' WHERE model_id='$model_id' ");
                    $this->success[] = $model_name . ': Описание модели обновлено в БД.';
                } else {
                    $link->query("INSERT INTO model_descriptions SET model_description='$description_model', model_id='$model_id'");                    
                    $this->success[] = $model_name . ': Описание модели добавлено в БД.';
                }//else
            } 
            
            
            
            //IMAGES
            if (isset($arr_prop['pic_preview']) && !empty($arr_prop['pic_preview']) && $arr_prop['pic_preview'] != ''){
                $model_pic_preview = $arr_prop['pic_preview'];
                $temp = $link->query("SELECT model_image_id FROM models_images WHERE model_id='$model_id' AND img_type_id=3");
                if ($temp->num_rows !== 0) {
                    $this->success[] = $model_name . ': PIC_Preview сущесвует в БД';
                } else {
                    $link->query("INSERT INTO models_images SET model_image_path='$model_pic_preview', model_id='$model_id', img_type_id=3");
                    $this->success[] = $model_name . ': новая PIC_Preview добавлена в БД';
                }
            }// if pic_preview
            
            if (isset($arr_prop['pic_fullsize']) && !empty($arr_prop['pic_fullsize']) && $arr_prop['pic_fullsize'] != ''){
                $model_pic_fullsize = $arr_prop['pic_fullsize'];
                $model_pic_fullsize_minific = 'min_'.$model_pic_fullsize;
                $temp = $link->query("SELECT model_image_id FROM models_images WHERE model_id='$model_id' AND img_type_id=1 LIMIT 1");
                if ($temp->num_rows !== 0) {
                    $this->success[] = $model_name . ': PIC_Fullsize сущесвует в БД';
                } else {
                    $link->query("INSERT INTO models_images SET model_image_path='$model_pic_fullsize', model_id='$model_id', img_type_id=1");
                    $this->success[] = $model_name . ': новая PIC_Fullsize добавлена в БД';
                    $link->query("INSERT INTO models_images SET model_image_path='$model_pic_fullsize_minific', model_id='$model_id', img_type_id=4");
                    $this->success[] = $model_name . ': новая MINIFIC PIC_Fullsize добавлена в БД';
                }
            }// if pic_fullsize
            
            if (isset($arr_prop['draw_fullsize']) && !empty($arr_prop['draw_fullsize']) && $arr_prop['draw_fullsize'] != ''){
                $model_draw_fullsize = $arr_prop['draw_fullsize'];
                $model_draw_fullsize_minific = 'min_'.$model_draw_fullsize;
                $temp = $link->query("SELECT model_image_id FROM models_images WHERE model_id='$model_id' AND img_type_id=2 LIMIT 1");
                if ($temp->num_rows !== 0) {
                    $this->success[] = $model_name . ': DRAW_Fullsize сущесвует в БД';
                } else {
                    $link->query("INSERT INTO models_images SET model_image_path='$model_draw_fullsize', model_id='$model_id', img_type_id=2");
                    $this->success[] = $model_name . ': новая DRAW_Fullsize добавлена в БД';
                    $link->query("INSERT INTO models_images SET model_image_path='$model_draw_fullsize_minific', model_id='$model_id', img_type_id=5");
                    $this->success[] = $model_name . ': новая MINIFIC DRAW_Fullsize добавлена в БД';
                }                
            }// if draw_fullsize
            
            //PDF
            if (isset($arr_prop['pdf']) && !empty($arr_prop['pdf']) && $arr_prop['pdf'] != ''){
                $model_pdf = $arr_prop['pdf'];
                $temp = $link->query("SELECT pdf_id FROM models_pdf WHERE model_id='$model_id' LIMIT 1");
                if ($temp->num_rows !== 0) {                    
                    $link->query("UPDATE models_pdf SET pdf_url='$model_pdf' WHERE model_id='$model_id' ");
                    $this->success[] = $model_name . ': PDF обновлен в БД.';
                } else {
                    $link->query("INSERT INTO models_pdf SET pdf_url='$model_pdf', model_id='$model_id'");                    
                    $this->success[] = $model_name . ': новый PDF добавлен в БД.';
                }//else
            }            

            //PROD_ID
            $temp = $link->query("SELECT prod_id FROM products WHERE BINARY prod_article='$prod_article' AND prod_model_id='$model_id'");
            if ($temp->num_rows !== 0) {
                $temp = $temp->fetch_assoc();
                $prod_id = $temp['prod_id'];
                $link->query("UPDATE products SET prod_inox='$prod_inox', prod_description='$prod_description' WHERE prod_id='$prod_id' ");
                $link->query("DELETE FROM prod_prop_values WHERE prod_id='$prod_id'");// Delete all product's properties 
                $this->success[] = $prod_article.': товар существует в БД. (Обновлены разделы: inox, description)';
            } else {
                $link->query("INSERT INTO products SET prod_article='$prod_article', prod_model_id='$model_id', prod_inox='$prod_inox', prod_description='$prod_description' ");
                $prod_id = $link->insert_id;
                $this->success[] = $prod_article.': новый товар добавлен в БД.';
            }//else
            // run array only product properties
            foreach ($arr_prop as $prop_name => $prop_value) {
                if ($this->checkMinusWords($prop_name)) {

//                    if (is_float($prop_value) || is_double($prop_value)){
//                        $prop_value = (string)(round($prop_value, 3));
//                    }

                    //PROP_ID
                    $temp = $link->query("SELECT prop_id FROM properties WHERE BINARY prop_name='$prop_name'");
                    if ($temp->num_rows !== 0) {
                        $temp = $temp->fetch_assoc();
                        $prop_id = $temp['prop_id']; 
                        $this->success[] = $prop_name.': параметр существует в БД.';
                    } else {
                        $link->query("INSERT INTO properties SET prop_name='$prop_name'");
                        $prop_id = $link->insert_id;
                        $this->success[] = $prop_name.': новый параметр добавлен в БД.';
                    }

                    //MODEL_PROP_ID
                    $temp = $link->query("SELECT model_prop_id FROM model_properties WHERE model_id='$model_id' and prop_id='$prop_id'");
                    if ($temp->num_rows !== 0) {
                        $temp = $temp->fetch_assoc();
                        $model_prop_id = $temp['model_prop_id'];
                        $this->success[] = $prop_name.': параметр модели существует в БД.';
                    } else {
                        $link->query("INSERT INTO model_properties SET model_id='$model_id', prop_id='$prop_id'");
                        $model_prop_id = $link->insert_id;
                        $this->success[] = $prop_name.': новый параметр добавлен к модели в БД.';                        
                    }

                    //PROP_VALUE_ID
                    $temp = $link->query("SELECT prop_value_id FROM properties_values WHERE prop_id='$prop_id' and prop_value='$prop_value'");
                    if ($temp->num_rows !== 0) {
                        $temp = $temp->fetch_assoc();
                        $prop_value_id = $temp['prop_value_id'];
                        $this->success[] = $prop_value.': значение параметра существует в БД.';
                    } else {
                        $link->query("INSERT INTO properties_values SET prop_id='$prop_id', prop_value='$prop_value'");
                        $prop_value_id = $link->insert_id;
                        $this->success[] = $prop_value.': новое значение параметра добавлено в БД.';
                    }


                    //PROD_PROP_VALUES
                    $temp = $link->query("SELECT prod_prop_value_id FROM prod_prop_values WHERE prod_id='$prod_id' and model_prop_id='$model_prop_id' and prop_value_id='$prop_value_id'");
                    if ($temp->num_rows !== 0) {
                        $temp = $temp->fetch_assoc();
                        $prod_prop_value_id = $temp['prod_prop_value_id'];
                        $link->query("UPDATE prod_prop_values SET prod_id='$prod_id', model_prop_id='$model_prop_id', prop_value_id='$prop_value_id' WHERE prod_prop_value_id='$prod_prop_value_id'");
                    } else {
                        $link->query("INSERT INTO prod_prop_values SET prod_id='$prod_id', model_prop_id='$model_prop_id', prop_value_id='$prop_value_id' ");
                        $prod_prop_value_id = $link->insert_id;                        
                    }
                }//if(checkMinusWords)
            }//foreach
            
        }//foreach whole array
        
        $link->close();
        
    }//AddToDB
    
    
    public function checkMinusWords($value) {    
        foreach ($this->arr_minus_words as $word) {
            if ($word === $value) {
                return false;
            }
        }//foreach

        return true;
    }//checkMinusWords
    
    
    
    
    ////////////////////////////////////
       
    
}//class AddExcelToDB


