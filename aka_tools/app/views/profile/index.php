<?php
//var_dump($_SESSION);
//var_dump($_POST);
//var_dump($_FILES);
//var_dump($profile_data_list);
?>

<h3>Профиль</h3>
<p>Здравствуйте  <?= $_SESSION['auth']['user_name'] ?></p>
<div class="container">
    
    <div class="row">
        <div class="col-lg-4 buttons"> </div>
        <div class="col-sm-3 col-md-2">
            <h4>Загрузить аватарку</h4>
            <div class="">
                <?php $avatar = ($avatar_image == '') ? 'default-avatar.png' : $avatar_image ; ?>
                <a href="#" class="thumbnail"><img src="<?= IMAGES_FOLDER ?>avatars/<?=$avatar?>" alt="avatar"></a>
                <div class="caption">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">                            
                            <input type="hidden" name="user_id" value="<?= $_SESSION['auth']['user_id'] ?>">
                            <input style="padding-bottom: 10px;" type="file" name="avatar_image" class="form-control-file">
                            <!--<br>-->
                            <input type="submit" class="btn btn-success btn-sm" name="avatar_download" value="Загрузить">
                            <!--<br>-->
                            <br>
                            <span class="error"><?= $errors ?></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  
</div>   




<!--<div class="container">
    <div class="row">
        <div class="col-lg-1 buttons"> </div>

        <div class="col-lg-6 buttons">

            <form class="form-horizontal" method="POST" action="">

                <div class="form-group">                                      
                    <label class="control-label col-xs-3">Дата рождения:</label>
                    <div class="col-xs-3">
                        <input type="hidden" name="" value="">
                        <input type="date" name="birthdate" value="">
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3" for="inputEmail">Email:</label>
                    <div class="col-xs-9">
                        <input type="email" class="form-control" name="user_email" id="inputEmail" placeholder="Email">
                    </div>
                </div>                
                <div class="form-group">
                    <label class="control-label col-xs-3" for="phoneNumber">Телефон рабочий:</label>
                    <div class="col-xs-9">
                        <input type="tel" class="form-control" id="phoneNumber" placeholder="Введите номер телефона">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3" for="phoneNumber">Телефон личный:</label>
                    <div class="col-xs-9">
                        <input type="tel" class="form-control" id="phoneNumber" placeholder="Введите номер телефона">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3" for="phoneNumber">Телефон личный:</label>
                    <div class="col-xs-9">
                        <input type="tel" class="form-control" id="phoneNumber" placeholder="Введите номер телефона">
                    </div>
                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3" for="postalAddress">Адрес:</label>
                                    <div class="col-xs-9">
                                        <textarea rows="3" class="form-control" id="postalAddress" placeholder="Введите адрес"></textarea>
                                    </div>
                                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">Пол:</label>
                    <div class="col-xs-2">
                        <label class="radio-inline">
                            <input type="radio" name="genderRadios" value="male"> Мужской
                        </label>
                    </div>
                    <div class="col-xs-2">
                        <label class="radio-inline">
                            <input type="radio" name="genderRadios" value="female"> Женский
                        </label>
                    </div>
                </div>
                                <div class="form-group">
                                    <div class="col-xs-offset-3 col-xs-9">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="agree">  Я согласен с <a href="#">условиями</a>.
                                        </label>
                                    </div>
                                </div>
                <br />
                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                        <input type="reset" class="btn btn-default" value="Очистить форму">
                    </div>
                </div>
            </form>


        </div>

        <div class="col-lg-5 buttons"> </div>
    </div>

</div>-->



