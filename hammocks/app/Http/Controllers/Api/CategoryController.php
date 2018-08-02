<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseApiController;
use App\Service\Api\CategoryControllerLogic as Logic;

class CategoryController extends BaseApiController
{

    // カテゴリ、ジャンルリストを取得する
    public function getCategoryList(Request $request) {
        $big_category_id = $request->input('big_category_id');
        $categories = Logic::getCategoryAndGenreList($big_category_id);
        $big_categories = \Config::get('category.select');
        $big_category_name = $big_categories[$big_category_id];

        return new JsonResponse(['list' => $categories, 'name' => $big_category_name]);
    }

    // ブランドモーダルのリストを取得する
    public function getModalBrandList(Request $request) {
        $params = $request->input();
        $brands = Logic::getModalBrandListByAnyId($params);
        return new JsonResponse($brands);
    }
}
