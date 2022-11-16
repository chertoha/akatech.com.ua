<?php

namespace app\models;

use app\core\Model;

class Auth extends Model {

    private $user_id = '';
    private $user_name = '';
    private $user_lastname = '';
    private $login = '';
    private $password = '';
    private $token = '';
    private $ip = '';
    private $role_id = '';
    private $user_avatar_image = '';
    public $error = '';
    public $authorized = false;
    private $rememeber = false;

    public function getUsers() {
        $params = [
            'allowed' => USER_ALLOWED_VALUE,
        ];
        $result = $this->db->row('SELECT * FROM auth_users WHERE user_allowed= :allowed', $params);
        return $result;
    }

    public function getUserById($id) {
        $params = [
            'id' => $id,
        ];
        $result = $this->db->row('SELECT * FROM auth_users u LEFT JOIN auth_roles r ON r.role_id=u.user_role_id WHERE user_id= :id', $params);
        return $result[0];
    }

    public function authorization() {
        $this->isLoginEmpty();
        $this->isTokenIsset();
        $this->isSessionExist();
        $this->authorize();
    }

    private function isLoginEmpty() {
        if (isset($_POST['login']) && ($_POST['login'] === '' || $_POST['password'] === '')) {// IF FIELDS ARE EMPTY
            $this->error = 'EMPTY Login or Password!';
            return;
        }
    }

    private function isTokenIsset() {
        if (isset($_COOKIE['token'])) {// TOKEN EXISTS
            $this->token = $_COOKIE['token'];

            $query = "  SELECT u.user_id, t.auth_user_ip, t.auth_token_value, u.user_login 
                        FROM auth_tokens t left join auth_users u
                        on t.auth_user_id=u.user_id
                        WHERE t.auth_token_value= :token
                     ";
            $params = [
                'token' => $this->token,
            ];

            $res = $this->db->row($query, $params);
            if (count($res) == 1) {
                $res = $res[0];
                if ($res['auth_user_ip'] === $_SERVER['REMOTE_ADDR'] && $res['auth_token_value'] === $_COOKIE['token']) {
                    $_SESSION['auth'] = $this->getUserById($res['user_id']);
                }
            }
        }
    }

    private function isSessionExist() {
        if (isset($_SESSION['auth'])) {// SESSION EXISTS
            if (isset($_POST['logout'])) {// LOG OUT
                setcookie('token', null, -1);
                session_unset();
                session_destroy();
                $this->authorized = false;
                return;
            } else {                   // SESSION IS STILL OPENED
                $this->authorized = true;
            }
        }
    }

    private function authorize() {
        if (isset($_POST['user_id'])) {//AUTHORIZATION
            $user_id = $_POST['user_id'];
            $password = md5($_POST['password']);

            $query = "SELECT * FROM auth_users u LEFT JOIN auth_roles r ON r.role_id=u.user_role_id WHERE user_id= :user_id AND user_password= :password";
            $params = [
                'user_id' => $user_id,
                'password' => $password,
            ];
            $res = $this->db->row($query, $params);

            if (count($res) == 0) {
                $this->error = 'WRONG Login or Password!';
            } else if (count($res) == 1) {
                $this->authorized = true;
                $res = $res[0];
                $this->user_id = $res['user_id'];
                $this->user_name = $res['user_name'];
                $this->user_lastname = $res['user_lastname'];
                $this->login = $res['user_login'];
                $this->password = $res['user_password'];
                $this->role_id = $res['user_role_id'];
                $this->user_avatar_image = $res['user_avatar_image'];
                $this->ip = $_SERVER['REMOTE_ADDR'];

                $auth_data = [
                    'user_id' => (int) $this->user_id,
                    'user_name' => $this->user_name,
                    'user_lastname' => $this->user_lastname,
                    'user_login' => $this->login,
                    'user_ip_address' => $this->ip,
                    'user_role_id' => (int) $this->role_id,
                    'role_name' => $res['role_name'],
                    'user_avatar_image' => $this->user_avatar_image,
                ];
//                $_SESSION['auth'] = $this->login;
                $_SESSION['auth'] = $auth_data;
//                $_SESSION['auth_data'] = $auth_data;

                if (isset($_POST['remember']) && $_POST['remember'] === 'on') {
                    $this->rememeber = true;
                }//if remember                
            }//else if
            //
            //
            //Set cookie 
            if (!isset($_COOKIE['token'])) {
                if ($this->rememeber) {
                    $hash = md5($this->ip . $this->user_id . $this->login . $this->password . time());
                    $params = [
                        'user_id' => $this->user_id,
                        'ip' => $this->ip,
                        'hash' => $hash,
                    ];
                    $sql = "INSERT INTO auth_tokens SET auth_user_id= :user_id, auth_user_ip= :ip, auth_token_value= :hash";
                    $this->db->query($sql, $params);

                    setcookie('token', $hash, time() + 24*60*60);
                }//if 
            }
        }//if check login&password
    }

}
