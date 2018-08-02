<?php

namespace App\Service\Api;

use App\Models\User\Follow as Follow;
use App\Models\User\Followers as Followers;

class FollowControllerLogic extends \App\Service\Base {

    /**
    * フォローする
    *
    * @params  $follow_users_id  int  フォロー先のユーザーID
    *          $follower_user_id int  フォローするユーザーID
    * @return  
    */
    public static function setFollowToFollewer($follow_users_id, $follower_users_id) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // フォロー済みかどうかのチェック
            if (self::checkFollower($follower_users_id, $follow_users_id)) {
                $follow = self::releaseFollow($follow_users_id, $follower_users_id);
            } else {
                $follow = self::addFollower($follow_users_id, $follower_users_id);
            }

            \DB::commit();
            return $follow;
        } catch (\App\Exceptions\ApiAuthException $e) {
            \DB::rollBack();
            throw $e;
        }

    }

    /**
    * フォロワー追加
    *
    * @params $follow_users_id    int フォロー先ユーザーID
    *         $follower_users_id  int フォロワーユーザーID
    * @return 
    */
    public static function addFollower($follow_users_id, $follower_users_id) {

        // フォロー元を登録
        $follow = Follow::findByUsersId($follow_users_id);
        if ( ! is_null($follow) && $follow->count()) {
            $follow->increment('user_follower_count');
        } else {
            $follow = new Follow();
            $follow->users_id = $follow_users_id;
            $follow->user_follower_count = 1;
            $follow->save();
        }

        // フォロワー登録
        $follower = new Followers();
        $follower->users_id = $follow_users_id;
        $follower->user_follow_id = $follower_users_id;
        $follower->save();

        // ユーザーカウントを更新
        // フォローされる側
        $user_info_count = \App\Models\User\InfoCount::on("master")->where('users_id', $follow_users_id)->first();
        $user_info_count->increment('follower_count');

        // フォローする側
        $user_info_count_follower = \App\Models\User\InfoCount::on("master")->where('users_id', $follower_users_id)->first();
        $user_info_count_follower->increment('follow_count');

        return $follow;
    }

    /**
    * フォロー解除
    *
    * @params $follow_users_id    int フォロー先ユーザーID
    *         $follower_users_id  int フォロワーユーザーID
    * @return 
    */
    public static function releaseFollow($follow_users_id, $follower_users_id) {
        // フォロー先を取得
        $follow = Follow::findByUsersId($follow_users_id);       
        // カウントを引く
        $follow->decrement('user_follower_count');

        // フォロワーを論理削除
        $follower = \App\Models\User\Followers::findFollowerByUsersId($follower_users_id, $follow_users_id, 1);
        $follower->delete();

        // ユーザーカウントを更新
        // フォローされる側
        $user_info_count = \App\Models\User\InfoCount::where('users_id', $follow_users_id)->first();
        $user_info_count->decrement('follower_count');

        // フォローする側
        $user_info_count_follower = \App\Models\User\InfoCount::where('users_id', $follower_users_id)->first();
        $user_info_count_follower->decrement('follow_count');

        return $follow;
    }

    /**
    * フォロー中のユーザー一覧取得
    *
    * @params $users_id    int  オーナーユーザーID
    * @return \App\Models\User\Followers
    */
    public static function getFollows($users_id, $params) {
        return Followers::getFollowsByUsersId($users_id, $params);
    }

    /**
    * カウントの単位を適切な桁にして返す
    *
    * @params  $follwos  フォロー、フォロワー
    * @return  array
    */
    public static function setCountExt($follows) {
        if (count($follows)) {
            foreach ($follows as $column => $follow) {
                if (preg_match("/count/", $column)) {
                    $follows->$column = self::getRoundNumAndExt($value);
                }        
            }
        }
        return $follows;
    }

}
