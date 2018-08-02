<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Service\UserArchiveControllerLogic as Logic;

class UserArchiveController extends Controller
{
    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    // 出品リスト
    public function showSales(Request $request) {
        return \View::make('user.archive.sales', $this->data);
    }

    // 購入リスト
    public function showPurchase(Request $request) {
        return \View::make('user.archive.purchase', $this->data);
    }
}
