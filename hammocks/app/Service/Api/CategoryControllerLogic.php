<?php

namespace App\Service\Api;

use App\Models\Items;
use App\Models\Brands;
use App\Models\Category;
use App\Models\Genre;
use App\Models\GenreSecond;

class CategoryControllerLogic extends \App\Service\Base {

    /**
    * カテゴリとジャンルリストを大カテゴリIDで取得して配列でパースして返す
    *
    * @params $big_category_id  int  大カテゴリID
    * @return App\Models\Category
    */
    public static function getCategoryAndGenreList($big_category_id) {
        $categories = Category::getCategoryAndGenreListByBigCategoryId($big_category_id);
        $tmp_categories = [];
        foreach ($categories as $key => $category) {
            $tmp_categories[$key] = $category;
            $tmp_categories[$key]['count'] = isset($category->category_count->count) ? $category->category_count->count : 0;
            $tmp_categories[$key]['genre'] = self::perseGenre($category);
        }
        return $tmp_categories;
    }

    /**
    * モーダル用ブランドリストを３種類のどれかのIDで取得
    *
    * @params $params array  検索条件
    * @return App\Models\Brands
    */
    public static function getModalBrandListByAnyId($params) {
        $brands = Brands::getBrandsByAnyId($params);        
        if (is_null($brands)) {
            return [];
        }
        $tmp_brands = [];
        // ページによって、キーを切り替える
        $key_name = "name_category";
        if ($params['lang_type'] == 2) {
            $key_name = "name_category_kana";
        }
        foreach ($brands as $key => $brand) {
            $tmp_brands[$brand->$key_name][$key]["id"] = $brand->id;
            $tmp_brands[$brand->$key_name][$key]["name"] = $brand->name_display;
            $tmp_brands[$brand->$key_name][$key]["count"] = is_null($brand->has_count) ? 0 : $brand->has_count;
        }
        return $tmp_brands;
    }

    /**
    * ジャンルをネストして配列で返す
    *
    * @params $category  \App\Models\Category  カテゴリモデル
    * @return array
    */
    public static function perseGenre($category) {
        $tmp_genre = [];
        if ( isset ($category->genre)) {
            foreach ($category->genre as $key => $genre) {
                $tmp_genre[$key] = $genre;
                $tmp_genre[$key]['count'] = isset($genre->genre_count->count) ? $genre->genre_count->count : 0;
                $tmp_genre[$key]['genre_second'] = self::parseGenreSecond($genre);
            }
            return $tmp_genre;
        }
        return null;
    }

    /**
    * セカンドジャンルをネストして配列で返す
    *
    * @params $category  \App\Models\Genre  ジャンルモデル
    * @return array
    */
    public static function parseGenreSecond($genre) {
        $tmp_genre_second = [];
        if ( isset ($genre->genre_second)) {
            foreach ($genre->genre_second as $key => $genre_second) {
                $tmp_genre_second[$key] = $genre_second;
                $tmp_genre_second[$key]['count'] = isset($genre_second->genre_second_count->count) ? $genre_second->genre_second_count->count : 0;
            }
            return $tmp_genre_second;
        }
        return null;
    }

}
