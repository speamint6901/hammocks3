<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests\Admin\AuthControllerRequest;
use App\Http\Controllers\BaseAdminController;
use App\Service\Admin\AuthControllerLogic as Logic;

class AuthController extends BaseAdminController
{
    // 管理画面ログインページ
    public function showIndex() {
        return \View::make('admin.index', $this->data);
    }


    // ログインチェック処理
    public function postLogin(AuthControllerRequest $request ) {

        $post = $request->input();

        // ログイン情報 セッション保存
        $request->session()->put('login_email', $post['email']);

        // 管理画面トップへリダイレクト
        return redirect()->action('Admin\TopController@showIndex');
    }


    // ログアウト処理
    public function getLogout( Request $request ) {

        // ログイン情報 セッション破棄
        $request->session()->forget('login_email');

        return \View::make('admin.index', $this->data);
    }
}
