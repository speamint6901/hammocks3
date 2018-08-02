
var MultiSearchlist = function(element, option, categoryEventOptions) {
    // Listを継承
    List.call(this, element, option);
    if (categoryEventOptions.length > 0) {
        this.multiSearchSetOptions(categoryEventOptions);
    }
    this.addMultiEventListner();
};

// リストを継承
MultiSearchlist.prototype = Object.create(List.prototype, {value: {constructor: MultiSearchlist}});

// マルチサーチ用のオプションを一括セット
MultiSearchlist.prototype.multiSearchSetOptions = function(options) {
    for (o in options) {
        if (this.categoryEventOptions[o] !== undefined) {
            this.categoryEventOptions[o] = options[o];
        }
    }
};

// マルチサーチのオプション
// それぞれの検索要素を配列で指定
MultiSearchlist.prototype.categoryEventOptions = {
    event_elem : [".big_category_li","span.category_li","span.genre_li", "span.genre_second_li", ".brand_li"], // 選択要素
    event_type : ["click", "click", "click", "click", "click"], // イベントタイプ
    ids        : ["big_category_id", "category_id", "genre_id", "genre_second_id", "brands_id"], // postパラメーターキー
    box_button_elem : ["", "#category_list_button", "#category_list_button", "#category_list_button", "#brand_list_button"], //モーダル開くボタン
    box_button_label : ["", "全て", "全て", "全て", "全てのブランド"] //モーダル開くボタンラベル
};

// マルチサーチのpostパラメータをリセットする
MultiSearchlist.prototype.initMultiSearchParams = function(eo, active_id) {
    var label;
    for(e in this.categoryEventOptions.event_elem) {
        if (e > 0) {
            console.log(e);
            this.params[this.categoryEventOptions.ids[e]] = null;
            if (this.categoryEventOptions.box_button_elem[e] != "") {
               label = this.categoryEventOptions.box_button_label[e];
               $(this.categoryEventOptions.box_button_elem[e]).html(label); 
            }
        }
    }
    this.selectFirstParamDispModal(eo, active_id);
};

MultiSearchlist.prototype.selectFirstParamDispModal = function(eo, active_id) {
    $(this.categoryEventOptions.event_elem[0]).removeClass("active");
    $(eo.target).addClass("active");
    $("#category_select_list").empty();
    dispCategories(active_id);
};

// それぞれのイベントを一括登録
MultiSearchlist.prototype.addMultiEventListner = function() {
    var _this = this; 
    for(e in this.categoryEventOptions.event_elem) {
        (function (n,_this) {
            $(document).on(_this.categoryEventOptions.event_type[n], _this.categoryEventOptions.event_elem[n], function(eo) {
                if (_this.options.listLoadedFlag) {
                    _this.options.page = 1;
                    _this.options.pagingDoFlag = 0;
                    _this.options.listLoadedFlag = 0;
                    _this.disableSortAndFilterBtn();
                    _this.options.url = _this.options.initUrl;
                    // 表示領域を一旦削除
                    $(_this.element).empty();
                    // フィルターのID
                    var target = eo.target.id.split("-");
                    _this.params[_this.categoryEventOptions.ids[n]] = target[1];
                    if (n == 0) {
                        _this.initMultiSearchParams(eo, target[1]);
                        _this.getItemList();
                    } else {
                        var box_btn_element = _this.categoryEventOptions.box_button_elem[n];
                        _this.options.page = 1;
                        _this.options.url = _this.options.initUrl;
                        $(box_btn_element).html($(eo.target).html());
                        _this.getItemList();
                    }
                }
            });
        })(e, _this);
    }
}
