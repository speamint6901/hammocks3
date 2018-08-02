<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusScope;

class Items extends Base 
{

    /**
    * brands  1:1
    */
    public function brands() {
        return $this->hasOne("\App\Models\Brands", "id", "brands_id");
    }

    /**
    * user_items 1:多
    */
    public function user_items() {
        return $this->hasMany("\App\Models\User\Items", "items_id", "id");
    }

    /**
    * category 1:1
    */
    public function category() {
        return $this->hasOne('\App\Models\Category', 'id', 'category_id');
    }

    /**
    * genre 1:1
    */
    public function genre() {
        return $this->hasOne('\App\Models\Genre', 'id', 'genre_id');
    }

    public static function scopeDefaultListSelect() {
        return static::select('items.id as items_id', 'user_items.id as user_items_id', 'items.name as name', 
                              'brands.name as brand_name', 'items.want_count as want_count',
                              'items.have_count as have_count', 'items.article_count',
                              'items.img_url as public_img', 'user_items.img_url as user_img',
                              'items.created_at as created_at', 'user_items.created_at as user_item_created_at');
    }

    // 非ログイン時のリストのデフォルトjoin
    public static function scopeDefaultListJoin() {
        return static::select('items.id as id', 'items.name as name', 
                              'brands.name as brand_name', 'items.want_count as want_count',
                              'items.have_count as have_count', 'items.article_count',
                              'items.img_url as public_img', 'items.created_at as created_at')
                      ->join('brands', 'brands.id', '=', 'items.brands_id');
    }

    // リストのデフォルトjoin
    public static function scopeDefaultLoginListJoin() {
        return static::select('items.id as id', 'items.name as name', 
                              'brands.name as brand_name', 'items.want_count as want_count',
                              'items.have_count as have_count', 'items.article_count',
                              'items.img_url as public_img', 'items.created_at as created_at',
                              'user_item_status.status as have_want_status')
                      ->join('brands', 'brands.id', '=', 'items.brands_id');
    }

    /**
    * scope default join
    */
    public function scopeDefaultJoin() {
        return static::select('items.id as items_id', 'items.description as description',
                              'items.category_id', 'items.genre_id', 'items.genre_second_id',
                              'items.name as name', 'brands.name_display as brand_name','items.status', 
                              'brands.id as brands_id', 'items.want_count as want_count',
                              'items.have_count as have_count', 'items.article_count', 'items.img_site_url',
                              'items.img_url as public_img', 'item_evaluation.average as average',
                              'genre.name as genre_name', 'category.name as category_name', 
                              'genre_second.name as genre_second_name', 'items.created_at as created_at')
                     ->join('brands', 'brands.id', '=', 'items.brands_id')
                     ->join('category', 'category.id', '=', 'items.category_id')
                     ->leftJoin('item_evaluation', 'item_evaluation.items_id', '=', 'items.id')
                     ->leftJoin('genre', 'genre.id', '=', 'items.genre_id')
                     ->leftJoin('genre_second', 'genre_second.id', '=', 'items.genre_second_id');
    }

    /**
    * findメソッドを上書きし、active判定を付与
    */
    public static function find($id) {
        return static::on(self::getSlave())->active()->find($id);
    }

    /**
    * allメソッドを上書きし、active判定を付与
    */
    public static function all($columns = []) {
        return static::on(self::getSlave())->active()->get();
    }

    /**
    * ステータスが公開状態のアイテムのみ取得するScope
    */
    public function scopeActive($query) {
        return $query->where('items.status', 1);
    }

    public function scopeItemStatus($query, $users_id) {
        return $query->where("user_item_status.users_id", "=", $users_id);
    }

    /**
    * アイテムをidで一件取得する
    *
    * @params $id  int アイテムID
    * @return \App\Models\Items
    */  
    public static function getItemById($id) {
        $query = self::defaultJoin()
                    ->where('items.id', $id)
                    ->active();
        return self::firstS($query);
    }

