<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Base 
{
    // 画像のタイプcache key
    const USER_AVATER_KEY = "user_avater";
    const USER_BACKGROUND_KEY = "user_background";
    const USER_IDENTIFICATION_KEY = "identification";

    public static $image_path_list = [
        self::USER_AVATER_KEY => "avater",
        self::USER_BACKGROUND_KEY => "background",
        self::USER_IDENTIFICATION_KEY => "identification",
    ];

    /**
    * user_profile　1:1
    */
    public function profile() {
        return $this->hasOne("\App\Models\User\Profile", 'users_id', 'id');
    }

    /**
    * user_secret_profile 1:1
    */
    public function secret_profile() {
        return $this->hasOne("\App\Models\User\SecretProfile", "users_id", "id");
    }

    /**
    * user_items 1:many
    */
    public function items() {
        return $this->hasMany("\App\Models\User\Items");
    }

    /**
    * user_payments  1:many
    */
    public function payments() {
        return $this->hasMany("\App\Models\User\Payments");
    }

    /**
    * user_item_evaluation_users  1:many
    */
    public function item_evaluation_users() {
        return $this->hasMany("\App\Models\User\ItemEvaluationUsers");
    }

    /**
    * default join
    */
    public static function defaultJoin() {
        return static::select('users.id as user_id', 'users.name as name', 
                              'users.avater_img_url as avater_img_url', 'user_profile.*')
                    ->join('user_profile', 'users.id', '=', 'user_profile.users_id');
    }

    
    /**
    * user_id からコンテナリストを取得する
    * 
    * @param  int  $user_id  ユーザーID
    * @return App\Models\User\UserContanier
    */
    public static function getContanerListByUserId($user_id) {
        $query = self::query()->orderBy('created_at', 'desc');
        $user_list = self::getS($query);
        foreach ($user_list as $u) {
            var_dump($u->user_items);
        }
    }

    /**
    * 基本情報をjoinしてidから一件取得する
    *
    * @params int @users_id ユーザーID
    * @return App\User\Users
    */
    public static function getUserInfoById($users_id) {
        $query = self::defaultJoin()->where('users.id', $users_id);
        return self::firstS($query);
    }

    /**
    * ユーザーの画像系を更新
    *
    * @oarams array $image
    * @return self
    */
    public function updateImages($image, $file_info) {
        $file_info = $file_info[$image["cache_key"]];
        $group_dir = self::getGroupDir($this->id);
        $finish_path = self::makeGroupDir($file_info['path'], $group_dir);
        if ($image["cache_key"] == self::USER_AVATER_KEY) {
            // アバターのみドメイン + パスで保存
            $full_path = \Config::get("app.url") . self::getStoragePath();
            $this->avater_img_url = $full_path . $finish_path . $this->id . $file_info['ext'];
            $res_avater_img_url = $finish_path . $this->id . $file_info['ext'];
            $this->save();
            return $res_avater_img_url;
        } else {
            $this->profile->avater_background_url = $finish_path . $this->id . $file_info['ext'];
            $this->profile->save();
            return $this->profile->avater_background_url;
        }
    }
}
