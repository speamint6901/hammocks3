<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseApiController;
use \App\Service\Api\FollowControllerLogic as Logic;

class FollowController extends BaseApiController
{

    const USER_LIST_PER_PAGE = 10;

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
        if (is_null($this->user)) {
            throw new \App\Exceptions\ApiAuthException("followするにはログインしてください");
        }
    }
    
    // フォロー処理（追加、解除のトグル）
    public function follow(Request $request) {
        $follow_users_id = $request->input('users_id'); 
        $follow = Logic::setFollowToFollewer($follow_users_id, $this->users_id);
        return new JsonResponse($follow);
    }

    // フォロー一覧表示
    public function getFollows(Request $request) {
        $params = $request->input();
        $owner_users_id = $params["owner_users_id"];
        $follows = Logic::getFollows($owner_users_id, $params)->paginate(self::USER_LIST_PER_PAGE);
        $follows = Logic::setCountExt($follows);
        return new JsonResponse($follows);
    }
}
