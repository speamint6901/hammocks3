<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseApiController;
use \App\Service\Api\PublicItemControllerLogic as Logic;

class PublicItemController extends \App\Http\Controllers\ItemController
{

    const COMMENT_LIST_PER_PAGE = 16;
    const ITEM_COMPLETION_LIST_LIMIT = 10;

    // アイテムリストを返す(public パターン)
    public function getItemList(Request $request) {
        $params = $request->input();
        //$owner_users_id = null; 
        $owner_users_id = $this->users_id;
        // have,wantで絞り込む際にその人のユーザーIDを渡す
        if (isset($params["owner_users_id"]) && ! empty($params["owner_users_id"])) {
            $owner_users_id = $params["owner_users_id"];
        }

        if (isset($params["search_word"]) && ! empty($params["search_word"])) { 
            $params = self::setIdsSearchWordParams($params, "items");
            if (empty($params["ids"])) {
                return new JsonResponse(["total" => 0]);        
            }
        }
            
        $items = Logic::getItemList($params, $owner_users_id)->paginate(self::COMMENT_LIST_PER_PAGE);
        $items = Logic::setPriceAndSaleCount($items);
        return new JsonResponse($items);
    }

    // カテゴリ検索
    public function getSearchItemsByCategory(Request $request) {
        $params = $request->input();
        $session_key = "categories";
        if ($params['key'] == "brands_id") {
            $session_key = "brands";
        }
        $request->session()->put($session_key, $params);
        $searchParams[$session_key] = $params;
        if ($session_key == "brands") {
            $searchParams["categories"] = $request->session()->get("categories", null);
        } else {
            $searchParams["brands"] = $request->session()->get("brands", null);
        }
        
        $items = Logic::getItemsByAnyId($searchParams);
        return new JsonResponse($items);
    }

    // 登録時の候補検索
    public function getCompletionItems(Request $request) {
        //self::setPagingInfo($request, 50);
        $params = $request->input();
        $word = $request->input('word');
        $brands_id = $request->input('brands_id');
        $items = Logic::getCompletionItems($params, $brands_id, $word);
        return new JsonResponse(["items" => $items, "word" => $word, "offset" => 0]); 
    }

}
