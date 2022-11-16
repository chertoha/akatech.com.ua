<?php  // Auth/index.php
//var_dump($_POST);
//var_dump($_SESSION);
//var_dump($_COOKIE);
?>

<div class="auth_form">

    <form method="POST" action="">
        <h2>AKA-Tools</h2>                
        <label for="user_id">Login</label><br>
        <select id="login" style="width:180px; height:30px;" class="input_form" name="user_id">
            <?php foreach ($arr_all_users as $user): ?>
                <option value="<?php echo $user['user_id'] ?>"><?php echo $user['user_name'].' '. $user['user_lastname'] ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <!--<input id="login" style="width:180px; height:30px;" class="input_form" name="login" type="text"><br>-->

        <label for="pswrd">Password</label><br>
        <input id="pswrd" style="width:180px; height:30px;" class="input_form" name="password" type="password"><br>
        <input id="rememberme" checked name="remember" type="checkbox">
        <label for="rememberme">Remember Me</label><br>
        <input type="submit" style="width:180px; height:30px;" value="Log in" name="auth_login"><br>
        <span class="error"><?= $error ?></span>
    </form>


</div>

