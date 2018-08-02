<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ItemController;
use \App\Service\Api\ArticleControllerLogic as Logic;

class ArticleController extends ItemController
{

    const ARTICLE_LIST_PER_PAGE = 16;
    const TIMELINE_PER_PAGE = 4;

    // 記事リスト
    public function getItemList(Request $request) {
        $params = $request->input();
        if ( ! is_null($params["follower_users_id"]) && ! empty($params["follower_users_id"])) {
            $follow_user_ids = Logic::getFollowIds($params["follower_users_id"]);
            if ( ! is_null($follow_user_ids))  {
                $params["follow_user_ids"] = $follow_user_ids;
            } else {
                return new JsonResponse(["total" => 0]); 
            }
        }

        // 全文検索
        if (isset($params["search_word"]) && ! empty($params["search_word"])) { 
            $params = self::setIdsSearchWordParams($params, "article");
            if (empty($params["ids"])) {
                return new JsonResponse(["total" => 0]);        
            }
        }

        $article = Logic::getArticleList($params)->paginate(self::ARTICLE_LIST_PER_PAGE);
        return new JsonResponse($article); 
    }

    // ユーザーアイテムIDでタイムラインリスト取得
    public function getTimeline(Request $request) {
        $params = $request->input();
        $params["sort"] = "created_at";
        $owner_users_id = $params["owner_users_id"];
        $article = Logic::getTimeline($params)->paginate(self::TIMELINE_PER_PAGE);
        // 自分がpickしてるかどうかをまとめてセットする
        $article = Logic::setIsPickToArticles($this->users_id, $article);
        return new JsonResponse($article); 
    }

    // 記事プレビュー取得
    public function getItemDetail(Request $request) {
        $params = $request->input();
        $self_users_id = null;
        if (isset($this->users_id)) {
            $self_users_id = $this->users_id;
        }
        $article = Logic::getArticleInfo($params, $self_users_id);
        return new JsonResponse($article); 
    }

    // ログ記事編集
    public function editLogArticle(Request $request) {
        $params = $request->input();
        $article = Logic::editArticle($this->users_id, $params);
        return new JsonResponse($article); 
    }

    // ログ記事編集
    public function deleteLogArticle(Request $request) {
        $article_id = $request->input("article_id");
        $res = Logic::deleteLogArticle($this->users_id, $article_id);
        return new JsonResponse(["status" => $res, "article_id" => $article_id]);
    }
}
