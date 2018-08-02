<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class BaseApiController extends Controller
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    const USER_LIST_LIMIT = 10; // ユーザーリストの総表示数

    protected $params = [];

    protected $result_offset = 0;

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    // API認証チェック
    protected function authCheck() {
       if ( is_null($this->users_id) ) {
            throw new \App\Exceptions\ApiAuthException("ログインして下さい");
       }
    }

    // リミットオフセットセット
    protected function setPagingInfo($request, $per_page) {
        // ポストされたフィルターを取得する
        $this->params = $request->input();
        // デフォルトは登録日時
        $this->params['sort'] = 'created_at';
        if (!isset($this->params['offset'])) {
            $this->params['offset'] = 0;
        }
        $this->result_offset = $this->params['offset'] + $per_page;
        $this->params['per_page'] = $per_page;
    }
}
