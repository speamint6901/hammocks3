<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItemInfo extends Base
{
    //
    protected $table = "sale_item_info";

    const DELIVERY_DAY_TYPE_ONE = 1;
    const DELIVERY_DAY_TYPE_TWO = 2;
    const DELIVERY_DAY_TYPE_THREE = 3;

    const DELIVERY_PATTERN_CASHON = 0;
    const DELIVERY_PATTERN_POSTAGE = 1;

    protected static $delivery_day_nums = [
       self::DELIVERY_DAY_TYPE_ONE => "1~2日で発送",
       self::DELIVERY_DAY_TYPE_TWO => "2~3日で発送",
       self::DELIVERY_DAY_TYPE_THREE => "4~7日で発送", 
    ];

    protected static $delivery_pattern = [
        self::DELIVERY_PATTERN_CASHON => "着払い(購入者負担)",
        self::DELIVERY_PATTERN_POSTAGE => "送料込み(出品者負担)",
    ];

    /**
    * 発送日を取得する
    *
    * @params $type int  発送日タイプ
    * @return array
    */
    public static function getDeliveryDayNumByType($type) {
        return static::$delivery_day_nums[$type];
    }

    /**
    * 配送タイプをNumで取得する
    *
    * @params $type int  発送タイプ
    * @return string
    */
    public static function getDeliveryPatternByNum($num) {
        return static::$delivery_pattern[$num];
    }

    /**
    * 発送日を全取得
    *
    * @return array
    */
    public static function getDeliveryDayNums() {
        return static::$delivery_day_nums;
    }

    /**
    * ユーザーアイテムIDから一件取得
    *
    * @params  $user_items_id  int  ユーザーアイテムID
    *          $is_master      bool マスタースレイブ切り替えフラグ
    * @return  self
    */
    public static function getByUserItemsId($user_items_id, $is_master = false) {
        $query = static::where("user_items_id", $user_items_id);
        
        if ($is_master) {
            return $query->get();    
        }

        return static::getS($query);
    }
}
