<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusScope;
use App\Models\User\ItemStatus as ItemStatus;
use App\Models\User\Item2Container as Item2Container;
use App\Models\Items as PublicItems;

class Items extends \App\Models\Base 
{
    protected $table = "user_items";

    const COUNT_TYPE_HAVE = 1;
    const COUNT_TYPE_WANT = 2;

    protected static $_count_column = [
        self::COUNT_TYPE_HAVE => "have_count",
        self::COUNT_TYPE_WANT => "want_count",
    ];

    const COUNT_UPDATE_TYPE_ADD = 1;
    const COUNT_UPDATE_TYPE_SUB = 2;

    /**
    * article 1:多
    */
    public function article() {
        return $this->hasMany('\App\Models\Article', 'id', 'user_items_id');
    }

    /**
    * items 1:1
    */
    public function items() {
        return $this->hasOne('\App\Models\Items', 'id', 'items_id');
    }

    /**
    * default select
    */
    public function scopeDefaultListSelect() {
        return static::select('user_items.id as user_item_id', 'user_items.users_id as user_id',  
                              'items.id as item_id', 'items.name as item_name',
                              'items.want_count', 'items.have_count', 'user_items.img_url', 'items.img_url as public_img',
                              'brands.name as brand_name', 'user_items.created_at as created_at');
    }

    /**
    * default detail select
    */
    public function scopeDefaultDetailSelect() {
        return static::select('user_items.id as user_item_id', 'user_items.users_id as user_id',  
                              'items.id as item_id', 'items.name as item_name',
                              'user_items.description as description', 'items.description as public_description',
                              'items.want_count', 'items.have_count', 'user_items.img_url', 'items.img_url as public_img',
                              'brands.name as brand_name', 'user_items.created_at as created_at',
                              'users.name as user_name', 'users.avater_img_url as user_avater_img_url',
                              'item_evaluation.average as evaluation_average');
    }

    // sale item default join
    public function scopeSaleItemJoin() {
        return static::select("user_items.id as user_items_id", "user_items.users_id as users_id",
                              "items.id as items_id", "items.name as items_name");
    }

    /**
    * default join
    */
    public function scopeDefaultJoin() {
        return static::select('user_items.id as user_item_id', 'user_items.users_id as user_id', 'user_items.is_store', 
                              'user_items.price','users.avater_img_url as avater_img_url', 'users.name as user_name',
                              'items.id as item_id', 'items.name as item_name',
                              'items.want_count', 'items.have_count', 'user_items.img_url', 'items.img_url as public_img',
                              'brands.name as brand_name', 'user_items.created_at as created_at')
                    ->join('users', 'users.id', '=', 'user_items.users_id')
                    ->join('items', 'user_items.items_id', '=', 'items.id')
                    ->join('brands', 'brands.id', '=', 'items.brands_id');
    }

    /**
    * default join
    */
    public function scopeDefaultDetailJoin() {
        return static::select('user_items.id as user_item_id', 'user_items.users_id as user_id',  
                              'items.id as item_id', 'items.name as item_name',
                              'user_items.description as description', 'items.description as public_description',
                              'items.want_count', 'items.have_count', 'user_items.img_url', 'items.img_url as public_img',
                              'brands.name as brand_name', 'user_items.created_at as created_at',
                              'category.id as category_id', 'genre.id as genre_id', 'genre_second.id as genre_second_id',
                              'category.name as category_name', 'genre.name as genre_name',
                              'genre_second.name as genre_second_name', 'user_items.is_store as is_store',
                              'users.name as user_name', 'users.avater_img_url as user_avater_img_url',
                              'item_evaluation.id as evaluation_id', 'item_evaluation.average as evaluation_average')
                    ->join('items', 'user_items.items_id', '=', 'items.id')
                    ->join('brands', 'brands.id', '=', 'items.brands_id')
                    ->join('category', 'category.id', '=', 'items.category_id')
                    ->join('users', 'users.id', '=', 'user_items.users_id')
                    ->leftJoin('genre', 'genre.id', '=', 'items.genre_id')
                    ->leftJoin('genre_second', 'genre_second.id', '=', 'items.genre_second_id')
                    ->leftJoin('item_evaluation', 'items.id', '=', 'item_evaluation.items_id');
    }

