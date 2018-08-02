<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Service\UserArchiveControllerLogic as Logic;

class GuideController extends Controller
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    // ユーザーガイド
    public function showUser(Request $request) {
        return \View::make('guide.users_guide', $this->data);
    }

    // プライバシーポリシー
    public function showPrivacyPolicy(Request $request) {
        return \View::make('guide.privacy_policy', $this->data);
    }

    // 禁止出品物
    public function showProhibitions(Request $request) {
        return \View::make('guide.prohibitions', $this->data);
    }

    // 利用規約
    public function showAup(Request $request) {
        return \View::make('guide.aup', $this->data);
    }

    // 禁止行為
    public function showProhibitedActs(Request $request) {
        return \View::make('guide.prohibited-acts', $this->data);
    }

    // 特定商取引法
    public function showCommercial() {
        return \View::make('guide.commercial_law', $this->data);
    }

}
