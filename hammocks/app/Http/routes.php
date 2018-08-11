<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// アプリAPI
Route::group(array('prefix' => 'api'), function($router) {
    Route::get('test', 'Api\TestController@showIndex');
});

// web 非同期通信
Route::group(array('prefix' => 'ajax', 'middleware' => 'api'), function($router) {

    // ログインユーザーのみアクセス出来るルーティング
    Route::group(array("middleware" => "users"), function($route) {
        // 画像アップローダー
        Route::post('/tmp_upload', 'Api\UploadController@tmpUpload');
        Route::post('/tmp_remove', 'Api\UploadController@tmpRemove');
        // コンテナ登録
        Route::post('/add_container', 'Api\UserContainerController@addContainer');
        // コンテナのログ削除
        Route::post('/delete_container_log', 'Api\UserContainerController@removeLogContainer');
        // コンテナ編集
        Route::post('/container_edit_save', 'Api\UserContainerController@editContainer');
        // コンテナをロック、アンロック
        Route::post('/container_lock_send', 'Api\UserContainerController@toggleLockContainer');
        // コンテナを削除
        Route::post('/container_delete_send', 'Api\UserContainerController@deleteContainer');
        // 欲しいカウントアイコン押下
        Route::post('/push_haswant/{type}/{user_item_id}', 'Api\HasWantController@showPushHasWantIcon')
            ->where(['type' => '[0-9]+', 'user_item_id' => '[0-9]+']);
        Route::post('/push_user_item_clip/{user_item_id}', 'Api\UserItemClipController@showPushClipIcon')
            ->where(['user_item_id' => '[0-9]+']);
        // ブランド入力補完出力用
        Route::post('/autocomplete_brand/', 'Api\AutoCompleteController@getBrandList');
        // タグ入力補完出力用
        Route::post('/autocomplete_tag/', 'Api\AutoCompleteController@getTagList');
        // アイテム入力補完出力用
        Route::post('/completion_item/', 'Api\PublicItemController@getCompletionItems');
        // urlスレイプニング処理
        Route::post('/url_slape_action', 'Api\WebScrapingController@getImageList');
        // 大カテゴリ選択時、子要素セレクトボックス連携用
        Route::post('/select_big_category/', 'Api\AutoCompleteController@getCategoryList');
        // カテゴリ選択時、子要素セレクトボックス連携用
        Route::post('/select_category/', 'Api\AutoCompleteController@getGenreList');
        // ジャンル選択時、子要素セレクトボックス連携用
        Route::post('/select_genre/', 'Api\AutoCompleteController@getSecondGenreList');
        // アイテム編集
        Route::post('/item/edit', 'Api\UserItemsController@updateUserItems');
        // アイテム評価
        Route::post('/item/rating', 'Api\UserItemsController@saveSessionRating');
        // ユーザーコンテナ登録
        Route::post('/regist_user_container/', 'Api\UserContainerController@registUserContainer');
        // ユーザーアイテム重複チェック
        Route::post('/has_item_user/', 'Api\UserItemsController@hasItemByUser');
        // フォローする
        Route::post('/follow_action/', 'Api\FollowController@follow');
        // ユーザー設定更新
        Route::post('/user_image_update', 'Api\UserSettingController@updateUserImage');
        Route::post('/update_tab1_user_setting', 'Api\UserSettingController@updateTabOne');
        Route::post('/update_tab2_user_setting', 'Api\UserSettingController@updateTabTwo');
        Route::post('/update_tab3_user_setting', 'Api\UserSettingController@updateTabThree');
        // パスワード変更
        Route::post('/updatePassword', 'Api\UserSettingController@updatePassword');
        // sms送信
        Route::post('/send_sms/', 'Api\SmsController@sendSmsPhoneNo');
        // 本人確認書類アップロード
        Route::post('/identification_update/', 'Api\UserSettingController@updateIdentificationImage');
        // ログ記事編集 
        Route::post('/log_edit_send/', 'Api\ArticleController@editLogArticle');
        // ログ記事編集 
        Route::post('/log_delete_send/', 'Api\ArticleController@deleteLogArticle');

    });
    
    /** リストパターン **/
    // パブリックアイテム
    Route::post('/public_item_list', 'Api\PublicItemController@getItemList');
    // ユーザーアイテム
    Route::post('/user_item_list', 'Api\UserItemsController@getUserItemList');
    Route::post('/user_rating_list', 'Api\UserItemsController@getUserItemRatingList');
    // 記事
    Route::post('/article_list', 'Api\ArticleController@getItemList');
    Route::post('/articl_detail', 'Api\ArticleController@getItemDetail');
    // コンテナ一覧参照
    Route::post('/container_list', 'Api\UserContainerController@getContainerList');

    // タイムライン一覧
    Route::post('/timeline_list', 'Api\ArticleController@getTimeline');

    // ユーザーアイテム一覧参照
    Route::post('/itemlist', 'Api\UserItemsController@showUserItemList');
    Route::post('/item_comment_list', 'Api\UserItemsController@getUserItemsCommentPage');
    // ユーザーリスト一覧
    Route::post('/followFollewerlist', 'Api\FollowController@getFollows');

    // 表示用タグリスト取得
    Route::post('/tag/list', 'Api\UserItemsController@getDispTagList');

    // 検索結果取得
    Route::post('/search_result/', 'Api\UserItemsController@getSearchResultItems');
    // モーダルリスト用カテゴリリスト
    Route::post('/search_category_list/', 'Api\CategoryController@getCategoryList');
    // モーダルカテゴリ選択時のアイテム検索
    Route::post('/select_category_search/', 'Api\PublicItemController@getSearchItemsByCategory');
    // モーダルカテゴリ選択時のモーダルブランドリスト
    Route::post('/modal_brand_list/', 'Api\CategoryController@getModalBrandList');

    // 問題報告
    Route::post('/ban_report_send/', 'Api\UserItemsController@sendBanReport');
});

