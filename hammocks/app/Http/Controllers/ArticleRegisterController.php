<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRegisterPostRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ItemController;
use App\Service\ArticleRegisterControllerLogic as Logic;

class ArticleRegisterController extends ItemController
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    // 記事登録ページ
    public function showArticleRegister($id, Request $request) {
         // キャッシュクリア
         $this->clearImageUploaderCache($id, "article");
         $items = Logic::getItemById($id);
         if (is_null($items) || empty($items)) {
            throw new \App\Exceptions\NotFoundUserException();
         }
         $this->data['items'] = $items;
         $this->data['upload_type'] = "article";
         return \View::make('item.article-register', $this->data);
    }

    // 記事登録
    public function articleConfirm(ArticleRegisterPostRequest $request) {
        $params = $request->input();
        $session_tags = $request->session()->get('tags', null);

        // キャッシュから画像情報を取得
        $cache_key = "article" . "_" . $params["items_id"] . "_" . $this->users_id;
        $img_cache = \Cache::get($cache_key, null); 
        if ( ! is_null($img_cache) && ! empty($img_cache)) {
            $params["pict-data-url"] = $img_cache[0]["data_url"];
            $params["pict-mimetype"] = $img_cache[0]["mime_type"];
        }

        // rateをセッションから取り出す
        $params["rate"] = $request->session()->get("item_rate", null);

        $article = Logic::articleRegister($this->users_id, $params, $session_tags);
        return redirect("user/log/" . $article->user_items_id);
    }

}
