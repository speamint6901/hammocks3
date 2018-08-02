<?php

namespace App\Service\Api;

use App\Models\Items as Items;
use App\Models\Brands as Brands;
use App\Models\Tags as Tags;
use App\Models\Category as Category;
use App\Models\Genre as Genre;
use App\Models\GenreSecond as GenreSecond;

class AutoCompleteControllerLogic extends \App\Service\Base {

    /**
    * 補完用ブランドを全件取得
    * @return array
    */
    public static function getBrandAll() {
        return Brands::getBrandNames()->map(function($brands) {
            return ["id" => $brands->id, "value" => $brands->name];    
        });
    }

    /**
    * タグの入力補完用のリストを一次元配列で取得する
    * @params  $users_id  ユーザーID
    * @return  array
    */
    public static function getTags($users_id) {
        $tags = Tags::getTagNamesByUsersId($users_id)->toArray();
        $resTags = array_map(function($tag) {
            return $tag['tag_text'];
        }, $tags);
        return ["responseTags" => $resTags, "sessionTags" => $tags];
    }

    /**
    * 補完用アイテム名をnameで取得
    * @params $brands_id int  アイテム名
    */
    public static function getItems($brands_id) {
        return Items::getItemsByNameByBrandsId($brands_id)->map(function($items) {
            return ["id" => $items->id, "value" => $items->name];    
        });
    }

    /**
    * カテゴリを大カテゴリIDで取得する
    * @params $category_id  int  大カテゴリID
    * @return array
    */
    public static function getCategories($big_category_id) {
        return Category::getCategoriesByBigCategoryId($big_category_id)->toArray();
    }

    /**
    * ジャンルをカテゴリIDで取得する
    * @params $category_id  int  カテゴリID
    * @return array
    */
    public static function getGenres($category_id) {
        return Genre::getGenresByCategoryId($category_id)->toArray();
    }

    /**
    * サブジャンルをジャンルIDで取得する
    * @params $genre_id  int  ジャンルID
    * @return array
    */
    public static function getSecondGenres($genre_id) {
        return GenreSecond::getSecondGenresByGenreyId($genre_id)->toArray();
    }

}
