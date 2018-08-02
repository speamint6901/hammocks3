<?php

namespace App\Service;

use App\Models\Users;

class UserControllerLogic extends Base {

    /**
    * 画像の保存先などをavaterとbackgroundに分けて、作成する
    *
    * @params  $input array postパラメータ
    * @return  bool
    */
    protected static function createFileInfo($input) {
        $ext = self::$image_mimetypes[$input['mime_type']];
        $file_info = [];
        $key = $input["cache_key"];
        $path = Users::$image_path_list[$key];
        $file_info[$key]['path'] = '/user/' . $path . '/';
        $file_info[$key]['ext'] = $ext;
        return $file_info;
    }
}
