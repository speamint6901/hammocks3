<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class SecretProfile extends \App\Models\Base 
{
    protected $table = "user_secret_profile";

    public $incrementing = false;
    protected $primaryKey = 'users_id';

    const CERTIFICATE_STATUS_NON = 0;      // アップロードもしてない
    const CERTIFICATE_STATUS_UPLOAD = 1;   // 書類アップロードのみの状態
    const CERTIFICATE_STATUS_ACCEPT = 2;   // 本人確認済み


    /**
    * users_idから一件取得
    *
    * @params $users_id  int  ユーザーID
    * @return self
    */
    public static function findByUsersId($users_id, $is_master = false) {
        
        $query = static::where("users_id", $users_id);
        
        if ($is_master) {
            return $query->first();    
        }

        return static::firstS($query);
    }

    /**
    * 基本情報更新
    *
    * @params  $users_id  int    ユーザーID
    *          $params    array  postデータ
    * @return  self
    */
    public function saveStandardData($params) {
        if ( ! empty($params["profile_name"])) {
            $this->name = $params["profile_name"];
        }
        if ( ! empty($params["profile_name_kana"])) {
            $this->name_kana = $params["profile_name_kana"];
        }
        if ( ! empty($params["prefecture"])) {
            $this->prefecture_id = $params["prefecture"];
        }
        if ( ! empty($params["city"])) {
            $this->city = $params["city"];
        }
        if ( ! empty($params["address"])) {
            $this->address = $params["address"];
        }
        if ( ! empty($params["post_code"])) {
            $this->post_code = $params["post_code"];
        }
        // birth 形式が yyyy-mm-ddの時のみ
        if ( ! empty($params["birth"])) {
            if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $params["birth"])) {
                $split_birth = explode("-", $params["birth"]);
            } elseif (preg_match("/^([0-9]{4})/([0-9]{2})/([0-9]{2})$/", $params["birth"])) {
                $split_birth = explode("/", $params["birth"]);
            }
            $this->birth_year = $split_birth[0];
            $this->birth_mon = $split_birth[1];
            $this->birth_day = $split_birth[2];
        }
        $this->save();
    }
}
