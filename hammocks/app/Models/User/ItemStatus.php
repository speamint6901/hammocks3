<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ItemStatus extends \App\Models\Base
{

    protected $table = "user_item_status";
    //
    const USER_ITEM_STATUS_NONE = 0;
    const USER_ITEM_STATUS_HAVE = 1;
    const USER_ITEM_STATUS_WANT = 2;

    protected static $_item_status = [
        0 => self::USER_ITEM_STATUS_NONE,
        1 => self::USER_ITEM_STATUS_HAVE,
        2 => self::USER_ITEM_STATUS_WANT,
    ];

    /**
    * ステータスを取得する
    *
    * @params $status_num int ステータス
    * @return array ステータス
    */
    public static function getItemStatus($status_num) {
        return static::$_item_status[$status_num];
    }

    /**
    * ユーザーアイテムステータスを一件取得
    *
    * @params  $user_id  int  ユーザーID
    *          $item_id  int  アイテムID
    * @return  self model
    */
    public static function getStatusOne($user_id, $item_id, $is_master = 0) {
        $query = static::where("users_id", $user_id)->where('items_id', $item_id);
        if ($is_master) {
            return $query->first();
        }
        return self::firstS($query);
    }
}
