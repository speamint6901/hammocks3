<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Service\Base as Logic;

class Controller extends BaseController
{
    use /*AuthorizesRequests, AuthorizesResources*/ DispatchesJobs, ValidatesRequests;

    protected $data = [];

    protected $user;

    protected $users_id = null;

    protected $sns_share_path = [
        "article" => "/user/log/",
        "items" => "/master/item/",
    ];

    public function __construct(Request $request) {

        // ユーザーエージェント振り分け
        $this->setUserAgentVars($request);

        // 認証していれば、ユーザー情報を持ち回る
        $user = $user = \Auth::user();
        if (!is_null($user)) {
            $this->user = $user;
            $this->users_id = $user->id;
            $this->data['user'] = $user;
        }

        // StorageパスURL（画像パス用の変数)
        $storage_path = \Storage::url('public');
        $this->data['storage_url'] = url($storage_path);

        // route_class(css用) を動的に生成して全ビューに渡す
        $currentRoute = \Route::getCurrentRoute();

        // artisan route:listでエラー回避用
        if (is_null($currentRoute)) {
            return;
        }

        // viewでクラス切り替え
        $currentRouteUri = $currentRoute->uri();
        $currentRouteArray = explode("/", $currentRouteUri);
        $res_route = null;
        foreach ($currentRouteArray as $route) {
            if (empty($route)) {
                $res_route = "index";
                break;
            } elseif (preg_match("/\{/", $route)) {
                break;
            }
            if (is_null($res_route)) {
                $res_route = $route;
                continue;
            }
            $res_route .= " " . $route;
        }

        // ログイン時のリファラー記憶用
        // リファラーをセッションに保存して、ログイン時に該当ぺージに戻れるよう改修
        if ( ! preg_match("/auth/", $currentRouteUri) && ! preg_match("/ajax/", $currentRouteUri)) {
            $paramNames = $currentRoute->parameterNames();
            foreach ($paramNames as $paramName) {
                if ( ! is_null($currentRoute->getParameter($paramName))) {
                    $parameter = $currentRoute->getParameter($paramName);
                    $currentRouteUri = preg_replace("/\{". $paramName . "\}/", $parameter, $currentRouteUri);
                }
            }
            session()->put("url_referer", $currentRouteUri);
        }
        $this->data['route_class'] = $res_route;

        return;
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

    // 画像保存のキャッシュクリア
    public function clearImageUploaderCache($id, $cache_key_prefix) {
        Logic::clearImageUploaderCache($id, $this->users_id, $cache_key_prefix);
    }

    // 画像キャッシュ取得
    public function getImageUploaderCache($id, $cache_key_prefix) {
        return Logic::getImageUploaderCache($id, $this->users_id, $cache_key_prefix);
    }

    // snsシェアリンクコンフィグ取得
    public function setSnsLinks($page_name, $id) {
        $sns_config = \Config::get('sns.sharLink');
        $tmp_config = [];
        $myUrl = env("APP_URL") . $this->sns_share_path[$page_name] . $id;
        foreach ($sns_config as $key => $config) {
            $tmp_config[$key]['link'] = $config['url'] . $myUrl;
            if ( ! empty($config['text_key'])) {
                $tmp_config[$key]['link'] .= "&" . $config['text_key'] . '=' . $config['text']; 
            }
        }

        $this->data['sns_links'] = $tmp_config;
    }
}
