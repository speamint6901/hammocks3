<?php

namespace App\Service;

use Storage;
use App\Libs\SolrInput as Solr;
use App\Models\Items;
use App\Models\Brands;
use App\Models\Tags;
use App\Models\User\Items as UserItems;
use App\Models\User\Container as UserContainer;
use App\Models\User\Item2Container as UserItem2Container;
use App\Models\User\Item2Tags as UserItem2Tags;

class ItemRegisterControllerLogic extends ItemControllerLogic {

    /**
    * アイテムの状態マスタを全取得
    *
    * @return \App\Models\Mst\ItemConditions
    */
    public static function getPaymentConditionsAll() {
        return \App\Models\Mst\PaymentCondition::all();
    }

    /**
    * 出品重複チェック
    *
    * @params  $items_id  int アイテムID
    *          $users_id  int ユーザーID
    * @return  bool
    */
    public static function checkSaleItemDeplicate($users_id, $items_id) {
        if (UserItems::getSaleItemByItemsIdAndUsersId($users_id, $items_id)->count()) {
            throw new \App\Exceptions\SaleItemRegisterException("すでに出品中のアイテムです");
        }
    }

    /**
    * アイテム登録処理開始
    *
    * @params $users_id     int ユーザーID
    *         $post         array  inputデータ
    *         $session_tags array セッションに格納したタグデータ
    * @return array
    */
    public static function register($users_id, $post) {

        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // アイテム登録
            $items = self::saveItem($users_id, $post);

            if ( is_null($items) || empty($items)) {
                throw new \App\Exceptions\ItemRegisterException();
            }
            // コミット
            \DB::commit();
        // 登録時の例外
        } catch (\App\Exceptions\ItemRegisterException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        // その他例外
        } 
    }

    /**
    * items, user_items登録
    *
    * @params $input  array  inputデータ
    * @return array
    */
    public static function saveItem($users_id, $input) {
        // storageパスの指定
        $file_info = self::createFileInfo($input);
        // アイテムデータ保存(user_items, items)
        // itemのidが無ければ、public itemに新規登録する
        $items_id = $input['item_id'];
        if (empty($items_id)) {
            $items = self::savePublicItem($input, $file_info['public'], $users_id);
        }

        // 各種カウント更新
        self::incrementHasCounts($items);

        // have wantの更新
        if (isset($input['have_want']) && ! empty($input['have_want'])) {
            self::saveHaveWantParams($items, $users_id, $input['have_want']);
        }

        return $items;
    }

    /**
    * アイテム出品登録
    *
    * @params $post      array     inputパラメータ
    *         $images    array     画像データ
    *         $users_id  int       ユーザーID
    * @return void
    */
    public static function saleItemRegister($post, $images, $users_id) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // アイテム登録
            $items = self::saveSaleItem($post, $images, $users_id);

            if ( is_null($items) || empty($items)) {
                throw new \App\Exceptions\SaleItemRegisterException("登録に失敗しました");
            }
            // コミット
            \DB::commit();
            return $items;
        // アイテム重複登録の例外
        } catch (\App\Exceptions\SaleItemRegisterException $e) {
            \DB::rollBack();           
            throw $e;
        }
    }

    /**
    * アイテム出品登録詳細
    *
    * @params $post      array     inputパラメータ
    *         $images    array     画像データ
    *         $users_id  int       ユーザーID
    * @return void
    */
    public static function saveSaleItem($post, $images, $users_id) {

        $files_info = [];
        foreach ($images as $image) {
            $files_info[] = self::createFilesInfo($image);
        }

        // ユーザーアイテムを抽出
        $user_items = UserItems::getByUsersIdAndItemsId($users_id, $post['items_id'], true);
        // ユーザーアイテム未登録なら登録
        if (is_null($user_items) || empty($user_items)) {
            $user_items = new UserItems();
            $user_items = $user_items->saveItems($post, $users_id, $post['items_id'], $files_info[0]['user']);
            // 画像保存
            self::putImageBase64ToBlob($images[0]['data_url'], $images[0]['mime_type'], $user_items->img_url);
        }

        if (\App\Models\SaleItemInfo::getByUserItemsId($user_items->id, true)->count()) {
            throw new \App\Exceptions\SaleItemRegisterException("すでに出品済みのアイテムです");
        }

        // セール情報を保存
        $sale_item_info = new \App\Models\SaleItemInfo();
        $sale_item_info->user_items_id = $user_items->id;
        $sale_item_info->payment_conditon_id = $post['item_condition'];
        $sale_item_info->prefecture_id = $post['prefecture'];
        $sale_item_info->delivery_company_id = $post['delivery_company'];
        $sale_item_info->delivery_pattern = $post['delivery_pattern'];
        $sale_item_info->delivery_day_nums = $post['delivery_day_nums'];
        $sale_item_info->save();

        // user_item_imgへ画像保存
        foreach ($files_info as $key => $file) {
            $item_imgs = new \App\Models\User\ItemImgs(); 
            $item_imgs->saveItems($user_items->id, $file["sale"]);
            // 画像保存
            self::putImageBase64ToBlob($images[$key]['data_url'], $images[$key]['mime_type'], $item_imgs->img_url);
        }
        return $user_items;
    }

    /**
    * have wantの更新、追加
    *
    * @params $user_items  App\Models\User\Items  ユーザーアイテムモデル
    *         $users_id    int                    ユーザーID
    *         $status      int                    have:1 want:2
    * @return void
    */
    public static function saveHaveWantParams($items, $users_id, $status) {
        $item_status = \App\Models\User\ItemStatus::getStatusOne($users_id, $items->id, self::IS_MASTER_ON);
        $user_info_count = \App\Models\User\InfoCount::where('users_id', $users_id)->first();
        if ( ! is_null($item_status) && ! empty($item_status)) {
            // 同じステータスなら何もしない
            if ($item_status->status == $status) {
                return;
            } else {
                $item_status->status = $status;
                $item_status->save();
                UserItems::saveChangeHaveWantStatus($items, $status, $user_info_count, $item_status->status);
            }
        } else {
            $item_status = new \App\Models\User\ItemStatus();
            $item_status->users_id = $users_id;
            $item_status->items_id = $items->id;
            $item_status->status = $status;
            $item_status->save();
            $items->increment(UserItems::getHaveWantColumn($status));
            $user_info_count->increment(UserItems::getHaveWantColumn($status));
        }
    }

    /**
    * カテゴリ、ジャンルなどのカウントを更新する
    *
    * @params $user_items
    * @return void
    */
    public static function incrementHasCounts($items) {

        // brands_has_count更新
        $brand_has_count_model = \App\Models\Brand\HasCount::where('brands_id', $items->brands_id)->first();
        if ( ! is_null($brand_has_count_model) && ! empty($brand_has_count_model)) {
                $brand_has_count_model->increment("count");
        } else {
            $brand_has_count_model = new \App\Models\Brand\HasCount();
            $brand_has_count_model->brands_id = $items->brands_id;
            $brand_has_count_model->count = 1;
            $brand_has_count_model->save();
        }

        // category_count更新
        $category_count_model = \App\Models\Category\Count::where('category_id', $items->category_id)->first();
        if ( ! is_null($category_count_model) && ! empty($category_count_model)) {
            $category_count_model->increment("count");
        } else {
            $category_count_model = new \App\Models\Category\Count();
            $category_count_model->category_id = $items->category_id;
            $category_count_model->count = 1;
            $category_count_model->save();
        }

        // genre_count更新(genre_idがあれば)
        if ($items->genre_id) {
            $genre_count_model = \App\Models\Genre\Count::where('genre_id', $items->genre_id)->first();
            if ( ! is_null($genre_count_model) && ! empty($genre_count_model)) {
                $genre_count_model->increment("count");
            } else {
                $genre_count_model = new \App\Models\Genre\Count();
                $genre_count_model->genre_id = $items->genre_id;
                $genre_count_model->count = 1;
                $genre_count_model->save();
            }
        }

        // genre_count更新
        if ($items->genre_second_id) {
            $genre_second_count_model = \App\Models\GenreSecond\Count::where('genre_second_id', $items->genre_second_id)->first();
            if ( ! is_null($genre_second_count_model) && ! empty($genre_second_count_model)) {
                $genre_second_count_model->increment("count");
            } else {
                $genre_second_count_model = new \App\Models\GenreSecond\Count();
                $genre_second_count_model->genre_second_id = $items->genre_second_id;
                $genre_second_count_model->count = 1;
                $genre_second_count_model->save();
            }
        }
    }

    /**
    * itemsをsolrに登録する
    *
    * @params $items App\Models\Items
    * @return void
    */
    public static function putSolrItems($items) {
        $document = [
            "items_id" => $items->id,
            "name" => $items->name,
            "description" => $items->description,
            "brand_name" => $items->brands->name,
        ];
        Solr::forge("items")
            ->setDocument($document);
    }

    /**
    * ブランドをIDから一件取得する
    *
    * @params $brand_id ブランドID
    * @return App\Models\Brands
    */
    public static function getBrand($brand_id) {
        return Brands::getBrandInfo($brand_id);        
    }

    /**
    * プルダウンの値を文字列に変換して返す
    *
    * @params  $post  array  postデータ
    * @return  array
    */
    public static function pulldownValue2String($post) {
        $post["item_condition"] = \App\Models\Mst\ItemConditions::find($post["item_condition"])->name;
        $post["delivery_pattern"] = \App\Models\SaleItemInfo::getDeliveryPatternByNum($post["delivery_pattern"]);
        $post["delivery_company"] = \App\Models\Mst\DeliveryCompany::find($post["delivery_company"])->name;
        $post["prefecture"] = \App\Models\Prefecture::find($post["prefecture"])->name;
        $post["delivery_day_nums"] = \App\Models\SaleItemInfo::getDeliveryDayNumByType($post["delivery_day_nums"]);
        return $post;
    }
}
