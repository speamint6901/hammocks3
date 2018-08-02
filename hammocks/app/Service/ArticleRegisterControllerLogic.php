<?php

namespace App\Service;

use Storage;
use App\Libs\SolrInput as Solr;
use App\Models\Article;
use App\Models\Items;
use App\Models\Tags;
use App\Models\User\Items as UserItems;
use App\Models\User\Container as UserContainer;
use App\Models\User\Item2Container as UserItem2Container;
use App\Models\User\Item2Tags as UserItem2Tags;

class ArticleRegisterControllerLogic extends ItemControllerLogic {

    /**
    * 記事登録処理開始
    *
    * @params $users_id     int ユーザーID
    *         $post         array  inputデータ
    *         $session_tags array セッションに格納したタグデータ
    * @return array
    */
    public static function articleRegister($users_id, $post, $session_tags) {

        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // アイテム登録
            $article = self::saveUserItemAndArticle($users_id, $post);

            if ( is_null($article) || empty($article)) {
                throw new \App\Exceptions\ItemRegisterException();
            }
            // タグ登録
            if ( ! empty($post['label'])) {
                self::saveTags($users_id, $article->id, $post['label'], $session_tags);
            }
            /*
            // コンテナを選択していれば、カウント更新
            if ( ! empty($post['ContainerSelect'])) {
                $user_container = UserContainer::on('master')->find($post['ContainerSelect']);
                $user_container->increment('count');
                $user_item2container = new UserItem2Container();
                $user_item2container->user_items_id = $user_items->id;
                $user_item2container->container_id = $user_container->id;
                $user_item2container->status = 1;
                $user_item2container->save();
            }
            */
            // コミット
            \DB::commit();
            return $article;
        // 登録時の例外
        } catch (\App\Exceptions\ItemRegisterException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            throw $e;
        // その他例外
        }
    }

    /**
    * 記事,ユーザーアイテム登録
    *
    * @params $users_id     int ユーザーID
    *         $post         array  inputデータ
    * @return App\Models\User\Items
    */
    protected static function saveUserItemAndArticle($users_id, $post) {
        $items_id = $post['items_id'];
        
        if (isset($post["pict-data-url"])) {
            $file_info = self::createFileInfo($post);
        } else {
            $file_info["user"] = null;
            $file_info["article"] = null;
        }
        // ユーザーアイテムを取得
        $user_items = UserItems::getByUsersIdAndItemsId($users_id, $items_id, true);
        // ユーザーアイテム登録
        if (is_null($user_items)) {
            $user_items = self::saveUserItem($post, $users_id, $items_id, $file_info);
        }
        
        // 記事登録
        $article = self::saveArticle($post, $users_id, $user_items, $file_info);

        // 記事カウント更新
        $items = Items::on("master")->find($items_id);
        $items->increment('article_count');
        $items->updated_at = date('Y-m-d H:i:s');
        $items->save();

        return $article;
    }

    /**
    * 記事DB保存
    *
    * @params $users_id     int ユーザーID
    *         $post         array  inputデータ
    * @return App\Models\User\Items
    */
    protected static function saveArticle($input, $users_id, $user_items, $file_info) {
        $article = new Article();
        $article->saveArticle($input, $users_id, $user_items->id, $file_info['article']);

        // 画像保存(ユーザーアイテム）
        if (isset($input['pict-data-url']) && ! empty($input['pict-data-url'])) {
            self::putImageBase64ToBlob($input['pict-data-url'], $input['pict-mimetype'], $article->img_url);
        }

        // solr登録
        self::putSolrArticle($article, $user_items);

        return $article;
    }

}
