<?php

namespace App\Service\Admin;

use App\Service\Base;
use App\Models\Admin\UserAccount as UserAccount;

class UserRegisterControllerLogic extends Base {

    /**
    * 管理者情報登録処理開始
    *
    * @params $post         array  inputデータ
    * @return array
    */
    public static function register($post) {

        // トランザクションの開始
        \DB::beginTransaction();
        try {

            $admin_user_account_model = new \App\Models\Admin\UserAccount();
            $admin_user_account_model->name = $post['name'];
            $admin_user_account_model->email = $post['email'];
            $admin_user_account_model->password = $post['password'];
            $admin_user_account_model->save();

            // コミット
            \DB::commit();

        } catch (Exception $e) {

            // ロールバック、ロック解除
            \DB::rollBack();
            throw $e;
        }
    }

    /**
    * ログインメールアドレスからアカウント種別を取得する
    *
    * @params $email ログインメールアドレス
    * @return array
    */
    public static function getTypeByMail($email) {
        return UserAccount::getTypeByMail($email);
    }
}
