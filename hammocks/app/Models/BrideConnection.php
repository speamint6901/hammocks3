<?php
/**
* Modelとserviceの共有クラス
*/

namespace App\Models;

class BrideConnection extends Base {

    /**
    * slaveのコネクションを取得する
    * 
    * @return string  コネクション名
    */
    public static function getSlaveConnection() {
        return self::getSlave();
    }
}
