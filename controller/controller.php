<?php
defined ('AKATECH') or die ('Access Denied');


session_start();

// Подключение модели
require_once MODEL;


//Init
Init();

//Получение массива слайдов главного слайдера сайта
$arr_slider = getSlides();

//Получение массива "обзор продукции" 
$arr_overview = getOverview();

//Получение массива "дерево продукции"
$arr_tree_products = getTreeProducts(); // нужно добавить условие выбора между разными вьюшками

//Получение массива "последняя новость"
$arr_last_news = getLastNews();



$view= empty($_GET['view']) ? 'main' : $_GET['view'];


$cat_prod_list = []; // Список разделов в категории
$sub_cat_prod_list = []; // Список подразделов в разделе (список товаров)
$arr_model_datails = [];
$arr_breadcrumbs = [];
$arr_news_overview = [];
$arr_news_details = [];
$gallery_albums = [];
$catalog_includes = '';
$arr_search_result = [];

$title = 'Комплектующие от Акатех Груп';
$meta_description = 'Комплектующие для машиностроения АКАТЕХ. Промышленная фурнитура, звездочки и цепи, ремни и шкивы';
$meta_keywords = 'Промышленная фурнитура, конвейерные комплектующие, '
        . 'замки, защелки, индикаторы положения, счетчики оборотов,'
        . 'прижимы для сварки, карданы, шарнирные соединения, звёздочки, '
        . 'цепи, шкивы, ремни, зубчатые передачи, элементы приводов, '
        . 'конструкционный алюминиевый профиль, вибромоторы, мотор-вибраторы';

switch ($view) {
    case ('category'):
        $category_id = abs((int) $_GET['category_id']);
        $cat_prod_list = getCatalogProdListArray($category_id);
        $arr_breadcrumbs = getBreadcrumbsCatalog($category_id);
        if (!empty($cat_prod_list)){// на случай если страничка сайта не доделана
            $catalog_includes = 'includes/catalog/sub_categories_list.php';
        }        
        
        $arr_meta = getMetaTags($category_id);
        $meta_description = $arr_meta['meta_description'];
        $meta_keywords = $arr_meta['meta_keywords'];
        break;
    
    case ('sub_category'):
        $cat_id = abs((int) $_GET['cat_id']);
        $sub_cat_id = abs((int) $_GET['sub_cat_id']);
        $sub_cat_prod_list = getModelsFromSubCategory($sub_cat_id);
        $arr_breadcrumbs = getBreadcrumbsCatalog($cat_id, $sub_cat_id);
        $catalog_includes = 'includes/catalog/models_list.php';
        
        $arr_meta = getMetaTags($sub_cat_id);
        $meta_description = $arr_meta['meta_description'];
        $meta_keywords = $arr_meta['meta_keywords'];
        break;
    
    case ('models'):
        $cat_id = abs((int) $_GET['cat_id']);
        $sub_cat_id = abs((int) $_GET['sub_cat_id']);
        $model_id = abs((int) $_GET['model_id']);
        $arr_model_datails = getModelDescriptionPageArray($model_id);
        $arr_breadcrumbs = getBreadcrumbsCatalog($cat_id, $sub_cat_id, $model_id);
        $catalog_includes = 'includes/catalog/model_details.php';
        $meta_description = $arr_breadcrumbs[count($arr_breadcrumbs)-1]['crumb_name'];
        foreach ($arr_breadcrumbs as $key => $breadcrumb){
            $meta_keywords.= ($key == count($arr_breadcrumbs)-1) ? $breadcrumb['crumb_name'] : $breadcrumb['crumb_name'].', ';
        }
        break;
    
    case('catalogs'):
        $arr_breadcrumbs[] = [
            'crumb_name' => 'Каталоги',
            'crumb_href' => '?view=catalogs',
            ];
        $catalog_includes = 'includes/catalogs.php';
        $meta_description = 'Каталоги pdf промышленной фурнитуры, '
                . 'приводных элементов, конвейерных комплектующих и других комплектующих для машиностроения';
        $meta_keywords = 'Каталоги, скачать каталоги в пдф, каталоги промышленных комплектующих';
        break;
    
    case('news'):        
        if (isset($_GET['page'])){
            $page_num = abs((int) $_GET['page']);
            $arr_news_overview = getNewsOverview($page_num-1);
        }
        else {
            $arr_news_overview = getNewsOverview();
        }        
        $arr_breadcrumbs[] = [
            'crumb_name' => 'Новости',
            'crumb_href' => '?view=news',
            ];
        $catalog_includes = 'includes/news/news.php';
        
        $meta_description = 'Последние статьи от компании АКАТЕХ. Ценная информация для машиностроителей';
        $meta_keywords = 'Статьи машиностроение, новости АКАТЕХ, ценная информация для машиностроения';
        break;
    
    case('news_details'):
        $news_id = abs((int) $_GET['news_id']);
        $arr_news_details = getNewsDetails($news_id);
        $arr_breadcrumbs = getBreadcrumbsNews($news_id);        
        $catalog_includes = 'includes/news/news_details.php';
        $meta_description = 'Последние статьи от компании АКАТЕХ. Ценная информация для машиностроителей';
        $meta_keywords = 'Статьи машиностроение, новости АКАТЕХ, ценная информация для машиностроения';
        break;
    
    case('gallery'):
        $gallery_albums = getGalleryAlbums();
        $arr_breadcrumbs[] = [
            'crumb_name' => 'Галерея',
            'crumb_href' => '?view=gallery',
            ];
        $catalog_includes = 'includes/gallery/gallery.php';
        $meta_description = 'Галерея АКАТЕХ, фотографии применения изделий АКАТЕХ';
        $meta_keywords = 'Фото применения комплектующих, галерея компании АКАТЕХ';
        break;
    
    case('contacts'):
        $arr_breadcrumbs[] = [
            'crumb_name' => 'Контакты',
            'crumb_href' => '?view=contacts',
            ];
        $catalog_includes = 'includes/contacts.php';
        $meta_description = 'Контакты компании АКАТЕХ, карта проезда в офис';
        $meta_keywords = 'контакты АКАТЕХ, адрес компании АКАТЕХ';
        break;
    
    case('search'):
        $search_text = $_GET['search_text'];
        $arr_search_result = getSearchResult($search_text);
        $arr_breadcrumbs[] = [
            'crumb_name' => 'Поиск',
            'crumb_href' => '?view=search',
            ];        
        $catalog_includes = 'includes/catalog/search.php';
        
        $meta_description = '';
        $meta_keywords = '';
        break;
        
}//switch


//Выдача формы обратной связи в случае недоработанной части сайта или не заполненной товарной группы
if ($catalog_includes == ''){
    $catalog_includes = 'includes/catalog/feedback_form.php';
}

//Назначение title
if (!empty($arr_breadcrumbs)){
    $title = $arr_breadcrumbs[count($arr_breadcrumbs)-1]['crumb_name'];
}



// Подключение видов
if (empty($_GET['view'])){
    require_once TEMPLATE.'index.php';
}
else {
    require_once TEMPLATE.'catalog.php';
}