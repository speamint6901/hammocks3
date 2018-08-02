<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class BaseAdminController extends BaseController
{

    protected $data = [];

    public function __construct( Request $request ) {

        // ユーザーエージェント振り分け
        $this->setUserAgentVars($request);

        // StorageパスURL（画像パス用の変数)
        $storage_path = \Storage::url('public');
        $this->data['storage_url'] = url($storage_path);

        //セッションに保存されたログイン メールアドレス 取得
        $login_email = $request->session()->get('login_email');

        $this->data["path_prefix"] = \Config::get("admin.path_prefix");
        //ログインメールアドレスがセッションに保存されておらず、かつログインページでない場合、ログインページにリダイレクト
        if ( is_null($login_email) && $request->is('*/login') == 0 && $request->is('*/user-register') == 0 ) {
            Redirect::to($this->data["path_prefix"].'/login')->send();
            exit;
        }
    }

    // ua振り分け変数セット
    public function setUserAgentVars($request) {
        $ua = $request->server->get('HTTP_USER_AGENT');
        $agent = new Agent();
        $agent->setUserAgent($ua);

        if ($agent->isTablet()) {
            $this->data['user_agent'] = "tablet";
        } elseif ($agent->isMobile()) {
            $this->data['user_agent'] = "sp";
        } else {
            $this->data['user_agent'] = "pc";
        }
    }
}
