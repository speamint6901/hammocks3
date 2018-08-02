<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Follow extends \App\Models\Base
{

    // jobdispatchトレイト
    use DispatchesJobs;

    //
    protected $table = "user_follow";

    protected $primaryKey = "users_id";

    /**
    * user_followers 1:many
    */
    public function followers() {
        return $this->hasMany('\App\Models\User\Followers', 'users_id', 'users_id');
    }

    /**
    * フォロー元ユーザーを一件取得(マスター参照)
    *
    * @params $users_id int ユーザーID
    * @return self
    */
    public static function findByUsersId($users_id) {
        return self::where('users_id', $users_id)->first();
    }
}
