<?php

namespace App\Service;

use Storage;
use App\Libs\SolrInput as Solr;
use App\Libs\SolrQuery as SolrQuery;
use App\Models\Items;
use App\Models\Tags;
use App\Models\User\Items as UserItems;
use App\Models\User\Container as UserContainer;
use App\Models\Article2Tags as Article2Tags;
use App\Models\Item\Evaluation as ItemEvaluation;
use App\Models\Item\EvaluationUsers as ItemEvaluationUsers;
use App\Models\Mst\ItemConditions;

class ItemControllerLogic extends Base {

    /**
    * public itemをIDで一件取得
    *
    * @params  $id  int  items_id
    * @return  App\Models\Items
    */
    public static function getItemById($items_id) {
        return Items::getItemById($items_id);
    }

    /**
    * ログをidで取得
    *
    * @params  $article_id  int  記事ID
    * @return  \App\Models\Article
    */
    public static function findLogById($article_id) {
        return \App\Models\Article::findTimelineById($article_id);
    }

    /**
    * アイテムの状態（mst_item_conditions)のリストを取得
    *
    * @return \App\Models\Mst\ItemConditions
    */
    public static function getMstItemConditions() {
        return ItemConditions::all();
    }

    /**
    * 宅配業者マスタから全取得
    *
    * @return \App\Models\Mst\DeliveryCompany
    */
    public static function getMstDeliveryCompany() {
        return \App\Models\Mst\DeliveryCompany::all();
    }

    /**
    * 発送日一覧を全取得
    *
    * @return array
    */
    public static function getDeliveryDayNums() {
        return \App\Models\SaleItemInfo::getDeliveryDayNums();
    }

    /**
    * フォロー中のユーザーIDを取得
    *
    * @params $users_id  int  ユーザーID
    * @return $user_ids  array
    */
    public static function getFollowIds($users_id) {
        $follows = \App\Models\User\Followers::getFollwsByUserFollowId($users_id)->toArray();
        if (is_null($follows) || empty($follows)) {
            return null;
        }
        $tmp = [];
        $tmp = array_map(function($follow) {
            return $follow["users_id"];
        }, $follows);
        return $tmp;
    }

    /**
    * ピックされているかチェックしたものをタイムラインに含める
    *
    * @params  $users_id  int    ユーザーID
    *          $article   array  記事モデル
    * @return  \App\Models\Article
    */
    public static function setIsPickToArticles($users_id, $article) {
        $article_list = $article->getCollection();
        foreach ($article_list as $data) {
            $data->is_pick = self::setIsPickToArticle($users_id, $data);
        } 
        return $article;
    }

    public static function setIsPickToArticle($users_id, $article) {
        return self::checkHasPickInArticle($users_id, $article->id);
    }

    public static function checkHasPickInArticle($users_id, $article_id) {
        $count = \App\Models\Article2Container::hasPickInArticle($users_id, $article_id)->count();
        if ($count) {
            return true;
        }
        return false;
    }

    /**
    * public item 保存（画像含む)
    *
    * @params $input      array 入力値
    *         $file_info  array ファイル情報
    * @return $items?id   int   アイテムID
    */
    public static function savePublicItem($input, $file_info, $users_id) {
        $items = new Items();
        $items->saveItems($input, $file_info, $users_id);
        // 画像保存(パブリックアイテム）
        if (isset($input['pict_result_img']) && ! empty($input['pict_result_img'])) {
            self::downloadAndPutImage($input['pict_result_img'], $items->img_url);
        } else {
            self::putImageBase64ToBlob($input['pict-data-url'], $input['pict-mimetype'], $items->img_url);
        }
        // solr登録
        self::putSolrItems($items);

        return $items;
    }

    /**
    * user items の保存（画像含む）
    *
    * @params $input     array 入力値
    *         $users_id  int   ユーザーID
    *         $items_id  int   アイテムID
    *         $file_into array ファイル情報
    * @return $user_items  App\Models\User\Items
    */
    public static function saveUserItem($input, $users_id, $items_id, $file_info) {
        $user_items = new UserItems();
        $user_items->saveItems($input, $users_id, $items_id, $file_info['user']);

        // 画像保存(ユーザーアイテム）
        if (isset($input['pict-data-url']) && ! empty($input['pict-data-url'])) {
            self::putImageBase64ToBlob($input['pict-data-url'], $input['pict-mimetype'], $user_items->img_url);
        }

        // solr登録
        //self::putSolrUserItems($user_items);

        return $user_items;
    }