    /**
    * アイテムリスト取得（リストページ用）
    *
    * @params $params
    * @return self
    */
    public static function getItemDefaultList($params = [], $users_id = null) {
        // ログイン時
        if ( ! is_null($users_id) && ! empty($users_id)) {
            $query = self::with('user_items')->defaultLoginListJoin()
                        ->leftJoin("user_item_status", function($join) use ($users_id) {
                            $join->on("user_item_status.items_id", "=", "items.id")
                                 ->where("user_item_status.users_id", "=", $users_id);
                        });
        // 非ログイン時
        } else {
            $query = self::with('user_items')->defaultListJoin();
        }
        // フィルター、ソートがあれば
        if ( ! empty($params)) {
            $table = "items";
            // have,want フィルター
            if (isset($params["item_status"]) && ! empty($params["item_status"]) && ! is_null($users_id)) {
                $query->itemStatus($users_id);
            }
            // ソート条件がアイテム評価の場合
            if (isset($params["sort"]) && $params["sort"] === "average") {
                $table = "item_evaluation";
                $query->leftJoin("item_evaluation", "item_evaluation.items_id", "=", "items.id");
            }
            // big category が条件にあれば
            if (isset($params["big_category_id"]) && ! empty($params["big_category_id"])) {
                $query->join("category", "category.id", "=", "items.category_id")
                      ->where("category.big_category_id", $params["big_category_id"]);
            }
            $query = self::setConditionsItems($query, $params);
            $query = self::setSort($query, $params, $table);
        }
        $query->active();
        return $query;
        //return self::getS(self::setLimitOffset($query, $params, "items"));
    }

