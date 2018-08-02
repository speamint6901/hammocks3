<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Container extends \App\Models\Base
{
    //
    protected $table = "article_container";

    // user_item2container 1 : 多
    public function article2container() {
        return $this->hasMany('\App\Models\User\Item2Container', 'container_id');
    }

    /**
    * ステータスが公開状態のアイテムのみ取得するScope
    */
    public function scopeActive($query) {
        return $query->where('article_container.status', 1);
    }

    // ミューテタ (クリップカウント)
    public function getCountAttribute($value) {
        // 1k
        if ($value >= 1000 && $value < 10000000) {
            return round($count * 0.001, 1) . "K";
        } 
        if ($value >= 10000000) {
            return round($value * 0.0000001, 1) . "M";
        }
        return $value;
    }

    /**
    * ユーザーコンテナリストをユーザーIDとコンテナ名で抽出する
    *
    * @params $users_id         int      ユーザーID
    *         $container_name   string   コンテナ名
    * @return App\Models\User\Container
    */
    public static function checkByUsersIdAndName($users_id, $container_name, $is_master = 0) {
        if ($is_master) {
            $query = static::on("master")->where('users_id', $users_id);
        } else {
            $query = static::where('users_id', $users_id);
        }
        return $query->where('name', $container_name)
               ->count();
    }

    /**
    * ユーザーコンテナをusers_idでカウントする
    *
    * @params  $users_id  int   ユーザーID
    * @return  int
    */
    public static function getCountByUsersId($users_id, $is_master = 0) {
        if ($is_master) {
            $query = static::on("master")->where('users_id', $users_id);
        } else {
            $query = static::where('users_id', $users_id);
        }
        return $query->count();
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
        if (!$params["is_container_owner"]) {
            $query->active();
        }
        return self::getS($query);
    }

    /**
    * コンテナをidとusers_idで絞り込む（なりすまし回避)
    *
    * @params  $users_id     int  ユーザーID
    *          $container_id int コンテナID
    * @return  self
    */
    public static function findByUsersIdAndId($users_id, $id, $is_master = 0) {
        $query = static::where("id", $id)
                            ->where("users_id", $users_id);
        if ($is_master) {
            return $query->first();
        }
        return static::firstS($query);
    }

    /**
    * pickしてるかどうかをarticle_idとusers_idでチェックする
    *
    * @params $article_id  int  ログID
    *         $users_id    int  ユーザーID
    * @return int
    */
    public static function checkByArticleIdAndUsersId($article_id, $users_id) {
        $query = static::leftJoin("article2container", "article2container.container_id", "=", "article_container.id")
                        ->where("article_container.users_id", $users_id)
                        ->where("article2container.article_id", $article_id);
        $response = static::getS($query);
        if ($response->count() > 0) {
            return 1;
        }
        return 0;
    }
}
