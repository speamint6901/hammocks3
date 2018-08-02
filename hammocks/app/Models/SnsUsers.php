<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SnsUsers extends Base
{
    const SNS_TYPE_FACEBOOK = 1;
    const SNS_TYPE_TWITTER = 2;
    //
    protected $table = "sns_users";

    /**
    * ステータスがオンのみ取得するScope
    */
    public function scopeActive($query) {
        return $query->where('sns_users.status', 1);
    }

    /**
    * 連携チェック(sns側から受信時)
    * snsのidとタイプでチェックをかける用
    * ログイン時
    *
    * @params $social_id  int  snsID
    *         $type       int  snsタイプ
    * @return self
    */
    public static function findSnsUserBySocialIdAndType($social_id, $type, $switch = 0) {
        $query = static::join("users", "users.id", "=", "sns_users.users_id")
                        ->where("social_id", $social_id)
                        ->where("type", $type);
        if ($switch) {
            $query->active();
        }
        return static::firstS($query);
    }
}
