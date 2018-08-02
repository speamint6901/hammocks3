<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseApiController;
use \App\Service\Api\AutoCompleteControllerLogic as Logic;

class AutoCompleteController extends BaseApiController
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
        if (is_null($this->user)) {
            //throw new \Exception("dont auth");
        }
    }

    // ブランド補完用リスト
    public function getBrandList() {
        $brands = Logic::getBrandAll();
        return new JsonResponse($brands);
    }

    // タグ補完用リスト
    public function getTagList(Request $request) {
        $tags = Logic::getTags($this->users_id);
        // 登録時にidと照合する用にセッション格納
        $request->session()->put('tags', $tags['sessionTags']);
        return new JsonResponse($tags['responseTags']);
    }

    // アイテム補完用リスト
    public function getItemList(Request $request) {
        $brands_id = $request->input('brand_id');
        // アイテム名でpublic itemから検索し、一致したら返す
        $items = Logic::getItems($brands_id);
        // 登録時にidと照合する用にセッション格納
        return new JsonResponse($items);
    }

    // 大カテゴリ選択時の子セレクトボックスと連携
    public function getCategoryList(Request $request) {
        $big_category_id = $request->input('CategorySelect');
        // アイテム名でpublic itemから検索し、一致したら返す
        $categories = Logic::getCategories($big_category_id);
        // 登録時にidと照合する用にセッション格納
        return new JsonResponse($categories);
    }

    // カテゴリ選択時の子セレクトボックスと連携
    public function getGenreList(Request $request) {
        $category_id = $request->input('genreselect');
        // アイテム名でpublic itemから検索し、一致したら返す
        $genres = Logic::getGenres($category_id);
        // 登録時にidと照合する用にセッション格納
        return new JsonResponse($genres);
    }

    // ジャンル選択時の子セレクトボックスと連携
    public function getSecondGenreList(Request $request) {
        $genre_id = $request->input('Sub_GenreSelect');
        // アイテム名でpublic itemから検索し、一致したら返す
        $genres = Logic::getSecondGenres($genre_id);
        // 登録時にidと照合する用にセッション格納
        return new JsonResponse($genres);
    }
}
