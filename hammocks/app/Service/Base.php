<?php

namespace App\Service;

use Storage;
use App\Models\BrideConnection as Bride;

class Base {

    const IS_MASTER_ON = 1;
    const IS_MASTER_OFF = 0;

    const STORAGE_PATH_ITEMS = "public_items";
    const STORAGE_PATH_USER_ITEMS = "user_items";
    const STORAGE_PATH_ARTICLE = "article";
    const STORAGE_PATH_SALE_ITEMS = "sale_items";

    protected static $image_mimetypes = [
        "image/jpeg" => ".jpg",
        "image/png" => ".png",
    ];

    public function __construct() {

    }

    protected static function getSlave() {
        return Bride::getSlaveConnection();
    }

    /**
    * その他ブランドID取得
    */
    public static function getOtherBrandId() {
        return \App\Models\Brands::BRANDS_ID_OTHER;
    }

    /**
    * 都道府県を全取得
    *
    * @return \App\Models\Prefecture
    */
    public static function getPrefectures() {
        return \App\Models\Prefecture::all();
    }

    /**
    * カウント数に応じて、計算して単位を付与する
    *
    * @params  $count  int  それぞれのカウント数
    * @return  float
    */
    protected static function getRoundNumAndExt($count) {
        // 1k
        if ($count >= 1000 && $count < 10000000) {
            return round($count * 0.001, 1) . "K";
        } 
        if ($count >= 10000000) {
            return round($count * 0.0000001, 1) . "M";
        }
        return $count;
    }

    /**
    * 所有者のユーザーIDでログインユーザーIDがフォロー中かどうかを調べる
    *
    * @params  $login_users_id  int  ログインユーザーID
    *          $page_users_id   int  ページ所有者ユーザーID
    * @return  int
    */
    public static function checkFollower($login_users_id, $page_users_id) {
        $follower = \App\Models\User\Followers::getFollowerByUsersId($login_users_id, $page_users_id);
        if ( ! is_null($follower) ) {
            return $follower->count();
        }
        return false;
    }

    /**
    * 所有者のユーザーIDでユーザーが存在するか調べる
    *
    * @params  $users_id  int  ログインユーザーID
    * @return  bool
    */
    public static function foundCheckOwnerUser($users_id) {
        $users = \App\Models\Users::find($users_id);
        if ( ! is_null($users) && $users->count()) {
            return true;
        }
        return false;
    }

    /**
    * 画像DataURLをデコードして、対象フォルダに保存する
    * 後々storageをs3などに変更しても対応出来るようにする
    *
    * @params $data_url  string  base64の画像dataURL
    *         $mime_type string  mime type
    * @return bool
    */
    protected static function putImageBase64ToBlob($data_url, $mime_type, $file_name) {
        $image = str_replace('data:'.$mime_type.';base64,', '', $data_url);
        $image = str_replace(' ', '+', $image);
        // バイナリに戻す
        $file_data = base64_decode($image);

        // ファイル保存
        return Storage::disk('public')->put($file_name, $file_data);
    }

    // 画像削除
    protected static function deleteStorageImage($img_url) {
        return Storage::disk('public')->delete($img_url);
    }

    // 画像保存のキャッシュクリア
    public static function clearImageUploaderCache($id, $users_id, $cache_key_prefix) {
        $key = $cache_key_prefix . "_" . $id . "_" . $users_id;
        \Cache::forget($key);
    }

    // 画像キャッシュ取得
    public static function getImageUploaderCache($id, $users_id, $cache_key_prefix) {
        $key = $cache_key_prefix . "_" . $id . "_" . $users_id;
        return \Cache::get($key, null);
    }
}
