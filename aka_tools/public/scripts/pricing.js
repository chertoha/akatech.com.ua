var arrObjItems = new Array(); // articles with data
var tab = document.getElementById('autokp_table');
var pricingDataObj = new Array(); // currancy rate, common discount checkbox status ...

$(document).ready(function () {

    ajaxItemsRequest(callBackFunc);
    function callBackFunc(data) {
        data = $.parseJSON(data);
        console.log(data);
        arrObjItems = data.autokp;
        pricingDataObj = data.pricing_data;
        build();
    }

});


/*BUILD TABLE*/
function build() {
    //drop table
    $('.autokp_row').empty();

    //set currancy rate
    $('#autokp_currency_rate').val(pricingDataObj.currency_rate);

    //set common discount checkbox status
    if (pricingDataObj.common_discount_status == 1) {
        document.getElementById('oneDiscountForAll').checked = true;
    } else {
        document.getElementById('oneDiscountForAll').checked = false;
    }

    //refresh prices
    calculation();
    $('#autokp_total_sum').val(pricingDataObj.total_sum);

    for (var i = 0; i < arrObjItems.length; i++) {
        var row = document.createElement('tr');
        row.className = 'autokp_row';
        $(row).append('<input type="hidden" name="article_id" value="' + i + '">');
        $(row).append('<td class="text-center">' + (i + 1) + '</td>');
        $(row).append('<td class="text-center"><img src="' + arrObjItems[i].img_full_path + '" class="autokp-art-img"></td>');
        $(row).append('<td class="text-center">' + arrObjItems[i].prod_article + '</td>');
        $(row).append('<td class="text-center"><input type="text" class="quantity" name="autokp_quantity" value="' + arrObjItems[i].qty + '"></td>');
        $(row).append('<td class="text-center">' + arrObjItems[i].price_uah + '</td>');
        var isDisabled = (pricingDataObj.common_discount_status == 1 && i !== 0) ? 'disabled' : '';
        $(row).append('<td class="text-center"><input ' + isDisabled + ' type="text" class="discounts" name="autokp_discount" value="' + arrObjItems[i].discount + '"></td>');
        $(row).append('<td class="text-center">' + arrObjItems[i].price_discounted + '</td>');
        $(row).append('<td class="text-center"><input type="number" class="hand_price" name="autokp_hand_price" value="' + arrObjItems[i].hand_price + '"></td>');
        $(row).append('<td class="text-center"><b>' + arrObjItems[i].price_sum + '</b></td>');
        $(row).append('<td class="text-center"><input type="text" class="delivery_time" name="autokp_delivery_time" value="' + arrObjItems[i].delivery_time + '"></td>');
        $(row).append('<td class="text-center"><button class="autokp_item_up">▲</button><button class="autokp_item_down">▼</button></td>');
        $('#autokp_table').append(row);
    }

    ajaxUpdateSession();

}

function calculation() {
    var sum = 0;
    for (var i = 0; i < arrObjItems.length; i++) {
        arrObjItems[i].price_uah = (arrObjItems[i].sales_price_value * $('#autokp_currency_rate').val()).toFixed(2);
        arrObjItems[i].price_discounted = (arrObjItems[i].price_uah - ((arrObjItems[i].price_uah / 100) * arrObjItems[i].discount)).toFixed(2);
        if (arrObjItems[i].hand_price === '') {
            arrObjItems[i].price_sum = (arrObjItems[i].qty * arrObjItems[i].price_discounted).toFixed(2);
        } else {
            arrObjItems[i].price_sum = (arrObjItems[i].qty * arrObjItems[i].hand_price).toFixed(2);
        }        
        sum += parseFloat(arrObjItems[i].price_sum);
        pricingDataObj.total_sum = sum.toFixed(2);
    }

    //common discount
    if (pricingDataObj.common_discount_status == 1) {
        for (var i = 0; i < arrObjItems.length; i++) {
            arrObjItems[i].discount = arrObjItems[0].discount;
        }
    }
}

tab.onclick = function (event) {
//    event.preventDefault();
    var target = event.target;

    //CHANGE ORDER ITEMS
    if (target.className === 'autokp_item_up') {
        var id = $(target).closest('.autokp_row').children('input[name="article_id"]').val();
        var index = findIndex(id);
        if (index - 1 >= 0) {
            var temp = arrObjItems[index - 1];
            arrObjItems[index - 1] = arrObjItems[index];
            arrObjItems[index] = temp;
            build();
        } else {
            alert('Куда уж выше ?? ');
        }
    }

    if (target.className === 'autokp_item_down') {
        var id = $(target).closest('.autokp_row').children('input[name="article_id"]').val();
        var index = findIndex(id);
        if (index + 1 <= arrObjItems.length - 1) {
            var temp = arrObjItems[index + 1];
            arrObjItems[index + 1] = arrObjItems[index];
            arrObjItems[index] = temp;
            build();
        } else {
            alert('Что, краёв не видишь? ');
        }
    }
    //CHANGE ORDER ITEMS      
};

