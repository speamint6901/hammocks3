<?php

namespace App\Service\Api;

use App\Models\User\Items as UserItems;

class UserItemClipControllerLogic extends \App\Service\Base {

    /**
    * 欲しい、持ってるカウント更新
    *
    * @params  $params  array  パラメータ
    * @return  array
    */
    public static function updateFavCounts($params) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            $fav_info = UserItems::updateFavCounts($params);
            // コミット
            \DB::commit();
        } catch (Exception $e) {
            // ロック解除
            \DB::rollBack();
            throw $e;
        }
        return $fav_info;
    }

}
