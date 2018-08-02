<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users2Tags extends Base
{
    //
    protected $table = "users2tags";

    /**
    * bulkinsert 
    *
    * @params $users_items_id      int       ユーザーID
    *         $user_tags           array     タグIDのリスト
    * @return bool
    */
    public static function bulkInsertUsers2Tags($users_id, $tags) {
        $insert_data = [];
        foreach ($tags as $key => $tag) {
            if ( ! self::where('tags_id', $tag['id'])->where('users_id', $users_id)->count()) {
                $insert_data[$key]['tags_id'] = $tag['id'];
                $insert_data[$key]['users_id'] = $users_id;
                $insert_data[$key]['created_at'] = date('Y-m-d H:i:s');
                $insert_data[$key]['updated_at'] = date('Y-m-d H:i:s');
            }
        }
        static::insert($insert_data);
    }
}
