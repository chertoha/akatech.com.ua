//Скрипт виджета totemticker (список товаров в корзине)
$(function () {
    $('#vertical-ticker').totemticker({
        row_height: '65px',
        next: '#ticker-next',
        previous: '#ticker-previous',
        stop: '#stop',
        start: '#start',
        interval: 100000,
        mousestop: true
    });
});


/* Появление корзины + привязка события на исчезание ярлыка корзины */
function CartShowClose() {
  
        var bmc = $('#main_cart');
        if (bmc.css('display') != 'block') {
            bmc.show(0, function () {
                $(document).bind('click#btn_order_sheet', function (e) {
                    if (!$(e.target).closest(bmc).length) {
                        bmc.hide(200);
                    }
                });
            });
        }
}//CartShowClose




/* Вывод товаров в корзине*/
function CartProductShow(){
      
    $.ajax({
        url: 'ajax/ajax.php',
        type: 'POST',
        data: {
            cart: 'printcart'
        },
        success: function (response) {
//            alert(response);            
            $('#vertical-ticker').empty();
            $('#vertical-ticker').append(response);
                       
        }//success
    });
    
}//CartProductShow()





//Появление блока #main_cart
$(document).ready(function () {

    //Показать корзину, если в ней есть товары
    $.ajax({
        url: 'ajax/ajax.php',
        type: 'POST',
        data: {
            cart: 'numofproducts'
        },
        success: function (response) {
//            alert(response);
            if (response >= 1){
//                if (response >= 4){
//                    $('#vertical-ticker').css('height',400);
//                }
//                else {
//                    $('#vertical-ticker').css('height',response*100);
//                }
                CartShowClose();
            }            
        }
    });


    $('a.product_name_1').click(function (event) {

        var target = $(event.target);

        //НАЧАЛО Запись тоаров в сессию через AJAX
        var cart_prod_id = target.parent().children('input[name="cart_prod_id"]').val();
        var cart_brand_name = target.parent().children('input[name="cart_brand_name"]').val();
        var cart_prod_name = target.parent().children('input[name="cart_prod_name"]').val();
        var cart_prod_descript = target.parent().children('input[name="cart_prod_descript"]').val();
        var cart_prod_img_url = target.parent().children('input[name="cart_prod_img_url"]').val();

        $.ajax({
            url: 'ajax/ajax.php',
            type: 'POST',
            data: {
                cart: 'savetocart',
                prod_id: cart_prod_id,
                brand_name: cart_brand_name,
                prod_name: cart_prod_name,
                prod_description: cart_prod_descript,
                image_url: cart_prod_img_url
            },
            success: function (response) {
//                            alert(response);
                $('#main_cart').hide(500).show(500);
            }
        });
        //КОНЕЦ Запись тоаров в сессию через AJAX

        
        // Появление корзины
        CartShowClose();
        
        return false;
    });
});



//Появление блока .chat (ярлык корзины "создать запрос")
$(document).ready(function () {
    $('.cart_big').hover(function () {
        $('.chat').fadeIn(300);
    },
            function () {
                $('.chat').fadeOut(300);
            });
});



//Построение таблицы товаров модального окна из сессии
$('#main_cart').click(function() {
  CartProductShow();
});

            
            
//Изменение количества товаров в списке (html строится в ajax_catalog)
$('body').change(function(event){
    var target = $(event.target);
    
    if (target.hasClass('cart_prod_quantity')){        
        var cart_prod_id = target.parent().parent().children('input[name="cart_prod_id"]').val();
        var cart_prod_quantity =  target.val();
        
        $.ajax({
            url: 'ajax/ajax.php',
            type: 'POST',
            data: {
                cart: 'changequantity',
                prod_id: cart_prod_id,
                prod_quantity: cart_prod_quantity 
            },
            success: function (response) {
//                alert(response);
                
            }
        });
    }     
    
});



$('body').click(function(event){   
    
    var target = $(event.target);    
    
    //Удаление товара из корзины
    if (target.hasClass('cart_prod_remove')){
        var cart_prod_id = target.parent().parent().children('input[name="cart_prod_id"]').val();
        
        $.ajax({
            url: 'ajax/ajax.php',
            type: 'POST',
            data: {
                cart: 'removeitem',
                prod_id: cart_prod_id,                
            },
            success: function (response) {
//                alert(response);
                CartProductShow();
            }
        });
    }//if    
    
});
