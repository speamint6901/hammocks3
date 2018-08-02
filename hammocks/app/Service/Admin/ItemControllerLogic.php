<?php

namespace App\Service\Admin;

use App\Service\ItemControllerLogic as BaseItem;
use App\Models\Items;

class ItemControllerLogic extends BaseItem {

    /**
    * アイテム一覧を取得する
    *
    * @params $params array
    * @return array
    */
    public static function getItemList($params) {
        return Items::getItemsForAdminPage($params);
    }

    /**
    * アイテム詳細を取得する
    *
    * @params $items_id  int  アイテムID
    * @return \App\Models\Items
    */
    public static function getItemDetail($items_id) {
        $items = Items::getItemDetailForAdminPage($items_id);
        // アイテムが見つからない場合は404
        if ( ! is_null($items) && ! empty($items)) {
            // itemsに情報を追加する
            $items->evaluation_average_path = self::createAverageFileName($items->average);
            $evaluation_count = \App\Models\Item\EvaluationUsers::getCountByItemsId($items_id);
            $sale_count = \App\Models\User\Items::getUserItems(["items_id" => $items_id, "is_store" => 1])->count();
            $items->evaluation_count = self::getRoundNumAndExt($evaluation_count);
            $items->sale_count = self::getRoundNumAndExt($sale_count);
            $items->article_count = self::getRoundNumAndExt($items->article_count);
	    } else {
	        return [];
        }
        return $items;
    }

    /**
    * アイテムの公開、非公開を切り替える
    *
    * @params $items_id  int  アイテムID
    *         $status    int  公開非公開ステータス
    * @return void
    */
    public static function itemStatusChange($items_id, $status) {
        $items = Items::find_status_free($items_id);
        if ( ! is_null($items) && ! empty($items)) {
            if ($items->status) {
                throw new \App\Exceptions\NotFoundUserException();
            }
            $items->status = $status;    
            $items->save();
            self::incrementHasCounts($items);
            return $items;
        } else {
            throw new \App\Exceptions\NotFoundUserException();
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
}