    /**
    * scope is sale
    */
    public function scopeIsSale($query) {
        return $query->where("user_items.is_store", 1);
    }

    /**
    * findメソッドを上書きし、active判定を付与
    */
    public static function find($id) {
        return static::on(self::getSlave())->find($id);
    }

    /**
    * allメソッドを上書きし、active判定を付与
    */
    public static function all($columns = []) {
        return static::on(self::getSlave())->get();
    }

    /**
    * ステータスが公開状態のアイテムのみ取得するScope
    */
    public function scopeActive($query) {
        return $query->where('user_items.status', 1);
    }

    /**
    * have,wantのカウントカラム文字列を取得する
    *
    * @params $status int  have wantステータス
    * @return string
    */
    public static function getHaveWantColumn($status) {
        return self::$_count_column[$status];
    }

    /**
    * saleアイテム取得(デフォルトリスト）
    * このモデルからの参照の際はsaleアイテムのみ抽出する
    *
    * @params $params  array  requestパラメータ
    * @return self
    */
    public static function getUserItems($params = []) {
        $query = static::defaultJoin();

        if ( ! empty($params)) {
            $table = self::getTableName();
            if (isset($params['is_store']) &&  ! is_null($params['is_store'])) {
                $query->isSale();
            }
            $query = static::setConditionsItems($query, $params);
            $query = self::setSort($query, $params, $table);
        }
        return $query;
        //return static::getS(self::setLimitOffset($query, $params));
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
            $query->whereIn('user_items.items_id', $params['ids']);
        }

