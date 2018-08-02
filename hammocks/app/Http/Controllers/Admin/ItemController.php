<?php

namespace App\Http\Controllers\Admin;

use Mail;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\BaseAdminController;
use App\Service\Admin\ItemControllerLogic as Logic;

class ItemController extends BaseAdminController
{

    const COMMENT_LIST_PER_PAGE = 30;

    // アイテム登録一覧ページ
    public function showIndex(Request $request) {
        $params = $request->input();
        $items = Logic::getItemList($params)->paginate(self::COMMENT_LIST_PER_PAGE);
        $this->data["items"] = $items;
        return \View::make('admin.item.index', $this->data);
    }

    // アイテム選択ページ
    public function showItemRegister($id) {
        $items = Logic::getItemDetail($id);
        $this->data["item_info"] = $items;
        return \View::make('admin.item.detail', $this->data);
    }

    // アイテム公開設定
    public function showItemStatusUp($id) {
        $items = Logic::itemStatusChange($id, 1);
        $user = \App\Models\Users::find($items->create_users_id);
        $subject = "あなたの登録されたギアが公開されました!";
        self::sendConfirmMail($user, $items, $subject);
        return redirect($this->data["path_prefix"] . '/item-register/' . $id);
    }

    // アイテム名編集
     public function showItemNameEdit(Request $request, $id) {
        $params = $request->input();
        $items = \App\Models\Items::find_status_free($id);
        $items->name = $params["name"];
        $items->save();
        return redirect($this->data["path_prefix"] . '/item-register/' . $id);
    }

    // アイテム説明文編集
     public function showItemDescriptionEdit(Request $request, $id) {
        $params = $request->input();
        $items = \App\Models\Items::find_status_free($id);
        $items->description = $params["description"];
        $items->save();
        return redirect($this->data["path_prefix"] . '/item-register/' . $id);
    }

    // 公開メール
    private function sendConfirmMail($user, $items, $subject) {
        Mail::send(
            'emails.item_status_up',
            ['user' => $user, 'items' => $items],
            function($message) use ($user, $subject) {
                $message->to($user->email, $user->name)->subject($subject);
            }
        );
    }

}
