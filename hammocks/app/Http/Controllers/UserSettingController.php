<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Service\UserSettingControllerLogic as Logic;

class UserSettingController extends Controller
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
        /*
        if (is_null($this->user)) {
            // TODO リダイレクトを書く
            return Redirect::to('/auth/login')->send();
        }
        */
    }

    // ユーザー設定
    public function showIndex() {

        self::clearImageUploaderCache(1, "user_avater");
        self::clearImageUploaderCache(1, "user_background");

        // ユーザー情報を取得
        $this->data['user_info'] = Logic::getUserInfo($this->users_id);

        // 都道府県一覧(プルダウン用）
        $this->data['prefectures'] = Logic::getPrefectures()->toArray();

        return \View::make('user.setting', $this->data);
    }

    // 本人確認書類アップロードページ
    public function showIdentification() {
        self::clearImageUploaderCache(1, "identification");
        return \View::make('user.setting.identification', $this->data);
    }

    // 基本情報入力単独ぺージ
    public function showBasicInfo() {
        return \View::make('user.setting.basic_information', $this->data);
    }

    // 購入者情報入力単独ページ
    public function showPurchaser() {
        return \View::make('user.setting.purchaser', $this->data);
    }

    // 出品者情報入力単独ページ
    public function showSeller() {
        return \View::make('user.setting.seller', $this->data);
    }

    // 売り上げ管理
    public function showSales() {
        return \View::make('user.setting.sales', $this->data);
    }

    // sms認証ページ
    public function showSms() {
        return \View::make('user.setting.sms', $this->data);
    }

    // sms認証ページ
    public function resultSms() {
        return \View::make('user.setting.sms2', $this->data);
    }

}
