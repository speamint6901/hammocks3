<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Service\TopControllerLogic as Logic;

class TopController extends Controller
{

    const SEARCH_WORD_PER_PAGE = 16;

    public function showIndex() {
        $this->data["sort_box"] = \Config::get("sort.master_item.select_box");
        $this->data["word"] = "";
        return \View::make('index', $this->data);
    }

    // 全文検索（サーチバーsubmit)
    public function showWordSearch(Request $request) {
        $this->data["filter_id"] = $request->input("filter_id");
        $this->data["sort_box"] = \Config::get("sort.master_item.select_box");
        $this->data["word"] = $request->input("s");
        $this->data["per_page"] = self::SEARCH_WORD_PER_PAGE;
        return \View::make('index', $this->data);
    }
}
