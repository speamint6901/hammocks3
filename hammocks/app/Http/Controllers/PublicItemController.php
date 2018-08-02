<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Service\PublicItemControllerLogic as Logic;

class PublicItemController extends Controller
{

    // パブリックアイテムtopページ
    public function showIndex($id) {
        // アイテムIDから情報を取得する
        $this->data['item_info'] = Logic::getItemInfo($id, $this->users_id);
        // アイテムに紐づくuser_itemの一覧を取得する
        return \View::make('item.master.index', $this->data);
    }

    public function showPublicItemRating($id) {
        // アイテムIDから情報を取得する
        $this->data['item_info'] = Logic::getItemInfo($id, $this->users_id);

        // アイテムに紐づくuser_itemの一覧を取得する
        return \View::make('item.master.rating', $this->data);
    }

    // パブリックアイテムフォトページ
    public function showPublicItemPhoto($id) {
        // アイテムIDから情報を取得する
        $this->data['item_info'] = Logic::getItemInfo($id, $this->users_id);
        return \View::make('item.master.photo', $this->data);
    }

    // パブリックアイテムセールページ
    public function showPublicItemSale($id) {
        // アイテムIDから情報を取得する
        $this->data['item_info'] = Logic::getItemInfo($id, $this->users_id);
        return \View::make('item.master.sale', $this->data);
    }

}
