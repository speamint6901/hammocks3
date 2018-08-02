
var MultiList = function(element, option, categoryEventOptions) {
    // Listを継承
    List.call(this, element, option);
    //if (categoryEventOptions.length > 0) {
    this.multiListSetOptions(categoryEventOptions);
    //}
    if (categoryEventOptions.event_type[0] == "change") {
        this.addMultiListSelectEventListner();
    } else {
        this.addMultiListEventListner();
    }
};

// リストを継承
MultiList.prototype = Object.create(List.prototype, {value: {constructor: MultiList}});

// マルチサーチ用のオプションを一括セット
MultiList.prototype.multiListSetOptions = function(options) {
    for (o in options) {
        if (this.categoryEventOptions[o] !== undefined) {
            this.categoryEventOptions[o] = options[o];
        }
    }
    console.log(this.categoryEventOptions);
};

// マルチサーチのオプション
// それぞれの検索要素を配列で指定
MultiList.prototype.categoryEventOptions = {
    event_elem : [], // 選択要素
    event_type : [], // イベントタイプ
    url_list : [],  // apiパスリスト
    templete_ids : [], // templeteIDリスト
    param1_keys : [], // その他パラメータ
    param1_values : [], // その他パラメータ
    sort_categorise : ["master_item", "sale_item", "article"]
};

MultiList.prototype.sortSelectBox = {
    0 : ["登録順", "want多い順", "have多い順", "記事数多い順", "評価高い順", "評価低い順"],
    1 : ["登録順", "値段が安い順", "値段が高い順"],
    2 : ["登録順", "pickが多い順"]
};

// タブ切り替え用
MultiList.prototype.setMultiListOptionAndParameters = function(n) {
    // urlセット
    if (this.categoryEventOptions.url_list[n] !== undefined) {
        this.options.url = this.categoryEventOptions.url_list[n];
    }

    // テンプレートをセット
    if (this.categoryEventOptions.templete_ids[n] !== undefined) {
        this.options.templete_id = this.categoryEventOptions.templete_ids[n];
    }

    // その他条件をパラメータにセットする
    var k = this.categoryEventOptions.param1_keys;
    console.log(this.categoryEventOptions.param1_values[n]);
    this.params[k] = this.categoryEventOptions.param1_values[n];

    $("div ul li").removeClass("active");
    console.log($(this.categoryEventOptions.event_elem[n]).parent());
    $(this.categoryEventOptions.event_elem[n]).parent().addClass("active");
};

// セレクトボックス用
MultiList.prototype.setMultiListSelectEventOptionAndParameters = function(n) {
    // urlセット
    if (this.categoryEventOptions.url_list[n] !== undefined) {
        this.options.url = this.categoryEventOptions.url_list[n];
    }

    // テンプレートをセット
    if (this.categoryEventOptions.templete_ids[n] !== undefined) {
        this.options.templete_id = this.categoryEventOptions.templete_ids[n];
    }

    // その他条件をパラメータにセットする
    if (this.categoryEventOptions.param1_keys[n]) {
        var k = this.categoryEventOptions.param1_keys[n];
        this.params[k] = this.categoryEventOptions.param1_values[n];
    }

    // 全文検索時にフィルター番号をサーチバーのhiddenにセットする
    $("#filter_id").val(n);

    // ソートの値をリセット
    this.params.sort = null;

    $("#sort").empty();
    this.options.sortCategory = this.categoryEventOptions.sort_categorise[n];
    var currentSelectBox = this.sortSelectBox[n];
    var tag = "";
    for (s in currentSelectBox) {
        value = parseInt(s) + 1;
        tag += '<option value="' + value + '">' +  currentSelectBox[s] + '</option>';
    }
    this.options.initUrl = this.categoryEventOptions.url_list[n];
    $("#sort").append(tag);
};

// タブ切り替え等のクリック系のイベントリスナー
MultiList.prototype.addMultiListEventListner = function() {
    var _this = this; 
    for(e in this.categoryEventOptions.event_elem) {
        (function (n,_this) {
            $(document).on(_this.categoryEventOptions.event_type[n], _this.categoryEventOptions.event_elem[n], function(eo) {
                if (_this.options.listLoadedFlag) {
                    _this.initEventOption(eo);
                    _this.options.pagingDoFlag = 0;
                    _this.setMultiListOptionAndParameters(n);
                    _this.getItemList();
                }
            });
        })(e, _this);
    }
};

// セレクトボックス用イベントリスナー
MultiList.prototype.addMultiListSelectEventListner = function() {
    var _this = this;
    (function (_this) {
        $(document).on(_this.categoryEventOptions.event_type[0], _this.categoryEventOptions.event_elem[0], function(eo) {
            if (_this.options.listLoadedFlag) {
                _this.initEventOption(eo);
                _this.options.pagingDoFlag = 0;
                // 表示領域を一旦削除
                // フィルターのID
                // それぞれのオプション及びパラメータの付与
                var targetValue = $(eo.target).val();
                _this.setMultiListSelectEventOptionAndParameters(targetValue);
                _this.disableSortAndFilterBtn();
                _this.getItemList();
            }
        });
    })(_this);
};

// 表示がdoneしたら(オーバーライド)
MultiList.prototype.initListFlags = function() {
    this.options.listLoadedFlag = 1;
    this.options.pagingDoFlag = 1;
    $(this.categoryEventOptions.event_elem[0]).removeAttr("disabled");
    $(this.options.sortElement).removeAttr("disabled");
};

// イベント発火時にフィルターとそーとを押せなくする(オーバーライド)
MultiList.prototype.disableSortAndFilterBtn = function() {
    $(this.options.sortElement).attr("disabled", "disabled");
    $(this.categoryEventOptions.event_elem[0]).attr("disabled", "disabled");
};

