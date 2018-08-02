<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Base 
{
    //
    protected $table = "category";

    // category_count 1:1
    public function category_count() {
        return $this->hasOne('\App\Models\Category\Count', 'category_id', 'id');
    }

    // genre 1:多
    public function genre() {
        return $this->hasMany('\App\Models\Genre');
    }

    // gener_second 1:多
    public function genre_seconds() {
        return $this->hasMany('\App\Models\GenreSecond');
    }

    /**
    * カテゴリを大カテゴリIDで取得する
    *
    * @params $big_category_id  int  大カテゴリID
    * @return App\Models\Category
    */
    public static function getCategoriesByBigCategoryId($big_category_id) {
        $query = self::select('id', 'name')
                        ->where('big_category_id', $big_category_id);
        return self::getS($query);
    }

    /**
    * カテゴリとジャンルリストを大カテゴリIDで取得する
    *
    * @params $big_category_id  int  大カテゴリID
    * @return App\Models\Category
    */
    public static function getCategoryAndGenreListByBigCategoryId($big_category_id) {
        $query = self::with('genre')
            ->where('big_category_id', $big_category_id);
        return self::getS($query);
    }
}
