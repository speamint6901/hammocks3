var urlItemList = "";
var defer = $.Deferred();
var searchResultUrl = getDomain() + consUrlJs.serarchResultPath;

var imageLoadSomething = function(offset) {
    var params = { "offset" : offset };
    $.post(searchResultUrl, params, userItemListFunc);
    return defer.promise();
}

// ページ読み込み時のアイテムリスト取得
$(document).ready(function () {
    var promise = imageLoadSomething(0);
    promise.done(function() {
        setImageFit();
    });
});

// ページング時のアイテムリスト取得
function getItemListFunc(offset) {
    var promise2 = imageLoadSomething(offset);
    promise2.done(function() {
        setImageFit();
    });
}


function userItemListFunc(data, httpStatus) {
    console.log(data);
    if (data.user_items.length == 0) {
        $("#offset").val("max");
        return;
    }
    $("#offset").val(data.offset);
    $.each(data.user_items, showItemList)
    //setTimeout(function() {
    defer.resolve();
    //}, 1000);
    /*
    if (data.user_items.length == 0) {
        $("#offset").val("max");
        return;
    }
    $("#offset").val(data.offset);
    $.each(data.user_items, showItemList)
    */
}
