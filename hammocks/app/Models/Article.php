<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Base
{
    //
    protected $table = "article";

    /**
    * article2tags 1:多
    */
    public function article2tags() {
        return $this->hasMany('\App\Models\Article2Tags', 'article_id', 'id');
    }

    /**
    * article2container 1:多
    */
    public function article2container() {
        return $this->hasMany('\App\Models\Article2Container', 'article_id', 'id');
    }


    /**
    * user_items 多:1
    */
    public function user_items() {
        return $this->belongsTo('\App\Models\User\Items', 'user_items_id', 'id');
    }

    // ミューテタ
    public function getCreatedAtAttribute($value) {
        $date = date_create($value);
        return date_format($date, "Y.m.d");
    }

    /**
    * タイムライン取得時
    */
    public function scopeDefaultDetailJoin() {
        return static::select('article.id', 'article.user_items_id', 'article.users_id',
                              'article.title', 'article.article_text','user_items.users_id',
                              'article.img_url as article_img_url', 'article.created_at',
                              'items.id as items_id', 'items.name as items_name')
                     ->join('user_items', 'user_items.id', '=', 'article.user_items_id')
                     ->join('items', 'items.id', '=', 'user_items.items_id');
    }

    /**
    * 記事一覧(検索など)
    */
    public function scopeDefaultListJoin() {
        return static::select('article.id', 'article.user_items_id', 'article.users_id',
                              'users.avater_img_url', 'users.name as user_name', 'items.name as item_name', 
                              'user_items.id as user_items_id', 'user_items.users_id',
                              'brands.name as brand_name', 'article.img_url', 'article.created_at')
                     ->join('users', 'users.id', '=', 'article.users_id')
                     ->join('user_items', 'user_items.id', '=', 'article.user_items_id')
                     ->join('items', 'items.id', '=', 'user_items.items_id')
                     ->join('brands', 'brands.id', '=', 'items.brands_id');
    }

    /**
    * ステータスが公開状態のアイテムのみ取得するScope
    */
    public function scopeActive($query) {
        return $query->where('article.status', 1);
    }

    /**
    * 記事をidで一件取得
    *
    * @params $id  int  プライマリキー
    * @return \App\Models\Article(with article_paragraph)
    */
    public static function getArticleById($id) {
        $query = static::defaultDetailJoin()
                    ->where('article.id', $id);
        return static::firstS($query);
    }

    /**
    * タイムラインと同じ形式で１件取得
    *
    * @params $id  int  プライマリキー
    * @return \App\Models\Article
    */
    public static function findTimelineById($id) {
        $query = self::with('user_items', 'article2tags.tags');
        $query->where("article.id", $id);
        return static::firstS($query);
    }

    /**
    * 記事プレビューページ
    *
    * @params $id  int  プライマリキー
    * @return \App\Models\Article
    */
    public static function findDetailById($id) {
        $query = self::select("article.id as article_id", "article.article_text",
                              "article.img_url", "article.count as pick_count",
                              "user_items.id as user_items_id", "user_items.is_store",
                              "items.id as items_id", "items.name as items_name",
                              "brands.id as brands_id", "brands.name as brands_name",
                              "category.id as category_id", "category.name as category_name",
                              "genre.id as genre_id", "genre.name as genre_name",
                              "genre_second.id as genre_second_id", "genre_second.name as genre_second_name",
                              "users.id as users_id", "users.name as users_name", "users.avater_img_url")
                ->join("users", "users.id", "=", "article.users_id")
                ->join("user_items", "user_items.id", "=", "article.user_items_id")
                ->join("items", "items.id", "=", "user_items.items_id")
                ->join("brands", "brands.id", "=", "items.brands_id")
                ->leftJoin("category", "category.id", "=", "items.category_id")
                ->leftJoin("genre", "genre.id", "=", "items.genre_id")
                ->leftJoin("genre_second", "genre_second.id", "=", "items.genre_second_id");
        $query->where("article.id", $id);
        return static::firstS($query);
    }

    /**
    * 記事をidで一件取得
    *
    * @params $id  int  プライマリキー
    * @return \App\Models\Article(with article_paragraph)
    */
    public static function findArticleByIdAndUsersId($id, $users_id, $is_master = 0) {
        $query = static::defaultDetailJoin()
                    ->where('article.id', $id)
                    ->where('article.users_id', $users_id);
        if ($is_master) {
            return $query->first();
        }
        return static::firstS($query);
    }

    /**
    * 記事一覧を取得
    *
    * @params $items_id  int    アイテムID
    *         $params    array  ['sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\Article
    */
    public static function getArticleList($params) {
        $query = static::defaultListJoin();
        if ( ! empty($params)) {
            // コンテナの中身
            if (isset($params['container_id']) && ! empty($params['container_id'])) {
                $query->leftJoin("article2container", "article2container.article_id", "=", "article.id");
                $query->where("article2container.container_id", $params["container_id"])
                      ->where("article2container.deleted_at", null);
            }
            // タグ検索
            if (isset($params['tags_id']) && ! empty($params['tags_id'])) {
                $query->leftJoin("article2tags", "article2tags.article_id", "=", "article.id")
                      ->where('article2tags.tags_id', $params['tags_id'])
                      ->where('article2tags.deleted_at', null);
            }
            $qpery = static::setMyConditions($query, $params);
            $query = static::setSort($query, $params, "article");
        }
        return $query;
        //return static::getS(self::setLimitOffset($query, $params, 'article'));
    }

    /**
    * タイムラインを取得
    *
    * @params $params   array  ['sort' => ,'offset' => ,'limit' => , ... ]
    * @return \App\Models\Article
    */
    public static function getTimelineByAnyId($params) {
        $query = self::with('user_items', 'article2tags.tags');
        if ( ! empty($params)) {
            $qpery = static::setMyConditions($query, $params);
            $query = static::setSort($query, $params, "article");
        }
        return $query;
    }

    /**
    * 記事一覧をパラメータによって条件を付ける
    *
    * @params $params array  クライアントからの条件 
    * @return \App\Models\Article(with article_paragraph)
    */
    protected static function setMyConditions($query, $params) {
        
        // フォロー中のユーザー記事
        if (isset($params['follow_user_ids']) && ! empty($params['follow_user_ids'])) {
            $query->whereIn('article.users_id', $params['follow_user_ids']);
        }

        // 全文検索
        if (isset($params["ids"]) && ! empty($params["ids"])) {
            $query->whereIn('article.id', $params['ids']);
        }

        // ユーザーアイテムIDで絞り込む
        if (isset($params['user_items_id']) && ! empty($params['user_items_id'])) {
            $query->where('article.user_items_id', $params['user_items_id']);
        }

        // アイテムIDで絞り込む
        if (isset($params['items_id']) && ! empty($params['items_id'])) {
            $query->where('user_items.items_id', $params['items_id']);
        }

        // ユーザーIDで絞り込む
        if (isset($params['users_id']) && ! empty($params['users_id'])) {
            $query->where('article.users_id', $params['users_id']);
        }

        // ブランドで絞り込む
        if (isset($params['brands_id']) && ! empty($params['brands_id'])) {
            $query->where('items.brands_id', $params['brands_id']);
        }

        return $query;
    }

    /**
    * 記事登録
    *
    * @params $input array 登録記事情報
    * @return App\Models\Article
    */
    public function saveArticle($input, $users_id, $user_items_id, $file_info) {
        $this->users_id = $users_id;
        $this->user_items_id = $user_items_id;
        $this->article_text = $input['item_description'];
        $this->save();
        if ( ! is_null($file_info)) {
            $group_dir = self::getGroupDir($this->id);
            $finish_path = self::makeGroupDir($file_info['path'], $group_dir);
            $this->img_url = $finish_path . $this->id . $file_info['ext'];
            $this->save();
        }
        return $this;
    }

    /**
    * 記事削除
    *
    * @return void
    */
    public function deleteArticleRelations() {

        // カウント関連を更新
        // itemsのカウント減らす
        $user_items = \App\Models\User\Items::on("master")->find($this->user_items_id);
        $user_items->items()->decrement("article_count");

        // 関連コンテナの削除
        $this->article2container()->forceDelete();
        // 関連タグの削除
        $this->article2tags()->forceDelete();
        // 最後に記事削除
        $this->delete();
    }

}
