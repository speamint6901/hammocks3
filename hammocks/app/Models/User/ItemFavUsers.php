<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ItemFavUsers extends \App\Models\Base
{
    //
    protected $table = "user_item_fav_users";

    /**
    * お気に入り状態を一件返す
    * レコードが無い場合はfalseを返す
    *
    * @params  $user_id          ユーザーID
    *          $user_items_id    ユーザーアイテムID
    * @return  bool  fav_flag
    */
    public static function getFavFlag($user_id, $user_item_id) {
        $query = static::select('fav_flag')
                          ->where('users_id', $user_id)
                          ->where('user_items_id', $user_item_id);

        $user_item_fav = static::firstS($query);

        return is_null($user_item_fav) ? false : $user_item_fav->fav_flag;
    }
}
