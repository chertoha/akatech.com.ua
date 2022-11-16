<?php


function Init(){
 
    //Отправка запроса (КОРЗИНА)+ запись инфо в сессию
    if (isset($_POST['btn_order_sheet'])){            
        $_SESSION['guest_form_info']['name'] = $_POST['name_order_sheet'];
        $_SESSION['guest_form_info']['email'] = $_POST['email_order_sheet'];
        $_SESSION['guest_form_info']['phone'] = $_POST['phone_order_sheet'];
        $_SESSION['guest_form_info']['company'] = $_POST['text_comp_order_sheet'];            
        
        
        if (isset ($_POST['g-recaptcha-response'])){
            
            $captcha_google_url = "https://www.google.com/recaptcha/api/siteverify";
            $captcha_google_key = "6Le9HlAUAAAAAAw9WwD_Ppph1mNq1nOi8dGfu07f";
            $captcha_google_query = $captcha_google_url.'?secret='.$captcha_google_key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];
            
            $captcha_google_result = json_decode(file_get_contents($captcha_google_query));
            
            //var_dump($captcha_google_result);
            //echo $captcha_google_query;
//            var_dump($_POST);
            
            if ($captcha_google_result->success){
                 $customer_name = $_POST['name_order_sheet'];
                 $customer_email = $_POST['email_order_sheet'];
                 $customer_tel = $_POST['phone_order_sheet'];
                 $customer_company = $_POST['text_comp_order_sheet'];
                 $customer_comment = $_POST['text_comment_order_sheet'];

                 $request_id = '';

                 $link = ConnectDB();
                 $link->query("INSERT INTO customer_request SET customer_name='$customer_name', customer_email='$customer_email', customer_tel='$customer_tel', customer_company='$customer_company', customer_comment='$customer_comment', request_date=(NOW())");
                 $request_id = $link->insert_id;

                 $product_tab = '<table border="1"><tr><th>№</th><th>Артикул</th><th>К-во</th></tr>';  

                 for ($i = 0; $i < count($_POST['product_article']) ; $i++){
                     $prod_id = $_POST['prod_id'][$i];     
                     $prod_qty = $_POST['product_quantity'][$i];   
                     $product_tab .= '<tr><td>'.($i+1).'</td><td>'.$_POST['product_article'][$i].' '.$_POST['product_info'][$i].'</td><td>'.$_POST['product_quantity'][$i].'</td></tr>';

                     $link->query("INSERT INTO customer_request_products SET customer_request_id='$request_id', prod_id='$prod_id', prod_quantity='$prod_qty'");
                 }        

                 $product_tab .= '</table>';


                 $link->close();

                 $to = REQUEST_EMAIL;
                 $subject = 'Запрос, '.$customer_company;
                 $message = '<html> 
                                 <head> 
                                     <title>Запрос стоимости</title> 
                                 </head> 
                                 <body> 
                                     <h3>Запрос стоимости</h3>
                                     <p>
                                         Имя: '.$customer_name.'<br>
                                         Email: '.$customer_email.'<br>    
                                         Тел: '.$customer_tel.'<br> 
                                         Компания: '.$customer_company.'<br> 
                                     </p>                            
                                     <p>
                                         '.$product_tab.'
                                     </p>   
                                     <p>
                                         Комментарий: '.$customer_comment.'<br>
                                     </p>     

                                 </body> 
                             </html>';
                 $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
                 $headers .= "From: REQUEST <sendphpmailserver@akatech.com.ua>\r\n";         
                 mail($to, $subject, $message, $headers); 
            }// if success
                
        }
        
        //Очистка корзины
        unset($_SESSION['cart']);
        
        
    }//Отправка запроса
    
    
    
    //Отправка формы обратной связи
    if (isset($_POST['feedback_form_submit'])){            
        $_SESSION['guest_form_info']['name'] = $_POST['name_order_sheet'];
        $_SESSION['guest_form_info']['email'] = $_POST['email_order_sheet'];
        $_SESSION['guest_form_info']['phone'] = $_POST['phone_order_sheet'];
        $_SESSION['guest_form_info']['company'] = $_POST['text_comp_order_sheet'];            

                
        $to = REQUEST_EMAIL;
        $subject = 'Форма обратной связи, '.$_POST['text_comp_order_sheet'];
        $message = '<html> 
                        <head> 
                            <title>Форма обратной связи</title> 
                        </head> 
                        <body>                             
                            <p>
                                Имя: '.$_POST['name_order_sheet'].'<br>
                                Email: '.$_POST['email_order_sheet'].'<br>    
                                Тел: '.$_POST['phone_order_sheet'].'<br> 
                                Компания: '.$_POST['text_comp_order_sheet'].'<br> 
                            </p>                           
                              
                            <p>
                                Сообщение: '.$_POST['text_comment_order_sheet'].'<br>
                            </p>     
                            
                        </body> 
                    </html>';
        $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
        $headers .= "From: QUESTION <sendphpmailserver@akatech.com.ua>\r\n";         
        mail($to, $subject, $message, $headers);
        
    }//
    
}//init