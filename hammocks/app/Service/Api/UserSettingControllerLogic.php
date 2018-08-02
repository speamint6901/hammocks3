<?php

namespace App\Service\Api;

use App\Models\Users;
use App\Models\User\SecretProfile as UserSecretProfile;
use App\Exceptions\UserSettingException;
use App\Modesl\User\Profile as UserProfile;

class UserSettingControllerLogic extends \App\Service\UserControllerLogic {

    /**
    * 基本情報を更新
    *
    * @params $users_id  int    ユーザーID
    *         $params    array  postデータ
    */
    public static function updateStandardData($users_id, $params) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            $user_secret_profile = UserSecretProfile::findByUsersId($users_id, true);
            $user_secret_profile->saveStandardData($params);
            // コミット
            \DB::commit();
            return $user_secret_profile;
        } catch (\App\Exception\UserSettingException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }
    }

    /**
    * ユーザー系の画像を保存する
    *
    * @params $users_id int    ユーザーID
    *         $image    array  キャッシュから取り出した画像データ
    * @return void
    */
    public static function updateUserImages($users_id, $image) {
        if (empty($image)) {
            throw new \App\Exception\UserSettingException("画像データが見つかりません");
        }
        $image = $image[0];
        $file_info = self::createFileInfo($image);
        $users = Users::on("master")->find($users_id);
        $img_url = $users->updateImages($image, $file_info);
        // 画像をストレージに保存
        self::putImageBase64ToBlob($image['data_url'], $image['mime_type'], $img_url);
        // 完了したらcache削除
        self::clearImageUploaderCache(1, $users_id, $image["cache_key"]);
        return $users;
    }

    /**
    * 本人確認の画像を保存する
    *
    * @params $users_id int    ユーザーID
    *         $image    array  キャッシュから取り出した画像データ
    * @return void
    */
    public static function updateIdentificationImages($users_id, $images) {
        if (empty($images)) {
            throw new \App\Exceptions\UserSettingException("画像データが見つかりません");
        }
        
        $users = UserSecretProfile::on("master")->find($users_id);
        if ($users->is_certificate_auth === UserSecretProfile::CERTIFICATE_STATUS_ACCEPT) {
            throw new \App\Exceptions\UserSettingException("既に本人確認書類提出済みです");
        }
        foreach ($images as $key => $image) {
            $file_info = self::createFileInfo($image);
            $img_url = $file_info[$image["cache_key"]]["path"] . $users_id . "_" . $key . $file_info[$image["cache_key"]]["ext"];
            // 画像をストレージに保存
            self::putImageBase64ToBlob($image['data_url'], $image['mime_type'], $img_url);
        }
        $users->is_certificate_auth = UserSecretProfile::CERTIFICATE_STATUS_UPLOAD;
        $users->save();
        // 完了したらcache削除
        self::clearImageUploaderCache(1, $users_id, $image["cache_key"]);
        return $users;
    }

    /**
    * パスワード変更
    *
    * @params $users_id int    ユーザーID
    *         $params   array  postパラメータ
    * @return void
    */
    public static function updatePassword($users_id, $params) {
        if (empty($params["password"])) {
            throw new UserSettingException("現在のパスワードを入力してください");
        }
        if (empty($params["new_password"])) {
            throw new UserSettingException("新しいパスワードを入力してください");
        }
        if (empty($params["re_password"])) {
            throw new UserSettingException("新しいパスワード(確認用)を入力してください");
        }
        if ($params["password"] === $params["new_password"]) {
            throw new UserSettingException("現在のパスワードとは違うパスワードを設定してください");
        }
        $user = Users::on("master")->find($users_id);
        if ( is_null($user)) {
            throw new UserSettingException("ユーザーが見つかりません");
        }
        if ( ! \Hash::check($params["password"], $user->password)) {
            throw new UserSettingException("現在のパスワードが違います");
        }
        if ($params["new_password"] !== $params["re_password"]) {
            throw new UserSettingException("確認用パスワードが一致しません");
        }
        // 登録変更処理
        $user->password = bcrypt($params["new_password"]);
        $user->save();
        return $user;
    }
}
