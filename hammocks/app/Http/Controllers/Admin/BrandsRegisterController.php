<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Http\Requests\Admin\BrandsRegisterRequest;
use App\Http\Controllers\BaseAdminController;
use App\Service\Admin\BrandsRegisterControllerLogic as Logic;

class BrandsRegisterController extends BaseAdminController
{
    // ブランド登録 トップページ表示
    public function showIndex() {

        // ブランド情報取得
        $this->data['brands'] = Logic::getBrandNames();

        return \View::make('admin.brands_register_list', $this->data);
    }

    // ブランド登録 新規登録ページ表示
    public function showBrandsAdd() {

        return \View::make('admin.brands_register_edit', $this->data);
    }

    // ブランド登録 編集ページ表示
    public function showBrandsEdit($id) {

        //更新対象ID設定
        $this->data['brand_id'] = $id;

        // ブランド情報取得
        $this->data['brands'] = Logic::getBrandInfo($id);

        return \View::make('admin.brands_register_edit', $this->data);
    }

    // ブランド登録 登録・更新処理
    public function showItemConfirm( BrandsRegisterRequest $request ) {

        $post = $request->input();

        // 管理者情報登録
        Logic::register($post);

        // ブランド情報取得
        $this->data['brands'] = Logic::getBrandNames();

        return \View::make('admin.brands_register_list', $this->data);
    }

    // ブランド登録 削除処理
    public function setBrandsDelete($id) {

        // 管理者情報登録
        Logic::softDelete($id);

        // ブランド情報取得
        $this->data['brands'] = Logic::getBrandNames();

        return \View::make('admin.brands_register_list', $this->data);
    }

}
