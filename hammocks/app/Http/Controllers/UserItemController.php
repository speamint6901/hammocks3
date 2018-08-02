<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Service\UserItemControllerLogic as Logic;

class UserItemController extends Controller
{

    public function showIndex() {
        //$user = Logic::getUserById(1);
        //$user = Logic::getUserInfoById(1);
        //var_dump($user->profile->user_comment);
        //$container_list = Logic::getContainerListByUserId(1);
        //var_dump($container_list);
        //$this->dispatch(new \App\Jobs\TestJob());
        /*
        $tid = mt_rand(1,10);
        $fid = mt_rand(1,10);
        while($tid === $fid) {
            $fid = mt_rand(1,10);
        }
        $params = ["target_user_id" => $tid, "follower_user_id" => $fid];
        $this->dispatch(new \App\Jobs\UserFollowJob($params));
        //$follow = \App\Models\User\Follow::updateCount(1,2);
        */
        /*
        $params = [
            "id" => 6,
            "name" => "テストお城",
            "description" => "例外の中にはサーバーでのHTTPエラーコードを表しているものがあります。たとえば「ページが見つかりません」",
            ];
        $res = \App\Libs\SolrInput::forge("items")
                    ->setDocument($params);
        */
        /*
        $query = new \SolrQuery("name:*マンu*");
        $query->setStart(0);
        $query->setRows(300);
        $query_response = $solr->client->query($query);
        $response = $query_response->getResponse();
        var_dump($response);
        */
        return \View::make('index');
    }

    // タイムラインページ
    public function showUserItemDetail($id) {
        // idからアイテム情報取得
        $user_item = Logic::getUserItemsDetail($id);
        if (is_null($user_item) || empty($user_item)) {
            throw new \App\Exceptions\NotFoundUserException();
        }
        $this->setSnsLinks("article", $id);
        $this->data['is_myitem'] = null;
        if ( ! is_null($this->users_id) && $user_item->user_id == $this->users_id) {
            $this->data['is_myitem'] = 1;
        }
        $this->data['user_item_info'] = $user_item;

        return \View::make('user.log', $this->data);
    }

    // ログ単体ページ
    public function showLogDetail($id) {
        $log_info = Logic::findLogById($id);
        $log_info->is_pick = Logic::setIsPickToArticle($this->users_id, $log_info);
        $user_item = Logic::getUserItemsDetail($log_info['user_items_id']);
        if (is_null($user_item) || empty($user_item)) {
            throw new \App\Exceptions\NotFoundUserException();
        }
        $this->data['is_myitem'] = null;
        if ( ! is_null($this->users_id) && $user_item->user_id == $this->users_id) {
            $this->data['is_myitem'] = 1;
        }
        $this->data['user_item_info'] = $user_item;
        $this->data["log_info"] = $log_info;
        return \View::make('user.log.detail', $this->data);
    }

    public function showPublicItemDetail($id) {
        return \View::make('item.public');
    }

    // ユーザーアイテムセールページ
    public function showUserItemSale($id) {
        return \View::make('item.user.sale', $this->data);
    }

}
