<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use \App\Service\Api\HasWantControllerLogic as Logic;

class HasWantController extends Controller
{

    /**
    * 持ってる、欲しいのカウントアップ
    *
    * @input  items_id, users_id
    * @return  json   $has_want_counts ["want_count", "has_count"]
    */
    public function showPushHasWantIcon($type, $item_id) {
        $params = ["type" => $type, "item_id" => $item_id];
        $user = $user = \Auth::user();
        if (!is_null($user)) {
            $params['users_id'] = $user->id;
        } else {
            return new JsonResponse($user);
        }

        // userid todo 認証
        $has_want_counts = Logic::updateHasWantCounts($params);
        return new JsonResponse($has_want_counts);
    }

}
