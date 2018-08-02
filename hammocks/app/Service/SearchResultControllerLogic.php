<?php

namespace App\Service;

use App\Models\Users as User;
use App\Models\User\Container as Container;
use App\Models\Items;
use App\Models\User\Items as UserItems;
use App\Models\Brands;
use App\Models\Tags;
use App\Libs\SolrQuery as Solr;

class SearchResultControllerLogic extends Base {

    /**
    * ブランドをIDで一件取得する
    *
    * @params  $brands_id  int  ブランドID
    * @return  \App\Models\Brands
    */
    public static function findBrandById($brands_id) {
        return Brands::findBrandById($brands_id);
    }

    /**
    * ブランドリストを表示する（all)
    * pageで英語表記と日本語名を切り替える
    *
    * @params $page  int  ページ番号
    * @return App\Models\Brands
    */
    public static function getBrandList($page) {

        $brands = Brands::getBrandsNameGroup($page);        
        $tmp_brands = [];
        // ページによって、キーを切り替える
        $key_name = "name_category";
        if ($page == 2) {
            $key_name = "name_category_kana";
        }
        foreach ($brands as $key => $brand) {
            $tmp_brands[$brand->$key_name][$key]["id"] = $brand->id;
            $tmp_brands[$brand->$key_name][$key]["name"] = $brand->name_display;
            $tmp_brands[$brand->$key_name][$key]["count"] = is_null($brand->has_count) ? 0 : $brand->has_count;
        }
        return $tmp_brands;
    }

    public static function getItemListByBrandsId($brands_id) {
        $items = Items::getItemsByBrandsId($brands_id);            
        return $items;
    }

    /**
    * タグIDで一件取得する
    *
    * @params  $tags_id  int  タグID
    * @return  \App\Models\Tags
    */
    public static function getTagsById($tags_id) {
        return Tags::getById($tags_id);
    }

}