    /**
    * ユーザーアイテムの画像を変更する
    *
    * @params $input          array  postされたデータ
    *         $user_items_id  int    ユーザーアイテムID
    * @return \App\Models\User\Items
    */
    public static function updateUserItemImage($input, $user_items) {
        // storageパスの指定
        $file_info = self::createFileInfo($input);

        Storage::disk('public')->delete($user_items->img_url);
        $user_items->img_url = $file_info['user']['path'] . $user_items->id . $file_info['user']['ext'];
        if (isset($input['site_img_url']) && ! empty($input['site_img_url'])) {
            $user_items->img_site_url = $input['site_img_url'];
            self::downloadAndPutImage($input['pict_result_img'], $user_items->img_url);
        } else {
            self::putImageBase64ToBlob($input['pict-data-url'], $input['pict-mimetype'], $user_items->img_url);
        }
        $user_items->save();
        return $user_items;
    }

    /**
    * スクレイピングした画像をダウンロードして、保存する
    *
    * @params $img_url   string  対象のサイト画像URL
    *         $file_name string  保存するファイルパス名
    * @return bool
    */
    protected static function downloadAndPutImage($img_url, $file_name) {
        try {
            $file_data = file_get_contents($img_url);
        } catch (\ErrorException $e) {
            throw new \App\Exceptions\ItemRegisterException("画像ファイルの取得に失敗しました");
        }
        // ファイル保存
        if ($file_data) {
            return Storage::disk('public')->put($file_name, $file_data);
        }
    }

    /**
    * 画像の保存先などをuserとpublicに分けて、作成する
    *
    * @params  $mime_type string  mime type
    * @return  bool
    */
    protected static function createFileInfo($input) {
        if (empty($input['pict-mimetype'])) {
            $ext = self::getDownloadImgExt($input['pict_result_img']);
        } else {
            $ext = self::$image_mimetypes[$input['pict-mimetype']];
        }
        $file_info = [];
        $file_info['public']['path'] = '/' . self::STORAGE_PATH_ITEMS . '/';
        $file_info['user']['path'] = '/' . self::STORAGE_PATH_USER_ITEMS . '/';
        $file_info['article']['path'] = '/' . self::STORAGE_PATH_ARTICLE . '/';
        $file_info['public']['ext'] = $ext;
        $file_info['user']['ext'] = $ext;
        $file_info['article']['ext'] = $ext;
        return $file_info;
    }

    /**
    * 複数画像保存時のパス情報など
    *
    * @params  $post  array  ファイルパス情報
    * @return  bool
    */
    protected static function createFilesInfo($post) {
        $ext = self::$image_mimetypes[$post['mime_type']];
        $file_info = [];
        $file_info['user']['path'] = '/' . self::STORAGE_PATH_USER_ITEMS . '/';
        $file_info['sale']['path'] = '/' . self::STORAGE_PATH_SALE_ITEMS . '/';
        $file_info['user']['ext'] = $ext;
        $file_info['sale']['ext'] = $ext;
        return $file_info;
    }

    /**
    *  スクレイピングしてきた画像に対して、拡張子のチェックをかけて、対応する拡張子を返す
    *
    * @params $img_url  string  画像パス
    * @return string 拡張子
    */
    public static function getDownloadImgExt($img_url) {
        if (preg_match('/(jpg)/', $img_url)) {
            return ".jpg";
        }
        if (preg_match('/(png)/', $img_url)) {
            return ".png";
        }
        if (preg_match('/(gif)/', $img_url)) {
            return ".gif";
        }
        if (preg_match('/(svg)/', $img_url)) {
            return ".svg";
        }
    }

