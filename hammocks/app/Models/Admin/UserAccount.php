<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends \App\Models\Base
{
    protected $table = "admin_user_account";

    /**
     * アカウント種別をログインメールアドレスで取得する
     *
     * @params $email  ログインメールアドレス
     * @return App\Models\Admin\UserAccount
     */
    public static function getTypeByMail($email) {
        $query = self::select('type')
                        ->where('email', $email);
        return self::firstS($query);
    }
}
