<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Service\SearchResultControllerLogic as Logic;

class SearchController extends Controller
{
    public function showResult(Request $request) {
        //　検索ワードをsessionにセットする
        $params = \Request::input();
        //$item_ids = Logic::getSearchItemIds($params);
        $request->session()->put('search_params', $params);
        return \View::make('search.result', $this->data);
    }

    public function showCategory(Request $request) {
        //　検索ワードをsessionにセットする
        //$params = \Request::input();
        //$request->session()->put('search_params', $params);
        $this->data["sort_box"] = \Config::get("sort.master_item.select_box");
        return \View::make('search.category', $this->data);
    }

    // ブランド検索トップ
    public function showBrand() {
        // ブランドリストを取得する
        // pageは１固定（今は切り替えは行わないから）
        $this->data['brands'] = Logic::getBrandList(1);

        return \View::make('search.brand', $this->data);
    }

    // タグ検索
    public function showSelectTag($tag_id) {
        $tags = Logic::getTagsById($tag_id);
        $this->data["tags"] = $tags;
        return \View::make('search.select_tags', $this->data);
    }

    // ブランドセレクト
    public function showBrandResult($id) {
        $this->data['brands'] = Logic::findBrandById($id);
        $this->data["sort_box"] = \Config::get("sort.master_item.select_box");
        dump($this->data['brands']);
        return \View::make('search.select_brand', $this->data);
    }

    // カテゴリ、ジャンル、セカンドジャンル選択時のページ
    public function showCategoryResult($name, $id) {
        $param_key = $name . "_id";
        $param_value = $id;

        $res = null;
        if ($param_key == "category_id") {
            $res = \App\Models\Category::find($param_value);
        } elseif ($param_key == "genre_id") {
            $res = \App\Models\Genre::find($param_value);
        } elseif ($param_key == "genre_second_id") {
            $res = \App\Models\GenreSecond::find($param_value);
        } else {
            throw new \App\Exceptions\NotFoundHttpException();
        }

        $this->data["param_key"] = $param_key;
        $this->data["param_value"] = $param_value;
        $this->data["title_name"] = $res->name;
        
        $this->data["sort_box"] = \Config::get("sort.master_item.select_box");
        return \View::make('search.select_category', $this->data);
    }

}
