var ModalDetail = function(element, option) {
    this.element = element;
    this.setOptionAndParams(option);
    this.addModalOpenEventListner();
    console.log("dfdfadaf");
};

ModalDetail.prototype.setOptionAndParams = function(option) {
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

// オプションデフォルトセット
ModalDetail.prototype.options = {
    url : null,
    method : "post",
    templete_id : null, // リストで使用するtemplete_id
    eventElement : ".articleModalBtn",
    eventType : "click",
    dataParamKey : "article_id",
    dataElement : "data-article-id"
};

// postパラメーター
ModalDetail.prototype.params = {
    article_id : null
};

ModalDetail.prototype.addModalOpenEventListner = function() {
    var _this = this;
    $(document).on(this.options.eventType, this.options.eventElement, function(eo) {
        console.log(eo.target);
        $(_this.element).empty();
        _this.params[_this.options.dataParamKey] = $(eo.target).attr(_this.options.dataElement);
        _this.getItem();
    });
};

ModalDetail.prototype.getItem = function() {
 
    console.log(this.params);
    console.log(this.options);
    var _this = this;
    $.post(this.options.url, this.params, function(data, status) {
        console.log(data);
        if (_this.options.templete_id == 0) {
            _this.showArticle(data);
        }
    });
};
