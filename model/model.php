<?php
defined ('AKATECH') or die('Access Denied');

require_once 'init.php';

//CONNECT TO DATA BASE
function ConnectDB() {
    $link = new mysqli(HOST, USER, PASS, DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    return $link;
}//ConnectionDB


/*---Получение массива слайдов---*/
function getSlides(){    
    $arr_slides = [];   
    $link = ConnectDB();
    
    $res = $link->query("SELECT * FROM main_slider");
    while ($row = $res->fetch_assoc()){
        $arr_slides[] = $row;
    }//while
    
    $link->close();
    return $arr_slides;    
}//getSlides





/*---Получение массива групп товаров для главной страницы---*/
function getOverview (){
    $arr_overview = [];
    $link = new mysqli(HOST, USER, PASS, DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    $res = $link->query("   SELECT *
                            FROM tree_products
                            WHERE tree_prod_parent_id=0 AND tree_prod_visible='1'
                            ORDER BY tree_prod_order");
    while ($row = $res->fetch_assoc()){
        $arr_overview[] = $row;
    }//while
    $link->close();
    return $arr_overview;
}//getCatalog()


/*---Получение массива дерева товаров для сайдбара---*/
function getTreeProducts(){
    $arr_tree_products = [];
    $link = new mysqli(HOST, USER, PASS, DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    $res = $link->query("   SELECT *
                            FROM tree_products
                            WHERE tree_prod_visible='1'
                            ORDER BY tree_prod_parent_id, tree_prod_order");
    while ($row = $res->fetch_assoc()) {
        if ($row['tree_prod_parent_id'] == 0){
            $arr_tree_products[$row['tree_prod_id']][] = $row['tree_prod_name'];
        }
        else{
            $arr_tree_products[$row['tree_prod_parent_id']]['sub'][$row['tree_prod_id']] = $row['tree_prod_name'];
        }
    }//while
    $link->close();
    return $arr_tree_products;
}//getTreeProducts()



/*---Получение массива подразделов в разделе по id категории---*/
function getCatalogProdListArray($category_id){
    $cat_prod_list = [];
    $link = new mysqli(HOST, USER, PASS, DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    
    
    
    //Доработка для отображения раздела Кукамет (исключение)
    if ($category_id == 159){// Addition specialy for KUKAMET
        $res = $link->query("SELECT * FROM tree_products WHERE tree_prod_parent_id=159 ORDER BY tree_prod_order");
    }else{// Original code
        $res = $link->query("SELECT * FROM tree_products WHERE tree_prod_parent_id='$category_id' and tree_prod_visible='1' ORDER BY tree_prod_order");
    }
    
    
    
    while ($row = $res->fetch_assoc()){
        $cat_prod_list[] = $row;
    }//while
        
    return $cat_prod_list;
}//getCatalogProdListArray



/*---Получение массива моделей в подразделе по id категории и id субкатегории---*/
function getModelsFromSubCategory($sub_category_id){
    $arr_subcat_models = [];
    
    $link = new mysqli(HOST, USER, PASS, DB);
    $link->query("SET NAMES 'UTF8'") or die('Cant set charset');
    if (!empty($link->connect_error)) {
        die('No connection to server, error: ' . $link->connect_error);
    }
    
    $query = "  SELECT 
                pg.prod_groups_id, 
                pg.tree_prod_id, 
                pg.model_id, 
                m.model_name,
                m.serie_id, 
                m.model_onstock, 
                m.model_onsale, 
                md.model_description, 
                mi.model_image_path,
                tp.tree_prod_name,
                s.serie_name,
                b.brand_name,
                m.model_public_name,
                tp.tree_prod_parent_id,
                pgot.output_type_descriptor
                
                FROM product_groups pg LEFT JOIN models m
                ON pg.model_id=m.model_id LEFT JOIN model_descriptions md
                ON m.model_id=md.model_id LEFT JOIN 
                    (
                    SELECT * FROM models_images WHERE img_type_id='3'
                    ) mi
                ON m.model_id=mi.model_id LEFT JOIN tree_products tp
                ON pg.tree_prod_id=tp.tree_prod_id LEFT JOIN series s
                ON m.serie_id=s.serie_id LEFT JOIN brands b
                ON s.brand_id=b.brand_id LEFT JOIN prod_groups_output_type pgot
                ON tp.output_type_id=pgot.output_type_id
                
                WHERE pg.tree_prod_id='$sub_category_id' AND pg.prod_groups_visible='1'
                ORDER BY pg.prod_groups_order";
    
    $res = $link->query($query);
    while($row = $res->fetch_assoc()){
        
        $arr_subcat_models[] = $row;
        
    }//while
    
    return $arr_subcat_models;
}//getModelsFromSubCategory()



/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
// Массив для формирования страницы с описанием конкретной модели
function getModelDescriptionPageArray($model_id){
    
    $arr_total = [];
    $arr_images = [];
    $arr_props = [];
    $arr_products = [];
    $arr_model_info = [];
    $arr_specifications = [];
    $arr_videos = [];
    $arr_application = [];
    
    //МАССИВ ПАРАМЕТРОВ 
    $link = ConnectDB();   
    $query  = " SELECT p.prop_id, prop_name
                FROM model_properties mp LEFT JOIN properties p
                ON mp.prop_id=p.prop_id
                WHERE mp.model_id='$model_id'";
    $res = $link->query($query);
    while ($row = $res->fetch_assoc()){
        $arr_props[$row['prop_id']] = $row['prop_name'];
    }//while        
    $link->close();
    
    
    
    // МАССИВ ТОВАРОВ
    $link = ConnectDB();    
    $query = "  SELECT prod.prod_id ,prod.prod_article, pv.prop_id, pv.prop_value, prod.prod_description, prod.prod_inox
                FROM models m LEFT JOIN products prod
                ON m.model_id=prod.prod_model_id LEFT JOIN prod_prop_values ppv
                ON prod.prod_id=ppv.prod_id LEFT JOIN model_properties mp
                ON ppv.model_prop_id=mp.model_prop_id LEFT JOIN properties_values pv
                ON ppv.prop_value_id=pv.prop_value_id 
                WHERE m.model_id='$model_id'";    
    $res = $link->query($query);
    while ($row = $res->fetch_assoc()){
        $arr_products[$row['prod_id']]['prod_article'] = $row['prod_article'];
        $arr_products[$row['prod_id']]['prod_description'] = $row['prod_description'];
        $arr_products[$row['prod_id']]['prod_inox'] = $row['prod_inox'];
        $arr_products[$row['prod_id']]['properties'][$row['prop_id']] = $row['prop_value'];
        
    }//while     
    $link->close();
    
    
    // МАССИВ ИНФОРМАЦИИ О МОДЕЛИ
    $link = ConnectDB();   
    $query  = " SELECT m.model_id, 
                m.model_name, 
                m.model_public_name, 
                m.serie_id, 
                m.model_description, 
                s.serie_name, 
                s.brand_id,
                b.brand_name,
                mt.model_title_name,
                mi.model_info_text,
                md.model_description public_description,
                pdf.pdf_url,
                m3d.model_3d_url
                
                FROM models m LEFT JOIN series s 
                ON m.serie_id=s.serie_id LEFT JOIN brands b
                ON s.brand_id=b.brand_id LEFT JOIN models_titles mt
                ON m.model_title_id=mt.model_title_id LEFT JOIN models_information mi
                ON m.model_id=mi.model_id LEFT JOIN model_descriptions md
                ON m.model_id=md.model_id LEFT JOIN models_pdf pdf
                ON m.model_id=pdf.model_id LEFT JOIN models_3d m3d
                ON m.model_id=m3d.model_id
                WHERE m.model_id='$model_id'";
    $res = $link->query($query);
    $arr_model_info = $res->fetch_assoc();   
    $link->close();
    
    
    // МАССИВ КАРТИНОК И ЧЕРТЕЖЕЙ
    $link = ConnectDB();
    $query = "  SELECT *
                FROM models_images mi
                WHERE mi.model_id='$model_id'";
    $res = $link->query($query);
    while ($row = $res->fetch_assoc()){
        $arr_images[$row['img_type_id']][] = $row['model_image_path'];
    }//while
    $link->close();
    
    
    //МАССИВ СПЕЦИФИКАЦИИ МОДЕЛИ
    $link = ConnectDB();
    $query = "  SELECT ms.model_specific_id, msp.model_specific_param_name, mspv.model_sp_param_val
                FROM model_specifications ms LEFT JOIN model_specific_params_values mspv
                ON ms.model_sp_param_val_id=mspv.model_sp_param_val_id LEFT JOIN model_specific_params msp
                ON mspv.model_specific_param_id=msp.model_specific_param_id
                WHERE ms.model_id='$model_id' AND ms.model_sp_param_visible='1'";
    
    $res = $link->query($query);
    while ($row = $res->fetch_assoc()){
        $arr_specifications[$row['model_specific_param_name']][$row['model_specific_id']] = $row['model_sp_param_val'];
    }//while
    $link->close();
    
    
    //МАССИВ ВИДЕО
    $link = ConnectDB();
    $query = "  SELECT *
                FROM model_videos mv
                WHERE mv.model_id='$model_id'";
    $res = $link->query($query);
    while ($row = $res->fetch_assoc()){
        $arr_videos[$row['model_video_id']]['video_src'] = $row['model_video_src'];
        $arr_videos[$row['model_video_id']]['video_name'] = $row['model_video_name'];
    }//while
    $link->close();
    
    //МАССИВ ПРИМЕНЕНИЕ
    $link = ConnectDB();
    $query = "  SELECT *
                FROM model_app_photo map
                WHERE map.model_id='$model_id'";
    $res = $link->query($query);
    $count = 0;
    while ($row = $res->fetch_assoc()){
        $count++;
        $arr_application[$count]['application_image'] = $row['model_app_photo_url'];
        $arr_application[$count]['application_text'] = $row['model_app_photo_description'];
    }//while
    $link->close();
    
    
    // ЗАПИСЬ В ОБЩИЙ МАССИВ
    $arr_total = [
        'model_info' => $arr_model_info,
        'images' => $arr_images,
        'prod_properties' => $arr_props,
        'products' => $arr_products,
        'specification' => $arr_specifications,
        'videos' => $arr_videos,
        'applications' => $arr_application,
        ];
           
//    var_dump($arr_total);
    return $arr_total;
}//getModelDescriptionPageArray()




/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
// Хлебные крошки
function getBreadcrumbsCatalog($cat_id, $sub_cat_id = 0, $model_id = 0){
    $arr_crumbs = [];
    
    $link = ConnectDB();
    
    $res = $link->query("SELECT tree_prod_name FROM tree_products WHERE tree_prod_id='$cat_id'");
    $res = $res->fetch_assoc();
    $cat_name = strip_tags($res['tree_prod_name']);
        
    $arr_crumbs[] = [
        'crumb_name' => $cat_name,
        'crumb_href' => '?view=category&category_id='.$cat_id,
    ];
    
    if ($sub_cat_id !== 0){
        $res = $link->query("SELECT tree_prod_name FROM tree_products WHERE tree_prod_id='$sub_cat_id'");
        $res = $res->fetch_assoc();
        $sub_cat_name = strip_tags($res['tree_prod_name']);
        
        $arr_crumbs[] = [
            'crumb_name' => $sub_cat_name,
            'crumb_href' => '?view=sub_category&cat_id='.$cat_id.'&sub_cat_id='.$sub_cat_id,
        ];
    }//if
    
    if ($model_id !== 0){
        $res = $link->query("SELECT model_public_name, model_description FROM models WHERE model_id='$model_id'");
        $res = $res->fetch_assoc();
        $model_public_name = strip_tags($res['model_public_name']);
        $model_description = strip_tags($res['model_description']);
        
        $arr_crumbs[] = [
            'crumb_name' => $model_description.' '.$model_public_name,
            'crumb_href' => '?view=sub_category&cat_id='.$cat_id.'&sub_cat_id='.$sub_cat_id.'&model_id='.$model_id,
        ];
    }//if
    
    $link->close(); 
    return $arr_crumbs;    
}//getBreadcrumbs

function getBreadcrumbsNews($news_id){
    $arr_crumbs = [];    
    $link = ConnectDB();
    
    $res = $link->query("SELECT news_title FROM news WHERE news_id='$news_id'");
    $res = $res->fetch_assoc();
    $news_title = $res['news_title'];
    
    $arr_crumbs[] = [
            'crumb_name' => 'Новости',
            'crumb_href' => '?view=news',
        ];
        
    $arr_crumbs[] = [
            'crumb_name' => $news_title,
            'crumb_href' => '?view=news_details',
        ];
    
    $link->close(); 
    return $arr_crumbs;    
}//getBreadcrumbsNews





/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
// Новости
function getNewsOverview($page_num = 0){ 
    $news_per_page = 4; // число новостей на одной странице
    $num_links = 5; // число ссылок-страниц в пагинации (например 3 -> << 4 5 6 >>)
    
    $arr_news = [];             
    
    //Запись номера текущей страницы 
    $arr_news['current_page'] = $page_num+1;
    
    $link = ConnectDB();     

    //Запись кол-ва новостей и количества страниц 
    $res = $link->query("SELECT count(*) count_news FROM news");
    $res= $res->fetch_assoc();
    $arr_news['count_news'] = $res['count_news'];
    $arr_news['count_pages'] = ceil($res['count_news']/$news_per_page);
    
    // Если номер страницы выходит за пределы существующих (например введен вручную пользователем в адресной строке)
    if ($arr_news['current_page'] > $arr_news['count_pages'] || $arr_news['current_page'] <= 1){
        $page_num = 0;
        $arr_news['current_page'] = $page_num+1;        
    }        
    
    $start = abs($page_num * $news_per_page);
    
    //Запись новостей в массив
    $res = $link->query("SELECT * FROM news ORDER BY news_date DESC,news_id LIMIT $start,$news_per_page");
    while ($row = $res->fetch_assoc()){        
        $news_text = strip_tags($row['news_text']);
        $news_text = substr($news_text, 0, 1150);
        $news_text = rtrim($news_text, "!,.-");
        $news_text = substr($news_text, 0, strrpos($news_text, ' '));
        $news_text = $news_text.'...';
        $row['news_text'] =  $news_text;       
        $arr_news['news'][] = $row;
    }//while       
    $link->close();    
        
    // Определение границ ссылок на страницы   << 1 2 3 4 5 >>    
    $row_num = ceil($arr_news['current_page'] / $num_links);        
    $row_end = $row_num * $num_links;
    $row_start  = $row_end - $num_links + 1;        
    if ($row_end > $arr_news['count_pages']){
        $row_end = $arr_news['count_pages'];
    } 
    
    //Запись границ выводимых ссылок-страниц в пагинации
    $arr_news['limits']['start'] = $row_start; 
    $arr_news['limits']['end'] = $row_end;
    
    
    return $arr_news;
}//getNewsOverview

function getNewsDetails($news_id){
    $arr_news_details = [];    
    $link = ConnectDB();    
    $res = $link->query("SELECT * FROM news WHERE news_id='$news_id' LIMIT 1");
    $arr_news_details = $res->fetch_assoc();  
    //$arr_news_details['news_text'] = strip_tags($arr_news_details['news_text']); //changed by chertok 23.05.18
    
    $link->close();
    return $arr_news_details;    
}//getNewsDetails


function getLastNews(){
    $arr_last_news = [];
    
    $link = ConnectDB();
    $res = $link->query("SELECT news_title, news_text FROM news ORDER BY news_date DESC, news_id LIMIT 1");
    $arr_last_news = $res->fetch_assoc();        
    $link->close();
    
    $news_text = strip_tags($arr_last_news['news_text']);
    $news_text = substr($news_text, 0, 400);
    $news_text = rtrim($news_text, "!,.-");
    $news_text = substr($news_text, 0, strrpos($news_text, ' '));
    $news_text = $news_text.'...';
    
    $arr_last_news['news_text'] =  $news_text;
        
    return $arr_last_news;
}//getLastNews





/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
// Галерея

function getGalleryAlbums(){
    
    $arr_albums = [];
   
    $link = ConnectDB();

    $res = $link->query("   SELECT *
                            FROM gallery_albums a LEFT JOIN galery_images i
                            ON a.album_id=i.album_id
                            ORDER BY a.album_order");
    
    while ($row = $res->fetch_assoc()){
        
        $arr_albums[$row['album_id']]['album_image_url'] = $row['album_image_url'];
        $arr_albums[$row['album_id']]['album_descriptor'] = $row['album_descriptor'];
        $arr_albums[$row['album_id']]['album_name'] = $row['album_name'];       
        
        $arr_albums[$row['album_id']]['images'][$row['galery_image_id']]['image_url'] = $row['image_url'];   
        $arr_albums[$row['album_id']]['images'][$row['galery_image_id']]['image_title'] = $row['image_title'];  
        
    }//while
    
    $link->close();
    return $arr_albums;
}//getGalleryAlbums




/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
// Поиск

function getSearchResult($search_text){
    
    $arr_search = [];
    
    
    $link = ConnectDB();
    $query = "  SELECT  m.model_id,
                        m.model_name, 
                        m.model_public_name, 
                        m.model_onstock, 
                        m.model_onsale, 
                        mi.model_image_path, 
                        md.model_description,
                        b.brand_name,
                        mt.model_title_name,
                        pg.tree_prod_id,
                        tp.tree_prod_parent_id,
                        tp.tree_prod_name
                FROM models m LEFT JOIN models_images mi
                ON m.model_id=mi.model_id LEFT JOIN model_descriptions md
                ON m.model_id=md.model_id LEFT JOIN series s
                ON m.serie_id=s.serie_id LEFT JOIN brands b
                ON s.brand_id=b.brand_id LEFT JOIN models_titles mt
                ON m.model_title_id=mt.model_title_id LEFT JOIN product_groups pg
                ON m.model_id=pg.model_id LEFT JOIN tree_products tp
                ON pg.tree_prod_id=tp.tree_prod_id   
                WHERE (m.model_name LIKE '%$search_text%' OR m.model_public_name LIKE '%$search_text%') AND mi.img_type_id=3 
                LIMIT 100";
    
    $res = $link->query($query);
    while ($row = $res->fetch_assoc()){
        $arr_search[] = $row;
    }
    $link->close();
    
    return $arr_search;
}//getSearchResult


//Получение meta тегов description & keywords
function getMetaTags($tree_prod_id){
    $meta_tags = [];
    $link = ConnectDB();
    $res = $link->query("SELECT * FROM meta_tags WHERE meta_tree_prod_id='$tree_prod_id' LIMIT 1");
    $res = $res->fetch_assoc();
    $meta_tags['meta_description'] = $res['meta_description'];
    $meta_tags['meta_keywords'] = $res['meta_keywords'];
    $link->close();
    return $meta_tags;
}//getMetaTags
