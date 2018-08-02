// listオブジェクト
var List = function(element, option) {
    this.element = element;
    this.setOptionAndParams(option);
    if (option.onEventFilter !== undefined && option.onEventFilter) {
        this.addFilterEventListner();
    }
    if (option.onEventSort !== undefined && option.onEventSort) {
        this.addSortEventListner();
    }
    if (this.options.isPaging) {
        this.addPagingEventListner();
    }
    // フィルター用に初期URLをとっておく
    this.options.initUrl = option.url;
};

// オプションデフォルトセット
List.prototype.options = {
    url : null,
    initUrl : null,  //初回アクセスURL
    method : "post",
    page : 1, //current page
    isPaging : 1,  // ページング使用フラグ 1: 使用 2: 使用しない
    pagingType : "scroll", // ページングの種類　scroll , boutton
    pagingEventElement : null,  // ページング発火要素 例）#hoge
    pagingEventType : null,  // ページング発火イベントタイプ
    pagingDoFlag : 1,  // ページング表示ロックフラグ
    templete_id : null, // リストで使用するtemplete_id
    onFilter : 0,  // フィルター機能使用フラグ　1: 使用　2: 使用しない
    filterElement : null, //　フィルター要素　select,radioボタンなど
    sortElement : null, // ソート要素
    sortCategory : "master_item",
    eventType : null,
    listLoadedFlag : 1,
    is_selfuser : 0,  //自分のページ判定フラグ
    container_list_type : 0 // 1 : コンテナ登録時 0 : 通常リスト
};

// postパラメーター
List.prototype.params = {
    owner_users_id : null,
    users_id : null,
    follower_users_id : null,
    container_id : null,
    items_id : null,
    user_items_id : null,
    sort : null,
    follow_type : null,
    item_status : null,
    brands_id : null,
    big_category_id : null,
    category_id : null,
    genre_id : null,
    genre_second_id : null,
    tags_id : null,
    is_store : null,
    sort_category : null,
    is_container_owner : 0,
    search_word : null,
    from : 0,       // 全文検索時に使用（offset)
    per_page : null // 全文検索時に使用（limit)
};

List.prototype.setOptionAndParams = function(option) {
    // オプション一括セット
    for (o in option) {
        if (this.options[o] !== undefined) {
            this.options[o] = option[o];
        }
        if (this.params[o] !== undefined) {
            this.params[o] = option[o];
        }
    }
};

// イベント発火時にオプションを一部初期化
List.prototype.initEventOption = function(eo) {
    // ローディングフラグoff
    this.options.listLoadedFlag = 0;
    // ソート、フィルターのプルダウンをdisable
    this.disableSortAndFilterBtn();
    // 一覧を一旦削除
    $(this.element).empty();
    // パラメーターセット
    this.params[eo.target.id] = $(eo.target).val(); 
    // ページングをリセット
    this.options.page = 1;
    // 初回アクセスのurlをセット
    this.options.url = this.options.initUrl;
}

// フィルター,そーと使用時のイベントリスナを設定
List.prototype.addFilterEventListner = function() {
    // コールバック用にthisのエイリアスを作成
    var _this = this;
    $(document).on(this.options.eventType, this.options.filterElement, function(eo) {
        if (_this.options.listLoadedFlag) {
            _this.initEventOption(eo);
            _this.getItemList();
        } 
    });
};

// ソート使用時のイベントリスナを登録
List.prototype.addSortEventListner = function() {
    // コールバック用にthisのエイリアスを作成
    var _this = this;
    $(document).on(this.options.eventType, this.options.sortElement, function(eo) {
        if (_this.options.listLoadedFlag) {
            _this.initEventOption(eo);
            _this.params["sort_category"] = _this.options.sortCategory;
            _this.getItemList();
        }
    });
};

List.prototype.defer = $.Deferred();

// ページングコントローラー
List.prototype.addPagingEventListner = function() {
    var promise = this.doPagintEvent();
    var _this = this;
    promise.done(function() {
        console.log(_this.options.page);
        //_this.options.pagingDoFlag = 1; 
        if (_this.options.pagingEventType == "button") {
            if (_this.options.page != "max") {
                $(_this.options.pagingEventElement).show();
            }
        }
    });
};

