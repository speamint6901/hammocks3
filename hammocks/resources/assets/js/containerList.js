var urlItemList = "";
var storage_path = getStoragePath();
var baseUrl = getDomain();
var urlContainerList = baseUrl + consUrlJs.containerListPath;
var loadFlag = 1;
var defer = $.Deferred();
var users_id = getUsersId();


var imageLoadSomething = function(offset) {
    var params = { "offset" : offset, "users_id" : users_id };
    $.post(urlContainerList, params, userItemListFunc);
    return defer.promise();
}

function setImageFit() {
    $('.squarebox').imagefit({
      mode: 'outside',
      force : 'true',
      halign : 'center',
      valign : 'middle',
      onStart: function (index, container, imagecontainer) {},
      onLoad: function (index, container, imagecontainer) {},
      onError: function (index, container, imagecontainer) {},
    });
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
    if (data.container_list.length == 0) {
        $("#offset").val("max");
        return;
    }
    $("#offset").val(data.offset);
    $.each(data.container_list, showItemList)
    defer.resolve();
}

function showItemList(index, value) {

    var appendTag = '<section class="container_list">';
    appendTag += '<ul class="container_thumb">';
    $.each(value.items, function(key, v) {
        appendTag += '<li class="pic squarebox"><img src="' + storage_path + v.user_items.img_url + '"></li>';
    });
    appendTag += '</ul>';
    appendTag += '<p class="container_name">' + value.name + '</p><!--//brand_name-->';
    appendTag += '</section><!--//card-->';

    $('.card_flex').append(appendTag);
}