        // フォローしてるユーザー
        if (isset($params['follow_user_ids']) && ! empty($params['follow_user_ids'])) {
             $query->whereIn('user_items.users_id', $params['follow_user_ids']);           
        }
        // アイテムで絞り込み
        if (isset($params['items_id']) && ! empty($params['items_id'])) {
            $query->where('user_items.items_id', $params['items_id']);
        }
        // ユーザーで絞り込み
        if (isset($params['users_id']) && ! empty($params['users_id'])) {
             $query->where('user_items.users_id', $params['users_id']);
        }
        // ブランドで絞り込み
        if (isset($params['brands_id']) && ! empty($params['brands_id'])) {
             $query->where('items.brands_id', $params['brands_id']);
        }
        // カテゴリで絞り込み
        if (isset($params['category_id']) && ! empty($params['category_id'])) {
             $query->where('items.category_id', $params['category_id']);
        }
        // ジャンル
        if (isset($params['genre_id']) && ! empty($params['genre_id'])) {
             $query->where('items.genre_id', $params['genre_id']);
        }
        // セカンドジャンル
        if (isset($params['genre_second_id']) && ! empty($params['genre_second_id'])) {
             $query->where('items.genre_second_id', $params['genre_second_id']);
        }
        return $query;
    }

    /**
    * have wantを反転してインクリメント、デクリメントする
    *
    * @params $items \App\Models\Items  アイテムモデル
    *         $status int               have:1 want:2
    * @return void
    */
    public static function saveChangeHaveWantStatus($items, $status, $user_info_count, $current_status) {
        if ($status == self::COUNT_TYPE_WANT) {
            $items->increment(self::getHaveWantColumn(self::COUNT_TYPE_WANT));
            $user_info_count->increment(self::getHaveWantColumn(self::COUNT_TYPE_WANT));
            if ($current_status != 0) {
                $items->decrement(self::getHaveWantColumn(self::COUNT_TYPE_HAVE));
                $user_info_count->decrement(self::getHaveWantColumn(self::COUNT_TYPE_HAVE));
            }
        } else {
            $items->increment(self::getHaveWantColumn(self::COUNT_TYPE_HAVE));
            $user_info_count->increment(self::getHaveWantColumn(self::COUNT_TYPE_HAVE));
            if ($current_status != 0) {
                $items->decrement(self::getHaveWantColumn(self::COUNT_TYPE_WANT));
                $user_info_count->decrement(self::getHaveWantColumn(self::COUNT_TYPE_WANT));
            }
        }
    }

    /**
    * ユーザーアイテムを複数idで取得する
    *
    * @params $ids     array   複数のユーザーアイテムID
    *         $params  Array 　['sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\UserItems
    */
    public static function getItemListByIds($ids, $params) {
        $query = self::defaultJoin()->whereIn('user_items.id', $ids);
        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * ユーザーアイテムをページング処理(ajax)でN件ずつ取得する
    *
    * @params $params  Array 　['sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\UserItems
    */
    public static function getUserItemList($params = []) {
        $query = self::defaultJoin();
        // フィルター分岐
        if (isset($params['item_status'])) {
            $query->join("user_item_status", "user_item_status.items_id", "=", "items.id")
                  ->where("user_item_status.status", $params["item_status"])
                  ->where('user_item_status.users_id', $params['owner_users_id']);
        }
        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * ユーザーアイテム一覧をitems_idで取得する(コメントページ)
    *
    * @params $params  Array 　['items_id' =>, 'sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\UserItems
    */
    public static function getUserItemsCommentByItemsId($params) {
        $query = self::select('user_items.id as user_items_id', 'users.id as users_id',
                              'user_items.description as description', 'users.avater_img_url as avater_img',
                              'item_evaluation_users.evaluation_num as evaluation_num', 'user_items.created_at as created_at')
                    ->join('users', 'users.id', '=', 'user_items.users_id')
                    ->join('item_evaluation', 'item_evaluation.items_id', '=', 'user_items.items_id')
                    ->leftJoin('item_evaluation_users', 'item_evaluation_users.item_evaluation_id', '=', 'item_evaluation.id')
                    ->where('user_items.items_id', $params['items_id']);

        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * ユーザーアイテム一覧をitems_idで取得する(フォトページ)
    *
    * @params $params  Array 　['items_id' =>, 'sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\UserItems
    */
    public static function getUserItemsPhotoByItemsId($params) {
        $query = self::select('user_items.id as user_items_id', 'users.id as users_id',
                              'user_items.img_url as img_url', 'users.avater_img_url as avater_img',
                              'users.name as user_name')
                    ->join('users', 'users.id', '=', 'user_items.users_id')
                    ->where('user_items.items_id', $params['items_id']);

        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * ユーザーアイテム一覧をitems_idで取得する(saleページ)
    *
    * @params $params  Array 　['items_id' =>, 'sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\UserItems
    */
    public static function getUserItemsSaleByItemsId($params) {
        $query = self::select('user_items.id as user_items_id', 'users.id as users_id',
                              'user_items.price as price', 'user_items.img_url as img_url', 
                              'users.avater_img_url as avater_img','users.name as user_name')
                    ->join('users', 'users.id', '=', 'user_items.users_id')
                    ->where('user_items.items_id', $params['items_id'])
                    ->where('user_items.is_store', 1);

        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * ユーザーアイテムIDから詳細情報を一件取得
    *
    * @params $id  int  ユーザーアイテムID
    * @return \App\Models\User\Items
    */
    public static function getDetailById($id) {
        $query = self::defaultDetailJoin()
                    ->where('user_items.id', $id);
        return self::firstS($query);
    }

    /**
    * アイテムIDとユーザーIDで一件抽出する
    *
    * @params $items_id  int  アイテムID
    *         $users_id  int  ユーザーID
    *         $is_master bool マスターorスレイブ
    * @return self
    */
    public static function getByUsersIdAndItemsId($users_id, $items_id, $is_master = false) {
        $query = self::select("*")
                    ->where('items_id', '=', $items_id)
                    ->where('users_id', '=', $users_id);
        if ($is_master) {
            return $query->first();
        } else {
            return self::firstS($query);
        }
    }

    /**
    * ユーザーアイテムIDとユーザーIDで一件抽出する
    *
    * @params $id        int  プライマリキー
    *         $users_id  int  ユーザーID
    *         $is_master bool マスターorスレイブ
    * @return self
    */
    public static function getByIdAndUsersId($id, $users_id, $is_master = false) {
        $query = self::select("*")
                    ->where('id', '=', $id)
                    ->where('users_id', '=', $users_id);
        if ($is_master) {
            return $query->first();
        } else {
            return self::firstS($query);
        }
    }

    /**
    * ユーザーアイテムをタグIDから検索
    *
    * @params $tags_id  int  ユーザータグID
    * @return \App\Models\User\Items
    */
    public static function getUserItemsByUserTagsId($tags_id, $params = []) {
        $query = self::defaultJoin();
        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * ユーザーアイテムを複数IDから検索
    *
    * @params $ids array  ユーザーアイテムIDリスト
    * @return \App\Models\User\Items
    */
    public static function getItemListByUserItemsIds($ids, $params) {
        $query = self::DefaultListSelect()
                        ->leftJoin("items", "items.id", "=", "user_items.items_id")
                        ->join("brands", "brands.id", "=", "items.brands_id")
                        ->whereIn("user_items.id", $ids["user_items_id"]);
        if (isset($ids["items_id"])) {
            $query->orWhereIn("items.id", $ids["items_id"]);
        }
        return self::getS(self::setLimitOffset($query, $params));
    }

    /**
    * パブリックアイテムの欲しい持ってるのカウント更新
    * 及び欲しい持ってるユーザーのレコード追加、フラグ更新
    *
    * @params $params  Array 　['type' => ,'users_id' => ,'item_id' => ]
    * @return array
    */
    public static function updateHasWantCounts($params) {

        // 更新時はマスターDBを参照する
        //$user_items = static::on('master')->find($params['user_item_id']);
        $item = PublicItems::on("master")->find($params['item_id']);
        $user_info_count = \App\Models\User\InfoCount::where('users_id', $params['users_id'])->first();

        // アイテムが見つからない時は不正なので例外をスローする
        if (is_null($item)) {
            throw new Exception("item not found users_id : " . $params['users_id'] . " item_id : " . $params['item_id']);
        }

        $item_status = ItemStatus::where('users_id', $params['users_id'])->where('items_id', $item->id)->first(); 
        // レコードが無ければ新規追加
        if (is_null($item_status)) {
            self::insertItemStatus($params, $item->id);
            // カウント更新
            $item->increment(static::$_count_column[$params['type']], 1);
            $user_info_count->increment(static::$_count_column[$params['type']], 1);
        } else {
            $status = $item_status->status;
            // ステータスを見てカウントを更新する
            if ($params['type'] == static::COUNT_TYPE_WANT)  {
                if ($status === ItemStatus::USER_ITEM_STATUS_WANT) {
                    $item->decrement('want_count');
                    $user_info_count->decrement('want_count');
                    $params['type'] = 0; 
                } elseif ($status === ItemStatus::USER_ITEM_STATUS_HAVE) { 
                    $item->increment('want_count');
                    $item->decrement('have_count');
                    $user_info_count->increment('want_count');
                    $user_info_count->decrement('have_count');
                } else {
                    $item->increment('want_count');
                    $user_info_count->increment('want_count');
                }
            } elseif ($params['type'] == static::COUNT_TYPE_HAVE)  {
                if ($status === ItemStatus::USER_ITEM_STATUS_HAVE) {
                    $item->decrement('have_count');
                    $user_info_count->decrement('have_count');
                    $params['type'] = 0; 
                } elseif ($status === ItemStatus::USER_ITEM_STATUS_WANT) {
                    $item->increment('have_count');
                    $item->decrement('want_count');
                    $user_info_count->increment('have_count');
                    $user_info_count->decrement('want_count');
                } else {
                    $item->increment('have_count');
                    $user_info_count->increment('have_count');
                }
            }
            self::updateItemStatus($params, $item->id, $params['type']);
        }
        return ["status" =>  $params['type'], "want_count" => $item->want_count, "have_count" => $item->have_count];
    }

    /**
    * ユーザーアイテムのお気に入りのカウント更新
    * 及びお気に入りユーザーのレコード追加、フラグ更新
    *
    * @params $params  Array 　['type' => ,'users_id' => ,'user_item_id' => ]
    * @return array  ['clip_count' => , 'fav_flag']
    */
    public static function updateFavCounts($params) {

        // 更新時はマスターDBを参照する
        $user_item = static::on('master')->find($params['user_item_id']);
        $item2_container = Item2Container::where('users_items_id', $params['user_item_id'])->where('container_id', $params['container_id'])->first(); 

        // レコードが無ければ新規追加
        $update_fav_flag = null;
        if (is_null($item2_container)) {
            self::insertItem2Container($params);
            // カウント更新
            $user_item->increment('clip_count', 1);
            $update_fav_flag = 1;
        } else {
            $fav_flag = $item2_container->status;
            // お気に入りフラグを見てカウントを更新する
            if ($fav_flag) {
                $user_item->decrement('clip_count');
                $update_fav_flag = 0;
            } else {
                $user_item->increment('clip_count');
                $update_fav_flag = 1;
            }
            self::updateItem2Container($params, $update_fav_flag);
        }
        return ["clip_count" => $user_item->clip_count, "fav_flag" => $update_fav_flag];
    }

    /**
    * ステータスを更新
    *
    * @params  $params  array  パラメータ ["users_id", "items_id", "type"]
    *          $status  int    ステータス（タイプと同義だが動的に変わる
    * @return  void
    */
    public static function updateItemStatus($params, $item_id, $status) {
        ItemStatus::where('items_id', $item_id)
                   ->where('users_id', $params['users_id'])
                   ->update(['status' => $status, 'updated_at' => date('Y-m-d h:i:s')]);
    }

    /**
    * お気に入りユーザーを更新
    *
    * @params  $params    array  パラメータ ["users_id", "items_id", "type"]
    *          $fav_flag  int    お気に入りフラグ
    * @return  void
    */
    public static function updateItem2Container($params, $fav_flag) {
        Item2Container::where('user_items_id', $params['user_item_id'])
                   ->where('container_id', $params['container_id'])
                   ->update(['status' => $fav_flag, 'updated_at' => date('Y-m-d h:i:s')]);
    }

    /**
    * ステータスを新規追加
    *
    * @params  $params  array  パラメータ ["users_id", "item_id", "type"]
    *          $item_id int    パブリックアイテムID
    * @return  void
    */
    public static function insertItemStatus($params, $item_id) {
        ItemStatus::insert([
            "items_id" => $item_id,
            "users_id" => $params['users_id'],
            "status"   => ItemStatus::getItemStatus($params['type']),
            "created_at" => date("Y-m-d h:i:s"),
            "updated_at" => date("Y-m-d h:i:s"),
            ]
        );
    }

    /**
    * お気に入りユーザーレコードを新規追加
    *
    * @params  $params  array  パラメータ ["users_id", "user_item_id", "type"]
    * @return  void
    */
    public static function insertItem2Container($params) {
        Item2Container::insert([
            "user_items_id" => $params['user_item_id'],
            "container_id" => $params['container_id'],
            "status" => 1,
            "created_at" => date("Y-m-d h:i:s"),
            "updated_at" => date("Y-m-d h:i:s"),
            ]
        );
    }

    /**
    * ユーザーアイテム登録
    *
    * @params $input array 登録アイテム情報
    * @return void
    */
    public function saveItems($input, $users_id, $items_id, $file_info) {
        $this->users_id = $users_id;
        $this->items_id = $items_id;
        $this->user_container_id = (!empty($input['ContainerSelect'])) ?? null;
        if (isset($input['item_description'])) {
            $this->description = $input['item_description'];
        }
        // セールアイテム出品時の分岐
        if (isset($input['price'])) {
            $this->price = $input['price'];
            $this->is_store = 1;
            $this->item_condition = $input['item_condition'];
        }
        $this->save();
        if ( ! is_null($file_info)) {
            $group_dir = self::getGroupDir($this->id);
            $finish_path = self::makeGroupDir($file_info['path'], $group_dir);
            $this->img_url = $finish_path . $this->id . $file_info['ext'];
            if (isset($input['site_img_url']) && ! empty($input['site_img_url'])) {
                $this->img_site_url = $input['site_img_url'];
            }
        }
        $this->save();
        return $this;
    }

    /**
    * ユーザーIDとアイテムIDでカウントを取得する
    *
    * @params  $users_id  int  ユーザーID
    *          $items_id  int  アイテムID
    * @return  int  カウント
    */
    public static function getCountByUsersIdAndItemsId($users_id, $items_id) {
        return static::where("users_id", $users_id)
                        ->where("items_id", $items_id)
                        ->count();
    }

    /**
    * 出品中のアイテムをユーザーIDとアイテムIDで取得する
    *
    * @params  $users_id  int  ユーザーID
    *          $items_id  int  アイテムID
    * @return  self
    */
    public static function getSaleItemByItemsIdAndUsersId($users_id, $items_id) {
        $query = static::where("users_id", $users_id)
                       ->where("items_id", $items_id)
                       ->isSale();
        return static::getS($query);
    }
}
