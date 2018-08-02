<?php

namespace App\Service;

use App\Models\User\Container as Container;
use App\Models\User\Item2Container as Item2Container;
use App\Models\User\Items as UserItems;

class UserGarageControllerLogic extends Base {

    /**
    * ユーザー諸々のカウント情報を取得する
    *
    * @params $users_id  int  ユーザーID
    * @return App\Models\User\InfoCount
    */
    public static function getGarageInfo($users_id) {
        $user_info = \App\Models\User\InfoCount::getUserInfoCountByUsersId($users_id);
        $tmp_user_info = [];
        $user_info["log_count"] = \App\Models\Article::getArticleList(["users_id" => $users_id])->count();
        foreach ($user_info->getAttributes() as $column => $value) {
            if (preg_match("/count/", $column)) {
                $tmp_user_info[$column] = self::getRoundNumAndExt($value);
            } else {
                $tmp_user_info[$column] = $value;
            }
        }
        return $tmp_user_info;
    }

    /**
    * コンテナをユーザーIDとコンテナIDで取得
    *
    * @params $users_id      int  ユーザーID
    *         $container_id  int  コンテナID
    * @return \App\Models\ArticleContainer
    */
    public static function findArticleContainer($users_id, $container_id) {
        return \App\Models\Article\Container::findByUsersIdAndId($users_id, $container_id);
    }
}
