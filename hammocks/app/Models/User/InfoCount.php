<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class InfoCount extends \App\Models\Base
{
    //
    protected $table = "user_info_count";

    /**
    * user_info_countをユーザーIDで一件取得する
    *
    * @params $users_id  int  ユーザーID
    * @return self
    */
    public static function getUserInfoCountByUsersId($users_id) {
        $query = self::select('users.id as id','users.name as name', 'users.avater_img_url as avater_img_url',
                              'user_info_count.have_count as have_count', 'user_info_count.want_count as want_count',
                              'user_info_count.clip_count as clip_count', 'user_info_count.evaluation_count as evaluation_count',
                              'user_info_count.follow_count as follow_count', 'user_info_count.follower_count as follower_count',
                              'user_info_count.sale_count as sale_count', 'user_profile.user_comment as comment',
                              'user_profile.avater_background_url as avater_background_url')
                              ->join('users', 'users.id', '=', 'user_info_count.users_id')
                              ->join('user_profile', 'user_info_count.users_id', '=', 'user_profile.users_id')
                              ->where('user_info_count.users_id', $users_id);
        return self::firstS($query);
    }
}
