<?php defined('AKATECH') or die('Access Denied'); ?>


<div class="text-center">
    <br>
    <img src="<?=TEMPLATE?>/images/sorry.png" alt="Приносим извинения!" title="Sorry">
    <!--<h2>Этот раздел сайта ещё не готов! <br> Приносим извинения за неудобства!</h2>-->
    <h2>Цей розділ сайту ще не готовий! <br> Вибачте за незручності!</h2>
    <br>
    <!--<h2 style="text-transform:none;">Если Вас интересует данная продукция (каталоги, подбор аналогов, консультация и пр.), -->
    <!--    пожалуйста, позвоните нам или -->
    <!--    отправьте форму обратной связи представленную ниже.         -->
    <!--</h2>-->
     <h2 style="text-transform:none;">Якщо Ви зацікавлені у даній продукції (каталоги, підбір аналогів, консультація та інше), 
        будь ласка, передзвоніть нам або  
        надашліть форму зворотнього зв'язку.         
    </h2>
    <br>
</div>

<?php
$form_name = '';
$form_email = '';
$form_phone = '';
$form_company = '';
if (isset($_SESSION['guest_form_info'])) {
    $form_name = $_SESSION['guest_form_info']['name'];
    $form_email = $_SESSION['guest_form_info']['email'];
    $form_phone = $_SESSION['guest_form_info']['phone'];
    $form_company = $_SESSION['guest_form_info']['company'];
}
?>

<form id="form_contact_order_sheet3" class="text-center" role="form" method="post" onsubmit="FormSendOK()">	 


    <input type="text" name="name_order_sheet" value="<?= $form_name ?>" class="write_contact form-control" id="name_contact3" required="required" placeholder="Ваше имя *">
    <input type="email" name="email_order_sheet" value="<?= $form_email ?>" class="write_contact form-control" id="email_contact3" required="required" placeholder="Ваш e-mail *">
    <input type="tel" name="phone_order_sheet" value="<?= $form_phone ?>" class="write_contact form-control" id="phone_contact3" required="required" placeholder="Ваш телефон *">
    <input type="text" name="text_comp_order_sheet" value="<?= $form_company ?>" class="write_contact form-control" id="name_comp_contact3" required="required" placeholder="Название компании">
    <textarea name="text_comment_order_sheet" class="write_contact form-control" id="name_comment_contact3" placeholder="Ваше сообщение" rows="7"></textarea>

    <!--<p class="required text-left">Поля, отмеченные * , обязательны для заполнения</p>-->
    <p class="required text-left">Поля, відзначені * , є обов'язковими для заповнення</p>
    <!--<p class="text-center">После отправки формы наш сотрудник в кратчайший срок ответит Вам!</p>-->
    <p class="text-center">Після того, як Ви надішлете форму наш співробітник у найкоротший термін зв'яжеться з Вами. </p>
    <!--<button type="submit" name="feedback_form_submit" class="btn_write_review text-center" id="btn_order_sheet3">Отправить</button>													-->
    <button type="submit" name="feedback_form_submit" class="btn_write_review text-center" id="btn_order_sheet3">Надіслати</button>													

</form>