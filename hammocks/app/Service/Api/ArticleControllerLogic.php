<?php

namespace App\Service\Api;

use App\Models\Article;
use App\Models\Article\Container as ArticleContainer;
use App\Models\Article2Container;
use App\Libs\SolrQuery as Solr;

class ArticleControllerLogic extends \App\Service\ItemControllerLogic {

    /**
    * 記事一覧を取得
    *
    * @params $params array リクエストパラメータ
    * @return App\Models\Article
    */
    public static function getArticleList($params) {
        return Article::getArticleList($params);
    }

    /**
    * タイムラインを取得する
    *
    * @params $params array リクエストパラメーた
    * @return App\Models\Article
    */
    public static function getTimeline($params = []) {
        return Article::getTimelineByAnyId($params);
    }

    /**
    * 記事詳細取得
    *
    * @params $params array postパラメータ
    * @return \App\Models\Article
    */
    public static function getArticleInfo($params, $users_id) {
        $article = Article::findDetailById($params["article_id"]);
        if ( is_null($article) || empty($article)) {
            throw new \App\Exceptions\ApiAuthException("記事が見つかりませんでした");
        }
        $article->is_self_pick = 0;
        // ログイン中ならpickしてるかチェックする
        if ( ! is_null($users_id)) {
            $article->is_self_pick = ArticleContainer::checkByArticleIdAndUsersId($article->article_id, $users_id);    
        }
        // アイテム評価を取得
        $article->evaluation_average_path = 0;
        $article->evaluation_num = 0;
        $evaluation = \App\Models\Item\EvaluationUsers::findByUsersIdAndItemsId($users_id, $article->items_id);
        if ( ! is_null($evaluation) && ! empty($evaluation)) {  
            $article->evaluation_average_path = self::createAverageFileName($evaluation->evaluation_num);
            $article->evaluation_num = $evaluation->evaluation_num;
        }
        // タグ
        $tags = \App\Models\Tags::getUserTagsByUserItemsId($article->article_id);
        if ( ! is_null($tags) && ! empty($tags)) {
            $article->tags = $tags;
        }

        return $article;
    }

    /**
    * 記事編集
    *
    * @params  $users_id  int     ユーザーID
    *          $params    array   postパラメータ
    * @return  \App\Models\Article
    */
    public static function editArticle($users_id, $params) {

        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // 本人の記事かチェックする為users_idも条件に加える（不正防止)
            $article = Article::findArticleByIdAndUsersId($params["article_id"], $users_id, 1);

            if ( ! is_null($article) && ! empty($article) ) {
                $article->article_text = $params["article_text"]; 
                $article->save();
            } else {
                throw new \App\Exceptions\ItemEditException("ログが見つからなかった為、更新できませんでした");
            }
             // コミット
            \DB::commit();
            return $article;
        } catch (\App\Exceptions\ItemEditException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }    
    }

    /**
    * 記事削除
    *
    * @params  $users_id  int     ユーザーID
    *          $params    array   postパラメータ
    * @return  string
    */
    public static function deleteLogArticle($users_id, $article_id) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // 本人の記事かチェックする為users_idも条件に加える（不正防止)
            $article = Article::findArticleByIdAndUsersId($article_id, $users_id, 1);
            $img_url = $article->article_img_url;

            if ( ! is_null($article) && ! empty($article) ) {
                $article->deleteArticleRelations();
            } else {
                throw new \App\Exceptions\ItemEditException("ログが見つからなかった為、削除できませんでした");
            }

            // コミット
            \DB::commit();

            // 画像削除
            self::deleteStorageImage($img_url);
            return true;
        } catch (\App\Exceptions\ItemEditException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }
    }
}
