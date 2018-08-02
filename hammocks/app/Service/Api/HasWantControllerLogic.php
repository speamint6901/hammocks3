<?php

namespace App\Service\Api;

use App\Models\User\Items as UserItems;

class HasWantControllerLogic extends \App\Service\Base {

    /**
    * 欲しい、持ってるカウント更新
    *
    * @params  $params  array  パラメータ
    * @return  array
    */
    public static function updateHasWantCounts($params) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            $item_info = UserItems::updateHasWantCounts($params);
            // コミット
            \DB::commit();
        } catch (Exception $e) {
            // ロック解除
            \DB::rollBack();
            throw $e;
        }
        return $item_info;
    }

}
