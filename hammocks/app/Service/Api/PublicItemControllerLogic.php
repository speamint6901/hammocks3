<?php

namespace App\Service\Api;

use App\Models\Items;
use App\Libs\SolrQuery as Solr;

class PublicItemControllerLogic extends \App\Service\ItemControllerLogic {

    /**
    * アイテム一覧を取得する
    *
    * @params $params array
    * @return array
    */
    public static function getItemList($params = [], $users_id = null) {
        return Items::getItemDefaultList($params, $users_id);
    }

    /**
    * 最安値の値段とセールカウントをプロパティに追加して返す
    *
    * @params  $items  \App\Models\Items  itemsモデル
    * @return  \App\Models\Items
    */
    public static function setPriceAndSaleCount($items) {
        // 価格をセットする
        // foreachでやるとソート順が変わる時がある為、for文を使う
        for ($i=0; $i<=count($items) - 1; $i++) {
            $items[$i]->sale_count = 0;
            if (count($items[$i]->user_items) > 0) {
                // 最安値を抽出
                $items[$i]->price = $items[$i]->user_items->where("is_store", 1)->min("price");
                // セールカウント
                $items[$i]->sale_count = $items[$i]->user_items->filter(function($items) {
                    return $items->is_store == 1;
                })->count();
            }
        }
        return $items;
    }

    /**
    * カテゴリ検索でカテゴリ選択時のアイテムリストを返す
    *
    * @params $category_id int カテゴリID
    * @return 
    */
    public static function getItemsByAnyId($params) {
        return Items::getItemsByAnyId($params);
    }

    /**
    * タイピングした文字から補完リストを取得する
    *
    * @params $params  array  postパラメータ
    *         $word    string タイピング文字列
    * @return \App\Models\Items
    */
    public static function getCompletionItems($params, $brands_id, $word) {
         if (is_null($word)) {
            return;
        }
        $word = preg_quote($word, "/");
        //$query_string = "name:*" . $word . "*";
        $query_string = $word;
        $query = Solr::forge("items")
            ->setQuery($query_string)
            ->addField("id")
            ->query();
        $response = $query->getResponse();
        if (empty($response->response->docs)) {
            return [];
        }
        foreach ($response->response->docs as $key => $docs) {
            $ids[] = $docs->id;
        }
        return Items::getItemsListByIds($ids, $brands_id, $params);
    }
}
