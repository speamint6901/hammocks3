<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseApiController;
use \App\Service\Api\UserSettingControllerLogic as Logic;

class UserSettingController extends BaseApiController
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    // アバター、背景画像更新
    public function updateUserImage(Request $request) {
        $type = $request->input("type");
        $image = $this->getImageUploaderCache(1, $type);
        Logic::updateUserImages($this->users_id, $image);
    }

    // 本人確認書類アップロード
    public function updateIdentificationImage(Request $request) {
        $type = $request->input("type");
        $image = $this->getImageUploaderCache(1, $type);
        Logic::updateIdentificationImages($this->users_id, $image);
    }

    // TAB1更新(基本情報)
    public function updateTabOne(Request $request) {
        $params = $request->input("params");
        Logic::updateStandardData($this->users_id, $params);
    }

    // パスワード変更
    public function updatePassword(Request $request) {
        $params = $request->input();
        $user = Logic::updatePassword($this->users_id, $params);
        return new JsonResponse(["user" => $user, "message" => "パスワードを変更しました"]);
    }

    public function updateTabTwo(Request $request) {

    }

    public function updateTabThree(Request $request) {

    }

}
