<?php

namespace App\Service;

use App\Models\Container as Container;
use App\Models\Items as Items;
use App\Models\Tags as Tags;

class PublicItemControllerLogic extends \App\Service\ItemControllerLogic {

    /**
    * アイテム詳細ページデータ取得
    *
    * @params $user_items_id  int  ユーザーアイテムID
    * @return \App\Models\User\Items
    */
    public static function getItemInfo($items_id, $users_id = null) {
        $items = Items::getItemById($items_id);
        // アイテムが見つからない場合は404
        if ( ! is_null($items) && ! empty($items)) {
            // itemsに情報を追加する
            $items->evaluation_average_path = self::createAverageFileName($items->average);
            $evaluation_count = \App\Models\Item\EvaluationUsers::getCountByItemsId($items_id);
            $sale_count = \App\Models\User\Items::getUserItems(["items_id" => $items_id, "is_store" => 1])->count();
            $items->evaluation_count = self::getRoundNumAndExt($evaluation_count);
            $items->sale_count = self::getRoundNumAndExt($sale_count);
            $items->article_count = self::getRoundNumAndExt($items->article_count);
            $items->have_want_status = 0;
            if ( ! is_null($users_id)) {
                $user_item_status = \App\Models\User\ItemStatus::getStatusOne($users_id, $items->items_id);
                if ( ! is_null($user_item_status) && ! empty($user_item_status)) {
                    $items->have_want_status = $user_item_status->status;
                }
            }
	    } else {
	        throw new \App\Exceptions\NotFoundUserException();
        }
        return $items;
    }

    /**
    * ユーザーアイテムに紐づくタグを取得する
    *
    * @params $user_items_id  int  ユーザーアイテムID
    * @return \App\Models\User\Tags
    */
    public static function getUserItemTags($user_items_id) {
        return Tags::getUserTagsByUserItemsId($user_items_id);
    }
}
