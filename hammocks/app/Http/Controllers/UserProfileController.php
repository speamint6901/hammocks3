<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use App\Service\UserProfileControllerLogic as Logic;

class UserProfileController extends Controller
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
        if (is_null($this->user)) {
            // TODO リダイレクトを書く
            //throw new \Exception("dont auth");
        }
    }

    public function showIndex() {
        //todo user id取得(後日auth処理実装)
        return \View::make('user.index', $this->data);
    }

}
