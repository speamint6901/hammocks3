<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Base
{

    protected static $page_category = [
        "1" => "name",
        "2" => "name_category",
    ];

    // その他のprimary id
    const BRANDS_ID_OTHER = 278;

    /**
    * brands  1:1
    */
    public function brands_has_count() {
        return $this->hasOne("App\Models\Brand\HasCount", "brands_id", "id");
    }

    /**
    * ブランドをIDで一件取得する
    *
    * @params  $brands_id  int  ブランドID
    * @return  \App\Models\Brands
    */ 
    public static function findBrandById($id) {
        $query = self::select('brands.*', 'brands_has_count.count as has_count')
                        ->leftJoin('brands_has_count', 'brands_has_count.brands_id', '=', 'brands.id')
                        ->where("brands.id", $id);
        return self::firstS($query);
    }

    /**
    * ブランド名のリストを返す
    *
    * @return array
    */
    public static function getBrandNames() {
        return static::select('id', 'name', 'name_display')
            ->where('id', '!=', self::BRANDS_ID_OTHER)
            ->get();
    }

    /**
    * ブランドリストを名前順で取得し、name_categoryでグループ分けする
    *
    * @params $page  int  ページ番号
    * @return self
    */
    public static function getBrandsNameGroup($page) {
        $query = self::select('brands.*', 'brands_has_count.count as has_count')
                        ->leftJoin('brands_has_count', 'brands_has_count.brands_id', '=', 'brands.id')
                        ->where("brands.id", "!=", self::BRANDS_ID_OTHER)
                        ->orderBy('brands.' . self::$page_category[$page]); // ソートをページで切り替える
        return self::getS($query);
    }

    /**
    * ブランドリストをカテゴリ、ジャンル、セカンドジャンルのどれかのIDで抽出する
    *
    * @params $params  array  検索パラメータ
    * @return self
    */
    public static function getBrandsByAnyId($params) {
        $page = $params['lang_type'];
        $query = self::select('brands.*', 'brands_has_count.count as has_count')
                        ->leftJoin('brands_has_count', 'brands_has_count.brands_id', '=', 'brands.id')
                        ->orderBy('brands.' . self::$page_category[$page]) // ソートをページで切り替える
                        ->where('brands.id', '!=', self::BRANDS_ID_OTHER);
        return self::getS($query);
    }

    /**
    * ブランド情報をブランドIDで抽出する
    *
    * @params $id  int  プライマリキー
    * @return array
    */
    public static function getBrandInfo($id) {
        $query = static::select('*')
                    ->where('id', '=', $id);
        return self::firstS($query);
    }

    /**
    * ブランド情報を登録 or 更新
    *
    * @return array
    */
    public static function saveBrand($post) {
        if (empty($post['id'])){
            // 新規作成処理
            self::insert([
                'name' => $post['name'],
                'name_hiragana' => $post['name_hiragana'],
                'name_katakana' => $post['name_katakana'],
                'name_japan' => $post['name_japan'],
                'name_display' => $post['name_display'],
                'name_category' => strtoupper( mb_substr( $post['name'], 0, 1) ),
                'name_category_kana' => mb_substr( $post['name_hiragana'], 0, 1),
                'brand_img_url' => $post['brand_img_url'],
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        } else {
            // アップデート処理
            $date = [
                'name' => $post['name'],
                'name_hiragana' => $post['name_hiragana'],
                'name_katakana' => $post['name_katakana'],
                'name_japan' => $post['name_japan'],
                'name_display' => $post['name_display'],
                'name_category' => strtoupper( mb_substr( $post['name'], 0, 1) ),
                'name_category_kana' => mb_substr( $post['name_hiragana'], 0, 1),
                'brand_img_url' => $post['brand_img_url'],
                'updated_at' => date("Y-m-d H:i:s"),
            ];

            self::where('id', '=', $post['id'])->update($date);
        }
    }

    public static function softDelete($id) {
        self::where('id', '=', $id)->update(['deleted_at' => date("Y-m-d H:i:s")]);
    }
}
