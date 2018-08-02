<?php

namespace App\Service\Api;

use App\Models\Article;
use App\Models\Article\Container as ArticleContainer;
use App\Models\Article2Container;

class UserContainerControllerLogic extends \App\Service\Base {

    const CONTAINER_ITEM_PER_PAGE = 4;

    /**
    * ユーザーコンテナ登録処理
    * 
    * @params $users_id  int     ユーザーID
    *         $post      array   input データ
    * @return array
    */
    public static function registUserContainer($users_id, $post) {
        \DB::beginTransaction();
        try {
            // コンテナの制限数を超えてないかチェック
            if (ArticleContainer::getCountByUsersId($users_id, 1) > 29) {
               throw new \App\Exceptions\ArticleContainerException("作成できるコンテナは３０個までです"); 
            }
            // 同名のコンテナが存在しないかチェックする
            if (ArticleContainer::checkByUsersIdAndName($users_id, $post['MakeContainer'], 1)) {
                throw new \App\Exceptions\ArticleContainerException("同じ名前のコンテナが既に存在します");
            }

            // 存在しなければ、保存処理
            $user_container = new ArticleContainer();
            $user_container->users_id = $users_id;
            $user_container->name = $post['MakeContainer'];
            $user_container->count = 0;
            $user_container->status = 0;
            $user_container->save();
            // セレクトボックス追加用にkey valueの形式で返す
            $params['per_page'] = self::CONTAINER_ITEM_PER_PAGE;
            $user_container = self::setContainerLog($user_container, $params);
            \DB::commit();
            return $user_container;
        } catch (\App\Exceptions\ArticleContainerException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }
    }

    /**
    * コンテナ一覧取得
    * 
    * @params $users_id  int     ユーザーID
    *         $params    array   input データ
    * @return array
    */
    public static function getContainerList($users_id, $params) {
        $containers = ArticleContainer::getByUsersId($users_id, $params);        
        if ( ! $containers->count()) {
            return [];
        }
        return self::setContainerLogs($containers);
    }

    /* コンテナリストの持っているlogを規定数セットする
    *
    * @params  \App\Models\Article\Container
    * @return  array
    */
    public static function setContainerLogs($containers) {
        $tmp_containers = [];
        $params['per_page'] = self::CONTAINER_ITEM_PER_PAGE;
        foreach ($containers as $key => $container) {
            $tmp_containers[$key] = self::setContainerLog($container, $params);
        }
        return $tmp_containers;
    }

    /**
    * コンテナの持っているlogを規定数セットする
    *
    * @$container  \App\Models\Article\Container
    * @return array
    */
    public static function setContainerLog($container, $params) {
        $tmp_container = [];
        $tmp_container = $container;
        $tmp_container['items'] = Article2Container::getContainerItems($container->id, $params);
        return $tmp_container;
    }

    /**
    * コンテナ編集
    *
    * @params  $users_id       int  ユーザーID
    *          $container_id   int  コンテナID
    * @return  self
    */
    public static function editContainer($users_id, $params) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // 対象の自信のコンテナを取得
            $article_container = ArticleContainer::findByUsersIdAndId($users_id, $params['container_id']);

            // 自分のコンテナかチェックする
            if ( is_null($article_container) || empty($article_container)) {
                throw new \App\Exceptions\ApiAuthException("コンテナが見つかりません");
            }

