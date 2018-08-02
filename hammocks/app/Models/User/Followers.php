<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Followers extends \App\Models\Base
{
    //
    protected $table = "user_followers";

    /**
    * フォロワーをユーザーIDとフォロワーユーザーIDで取得する
    *
    * @params $users_id             int  フォローされてるユーザーID
    *         $follower_users_id    int  フォロワーユーザーID
    *         $is_master            bool マスター/スレイブフラグ
    * @return self
    */
    public static function getFollowerByUsersId($users_id, $follower_users_id, $is_master = false) {
        $query = self::where('users_id', $follower_users_id)->where('user_follow_id', $users_id);
        if ($is_master) {
            return $query->get();
        }
        return self::getS($query);
    }

    /**
    * フォロワーをユーザーIDとフォロワーユーザーIDで一件取得する
    *
    * @params $follower_users_id    int  フォロワーユーザーID
    *         $owner_users_id       int  フォローされてるユーザーID
    *         $is_master            bool マスター/スレイブフラグ
    * @return self
    */
    public static function findFollowerByUsersId($follower_users_id, $owner_users_id, $is_master = false) {
        $query = self::where('users_id', $owner_users_id)->where('user_follow_id', $follower_users_id);
        if ($is_master) {
            return $query->first();
        }
        return self::firstS($query);
    }

    /**
    * フォロー中のユーザー一覧取得
    * follow_type  1 : フォローしてる数  2 : フォロワー数
    *
    * @params $users_id    int  オーナーユーザーID
    * @return self
    */
    public static function getFollowsByUsersId($users_id, $params) {
        $query = self::select('users.id as users_id', 'users.name as name',
                              'users.avater_img_url as avater_img_url',
                              'user_info_count.have_count as have_count',
                              'user_info_count.want_count as want_count',
                              'user_info_count.clip_count as clip_count',
                              'user_info_count.sale_count as sale_count');
        if ( ! empty($params)) {
            if ( ! $params['follow_type']) {
                $query->join('user_info_count', 'user_info_count.users_id', '=', 'user_followers.users_id');
                $query->join('users', 'users.id', '=', 'user_followers.users_id');
                $query->where('user_followers.user_follow_id', $users_id);
            } else {
                $query->join('user_info_count', 'user_info_count.users_id', '=', 'user_followers.user_follow_id');
                $query->join('users', 'users.id', '=', 'user_followers.user_follow_id');
                $query->where('user_followers.users_id', $users_id);
            }
            $query = self::setSort($query, $params, "user_followers");
        }
        return $query;
        //return self::getS(self::setLimitOffset($query, $params, "user_followers"));
    }

    /**
    * フォロー中のユーザーをuser_follw_idで取得
    *
    * @params $user_follow_id int フォローワーユーザーID
    * @return self
    */
    public static function getFollwsByUserFollowId($user_follow_id) {
        $query = static::where("user_follow_id", $user_follow_id);
        return static::getS($query);
    }
}
