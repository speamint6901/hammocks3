<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Item2Tags as Item2Tags; 
use App\Models\Users2Tags;

class Tags extends \App\Models\Base 
{

    /**
    * article2tags 1:1
    */
    public function article2tags() {
        return $this->hasOne('\App\Models\Article2Tags', 'tags_id', 'id');
    }

    /**
    * idで一件取得
    *
    * @params  $id  int  tag_id
    * @return  self
    */
    public static function getById($id) {
        $query = static::where("id", $id);
        return static::firstS($query);
    }

    /**
    * タグ名で一件取得
    *
    * @params  $tag_name  string  タグ名
    * @return  self
    */
    public static function getByTagName($tag_name) {
        return static::where("tag_text", $tag_name)->first();
    }

    /**
    * 記事IDからタグリストを取得
    *
    * @params $id  int  ユーザーアイテムID
    * @return \App\Models\User\Tags
    */
    public static function getUserTagsByUserItemsId($article_id, $is_master = false) {
        $query = self::select('tags.id as tag_id', 'tags.tag_text as tag_name',
                              'article2tags.article_id as user_item_id')
                        ->join('article2tags', 'tags.id', '=', 'article2tags.tags_id')
                        ->where('article2tags.article_id', $article_id)
                        ->where('article2tags.deleted_at', null);
        if ($is_master) {
            return $query->get();
        }
        return self::getS($query);
    }

    /**
    * タグの名前リストをユーザーIDから取得する
    *
    * @params  $users_id  int  ユーザーID
    * @params  self
    */
    public static function getTagNamesByUsersId($users_id) {
        $query = static::select('tags.id', 'tags.tag_text')
                    ->join('users2tags', 'users2tags.tags_id', '=', 'tags.id')
                    ->where('users2tags.users_id', $users_id);
        return static::getS($query);
    }

    /**
    * タグの登録及び中間テーブルに登録
    *
    * @params $users_id       int     ユーザーID
    *         $user_items_id  int     ユーザーアイテムID
    *         $text           string  タグテキスト
    * @return  \App\Models\User\Tags
    */
    public function insertTags($users_id, $user_items_id, $text) {
        // 同じタグ名があるか一応チェックする
        $query = self::where("tag_text", $text);
        $tags = self::firstS($query);
        if (is_null($tags)) {
            return null;    
        }
        // tagsに保存
        $this->users_id = $users_id;
        $this->tag_text = $text;
        $this->save();

        // 中間テーブルに保存
        $this->insertUserItem2Tags($user_items_id, $this->id);
        return $this;
    }

    /**
    * 複数のタグを登録及び中間テーブルに登録
    *
    * @params $users_id        int     ユーザーID
    *         $original_tags   string  タグテキスト
    * @return  \App\Models\User\Tags
    */
    public function checkAndSaveOriginalTags($users_id, $original_tags) {
        $tags = [];
        $result_tags = null;
        // タグの登録状態をチェックする
        foreach ($original_tags as $key => $original_tag) {
            $result_tags = static::select('id', 'tag_text')
                            ->where('tag_text', $original_tag)
                            ->first();
            if ( empty($result_tags)) {
                // タグが無いなら新規登録
                $self = new static;
                $self->tag_text = $original_tag;
                $self->save();
                $tags[$key]['id'] = $self->id;
                $tags[$key]['tag_text'] = $self->tag_text;
            } else {
                $tags[$key]['id'] = $result_tags->id;
                $tags[$key]['tag_text'] = $result_tags->tag_text;
            }
        }

        // users2tagsに登録する(ユーザーとタグの紐付け）
        Users2Tags::bulkInsertUsers2Tags($users_id, $tags);        
        return $tags;
    }

    /**
    * user_itemsとtagsを紐付ける
    *
    * @params  $user_items_id  int  ユーザーアイテムID
    *          $tags_id   int  ユーザータグスID
    * @return  bool
    */
    public function userItem2Tags($user_items_id, $tags_id) {
        $query = Item2Tags::where("user_items_id", $user_items_id)
                            ->where("tags_id", $tags_id);
        $item2_tags = Item2Tags::firstS($query);
        if (is_null($item2_tags)) {
            return null;
        }
        // 重複が無ければ紐付けする
        $this->insertUserItem2Tags($user_items_id, $tags_id);
        return true;
    }

    /**
    * user_itemsとtagsを紐付けるレコードを登録する
    *
    * @params  $user_items_id  int  ユーザーアイテムID
    *          $tags_id   int  ユーザータグスID
    * @return  void
    */
    private function insertUserItem2Tags($user_items_id, $tags_id) {
        Item2Tags::insert([
            "tags_id" => $tags_id,
            "user_items_id" => $user_items_id,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),            
        ]);
    }
}
