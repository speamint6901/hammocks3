<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article2Container extends Base
{
    //
    protected $table = "article2container";

    // user_item2container 1 : 多
    public function article() {
        return $this->hasOne('\App\Models\Article', 'id', "article_id");
    }

    /**
    * article_container 1:1
    */
    public function article_container() {
        return $this->hasOne('\App\Models\Article\Container', 'id');
    }

    /**
    * ユーザーIDからコンテナアイテム（クリップ）一覧を取得
    *
    * @params $users_id int     ユーザーID
    *         $params   array   postされたソート及びフィルター
    * @return self
    */
    public static function getContainerItems($container_id, $params) {
        $query = self::with('article')->where('container_id', $container_id)->orderBy("created_at", "desc");
        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * pickをarticle_idとcontainer_idで一件取得
    *
    * @params  $article_id    int  記事ID
    *          $container_id  int  コンテナID
    * @return  self
    */
    public static function findByArticleIdAndContainerId($article_id, $container_id, $is_master = 0) {
        $query = static::where("article_id", $article_id)
                            ->where("container_id", $container_id);

        if ($is_master) {
            return $query->first();
        }
        return static::firstS($query);
    }

    public static function hasPickInArticle($users_id, $article_id) {
        $query = static::join("article", "article.id", "=", "article2container.article_id")
                        ->join("article_container", "article_container.id", "=", "article2container.container_id")
                        ->where("article_container.users_id", $users_id)
                        ->where("article2container.article_id", $article_id);
        return static::getS($query);
    }

    /**
    * articleとcontainerの紐付けを消す
    *
    * @params $container_id  int  コンテナID
    *         $article_id    int  ログID
    * @return void
    */ 
    public static function deleteArticleByArticleId($container_id, $article_id) {
        static::where("container_id", $container_id)
                ->where("article_id", $article_id)
                ->delete();   
    }

    /**
    * container_idで削除してarticle_idのリストを返す
    *
    * @params  $container_id  int  コンテナID
    * @return  array
    */
    public static function deleteByContainerId($container_id) {
        $article = static::select("article_id")
                        ->where("container_id", $container_id)
                        ->get()->toArray();

        static::where("container_id", $container_id)->delete();
        return $article;
    }

}
