<?php

namespace App\Service;

use App\Models\User\Container as Container;
use App\Models\User\Items as UserItems;
use App\Models\Tags as Tags;
use App\Models\Item\Evaluation as ItemEvaluation;

class UserItemControllerLogic extends \App\Service\ItemControllerLogic {

    /**
    * アイテム詳細ページデータ取得
    *
    * @params $user_items_id  int  ユーザーアイテムID
    * @return \App\Models\User\Items
    */
    public static function getUserItemsDetail($user_items_id) {
        $user_items = UserItems::getDetailById($user_items_id);
        if ( ! is_null($user_items) && ! empty($user_items)) {
            $evaluation = \App\Models\Item\EvaluationUsers::getItemEvaluationByUser($user_items->evaluation_id, $user_items->user_id);
            if ( ! is_null($evaluation) && ! empty($evaluation)) {
                $user_items->evaluation_average_path = self::createAverageFileName($evaluation->evaluation_num);
                $user_items->evaluation_num = $evaluation->evaluation_num;
            }
        } else {
            throw new \App\Exceptions\NotFoundUserException();
        }
        return $user_items;
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

    /**
    * アイテムを評価済みかどうかのフラグを取得
    *
    * @params $user_items_id  int  ユーザーアイテムID
    * @return \App\Models\User\Tags
    */
    public static function getMyRateCompleteFlag($items_id, $users_id) {
        return ItemEvaluation::getByItemsIdAndUsersId($items_id, $users_id)->count();
    }
}
