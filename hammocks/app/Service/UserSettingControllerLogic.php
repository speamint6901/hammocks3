<?php

namespace App\Service;

use App\Models\Users;

class UserSettingControllerLogic extends Base {


    /**
    * ユーザー詳細情報を取得する
    *
    * @params $users_id int ユーザーID
    * @return \App\Models\Users
    */
    public static function getUserInfo($users_id) {
        //return Users::getUserInfoById($users_id);
        return Users::find($users_id);
    }

}
