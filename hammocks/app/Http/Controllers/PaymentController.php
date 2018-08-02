<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
        if (is_null($this->user)) {
            // TODO リダイレクトを書く
            return Redirect::to('/auth/login')->send();
        }
    }

    // 決済ステータスページ
    public function showStatus(Request $request) {
        return \View::make('payment.status', $this->data);
    }

    // 売る側
    public function showSeller($page) {
        return \View::make('payment.seller.page'.$page, $this->data);
    }

    // 購入確認
    public function showConfirm($id) {
        return \View::make('payment.confirm', $this->data);
    }

    // 買う側
    public function showCustomer($page) {
        return \View::make('payment.customer.page'.$page, $this->data);
    }
}
