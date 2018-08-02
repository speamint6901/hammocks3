var urlItemList = "";
var storage_path = getStoragePath();
var baseUrl = getDomain();
var urlItemList = baseUrl + consUrlJs.itemListPath;
var defer = $.Deferred();


var imageLoadSomething = function(offset) {
    var params = { "offset" : offset };
    if ($("#item_status").val()) {
        params["item_status"] = $("#item_status").val();
    }
    if ($("#owner_users_id").val()) {
        params["owner_users_id"] = $("#owner_users_id").val();
    }
    $.post(urlItemList, params, userItemListFunc);
    return defer.promise();
}

// ページ読み込み時のアイテムリスト取得
$(document).ready(function () {
    var promise = imageLoadSomething(0);
    promise.done(function() {
        // 何か処理が必要なら足す
    });
});

// ページング時のアイテムリスト取得
function getItemListFunc(offset) {
    var promise2 = imageLoadSomething(offset);
    promise2.done(function() {
        // 何か処理が必要なら足す
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
    defer.resolve();
}

function showItemList(index, value) {

    var haveClassName = "disable";
    var wantClassName = "disable";
    if (value.have_want_status == 2) {
        wantClassName = "active";
    } else if (value.have_want_status) {
        haveClassName = "active";
    }
    var appendTag = '<section class="card">';
    appendTag += '<div class="pic squarebox"><img id="item_pict_' + value.id + '" class="img_resize" src=""></div><!--//pic-->';
    appendTag += ' <div class="card_infomation"><p class="brand_name">' + value.brand_name + '</p><!--//brand_name--><h1 class="item_name">' + value.name + '</h1><!--//card_name-->';
    appendTag += '<div class="status_icon">';
    appendTag += '<div class="' + haveClassName + '"><img src="' + baseUrl + '/images/ico-have-off.svg" class="icon-button" id="have_1_' + value.id + '"><span class="count">' + value.have_count + '</span></div>';

    appendTag += '<div class="' + wantClassName + '"><img src="' + baseUrl + '/images/ico-want-off.svg" class="icon-button" id="want_2_' + value.id + '"><span class="count">' + value.want_count + '</span></div>';

    appendTag += '<div><img src="' + baseUrl + '/images/ico-pick-off.svg" class="icon-button-fav" id="fav_' + value.id + '"><span class="count">' + value.article_count + '</span></div>';
    if (value.price) {
        appendTag += '<div>￥' + value.price + '</div>';
    }
    appendTag += '</div><!--//status_icon-->';
    appendTag += '</div><!--//card_infomation--></section><!--//card-->';
    $('.card_flex').append(appendTag);
    $('#item_pict_' + value.id).resizeOne();
    $('#item_pict_' + value.id).attr("src", storage_path + value.public_img);
}
