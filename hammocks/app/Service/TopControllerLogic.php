<?php

namespace App\Service;

use App\Models\Users as User;
use App\Models\User\Container as Container;
use App\Models\User\Items as UserItems;
use App\Models\Items;

class TopControllerLogic extends Base {

    /**
    * ユーザーをidから一件取得する
    *
    * @params int $users_id  ユーザーID
    * @return App\User\Users
    */
    public static function getUserById($users_id) {
        //return User::on(self::getSlave())->find($users_id); 
        return User::find($users_id); 
    }

    /**
    * 基本情報をjoinしてidから一件取得する
    *
    * @params $users_id int ユーザーID
    * @return App\User\Users
    */
    public static function getUserInfoById($users_id) {
        return User::getUserInfoById($users_id);
    }

    /**
    * ユーザーIDからコンテナ一覧を取得する
    *
    * @params $users_id int ユーザーID
    * @return App\User\Container
    */
    public static function getContainerListByUserId($user_id) {
        return Container::getContainerListByUserId($user_id);
    }

    /**
    * ユーザーアイテム一覧を取得する
    * @params $params array sort, filter等の条件
    * @return \App\Models\User\Items
    */
    public static function getUserItemList($params = []) {
        return UserItems::getUserItemList($params);
    }
}