    /**
    * 条件に応じて、where句を付与
    *
    * @params $query   クエリビルダー
    *         $params
    * @return クエリビルダー
    */
    public static function setConditionsItems($query, $params) {

        // 全文検索
        if (isset($params['ids']) && ! empty($params['ids'])) {
            $query->whereIn('items.id', $params['ids']);
        }
        // 出品中か
        if (isset($params['is_store']) && ! empty($params['is_store'])) {
            $query->join('user_items', 'user_items.items_id', '=', 'items.id');
            $query->where('user_items.is_store', $params['is_store']);
        }

        // ブランドID
        if (isset($params['brands_id']) && ! empty($params['brands_id'])) {
            $query->where('brands_id', $params['brands_id']);
        }

        // カテゴリID
        if (isset($params['category_id']) && ! empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        // ジャンルID
        if (isset($params['genre_id']) && ! empty($params['genre_id'])) {
            $query->where('genre_id', $params['genre_id']);
        }

        // セカンドジャンルID
        if (isset($params['genre_second_id']) && ! empty($params['genre_second_id'])) {
            $query->where('genre_second_id', $params['genre_second_id']);
        }

        // have,want指定
        if (isset($params["item_status"]) && ! empty($params["item_status"])) {
            $query->where("user_item_status.status", $params["item_status"]);
        }

        return $query;
    }

    /**
    * アイテムをbrands_idで取得する
    * TODO ユーザーアイテムを表示するか相談
    *
    * @params $brands_id int ブランドID
    * @return \App\Models\Items
    */
    public static function getItemsByBrandsId($brands_id) {
        $query = self::defaultListSelect()
                        ->leftJoin('user_items', 'user_items.items_id', '=', 'items.id')
                        ->join('brands', 'brands.id', '=', 'items.brands_id')
                        ->where('items.brands_id', $brands_id)
                        ->active();
        return self::getS($query);
    }

    /**
    * アイテムをページング処理(ajax)でN件ずつ取得する
    *
    * @params $params  Array 　['sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\Items
    */
    public static function getItemList($params = []) {
        $query = self::defaultJoin();
        // フィルター分岐
        if (isset($params['item_status'])) {
            $query->join("user_item_status", "user_item_status.items_id", "=", "items.id")
                  ->where("user_item_status.status", $params["item_status"])
                  ->where('user_item_status.users_id', $params['owner_users_id']);
        }
        $query->active();
        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * アイテムリストをブランドIDで取得
    *
    * @params $brands_id  int  ブランドID
    * @return \App\Models\Items
    */  
    public static function getItemsByNameByBrandsId($brands_id) {
        $query = self::select('items.id', 'items.name')
                        ->where('items.brands_id', $brands_id)
                        ->active();
        return self::getS($query);
    }

    /**
    * カテゴリIDからアイテムリストを返す
    *
    * @params $params  array  検索パラメータ
    * @return self
    */
    public static function getItemsByAnyId($params) {
        $query = self::select('items.id', 'items.name as name', 'items.img_url as img_url', 'items.category_id',
                              'brands.id as brand_id', 'brands.name as brand_name')
                        ->join('brands', 'brands.id', '=', 'items.brands_id');
        if (isset($params['categories'])) {
            $query->where('items.'.$params['categories']['key'], $params['categories']['id']);
        }
        if (isset($params['brands']) && isset($params['categories'])) {
            $query->orWhere('items.'.$params['brands']['key'], $params['brands']['id']);
        } else {
            $query->Where('items.'.$params['brands']['key'], $params['brands']['id']);
        }
        $query->active();
        return self::getS($query);
    }

    /**
    * アイテム登録
    *
    * @params $input array 登録アイテム情報
    * @return void
    */
    public function saveItems($input, $file_info, $users_id) {
        $this->category_id = $input['GenreSelect'];
        $this->genre_id = !empty($input['Sub_GenreSelect']) ? $input['Sub_GenreSelect'] : null;
        $this->genre_second_id = !empty($input['Sub-sub_GenreSelect']) ? $input['Sub-sub_GenreSelect'] : null;
        $this->brands_id = $input['brand_id'];
        $this->name = $input['item_name'];
        $this->description = $input['item_description'];
        // TODO テスト用に常時アクティブ
	    $this->status = 1;
        $this->create_users_id = $users_id;
        $this->save();
        $group_dir = self::getGroupDir($this->id);
        $finish_path = self::makeGroupDir($file_info['path'], $group_dir);
        $this->img_url = $finish_path . $this->id . $file_info['ext'];
        if (isset($input['site_img_url']) && ! empty($input['site_img_url'])) {
            $this->img_site_url = $input['site_img_url'];
        }
        $this->save();
        return $this;
    }

    /**
    * アイテムを複数idとブランドIDで検索して返す
    *
    * @params  $ids         array  アイテムID複数
    *          $brands_id   int    ブランドID
    * @return  self
    */
    public static function getItemsListByIds($ids, $brands_id, $params) {
        $query = self::select('items.id as items_id', 'items.name as item_name',
                              'items.img_url as img_url', 'brands.name_display as brand_name')
                    ->join('brands', 'brands.id', '=', 'items.brands_id')
                    ->where('items.brands_id', $brands_id)
                    ->whereIn('items.id', $ids)
                    ->active();
        return self::getS($query);
    }

    /**
    * 管理画面用のアイテム一覧を取得
    *
    * @return self
    */
    public static function getItemsForAdminPage($params) {
        $query = self::defaultListJoin()
                   ->leftJoin("users", "users.id", "=", "items.create_users_id");
        if (isset($params["status"])) {
            $query->where("items.status", $params["status"]);
        }
        if (isset($params["id"]) && ! empty($params["id"])) {
            $query->where("items.id", $params["id"]);
        }
        $query->orderBy("items.created_at", "desc");
        return $query; 
    }

    /**
    * 管理画面用のアイテムをidで一件取得する
    *
    * @params $id  int アイテムID
    * @return \App\Models\Items
    */  
    public static function getItemDetailForAdminPage($id) {
        $query = self::defaultJoin()
                    ->where('items.id', $id);
        return self::firstS($query);
    }

    /**
    * 管理画面用のアイテムをidで一件取得する(公開非公開無視のfinder)
    *
    * @params $id  int アイテムID
    * @return \App\Models\Items
    */  
    public static function find_status_free($id) {
        return self::on("master")->find($id);
    }
}
