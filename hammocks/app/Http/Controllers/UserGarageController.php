<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\UserGarageControllerLogic as Logic;

class UserGarageController extends Controller
{

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    // ユーザーが自分か他人かの切り分けするフラグをセットする
    protected function setSelfOrOtherUserFlag($id) {
        $this->data['self_flag'] = 0;
        if ($this->users_id === (int) $id) {
            $this->data['self_flag'] = 1;
        }
    }

    // フォロー済みかどうかチェックし、フラグをセットする
    protected function setFollowerFlag($id) {
        $this->data['is_follower'] = 0;
        if (Logic::checkFollower($this->users_id, $id)) {
           $this->data['is_follower'] = 1; 
        }
    }

    // ユーザー情報をまとめてセットする
    protected function setUserGarageInfo($id) {
        if ( ! Logic::foundCheckOwnerUser($id)) {
            throw new \App\Exceptions\NotFoundUserException();
        }
        $this->setSelfOrOtherUserFlag($id);
        $this->setFollowerFlag($id);
        $this->data['user_info'] = Logic::getGarageInfo($id);
    }

    // ガレージトップ
    public function showIndex($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.index', $this->data);
    }

    // ガレージログリスト
    public function showLogs($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.garage.log', $this->data);
    }

    // 持ってる
    public function showHaves($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.garage.haves', $this->data);
    }

    // 欲しい
    public function showWants($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.garage.wants', $this->data);
    }

    // クリップ
    public function showFavorite($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.garage.pick', $this->data);
    }

    // 売り物
    public function showSales($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.garage.sales', $this->data);
    }

    // フォロー
    public function showFollows($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.garage.follows', $this->data);
    }

    // フォロワー
    public function showFollowers($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.garage.followers', $this->data);
    }

    // 良い評価
    public function showEvaluationGood($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.evaluation_good', $this->data);
    }

    // 悪い評価
    public function showEvaluationBad($id) {
        $this->setUserGarageInfo($id);
        return \View::make('user.evaluation_bad', $this->data);
    }

    // コンテナの中身
    public function showContainerLogs($users_id, $container_id) {
        $this->setUserGarageInfo($users_id);
        $article_container = Logic::findArticleContainer($users_id, $container_id);
        if ( is_null($article_container)) {
            throw new \App\Exceptions\NotFoundUserException("コンテナが見つかりません");
        }
        $this->data['article_container'] = Logic::findArticleContainer($users_id, $container_id);
        return \View::make('user.garage.container', $this->data);
    }

    // ウォッチリスト
    public function showWatching() {
        return \View::make('user.watching', $this->data);
    }
}