tab.onchange = function (event) {
    event.preventDefault();
    var target = event.target;

    if (target.className === 'quantity') {
        var id = $(target).closest('.autokp_row').children('input[name="article_id"]').val();
        if ($(target).val() < 1) {
            arrObjItems[findIndex(id)].qty = 1;
        } else {
            arrObjItems[findIndex(id)].qty = $(target).val();
        }
        build();
    }
    if (target.className === 'discounts') {
        var id = $(target).closest('.autokp_row').children('input[name="article_id"]').val();
        if ($(target).val() < 0) {
            arrObjItems[findIndex(id)].discount = 0;
        } else if ($(target).val() > 100) {
            arrObjItems[findIndex(id)].discount = 100;
        } else {
            arrObjItems[findIndex(id)].discount = $(target).val();
        }
        build();
    }
    if (target.className === 'hand_price') {
        var id = $(target).closest('.autokp_row').children('input[name="article_id"]').val();
        arrObjItems[findIndex(id)].hand_price = $(target).val();
        build();
    }
    if (target.className === 'delivery_time') {
        var id = $(target).closest('.autokp_row').children('input[name="article_id"]').val();
        arrObjItems[findIndex(id)].delivery_time = $(target).val();
        build();
    }
    

    // SET ONE DISCOUNT FOR ALL ARTICLES
    if (target.id === 'oneDiscountForAll') {
        var arrDiscounts = document.getElementsByClassName('discounts');
        var commonDiscount = arrObjItems[0].discount;
//        console.log(arrObjItems);
        if (target.checked) {
            for (var i = 1; i < arrObjItems.length; i++) {
                arrObjItems[i].discount = commonDiscount;
                pricingDataObj.common_discount_status = 1;
            }
        } else {
            for (var i = 1; i < arrDiscounts.length; i++) {
                pricingDataObj.common_discount_status = 0;
            }
        }
        build();
    }

    //common discount
    if (pricingDataObj.common_discount_status == 1) {
        for (var i = 0; i < arrObjItems.length; i++) {
            arrObjItems[i].discount = arrObjItems[0].discount;
        }
        build();
    }

    // ИЗМЕНЕНИЕ РУЧНОГО ВВОДА ЦЕНЫ    
    if (target.className === 'hand_price') {
        target.value = ChangeComaToPoint(target.value);
        build();
    }// ИЗМЕНЕНИЕ РУЧНОГО ВВОДА ЦЕНЫ


};



tab.onwheel = function (event) {
    event.preventDefault();
    var target = event.target;

    //SCROLL DISCOUNTS
    if (target.className === 'discounts') {
        if (event.deltaY < 0)
            target.value = Number(target.value) + 5;
        else
            target.value = Number(target.value) - 5;


        if (target.value < 0) {
            target.value = 0;
//                alert('Скидка не может быть меньше 0%!');
        }
        if (target.value > 100) {
            target.value = 100;
//                alert('Скидка не может быть больше 100%!');
        }

        var id = $(target).closest('.autokp_row').children('input[name="article_id"]').val();
        arrObjItems[findIndex(id)].discount = $(target).val();

        //common discount
        if (pricingDataObj.common_discount_status == 1) {
            for (var i = 0; i < arrObjItems.length; i++) {
                arrObjItems[i].discount = arrObjItems[0].discount;
            }
        }
        build();
    }// discounts

    //SCROLL QUANTITIES
    if (target.className === 'quantity') {
        if (event.deltaY < 0) {
            target.value = Number(target.value) + 1;
        } else {
            target.value = Number(target.value) - 1;
        }

        if (target.value < 1) {
//                alert('К-во не может быть меньше 1!');
            target.value = 1;
//                console.log(target.value);
        }
        var id = $(target).closest('.autokp_row').children('input[name="article_id"]').val();
        arrObjItems[findIndex(id)].qty = $(target).val();
        build();
    }


};//tab.onwheel


//SCROLL CURRENCY
var currencyRate = document.getElementById('autokp_currency_rate');
currencyRate.onwheel = function (event) {
    event.preventDefault();
    if (event.deltaY > 0) {
        currencyRate.value = (Number(currencyRate.value) - 0.1).toFixed(1);
    } else {
        currencyRate.value = (Number(currencyRate.value) + 0.1).toFixed(1);
    }
    pricingDataObj.currency_rate = $(this).val();
    build();
};//currencyRate.onwheel


//CHANGE CURRENCY
currencyRate.onchange = function () {

    var currency = document.getElementById('autokp_currency_rate');
    if (currency.value !== '') {
        currency.value = ChangeComaToPoint(currency.value);
    } else {
        currency.value = 0;
    }

    pricingDataObj.currency_rate = $(this).val();
    build();
};//currencyRate.onchange


function findIndex(id) {
    for (var i = 0; i < arrObjItems.length; i++) {
        if (i == id) {
            return i;
        }
    }
}



// AJAX

/*GET ARRAY FROM SESSION*/
function ajaxItemsRequest(callBackFunc) {
    $.ajax({
        url: '',
        type: 'POST',
        data: {
            getArrFromSession: 'articles'
        },
        success: function (response) {
            if (response === -1) {
                alert('Нет товара для отображения');
            } else {
                callBackFunc(response);
            }
        }
    });
}


/*UPDATE SESSION*/
function ajaxUpdateSession() {
    $.ajax({
        url: '',
        type: 'POST',
        data: {
            update_session: 'update_session',
            autokp: arrObjItems,
            pricing_data: pricingDataObj
        },
        success: function (response) {
        }
    });
}


// Исправление "," на "."
function ChangeComaToPoint(string) {
    var str = string.split('');
    for (var i = 0; i < str.length; i++) {
        if (str[i] === ',') {
            str[i] = '.';
            return str.join('');
        }
    }//for i
//    console.log(string);
    return string;
}//CurrencyChangeComaToPoint()