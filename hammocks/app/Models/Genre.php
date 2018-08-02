<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Base
{
    //
    protected $table = "genre";

    // genre_count 1:1
    public function genre_count() {
        return $this->hasOne('\App\Models\Genre\Count', 'genre_id', 'id');
    }

    // genre_second 1:多
    public function genre_second() {
        return $this->hasMany('\App\Models\GenreSecond', 'genre_id', 'id');
    }

    /**
    * ジャンルをカテゴリIDで取得する
    * @params $category_id  int  カテゴリID
    * @return array
    */
    public static function getGenresByCategoryId($category_id) {
        $query = self::select('id', 'name')->where('category_id', $category_id);
        return self::getS($query);
    }
}
