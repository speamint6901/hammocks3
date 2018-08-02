var urlItemList = "";
var storage_path = getStoragePath();
var baseUrl = getDomain();
var urlUserList = baseUrl + consUrlJs.followFollewerListPath;
var defer = $.Deferred();

var imageLoadSomething = function(offset) {
    var params = { "offset" : offset };
    if ($("#follow_type").val()) {
        params["follow_type"] = $("#follow_type").val();
    }
    if ($("#owner_users_id").val()) {
        params["owner_users_id"] = $("#owner_users_id").val();
    }
    $.post(urlUserList, params, userItemListFunc);
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
        //setImageFit();
        return;
    });
}

function userItemListFunc(data, httpStatus) {
    console.log(data);
    if (data.items.length == 0) {
        $("#offset").val("max");
        return;
    }
    $("#offset").val(data.offset);
    $.each(data.items, showUserList)
    defer.resolve();
}

function showUserList(index, value) {
    var appendTag = '<section class="usercard">';
    appendTag += '<div class="user_thumb">';
    if (value.avater_img_url == "") {
        appendTag += '<a data-remodal-target="modal"><img src="' + baseUrl + '/images/user_default.png"></a>';
    } else {
        appendTag += '<a data-remodal-target="modal"><img src="' + storage_path + value.avater_img_url + '"></a>';
    }
    appendTag += '</div><!--//user_thumb-->';
    appendTag += '<div class="card_infomation">';
    appendTag += '<p class="name">' + value.name + '</p>';
    appendTag += '<div class="card_status">';
    appendTag += '<div class="status_icon">';
    appendTag += '<div><img src="' + baseUrl + '/images/ico-have-off.svg" type="image/svg+xml"><span class="count">' + value.have_count + '</span></div>';
    appendTag += '<div><img src="' + baseUrl + '/images/ico-want-off.svg" type="image/svg+xml"><span class="count">' + value.want_count + '</span></div>';
    appendTag += '<div><img src="' + baseUrl + '/images/ico-pick-off.svg" type="image/svg+xml"><span class="count">' + value.clip_count + '</span></div>';
    appendTag += '<div><img src="' + baseUrl + '/images/ico-sale-off.svg" type="image/svg+xml"><span class="count">' + value.sale_count + '</span></div>';
    appendTag += '</div><!--//status_icon-->';
    appendTag += '</div><!--//card_status-->';
    appendTag += '</div><!--//infomation-->';
    appendTag += '<div class="followbtn"><img src="' + baseUrl + '/images/ico-feed-off.svg" type="image/svg+xml"></div><!-- /.followbtn -->';
    appendTag += '</section><!--//card-->';
    $('.follow_user_area').append(appendTag);
}

