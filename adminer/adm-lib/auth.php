<?php

class Auth{
    private $user_id = '';
    private $login = '';
    private $password = '';
    private $token = '';
    private $ip = '';
    public $authorized = false;
    private $rememeber = false;
    private $error = '';
    
    
    /*-----------Show Authorization Form------------*/
    public function AuthResult(){
        $html_result = '<div class="auth_form">';
        $html_result.= '<form method="POST" action="">';
        
        if($this->authorized){
            $html_result.= '<input type="submit" name="logout" value="Log out">';            
        }
        else{
            $html_result.= '<label for="login">Login</label><br>';
            $html_result.= '<input id="login" class="input_form" name="login" type="text"><br>';
            $html_result.= '<label for="pswrd">Password</label><br>';
            $html_result.= '<input id="pswrd" class="input_form" name="password" type="password"><br>';
            $html_result.= '<input id="rememberme" name="remember" type="checkbox">'; 
            $html_result.= '<label for="rememberme">Remember Me</label><br>';
            $html_result.= '<input type="submit" value="Log in"><br>';  
            
        }
        $html_result.='<span class="error">'.$this->error.'</span>';
        $html_result.= '</form></div>';
        
        return $html_result;
    }//AuthResult();
    
    
    
    /*-----------Check authorization------------*/
    public function Authorization(){
        
        
        if (isset($_POST['login']) && ($_POST['login']==='' || $_POST['password']==='')){// IF FIELDS ARE EMPTY
            $this->error = 'EMPTY Login or Password!';
            return;
        }//if Form is empty
        
        
        if (isset($_COOKIE['token'])){// TOKEN EXISTS
            $token = $_COOKIE['token']; 
            
            $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
            $this->CheckConnectionDB($link);// check connection
            $query = "  SELECT t.adm_user_ip, t.adm_token_value, u.adm_user_login 
                        FROM adminer_tokens t left join adminer_users u
                        on t.adm_user_id=u.adm_user_id
                        WHERE t.adm_token_value='$token'
                     ";
            $query_result = $link->query($query);            
            $link->close();
           
            if ($query_result->num_rows == 1){
                $res = $query_result->fetch_assoc();
                if ($res['adm_user_ip'] === $_SERVER['REMOTE_ADDR'] && $res['adm_token_value'] === $_COOKIE['token']){
                    $_SESSION['auth']= $res['adm_user_login'];
//                    echo $_SESSION['auth'];
                }
            }//if 
        }//if TOKEN EXISTS
        
        
        if (isset($_SESSION['auth'])){// SESSION EXISTS
            if (isset($_POST['logout'])){// LOG OUT
                setcookie('token', null, -1);           
                session_unset();
                session_destroy(); 
                $this->authorized = false;
                return;
            }
            else {                      // SESSION IS STILL OPENED
                $this->authorized = true;
            }
        }//check SESSION
        
        
        if (isset($_POST['login'])){//AUTHORIZATION
            $login = $_POST['login'];
            $password = md5($_POST['password']);
            
            
            //link to DB
            $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);            
            $this->CheckConnectionDB($link);
            
            $query = "SELECT * FROM adminer_users WHERE adm_user_login='$login' and adm_user_password='$password'";
            $query_result = $link->query($query);
            $link->close();
            
            if ($query_result->num_rows == 0){
                $this->error = 'WRONG Login or Password!';                
            }
            else if($query_result->num_rows == 1){
                $this->authorized = true;
                $row = $query_result->fetch_assoc();
                $this->user_id = $row['adm_user_id'];
                $this->login = $row['adm_user_login'];
                $this->password = $row['adm_user_password'];   
                $this->ip = $_SERVER['REMOTE_ADDR'];
                $_SESSION['auth'] = $this->login;
                if (isset($_POST['remember']) && $_POST['remember']==='on'){
                    $this->rememeber = true;
                }//if remember                
            }//else if
            
            $query_result->free();            
                        
            //Set cookie 
            if ($this->rememeber){
                $link = new mysqli(ADM_HOST, ADM_USER, ADM_PASS, ADM_DB);
                $this->CheckConnectionDB($link);
                $hash = md5($this->ip.   $this->user_id.    $this->login.   $this->password.    time());
                $link->query("INSERT INTO adminer_tokens SET adm_user_id='$this->user_id', adm_user_ip='$this->ip', adm_token_value='$hash'");
                $link->close();
                setcookie('token',$hash, time()+86400);
            }//if
            
        }//if check login&password
        
        
        
    }//Authorization
    
    
    
    // IF NO CONNECTION TO DATA BASE
    public function CheckConnectionDB($link){
        if (!empty($link->connect_error)){
            die('No connection to database, error:'.$link->connect_error);
        } 
    }//CheckConnectionDB()
}//class User
