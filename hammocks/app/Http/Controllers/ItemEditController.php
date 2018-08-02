<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ItemController;
use App\Service\ItemEditControllerLogic as Logic;

class ItemEditController extends ItemController
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
        if (is_null($this->user)) {
            // TODO リダイレクトを書く
            return redirect("/");
        }
    }

    // アイテム編集実行
    public function editItem(Request $request) {
        var_dump($request->input());exit;
        return redirect("user/item/2");
    }
}