            $article_container->name = $params["name"];
            $article_container->status = $params["status"];
            $article_container->save();
            // コミット
            \DB::commit();
            return $article_container;

        } catch (\App\Exceptions\ApiAuthException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }
    }

    /**
    * pickをコンテナに追加
    *
    * @params $users_id  int     ユーザーID
    *         $params    array   postパラメータ
    * @return void
    */
    public static function addPick($users_id, $params) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // 対象のコンテナを取得
            $article_container = ArticleContainer::findByUsersIdAndId($users_id, $params["container_id"], 1);
            if ( is_null($article_container) || count($article_container) == 0) {
                throw new \App\Exceptions\ArticleContainerException("コンテナが見つかりません");
            }

            // コンテナのカウントを更新する
            $article_container->increment("count");
            
            // pickが登録済みか確認する
            $article2_container = Article2Container::findByArticleIdAndContainerId($params["article_id"], $params["container_id"], 1);
            if ( ! is_null($article2_container) || ! empty($article2_container)) {
                throw new \App\Exceptions\ArticleContainerException("既に登録済みのログです");    
            }
            $article2_container = new Article2Container();
            $article2_container->article_id = $params["article_id"];
            $article2_container->container_id = $params["container_id"];
            $article2_container->status = 1;
            $article2_container->save();

            // 記事のカウント更新
            $article = Article::on("master")->find($params["article_id"]);
            $article->increment("count");

            // ユーザーインフォカウント更新
            $user_info_count = \App\Models\User\InfoCount::where('users_id', $users_id)->first();
            $user_info_count->increment('clip_count');

            // コミット
            \DB::commit();
            return $article;
        } catch (\App\Exceptions\ArticleContainerException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }
    }

    /**
    * コンテナの中のログ削除
    *
    * @params  $users_id  int     ユーザーID
    *          $params    array   postパラメータ
    * @return  void
    */
    public static function removeLogContainer($users_id, $params) {

        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // 対象の自信のコンテナを取得
            $article_container = ArticleContainer::findByUsersIdAndId($users_id, $params['container_id'], 1);

            // 自分のコンテナかチェックする
            if ( is_null($article_container) || empty($article_container)) {
                throw new \App\Exceptions\ApiAuthException("コンテナが見つかりません");
            }

            // article2containerから削除
            Article2Container::deleteArticleByArticleId($params["container_id"], $params["article_id"]);

            // コンテナのカウント更新
            $article_container->decrement("count");

            // articleのカウント更新
            $article = Article::find($params["article_id"]);
            $article->decrement("count");

            // user_info_count更新
            $user_info_count = \App\Models\User\InfoCount::where("users_id", $users_id)->first();
            $user_info_count->decrement("clip_count");

            // コミット
            \DB::commit();
            return $params["article_id"];

        } catch (\App\Exceptions\ApiAuthException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }
    }

    /**
    * コンテナを削除
    *
    * @params  $users_id  int    ユーザーID
    *          $params    array  postパラメータ
    * @return  void
    */
    public static function removeContainer($users_id, $params) {
         // トランザクションの開始
        \DB::beginTransaction();
        try {
            // 対象の自信のコンテナを取得
            $article_container = ArticleContainer::findByUsersIdAndId($users_id, $params['container_id'], 1);

            // 自分のコンテナかチェックする
            if ( is_null($article_container) || empty($article_container)) {
                throw new \App\Exceptions\ApiAuthException("コンテナが見つかりません");
            }

            // article2containerから削除
            $article_ids = Article2Container::deleteByContainerId($params["container_id"]);

            if ( ! is_null($article_ids) && ! empty($article_ids)) {
                // 一次元配列に変換
                $article_ids = array_map(function($a) {
                    return $a["article_id"]; 
                },$article_ids);

                // articleのカウント更新
                $article_list = Article::whereIn("id", $article_ids)->get();
                $pick_count = $article_list->count();
                foreach ($article_list as $article) {
                    $article->decrement("count");
                }

                // user_info_count更新
                $user_info_count = \App\Models\User\InfoCount::where("users_id", $users_id)->first();
                $user_info_count->decrement("clip_count", $pick_count);
            }

            // article_containerの削除
            $article_container->delete();

            // コミット
            \DB::commit();
            return $params["container_id"];

        } catch (\App\Exceptions\ApiAuthException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }       
    }

    /**
    * コンテナのロック、アンロック切り替え
    *
    * @params  $users_id  int    ユーザーID
    *          $params    array  postパラメータ
    * @return  void
    */
    public static function toggleLockContainer($users_id, $params) {
         // トランザクションの開始
        \DB::beginTransaction();
        try {
            // 対象の自信のコンテナを取得
            $article_container = ArticleContainer::findByUsersIdAndId($users_id, $params['container_id'], 1);

            // 自分のコンテナかチェックする
            if ( is_null($article_container) || empty($article_container)) {
                throw new \App\Exceptions\ApiAuthException("コンテナが見つかりません");
            }

            $article_container->status = $params["status"];
            $article_container->save();

            // コミット
            \DB::commit();
            return $params["container_id"];

        } catch (\App\Exceptions\ApiAuthException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        }       
    }
}
