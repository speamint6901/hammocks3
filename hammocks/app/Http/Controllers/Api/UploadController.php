<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseApiController;

class UploadController extends BaseApiController {

    //　認証チェック
    public function __construct(Request $request) {
        parent::__construct($request);
        if (is_null($this->user)) {
            throw new \App\Exceptions\ApiAuthException("ログインしてください");
        }
    }

    // ファイルアップロード
    public function tmpUpload(Request $request) {
        // リクエストパラメータ取得
        $post = $request->input();

        if (!isset($post["id"]) || empty($post["id"])) {
            $post["id"] = 1;
        }

        // cache key 設定
        $cache_key = $post["cache_key"] . "_" . $post["id"] . "_" . $this->users_id;
        $cache_data[] = $post;
        $cache = \Cache::get($cache_key, null);

        if (count($cache) >= 4) {
            return new JsonResponse("max");
        }

        // キャッシュ有効期限（２時間）
        $expiresAt = Carbon::now()->addMinutes(480);
        if (is_null($cache)) {
            \Cache::add($cache_key, $cache_data, $expiresAt);
        } else {
            $cache[] = $post;
            \Cache::forget($cache_key);
            // cache再設定
            \Cache::add($cache_key, $cache, $expiresAt);
        }
        return new JsonResponse($cache); 
    }

    // ファイル削除
    public function tmpRemove(Request $request) {
        //\Cache::flush();exit;
        $post = $request->input();
        // cache key 設定
        $cache_key = $post["cache_key"] . "_" . $post["id"] . "_" . $this->users_id;
        $cache = \Cache::get($cache_key);
        if ( ! empty($post) && ! empty($cache)) {
            $res_cache = array_filter($cache, function($c) use ($post) {
                return $c["file_name"] != $post["file_name"];
            });
            \Cache::forget($cache_key);
            // 複数画像の場合は消去したもの以外を再追加
            if ( ! empty($res_cache)) {
                $expiresAt = Carbon::now()->addMinutes(480);
                \Cache::add($cache_key, $res_cache, $expiresAt);
            }
        }
        return new JsonResponse($cache_key); 
    }
}
