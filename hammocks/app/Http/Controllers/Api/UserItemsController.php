<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ItemController;
use \App\Service\Api\UserItemsControllerLogic as Logic;

class UserItemsController extends ItemController
{

    const COMMENT_LIST_PER_PAGE = 16;
    const PHOTO_LIST_PER_PAGE = 20;

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    // ユーザーアイテムリストを返す
    public function getUserItemList(Request $request) {
        $params = $request->input();
        if ( ! is_null($params["follower_users_id"]) && ! empty($params["follower_users_id"])) {
            $follow_user_ids = Logic::getFollowIds($params["follower_users_id"]);
            if ( ! is_null($follow_user_ids))  {
                $params["follow_user_ids"] = $follow_user_ids;
            } else {
                return new JsonResponse(["total" => 0]); 
            }
        }

        if (isset($params["search_word"]) && ! empty($params["search_word"])) { 
            $params = self::setIdsSearchWordParams($params, "items");
            if (empty($params["ids"])) {
                return new JsonResponse(["total" => 0]);        
            }
        }

        $user_items = Logic::getItemList($params)->paginate(self::COMMENT_LIST_PER_PAGE); 
        return new JsonResponse($user_items);
    }

    // ユーザーアイテム評価リストを返す
    public function getUserItemRatingList(Request $request) {
        $params = $request->input();
        $user_items = Logic::getItemRating($params)->paginate(self::COMMENT_LIST_PER_PAGE); 
        return new JsonResponse($user_items);
    }

    // public/item/comment/{1} ページのユーザーアイテムリスト取得
    public function getUserItemsCommentPage() {
        $user_items = Logic::getUserItemCommentListByItemId($this->params); 
        return new JsonResponse($user_items);
    }

    // public/item/photo/{1} ページのユーザーアイテムリスト取得
    public function getUserItemsPhotoPage() {

        // ポストされたフィルターを取得する
        $params = \Request::input();
        // デフォルトは登録日時
        $params['sort'] = 'created_at';
        if (!isset($params['offset'])) {
            $params['offset'] = 0;
        }

        $params['per_page'] = self::PHOTO_LIST_PER_PAGE;
        $user_items = Logic::getUserItemPhotoListByItemId($params); 
        return new JsonResponse($user_items);
    }

    // public/item/sale/{1} ページのユーザーアイテムリスト取得
    public function getUserItemsSalePage() {

        // ポストされたフィルターを取得する
        $params = \Request::input();
        // デフォルトは登録日時
        $params['sort'] = 'created_at';
        if (!isset($params['offset'])) {
            $params['offset'] = 0;
        }

        $params['per_page'] = self::PHOTO_LIST_PER_PAGE;
        $user_items = Logic::getUserItemSaleListByItemId($params); 
        return new JsonResponse($user_items);
    }

    // sessionに保存していたパラメータを元に検索結果をjsonで返す
    public function getSearchResultItems(Request $request) {

        if (!$request->session()->has('search_params')) {
            return;
        }

        $keyword = $request->session()->get('search_params', null);
        $user_items = Logic::getSearchItemKeyword($this->params, $keyword, $this->users_id);
        return new JsonResponse(["user_items" => $user_items, "offset" => $this->result_offset]);
    }

    // アイテム重複登録チェック
    public function hasItemByUser(Request $request) {
        $items_id = $request->input("item_id");
        $has_item = Logic::hasItemByUser($this->users_id, $items_id);
        return new JsonResponse(["has_item" => $has_item]);
    }

    // タグリスト表示
    public function getDispTagList(Request $request) {
        $user_items_id = $request->input("user_items_id", null);
        if ( is_null($user_items_id)) {
            return new JsonResponse([]);
        }
        $tag_list = Logic::getTagListByUserItemsId($user_items_id);
        return new JsonResponse($tag_list);
    }

    // ユーザーアイテム編集
    public function updateUserItems(Request $request) {
        if (is_null($this->user)) {
            throw new \App\Exceptions\ItemEditException("dont auth");
        }
        $input = $request->input();
        $session_tags = $request->session()->get('tags', null);
        $result_data = Logic::updateUserItem($input, $this->users_id, $session_tags);
        return new JsonResponse($result_data);
    }

    // ユーザー評価をセッションに保存
    public function saveSessionRating(Request $request) {
        if (is_null($this->user)) {
            throw new \App\Exceptions\ItemEditException("dont auth");
        }
        $items_id = $request->input("items_id");
        $rate = $request->input("rate");
        $response = Logic::saveItemRate($items_id, $this->users_id, $rate);
        return new JsonResponse($response);
    }

    // 問題報告
    public function sendBanReport(Request $request) {
        $params = $request->input();
        Logic::sendBanReport($params);
        return new JsonResponse(["message" => "問題を報告しました"]);
    }
}
