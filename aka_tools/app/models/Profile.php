<?php

namespace app\models;

use app\core\Model;

class Profile extends Model {

    public function getProfileDataList() {
        return $this->db->row('SELECT * FROM profile_data');
    }

    public function orderArrByKey($arr, $key_name) {// [val3] => [key1=>val1, key2=>val2, key3=>val3] ...
        $new_arr = [];
        foreach ($arr as $sub_arr) {
            $new_arr[$sub_arr[$key_name]] = $sub_arr;
        }
        ksort($new_arr);
        return $new_arr;
    }
    
    public function getAvatar($user_id){
        return $this->db->column('SELECT user_avatar_image FROM auth_users WHERE user_id= :id', ['id' => $user_id]);
    }

    public function downloadAvatar($image_data, $user_id) {
        $type = $image_data['type'];
        $tmp_name = $image_data['tmp_name'];
        $name = $image_data['name'];
        $size = $image_data['size'];
        if ($size > 500000) {
            return 'Файл должен быть не более 500кБ';
        }
        if ($type != 'image/jpeg' && $type != 'image/jpg' && $type != 'image/png' && $type != 'image/gif') {
            return 'Поддерживются форматы: jpg, png, gif';
        }

        $pic = getimagesize($tmp_name);
        $file_ext = image_type_to_extension($pic[2], false);

        $new_filename = uniqid() . '.' . $file_ext;
        $path = ROOT.IMAGES_FOLDER.'avatars/'.$new_filename;
        move_uploaded_file($tmp_name, $path);
        
        $params = [
            'id' => $user_id,
            'avatar' => $new_filename,
        ]; 
        $this->db->query('UPDATE auth_users SET user_avatar_image= :avatar WHERE user_id= :id', $params);
        
        return '<span style="color:green;">Аватар загружен</span>';
    }
    
    

}