    /**
    * タグをチェックをかけて登録する
    *
    * @params $users_id      int     ユーザーID
    *         $user_items_id int     ユーザーアイテムID
    *         $post_tags     string  postされたタグ tag1,tag2,tag3,..
    *         $session_tags  array   事前にセッションに保存したお気に入りのタグ
    * @return bool
    */
    public static function saveTags($users_id, $article_id, $post_tags, $session_tags) {

        if (Article2Tags::on("master")->where("article_id", $article_id)->count() >= 10) {
            throw new \App\Exceptions\ItemEditException("アイテムに対してのタグ登録数の上限を超えています。どれか削除した後、再度お試し下さい");
        }

        // 入力タグを配列に変換
        $post_tags = explode(',', $post_tags);
        $user_tags = [];
        $original_tags = $post_tags;
        // お気に入りタグと新規登録のタグを切り分ける
        if ( ! is_null($session_tags)) {
            // お気に入りのタグを抽出
            $user_tags = array_filter($session_tags, function($session_tag) use ($post_tags) {
                return in_array($session_tag['tag_text'], $post_tags);
            });

            // sessionのタグを一旦一次元配列に
            $session_text_tags = array_map(function($session_tag) {
                return $session_tag['tag_text'];
            }, $session_tags);

            // ユーザーに紐付いてないタグをフィルターかけて取得
            $original_tags = array_filter($post_tags, function($post_tag) use ($session_text_tags) {
                return ! in_array($post_tag, $session_text_tags);
            });
        }

        $merged_tags = null;
        if ( ! empty($original_tags)) {
            $tags_model = new Tags();
            // tagsテーブルをチェックし、タグが無ければ新規登録する
            $result_tags = $tags_model->checkAndSaveOriginalTags($users_id, $original_tags);
            // お気に入りとそうじゃ無いタグをマージする
            $merged_tags = array_merge($user_tags, $result_tags);
        } else {
            $merged_tags = $user_tags;
        }

        // Article2Tagssに保存(ユーザーアイテムとタグの紐付け）
        if ( ! empty($merged_tags)) {
            $article2tags = new Article2Tags();
            $article2tags->saveArticle2Tags($article_id, $merged_tags);
        }
    }

    /**
    * ユーザーアイテムに紐付いたタグを削除する
    *
    * @params  int      $user_items_id  ユーザーアイテムID
    *          string   $tag_name       タグ名
    * @return  void
    */
    public static function removeTag($user_items_id, $tag_name) {
        // タグ名からtagを取得
        $tag = Tags::getByTagName($tag_name);

        // 取得したタグでuser_item2tagsを論理削除
        $user_item2tags = Article2Tags::where("tags_id", $tag->id)
                            ->where("article_id", $user_items_id)
                            ->first();
        $user_item2tags->delete();
    }

    /**
    * アイテム評価を保存する
    *
    * @params $input     array postデータ
    *         $users_id  int   ユーザーID
    * @return void
    */
    public static function saveItemEvaluationUsers($rate, $items_id, $users_id) {
        $item_evaluation = ItemEvaluation::getFirstByItemsId($items_id, true);
        $evaluation_users = null;
        if (is_null($item_evaluation) || empty($item_evaluation)) {
            $item_evaluation = new ItemEvaluation();
            $item_evaluation->items_id = $items_id;
            $item_evaluation->average = $rate;
            $item_evaluation->save();
        } else {
            //　平均更新
            $evalution_user_count = $item_evaluation->item_evaluation_users->count();
            // ユーザー評価を取得
            $evaluation_users = $item_evaluation->item_evaluation_users->where('users_id', $users_id)->first();
            // rateの合計を出す
            if ( ! is_null($evaluation_users) && ! empty($evaluation_users)) {
                // 複数評価があれば
                if ($evalution_user_count > 1) {
                    // 自分以外を省いて合計する
                    $evaluation_sum = ItemEvaluationUsers::where('users_id', '!=', $users_id)->sum("evaluation_num");
                    $evaluation_sum += $rate;
                } else {
                    $evaluation_sum = $rate;
                }
            } else {
                if ($evalution_user_count > 1) {
                    $evaluation_sum = $item_evaluation->item_evaluation_users->sum('evaluation_num') + $rate;
                } else {
                    $evaluation_sum = $item_evaluation->item_evaluation_users[0]->evaluation_num + $rate; // post追加分のrateを足す
                }
                $evalution_user_count += 1; // post追加分のカウントを足す
            }
            $item_evaluation->average = round($evaluation_sum / $evalution_user_count, 1);
            $item_evaluation->save();
        }
        if ( ! is_null($evaluation_users) && ! empty($evaluation_users)) {
            $evaluation_users->users_id = $users_id;
            $evaluation_users->item_evaluation_id = $item_evaluation->id;
            $evaluation_users->evaluation_num = $rate;
            $evaluation_users->save();
        } else {
            $evaluation_users = new ItemEvaluationUsers();
            $evaluation_users->users_id = $users_id;
            $evaluation_users->item_evaluation_id = $item_evaluation->id;
            $evaluation_users->evaluation_num = $rate;
            $evaluation_users->save();
        }
        return $evaluation_users->evaluation_num;
    }

