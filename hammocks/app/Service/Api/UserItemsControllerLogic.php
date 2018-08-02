<?php

namespace App\Service\Api;

use App\Models\User\Items as UserItems;
use App\Models\Items;
use App\Models\User\ItemStatus as ItemStatus;
use App\Models\User\ItemFavUsers as ItemFav;
use App\Models\Tags;
use App\Libs\SolrQuery as Solr;

class UserItemsControllerLogic extends \App\Service\ItemControllerLogic {

    /**
    * saleアイテム一覧を取得する
    *
    * @params $params array
    * @return array
    */
    public static function getItemList($params = []) {
        return UserItems::getUserItems($params);
    }

    /**
    * ユーザーのアイテム評価一覧取得
    *
    * @params $params  array  postパラメータ
    * @return \App\Models\User\Items
    */
    public static function getItemRating($params = []) {
        return \App\Models\Item\EvaluationUsers::getUserRatingListByItemsId($params["items_id"]); 
    }

    /**
    * ユーザーアイテム一覧をitem_idで取得する(コメントページ)
    * @params $params array  ['items_id' =>, 'sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\User\Items
    */
    public static function getUserItemCommentListByItemId($params) {
        return UserItems::getUserItemsCommentByItemsId($params);
    }

    /**
    * ユーザーアイテム一覧をitem_idで取得する(フォトページ)
    * @params $params array  ['items_id' =>, 'sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\User\Items
    */
    public static function getUserItemPhotoListByItemId($params) {
        return UserItems::getUserItemsPhotoByItemsId($params);
    }

    /**
    * ユーザーアイテム一覧をitem_idで取得する(saleページ)
    * @params $params array  ['items_id' =>, 'sort' => ,'offset' => ,'limit' => ]
    * @return \App\Models\User\Items
    */
    public static function getUserItemSaleListByItemId($params) {
        return UserItems::getUserItemsSaleByItemsId($params);
    }

    /**
    * ユーザーアイテムIDからタグリストを取得する
    *
    * @params  $user_items_id  int  ユーザーアイテムID
    * @return  App\Models\Tags
    */
    public static function getTagListByUserItemsId($user_items_id) {
        return Tags::getUserTagsByUserItemsId($user_items_id);
    }

    /**
    * 検索ワードで全文検索し、結果をキャッシュする
    *
    * @params  $params  array  検索パラメータ
    * @return  array
    */
    public static function getSearchItemKeyword($params, $keyword, $users_id) {
        if (is_null($keyword["s"])) {
            return;
        }
        $query_string = "name:*" . $keyword['s']  . "*";
        $query_string .= " OR description:*" . $keyword['s'] . "*";
        $query_string .= " OR brand_name:*" . $keyword['s'] . "*";
        $query = Solr::forge("items")
            ->setQuery($query_string)
            ->addField("items_id")
            ->addField("id")
            ->setOffset($params['offset'])
            ->setRows($params['per_page'])
            ->query();
        $response = $query->getResponse();
        if (empty($response->response->docs)) {
            return [];
        }
        $ids = [];
        foreach ($response->response->docs as $key => $docs) {
            $ids[] = $docs->id;
        }
        $items = UserItems::getItemListByIds($ids, $params);
        return self::pushUserItemStatus($items, $users_id);
    }

    /**
    * 取得したアイテムリストに持ってる、欲しいステータスを追加する
    *
    * @params $user_items  \App\Models\User\Items  ユーザーアイテムのリスト
    *         $users_id    int                     ユーザーID
    * @return \App\Models\User\Items               statusを付与したユーザーアイテムリスト
    */
    public static function pushUserItemStatus($items, $users_id) {
        $res_items = [];
        foreach ($items as $key => $item) {
            $res_items[$key] = $item;
            $res_items[$key]["have_want_status"] = 0;
            if ( ! is_null($users_id)) {
                // 持ってる、欲しいの状況をセットする 1: 持ってる　2: 欲しい  0: どちらでも無い
                $item_status = ItemStatus::getStatusOne($users_id, $item->items_id);
                if (!is_null($item_status)) {
                    $res_items[$key]["have_want_status"] = $item_status->status;
                }
            }
        }
        return $res_items;
    }

    /**
    * ユーザーIDとアイテムIDからカウントを取得し、フラグで返す
    *
    * @params  $users_id  int  ユーザーID
    *          $items_id  int  アイテムID
    * @return  bool
    */
    public static function hasItemByUser($users_id, $items_id) {
        $user_items_count = UserItems::getCountByUsersIdAndItemsId($users_id, $items_id);
        return $user_items_count ? true : false;
    }

    /**
    * ユーザーアイテム更新
    *
    * @params $input array postデータ
    * @return App\Models\User\Items
    */
    public static function updateUserItem($input, $users_id, $session_tags) {
        // トランザクションの開始
        \DB::beginTransaction();
        try {
            // user_items_idとusers_idで自分のアイテムかチェックを兼ねて取得
            $any_vars = UserItems::getByIdAndUsersId($input['user_items_id'], $users_id, true);
            if ( is_null($any_vars)) {
                throw new \App\Exceptions\ItemEditException();
            }
            // 画像変更
            if (isset($input['pict-data-url']) || isset($input['site_img_url'])) {
                self::updateUserItemImage($input, $any_vars);
            // ディスクリプション変更
            } elseif (isset($input['description'])) {
                $any_vars->description = $input['description'];
                $any_vars->save();
                self::updateSolrUserItems($any_vars, $input['description']);
            } elseif (isset($input['tag'])) {
                if ($input["action"] == "add") {
                    self::saveTags($users_id, $input['user_items_id'], $input['tag'], $session_tags);
                } elseif ($input["action"] == "remove") {
                    self::removeTag($input['user_items_id'], $input['tag']);
                }
                $any_vars = Tags::getUserTagsByUserItemsId($input['user_items_id'], true);
            } elseif (isset($input['rate'])) {
                $average = self::saveItemEvaluationUsers($input, $any_vars->items_id, $users_id);
                $any_vars = ["average" => $average];
                $any_vars["average_path_name"] = self::createAverageFileName($average);
            }
            // コミット
            \DB::commit();
            return $any_vars;
            // 登録時の例外
        } catch (\App\Exceptions\ItemEditException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();
            throw $e;
        // databaseの例外
        } catch (\PDOException $e) {
            // ロールバック、ロック解除
            \DB::rollBack();           
            return $e->getCode();
        }
    }

    /**
    * アイテム評価を更新
    *
    * @params $items_id  int アイテムID
    *         $users_id  int ユーザーID
    * @return void
    */
    public static function saveItemRate($items_id, $users_id, $rate) {
        $average = self::saveItemEvaluationUsers($rate, $items_id, $users_id);
        $any_vars = ["average" => (int) $average];
        $any_vars["average_path_name"] = self::createAverageFileName($average);
        return $any_vars;
    }

    /**
    * 問題報告
    *
    * @params $params  array  postデータ
    * @return void
    */
    public static function sendBanReport($params) {
        // user_itemを取得
        $items = UserItems::on("master")->find($params['user_items_id']);
        
        if ( ! is_null($items) && ! empty($items)) {
            $item_ban_report = new \App\Models\Item\BanReport();
            $item_ban_report->user_items_id = $params["user_items_id"];
            $item_ban_report->article_id = $params["article_id"];
            $item_ban_report->type = $params["type"];
            $item_ban_report->report_text = $params["text"];
            $item_ban_report->save();
            return true;
        } else {
            throw new \App\Exceptions\UserSettingException("対象のアイテムが見つからなかったので、送信できませんでした");
        }
    }
}
