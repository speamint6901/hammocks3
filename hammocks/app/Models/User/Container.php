<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Container extends \App\Models\Base
{
    //
    protected $table = "user_container";

    // user_item2container 1 : 多
    public function user_item2container() {
        return $this->hasMany('\App\Models\User\Item2Container', 'container_id', 'id');
    }

    /**
    * ユーザーコンテナリストをユーザーIDから抽出する
    *
    * @params $users_id int ユーザーID
    * @return App\Models\User\Container
    */
    public static function getContainersByUsersId($users_id) {
        $query = self::select('id', 'name')->where('users_id', $users_id);
        return self::getS($query);
    }

    /**
    * ユーザーコンテナリストをユーザーIDとコンテナ名で抽出する
    *
    * @params $users_id         int      ユーザーID
    *         $container_name   string   コンテナ名
    * @return App\Models\User\Container
    */
    public static function checkByUsersIdAndName($users_id, $container_name) {
        return static::where('users_id', $users_id)
                ->where('name', $container_name)
                ->count();
    }

    /**
    * ユーザーIDからコンテナ（クリップ）一覧を取得
    *
    * @params $users_id int     ユーザーID
    *         $params   array   postされたソート及びフィルター
    * @return self
    */
    public static function getByUsersId($users_id, $params) {
        $query = self::where('users_id', $users_id);
        return self::getS(self::setLimitOffset($query, $params));
    }
}
