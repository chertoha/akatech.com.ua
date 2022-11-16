<?php


/*РАБОТА С КОРЗИНОЙ*/
if (isset($_POST['cart'])){
    
    
    
        //*Запись товаров в сессию для корзины*/
    if ($_POST['cart'] === 'savetocart'){       
           
        if (isset ($_SESSION) && !isset($_SESSION['cart'][$_POST['prod_id']])){           
            $_SESSION['cart'][$_POST['prod_id']]['prod_name'] = $_POST['prod_name'];
            $_SESSION['cart'][$_POST['prod_id']]['brand_name'] = $_POST['brand_name'];
            $_SESSION['cart'][$_POST['prod_id']]['prod_description'] = $_POST['prod_description'];
            $_SESSION['cart'][$_POST['prod_id']]['image_url'] = $_POST['image_url'];
            $_SESSION['cart'][$_POST['prod_id']]['quantity'] = '1';
        }        
        echo -1;
    }//    savetocart
    
    
    
    
        //*Вывод товаров в модальное окно корзины*/
    if ($_POST['cart'] === 'printcart'){
        $cart_html = '';
        
        if (isset ($_SESSION['cart'])){           
            
            $count = 0;
            foreach ($_SESSION['cart'] as $prod_id => $product) {
                
                $cart_html.= '<li>
                    <table class="table table-hover modal-cart">
                        <colgroup>
                            <col class="num_counter">
                            <col class="image">
                            <col class="name">							
                            <col class="quantity">							
                            <col class="remove">
                        </colgroup>
                        <tbody>
                            <tr>
                                <input type="hidden" name="cart_prod_id" value="'.$prod_id.'">
                                <td class="num_counter text-left">
                                    <h4>'.++$count.'.</h4>                                                
                                </td>
                                <td class="image text-left"><img class="img-responsive" src="'.TEMPLATE.'/images/models/'.$product['brand_name'].'/pic_preview/'.$product['image_url'].'" alt="'.$product['prod_description'].'"></td>
                                <td class="name text-left">
                                    <input type="hidden" name="product_article[]" value="'.$product['prod_name'].'">
                                    <input type="hidden" name="product_info[]" value="'.$product['prod_description'].'">
                                    <input type="hidden" name="prod_id[]" value="'.$prod_id.'">
                                    <h4>'.$product['prod_name'].'</h4>
                                    <p>'.$product['prod_description'].'</p>
                                </td>								
                                <td class="quantity">                                    
                                    <input class="cart_prod_quantity" type="number" name="product_quantity[]" value="'.$product['quantity'].'" size="3" max="100000" min="0" id="pyat">
                                </td>								
                                <td class="remove"><img class="cart_prod_remove" src="'.TEMPLATE.'/images/remove_close.png" alt="Удалить товар"></td>        
                            </tr>
                        </tbody>
                    </table>
                </li>';
            }//foreach
        }      
        
        if ($cart_html != ''){
            echo $cart_html;
        }
        else {
            echo '<h4>Корзина пуста</h4>';
        }        
    }//    printcart
    
    
    
    
    
         //*Изменение количества товаров , запись в сессию для корзины*/
    if ($_POST['cart'] === 'changequantity'){
        
        if (isset($_SESSION['cart'][$_POST['prod_id']])){
            $_SESSION['cart'][$_POST['prod_id']]['quantity'] = $_POST['prod_quantity'];
            echo '1';
        }
        else {
            echo -1;
        }
        
    }//    changequantity
    
    
    
    
    
         //*Проверка корзины на число товаров*/
    if ($_POST['cart'] === 'numofproducts'){
        
        if (isset($_SESSION['cart'])){            
            echo count($_SESSION['cart']);
        }
        else {
            echo -1;
        }        
    }//    numofproducts
    
    
    
    //*Удаление товара из корзины*/
    if ($_POST['cart'] === 'removeitem'){
        
        if (isset($_SESSION['cart'][$_POST['prod_id']])){
            unset ($_SESSION['cart'][$_POST['prod_id']]);
            echo '1';
        }
        else {
            echo -1;
        }
    }
    
    
    
    
}//CART




