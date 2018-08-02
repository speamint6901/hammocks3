<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request; 
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use \App\Service\Api\UserItemClipControllerLogic as Logic;

class UserItemClipController extends BaseApiController
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
        if (is_null($this->user)) {
            //throw new \Exception("dont auth");
        }
    }

    /**
    * お気に入りのカウント,フラグ更新
    *
    * @input  items_id, users_id
    * @return  json   $has_want_counts ["want_count", "has_count"]
    */
    public function showPushClipIcon($user_item_id) {
        $params["user_item_id"] = $user_item_id;
        $params['users_id'] = $user->id;

        // userid todo 認証
        $clip_counts = Logic::updateFavCounts($params);
        return new JsonResponse($clip_counts);
    }

}
