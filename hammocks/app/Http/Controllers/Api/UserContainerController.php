<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseApiController;
use \App\Service\Api\UserContainerControllerLogic as Logic;

class UserContainerController extends BaseApiController
{

    // ユーザーコンテナ登録
    public function registUserContainer(Request $request) {
        $user_container = Logic::registUserContainer($this->users_id, $request->input());
        return new JsonResponse($user_container);
    }

    // ユーザーコンテナ取得
    public function getContainerList(Request $request) {
        $params = $request->input();
        $users_id = $this->users_id;
        if (isset($params["owner_users_id"]) && ! empty($params["owner_users_id"])) {
            if ((int)$params["owner_users_id"] === $users_id) {
                $params["is_container_owner"] = 1;
            }
            $users_id = $params["owner_users_id"];
        }
        $container_list = Logic::getContainerList($users_id, $params);
        return new JsonResponse($container_list);
    }

    // ピック追加
    public function addContainer(Request $request) {
        $params = $request->input();
        $res = Logic::addPick($this->users_id, $params);
        return new JsonResponse(["article" => $res, "message" => "ピックに登録しました"]);
    }

    // コンテナ編集
    public function editContainer(Request $request) {
        $params = $request->input();
        $res = Logic::editContainer($this->users_id, $params);
        return new JsonResponse($res);
    }

    // コンテナ中のログ削除
    public function removeLogContainer(Request $request) {
        $params = $request->input();
        Logic::removeLogContainer($this->users_id, $params);
    }

    // コンテナ削除
    public function deleteContainer(Request $request) {
        $params = $request->input();
        $res = Logic::removeContainer($this->users_id, $params);
        return new JsonResponse($res);
    }

    // コンテナのロック、アンロック切り替え
    public function toggleLockContainer(Request $request) {
        $params = $request->input();
        $res = Logic::toggleLockContainer($this->users_id, $params);
        return new JsonResponse($res);       
    }

}
