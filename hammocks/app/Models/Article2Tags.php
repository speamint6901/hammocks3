<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tags;

class Article2Tags extends Base
{
    //
    protected $table = "article2tags";

    // article
    public function article() {
        return $this->belongsTo('\App\Models\Article', 'id', 'article_id');
    }

    /**
    * tags 1:1
    */
    public function tags() {
        return $this->hasOne('\App\Models\Tags', 'id', 'tags_id');
    }

    /**
    * タグをアイテムに紐付ける（insert)
    *
    * @params $users_items_id      int       ユーザーアイテムID
    *         $user_tags           array     ユーザー登録済みのタグリスト
    * @return bool
    */
    public function saveArticle2Tags($article_id, $tags) {
        $insert_data = [];
        foreach ($tags as $key => $tag) {
            $storeTag = self::onlyTrashed()->where('tags_id', $tag['id'])->where('article_id', $article_id)->first();
            if ( ! is_null($storeTag) && ! empty($storeTag)) {
                $storeTag->restore();
                continue;
            }
            if ( ! self::where('tags_id', $tag['id'])->where('article_id', $article_id)->count()) {
                $insert_data[$key]['tags_id'] = $tag['id'];
                $insert_data[$key]['article_id'] = $article_id;
                $insert_data[$key]['created_at'] = date('Y-m-d H:i:s');
                $insert_data[$key]['updated_at'] = date('Y-m-d H:i:s');
            }
        }
        static::insert($insert_data);
    }
}
