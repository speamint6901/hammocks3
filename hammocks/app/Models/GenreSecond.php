<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenreSecond extends Base 
{
    //
    protected $table = "genre_second";

    // genre_second_count 1:1
    public function genre_second_count() {
        return $this->hasOne('\App\Models\GenreSecond\Count', 'genre_second_id', 'id');
    }

    /**
    * サブジャンルをジャンルIDで取得する
    * @params $genre_id  int  ジャンルID
    * @return array
    */
    public static function getSecondGenresByGenreyId($genre_id) {
        $query = self::select('id', 'name')->where('genre_id', $genre_id);
        return self::getS($query);
    }
}
