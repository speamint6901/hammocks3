<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Base extends Model
{

    // デフォルトconnection
    protected $connection = 'master';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
    * slaveサーバーのconnectionをランダムでセットする
    * set $this->slave_connection
    * */
    public static function getSlave() {
        // slaveの台数をconfig/database.phpから取得
        $slave_count = \Config::get('database.slave_count');

        // randomでslaveを指定する
        $num = mt_rand(1, $slave_count);
        return 'slave' . $num;
    }

    // テーブル名取得
    public static function getTableName() {
        return with(new static)->getTable();
    }

    public static function find($id) {
        return static::on(self::getSlave())->find($id);
    }

    public static function all($columns = []) {
        return static::on(self::getSlave())->get();
    }

    public static function getS($query) {
        $query->getModel()->setConnection(self::getSlave());
        return $query->get();
    }

    public static function firstS($query) {
        $query->getModel()->setConnection(self::getSlave());
        return $query->first();
    }

    /**
    * ソートの共通処理
    *
    * @params $query       クエリビルター      
    *         $params      Array 　['sort' => ,'sort_type' => ]
    *         $table_name  string  テーブル名
    * @return $query
    */
    protected static function setSort($query, $params, $table_name = null) {
        $sort_type = "desc";  // デフォルトはdesc
        if ( ! isset($params['sort']) || empty($params['sort'])) {
            $sort_clumn = "created_at";  // デフォルトはcreated_at
        } else {
            $sort_clumn = $params["sort"];
            if ( isset($params["sort_type"])) {
                $sort_type = $params["sort_type"];
            }
        }

        if ( ! is_null($table_name)) {
            $query->orderBy($table_name . "." . $sort_clumn, $sort_type);
        } else {
            $query->orderBy(static::getTableName() . "." . $sort_clumn, $sort_type);
        }
        return $query;
    }

    /**
    * ソート及びリミットオフセットの共通処理
    *
    * @params $params  Array 　['sort' => ,'offset' => ,'limit' => ]
    * @return $query
    */
    protected static function setLimitOffset($query, $params, $table_name = null) {

        if (isset($params['offset'])) {
            $query->offset($params['offset']);
        }
        if (isset($params['per_page'])) {
            $query->limit($params['per_page']);
        }
        return $query;
    }

    /**
    * ストレージに保存する画像のidによるグループ分けの為の名前暗号化
    * 100ごとにディレクトリをふり分ける
    * 
    * @params $id int それぞれのID ( items_id,user_items_id,users_idなど )
    * @return string  暗号化後のディレクトリ名
    */
    public static function getGroupDir($id) {
        if ($id <= 100) {
            return md5("000");
        } else {
            // 下２桁は00に
            $tmp_id = substr($id, 0, -2);
            $res = intval($tmp_id . "00") + 100;
            return md5($res);
        }
    }

    /**
    * ディレクトリを検索して無ければ、追加する
    *
    * @params $path string ストレージの保存先パス
    *         $dir  string 暗号化された保存先ディレクトリ
    * @return string  最終的な保存先パス
    */
    public static function makeGroupDir($path, $dir) {
        if ( ! Storage::disk('public')->exists($path . $dir)) {
            //mkdir($path . $dir, 0777);
            Storage::disk('public')->makeDirectory($path . $dir);
        }
        return $path . $dir . "/";
    }

    public static function getStoragePath() {
        return Storage::url('public');
    }

}