// web 同期通信
Route::group(array('prefix' => '/', 'middleware' => 'web'), function($router) {

    // ログインユーザーのみアクセス出来るルーティング
    Route::group(array("middleware" => "users"), function($route) { 
        // ユーザー設定関連
        Route::get('user/setting', 'UserSettingController@showIndex');
        Route::get('user/setting/identification', 'UserSettingController@showIdentification');
        Route::get('user/setting/basic_information', 'UserSettingController@showBasicInfo');
        Route::get('user/setting/purchaser', 'UserSettingController@showPurchaser');
        Route::get('user/setting/seller', 'UserSettingController@showSeller');
        // SMS認証
        Route::get('user/setting/sms', 'UserSettingController@showSms');
        Route::get('user/setting/sms2', 'UserSettingController@resultSms');
        // 売り上げ管理
        Route::get('user/setting/sales', 'UserSettingController@showSales');
        // ろぐあうと
        Route::get('auth/logout', 'Auth\AuthController@getLogout');
        Route::get('user/watching', 'UserGarageController@showWatching');
        // アイテム登録
        Route::get('/item/register', 'ItemRegisterController@showStepOne');
        Route::get('/item/register/1', 'ItemRegisterController@showStepOne');
        Route::post('/item/register/2', 'ItemRegisterController@showStepTwo');
        Route::get('/item/register/2', 'ItemRegisterController@showStepTwoGet');
        Route::post('/item/register/confirm', 'ItemRegisterController@showItemConfirm');
        Route::get('/item/register/complete', 'ItemRegisterController@showComplete');
        // アイテム出品
        Route::get('/item/sale/register1/{id}', 'ItemRegisterController@showSaleStepOne')
            ->where('id', '[0-9]+');
        Route::get('/item/sale/register2', 'ItemRegisterController@showGetSaleStepTwo');
        Route::post('/item/sale/register2', 'ItemRegisterController@showSaleStepTwo');
        Route::get('/item/sale/register3', 'ItemRegisterController@showGetSaleStepThree');
        Route::post('/item/sale/register3', 'ItemRegisterController@showSaleStepThree');
        Route::get('/item/sale/register4', 'ItemRegisterController@showGetSaleStepFour');
        Route::post('/item/sale/register4', 'ItemRegisterController@showSaleStepFour');
        Route::get('/item/sale/confirm', 'ItemRegisterController@saleItemConfirm');
        // 記事登録
        Route::get('/item/article/register/{id}', 'ArticleRegisterController@showArticleRegister')
            ->where('id', '[0-9]+');
        Route::post('/item/article_register', 'ArticleRegisterController@articleConfirm');
    });
    // 認証系
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    
    Route::get('auth/f_login', 'Auth\AuthController@facebookLogin');
    Route::get('auth/f_register', 'Auth\AuthController@facebookRegister');
    Route::get('auth/f_callback', 'Auth\AuthController@facebookDoLogin');
    Route::get('auth/t_login', 'Auth\AuthController@twitterLogin');
    Route::get('auth/t_register', 'Auth\AuthController@twitterRegister');
    Route::get('auth/t_callback', 'Auth\AuthController@twitterDoLogin');

    // テスト
    Route::get('develop', 'TestController@showIndex');
    Route::get('develop/send_mail', 'TestController@sendMail');
    Route::get('paygent', 'TestController@showTestPaygent');

    // ユーザー登録
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');
    Route::get('auth/confirm/{token}', 'Auth\AuthController@getConfirm');

    // ユーザープロフィール
    Route::get('user/garage/{id}', 'UserGarageController@showIndex')
        ->where('id', '[0-9]+');
    Route::get('user/garage/log/{id}', 'UserGarageController@showLogs')
        ->where('id', '[0-9]+');
    Route::get('user/garage/haves/{id}', 'UserGarageController@showHaves')
        ->where('id', '[0-9]+');
    Route::get('user/garage/wants/{id}', 'UserGarageController@showWants')
        ->where('id', '[0-9]+');
    Route::get('user/garage/pick/{id}', 'UserGarageController@showFavorite')
        ->where('id', '[0-9]+');
    Route::get('user/garage/sales/{id}', 'UserGarageController@showSales')
        ->where('id', '[0-9]+');
    Route::get('user/garage/follows/{id}', 'UserGarageController@showFollows')
        ->where('id', '[0-9]+');
    Route::get('user/garage/followers/{id}', 'UserGarageController@showFollowers')
        ->where('id', '[0-9]+');
    Route::get('user/garage/evaluation_good/{id}', 'UserGarageController@showEvaluationGood')
        ->where('id', '[0-9]+');
    Route::get('user/garage/evaluation_bad/{id}', 'UserGarageController@showEvaluationBad')
        ->where('id', '[0-9]+');
    Route::get('user/garage/pick/container/{users_id}/{container_id}', 'UserGarageController@showContainerLogs')
        ->where('users_id', '[0-9]+')
        ->where('container_id', '[0-9]+');
    // アイテム記事トップ 
    Route::get('/user/log/{id}', 'UserItemController@showUserItemDetail')
        ->where('id', '[0-9]+');
    // 記事単体ページ
    Route::get('/user/log/detail/{id}', 'UserItemController@showLogDetail')
        ->where('id', '[0-9]+');

     // 出品リスト
    Route::get('user/archive/sales', 'UserArchiveController@showSales');
    Route::get('user/archive/purchase', 'UserArchiveController@showPurchase');

     // ユーザーガイド
    Route::get('guide/users_guide', 'GuideController@showUser');
    // 特定商取引法ページ
    Route::get('guide/commercial_law', 'GuideController@showCommercial');
    // プライバシーポリシー
    Route::get('guide/privacy_policy', 'GuideController@showPrivacyPolicy');
    // 禁止出品物
    Route::get('guide/prohibitions', 'GuideController@showProhibitions');
    // 利用規約
    Route::get('guide/aup', 'GuideController@showAup');
    // 禁止行為
    Route::get('guide/prohibited-acts', 'GuideController@showProhibitedActs');


    // アイテム関連
    Route::get('/user/item/sale/{id}', 'UserItemController@showUserItemSale')
        ->where('id', '[0-9]+');
    Route::get('/master/item/{id}', 'PublicItemController@showIndex')
        ->where('id', '[0-9]+');
    Route::get('/master/item/rating/{id}', 'PublicItemController@showPublicItemRating')
        ->where('id', '[0-9]+');
    Route::get('/master/item/photo/{id}', 'PublicItemController@showPublicItemPhoto')
        ->where('id', '[0-9]+');
    Route::get('/master/item/sale/{id}', 'PublicItemController@showPublicItemSale')
        ->where('id', '[0-9]+');


    // top,一覧系
    Route::get('/', 'TopController@showIndex');
    Route::post('/', 'TopController@showWordSearch');

    // 検索系
    Route::post('/search/result', 'SearchController@showResult');
    // カテゴリ
    Route::get('search/category', 'SearchController@showCategory');
    Route::get('search/select/{name}/{id}', 'SearchController@showCategoryResult')
        ->where('id', '[0-9]+')
        ->where('name', '[a-z]+');
    // ブランド
    Route::get('search/brand', 'SearchController@showBrand');
    Route::get('search/brand/select/{id}', 'SearchController@showBrandResult')
        ->where('id', '[0-9]+');
    // タグ検索
    Route::get('search/tag/{id}', 'SearchController@showSelectTag')
        ->where('id', '[0-9]+');

    // 決済
    Route::get('payment/confirm/{id}', 'PaymentController@showConfirm')
        ->where('page', '[1-2]+');
    Route::get('payment/do_callback', 'PaymentController@do');
    Route::get('payment/status', 'PaymentController@showStatus');
    Route::get('payment/seller/{page}', 'PaymentController@showSeller')
        ->where('page', '[0-9]+');
    Route::get('payment/customer/{page}', 'PaymentController@showCustomer')
        ->where('page', '[0-9]+');
});

