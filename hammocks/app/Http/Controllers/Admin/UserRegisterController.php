<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests\Admin\UserRegisterRequest;
use App\Http\Controllers\BaseAdminController;
use App\Service\Admin\UserRegisterControllerLogic as Logic;

class UserRegisterController extends BaseAdminController
{
    // 管理者登録トップ
    public function showIndex( Request $request ) {

        //セッションに保存されたログイン メールアドレス 取得
        $login_email = $request->session()->get('login_email');

        $account_type = Logic::getTypeByMail($login_email);

        //admin権限でない場合、トップページへリダイレクト
        //if ( $account_type['type'] ) {
            return \View::make('admin.user_register', $this->data);
       // }
        //else {
         //   return redirect()->action('Admin\TopController@showIndex');
        //}
    }

    // 管理者登録処理
    public function showItemConfirm( UserRegisterRequest $request ) {
        $post = $request->input();

        // 管理者情報登録
        Logic::register($post);

        // 管理画面トップへリダイレクト
        return redirect()->action('Admin\TopController@showIndex');
    }
}