    /**
    * 検索文字列をsolrにかけてidリストを取得する
    *
    * @params $word  string  検索文字列
    *         $type  string  検索タイプ
    * @return array
    */
    public static function getItemsIdsBySolrQuery($params, $type) {

        if ($type == "items") {
            $query = self::setSearchWordItemsQuery($params);
        } elseif ($type == "article") {
            $query = self::setSearchWordArticleQuery($params);
        }
        $response = $query->getResponse();
        if (empty($response->response->docs)) {
            return [];
        }
        $ids = [];
        foreach ($response->response->docs as $key => $docs) {
            $ids[] = $docs->id;
        } 
        return $ids;
    }

    /**
    * マスターアイテム検索の条件をセットする
    *
    * @params $keyword  string  検索ワード
    * @return
    */
    public static function setSearchWordItemsQuery($params) {
        /*
        $query_string = "name:*" . $params['search_word']  . "*";
        $query_string .= " OR description:*" . $params['search_word'] . "*";
        $query_string .= " OR brand_name:*" . $params['search_word'] . "*";
        */
        $query_string = $params['search_word'];
        $query = SolrQuery::forge("items")
            ->setQuery($query_string)
            ->addField("id")
            //->setOffset($params['from'])
            //->setRows($params['per_page'])
            ->query();

        return $query;
    }

    /**
    * ログ検索の条件をセットする
    *
    * @params $keyword  string  検索ワード
    * @return
    */
    public static function setSearchWordArticleQuery($params) {
        /*
        $query_string = "article_text:*" . $params['search_word']  . "*";
        $query_string .= " OR item_name:*" . $params['search_word'] . "*";
        $query_string .= " OR brand_name:*" . $params['search_word'] . "*";
        $query_string .= " OR category:*" . $params['search_word'] . "*";
        $query_string .= " OR genre:*" . $params['search_word'] . "*";
        */
        $query_string = $params['search_word'];
        $query = SolrQuery::forge("article")
            ->setQuery($query_string)
            ->addField("id")
            //->setOffset($params['from'])
            //->setRows($params['per_page'])
            ->query();

        return $query;
    }

    /**
    * user_itemsをsolrに登録する
    *
    * @params $items App\Models\User\Items
    * @return void
    */
    public static function putSolrItems($items) {
        $document = [
            "id" => $items->id,
            "name" => $items->name,
            "description" => $items->description,
            "brand_name" => $items->brands->name,
        ];
        Solr::forge("items")
            ->setDocument($document);
    }

    /**
    * articleをsolrに登録する
    *
    * @params $article App\Models\Article
    * @return void
    */
    public static function putSolrArticle($article, $user_items) {
        $genre_name = null;
        if ($user_items->items->genre_id) {
            $genre_name = $user_items->items->genre->name;
        }
        $document = [
            "id" => $article->id,
            "article_text" => $article->article_text,
            "item_name" => $user_items->items->name,
            "brand_name" => $user_items->items->brands->name,
            "category" => $user_items->items->category->name,
            "genre" => $genre_name,
        ];
        Solr::forge("article")
            ->setDocument($document);
    }

    /**
    * user_itemsのdescriptionのみsolrに登録する
    *
    * @params $items        App\Models\User\Items  ユーザーアイテムオブジェクト
    *         $description  string                 ユーザーアイテムのディスクリプション
    * @return void
    */
    public static function updateSolrUserItems($user_items, $description) {
        $document = [
            "id" => $user_items->id,
            "items_id" => $user_items->items_id,
            "name" => $user_items->item->name,
            "description" => $description,
            "brand_name" => $user_items->item->brands->name,
        ];
        return Solr::forge('items')
            ->setDocument($document);
    }

    /**
    * 小数点をハイフンに変換して返す（ファイル名用の処理）
    *
    * @params $average float アイテム評価平均値
    * @return string
    */
    protected static function createAverageFileName($average) {
        $split_average = explode('.', $average);       
        if (count($split_average) > 1) {
            if ($split_average[1] == 0) {
                return $split_average[0];
            } 
            return $split_average[0] . '-' . $split_average[1];
        }
        return (string) $average;
    }
}