// 管理画面
$admin_config = \Config::get("admin");
Route::group(array('prefix' => $admin_config["path_prefix"]), function($router) {
    // 管理ログイン画面関連
    Route::get('/login', 'Admin\AuthController@showIndex');
    Route::post('/login', 'Admin\AuthController@postLogin');
    Route::get('/logout', 'Admin\AuthController@getLogout');

    // 管理トップ画面関連
    Route::get('/', 'Admin\TopController@showIndex');

    // 管理者登録画面関連
    Route::get('/user-register', 'Admin\UserRegisterController@showIndex');
    Route::post('/user-register', 'Admin\UserRegisterController@showItemConfirm');

    // マスターアイテム関連
    Route::get('/item-list', 'Admin\ItemController@showIndex');
    Route::get('/item-register/{id}', 'Admin\ItemController@showItemRegister')
        ->where('id', '[0-9]+');
    Route::get('/item-status-up/{id}', 'Admin\ItemController@showItemStatusUp')
        ->where('id', '[0-9]+');
    Route::post('/item-name-edit/{id}', 'Admin\ItemController@showItemNameEdit')
        ->where('id', '[0-9]+');
    Route::post('/item-description-edit/{id}', 'Admin\ItemController@showItemDescriptionEdit')
        ->where('id', '[0-9]+');

    // ブランド登録画面関連
    Route::get('/brands-register', 'Admin\BrandsRegisterController@showIndex');
    Route::get('/brands-register/showBrandsAdd', 'Admin\BrandsRegisterController@showBrandsAdd');
    Route::get('/brands-register/showBrandsEdit/{id}', 'Admin\BrandsRegisterController@showBrandsEdit');
    Route::get('/brands-register/setBrandsDelete/{id}', 'Admin\BrandsRegisterController@setBrandsDelete');
    Route::post('/brands-register', 'Admin\BrandsRegisterController@showItemConfirm');
});

//Route::auth();

//Route::get('/home', 'HomeController@index');
