<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class EvaluationUsers extends \App\Models\Base
{
    //
    protected $table = "item_evaluation_users";

    /**
    * items_idでアイテムの評価リストを返す
    *
    * @params $items_id
    * @return self
    */
    public static function getUserRatingListByItemsId($items_id) {
        $query = static::select("users.name as user_name", "users.avater_img_url", "users.id as user_id",
                                "items.name as item_name", "item_evaluation_users.evaluation_num")
                        ->leftJoin("item_evaluation", "item_evaluation.id", "=", "item_evaluation_users.item_evaluation_id")
                        ->leftJoin("items", "items.id", "=", "item_evaluation.items_id")
                        ->Join("users", "users.id", "=", "item_evaluation_users.users_id")
                        ->where("item_evaluation.items_id", $items_id);
        return $query;



    }

    /**
    * アイテム一件の評価件数を取得する
    *
    * @params  $items_id  int  アイテムID
    * @return  int
    */
    public static function getCountByItemsId($items_id) {
        $query = static::join("item_evaluation", "item_evaluation.id", "=", "item_evaluation_users.item_evaluation_id")
                ->where("item_evaluation.items_id", $items_id);
        return static::getS($query)->count();
    }

    /**
    * アイテムに対するユーザーの評価を一件取得する
    * @params  $item_evaluation_id  int  評価ID
    *          $users_id            int  ユーザーID
    * @return  self
    */
    public static function getItemEvaluationByUser($item_evaluation_id, $users_id) {
        $query = static::where("item_evaluation_id", $item_evaluation_id)
                        ->where("users_id", $users_id);

        return static::firstS($query);
    }

    /**
    * ユーザーIDとアイテムIDで一件取得
    *
    * @params  $users_id  int  ユーザーID
    *          $items_id  int  アイテムID
    * @return  self
    */
    public static function findByUsersIdAndItemsId($users_id, $items_id) {
        $query = static::join("item_evaluation", "item_evaluation.id", "=", "item_evaluation_users.item_evaluation_id")
                        ->where("item_evaluation.items_id", $items_id)
                        ->where("item_evaluation_users.users_id", $users_id);

        return static::firstS($query);
    }
}
