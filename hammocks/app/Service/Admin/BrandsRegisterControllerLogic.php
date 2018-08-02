<?php

namespace App\Service\Admin;

use App\Service\Base;
use App\Models\Brands as Brands;

class BrandsRegisterControllerLogic extends Base {

    /**
    * ブランドリストを取得する
    *
    * @params
    * @return array
    */
    public static function getBrandNames() {
        return Brands::getBrandNames()->toArray();
    }

    /**
     * ブランド情報をブランドIDで抽出する
     *
     * @params
     * @return array
     */
    public static function getBrandInfo($id) {
        return Brands::getBrandInfo($id)->toArray();
    }

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

            Brands::saveBrand($post);

            // コミット
            \DB::commit();

        } catch (Exception $e) {

            // ロールバック、ロック解除
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * ブランド情報を削除
     *
     * @params
     * @return array
     */
    public static function softDelete($id) {
        Brands::softDelete($id);
    }
}
