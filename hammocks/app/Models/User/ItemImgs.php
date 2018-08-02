<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ItemImgs extends \App\Models\Base
{
    //
    protected $table = "user_item_imgs";

    /**
    * セールアイテム画像を保存する
    *
    * @params $user_items_id  int    ユーザーアイテムID
    *         $file           array  画像ファイル情報
    * @return void
    */
    public function saveItems($user_items_id, $file) {
        $this->users_items_id = $user_items_id;
        $this->save();
        $group_dir = $user_items_id;
        $finish_path = self::makeGroupDir($file['path'], $group_dir);
        $this->img_url = $finish_path . $this->id . $file['ext'];
        $this->save();
    }
}
