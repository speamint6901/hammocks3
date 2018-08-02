<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use App\Service\UserGarageController as Logic;

class UserGarageController extends Controller
{

    //　認証チェック
    public function __construct() {
        parent::__construct();
        if (is_null($this->user)) {
            // TODO リダイレクトを書く
            Redirect::to('/auth/login')->send();
        }
    }

    public function showIndex() {
        //todo user id取得(後日auth処理実装)
        return \View::make('user.index', $this->data);
    }

}