// ページング
List.prototype.doPagintEvent = function() {
    var _this = this;
    // ページスクロールタイプ
    if (this.options.pagingType == "scroll") {
        $(window).on("scroll", function(eo) {
            console.log(_this.options.pagingDoFlag);
            if (_this.options.pagingDoFlag == 1 && _this.options.page != "max") {
                var scrollHeight = $(document).height();
                var scrollPosition = $(window).height() + $(window).scrollTop();
                if ((scrollHeight - scrollPosition) / scrollHeight === 0) {               
                    _this.options.pagingDoFlag = 0;
                    _this.getItemList();
                    _this.defer.resolve();
                }
            }
        });
    // ボタンタイプ
    } else if (this.options.pagingType == "button") {
        $(document).on(this.options.pagingEventType, this.options.pagingEventElement, function(eo) {
            $(_this.options.pagingEventElement).hide();
            if (_this.options.page != "max" && _this.options.pagingDoFlag == 1) {
                _this.options.pagingDoFlag = 0;
                _this.getItemList(); 
                _this.defer.resolve();
            }
        });
    }
    return this.defer.promise();
};

// 初回リスト呼び出し
List.prototype.get = function() {
    console.log(this.options);
    if (this.options.listLoadedFlag) {
        this.options.listLoadedFlag = 0;
        this.options.pagingDoFlag = 0;
        this.options.url += "?page=" + this.options.page;
        this.disableSortAndFilterBtn();
        this.getItemList();
    }
};

// 表示がdoneしたら
List.prototype.initListFlags = function() {
    this.options.listLoadedFlag = 1;
    this.options.pagingDoFlag = 1;
    $(this.options.filterElement).removeAttr("disabled");
    $(this.options.sortElement).removeAttr("disabled");
};

// イベント発火時にフィルターとそーとを押せなくする
List.prototype.disableSortAndFilterBtn = function() {
    $(this.options.sortElement).attr("disabled", "disabled");
    $(this.options.filterElement).attr("disabled", "disabled");
};

// データ０の時
List.prototype.notFoundItems = function(systemMeesage) {

    this.initListFlags();
    // ページングoff
    this.options.page = "max";
    if (systemMeesage) {
        var html = '<div class="not_applicable"><p>' + message + '</p></div>';
    } else {
        var html = '<div class="not_applicable"><span>0件</span><p>該当するギアが見つかりませんでした。</p></div>';
    }
    $(this.element).append(html);
    return 0;
};

// ページングの設定
List.prototype.settingPagingOptions = function(res) {
   if (res.meesage !== undefined) {
        return this.notFoundItems(res.meesage);
   }
   if (this.options.isPaging == 1) {
        this.options.url = res.next_page_url;
        if (res.current_page == res.last_page) {
            this.options.page = "max";
            console.log("max");
        } else {
            this.params.from = res.from;
            this.params.per_page = res.per_page;
            console.log(this.params.from);
        }
        if (res.total == 0) {
            return this.notFoundItems(0);
        }
        return res.data;
    } else {
        if (res.length == 0) {
            return this.notFoundItems(0);
        } 
        return res;
    }
};

List.prototype.getItemList = function() {

    var templeteId = this.options.templete_id;
    console.log(this.options);
    var _this = this;
    console.log(this.params);
    $.post(this.options.url, this.params, function(res, status) {
        console.log(res);
        // ページング切り分け
        var data = _this.settingPagingOptions(res);
        if (!data) {
            return;
        }
        
        // リストの種類によって、テンプレートを表示
        if (templeteId == 2) {
            $.each(data, _this.showArticleList(data.length));
        } else if (templeteId == 8) {
            $.each(data, _this.showArticlePhotoList(data.length));
        } else if (templeteId == 7) {
            $.each(data, _this.showUserRatingList(data.length));
        } else if (templeteId == 6) {
            $.each(data, _this.showUserItemList(data.length));
        } else if (templeteId == 5) {
            $.each(data, _this.showUserList(data.length));
        } else if (templeteId == 4) {
            _this.showTimeline(res);
        } else if (templeteId == 3) {
            $.each(data, _this.showContainerList(data.length));
        } else if (templeteId == 1) {
            $.each(data, _this.showUserItemList(data.length));
        } else {
            $.each(data, _this.showItemList(data.length));
        }
    });
};
