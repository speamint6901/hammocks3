<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends \App\Models\Base
{
    //
    protected $table = "item_evaluation";

    /**
    * item_evaluation_users 1:多
    */
    public function item_evaluation_users() {
        return $this->hasMany('\App\Models\Item\EvaluationUsers', 'item_evaluation_id', 'id');
    }

    /**
    * アイテムIDとユーザーIDで取得
    *
    * @params $items_id int アイテムID
    *         $users_id int ユーザーID
    * @return self
    */
    public static function getByItemsIdAndUsersId($items_id, $users_id) {
        $query = self::join("item_evaluation_users", "item_evaluation.id", "=", "item_evaluation_users.item_evaluation_id")
                        ->where("item_evaluation.items_id", $items_id)
                        ->where("item_evaluation_users.users_id", $users_id);
        return self::getS($query);
    }

    /**
    * アイテムIDで一件取得する
    *
    * @params $items_id  int   アイテムID
    *         $is_master bool  マスター参照フラグ
    * @return self
    */
    public static function getFirstByItemsId($items_id, $is_master = false) {

        $query = self::with('item_evaluation_users')->where('items_id', $items_id);
        
        if ($is_master) {
            return $query->first();    
        } else {
            return self::firstS($query);
        }
    }
}
