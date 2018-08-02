var urlItemList = "";
var baseUrl = getDomain();

$(document).ready(function () {
    urlItemList = baseUrl + consUrlJs.itemCommentListPath;
    var items_id = getItemsId();
    var params = {"items_id" : items_id};
    $.post(urlItemList, params, userItemListFunc);
});

function userItemListFunc(data, httpStatus) {
    $.each(data, showItemList)
    console.log(data);
}

function showItemList(index, value) {

    var appendTag = '<div class="user_comment">';
    appendTag += '<div class="upperinfo">';
    appendTag += '<div class="user_thumb">';
    appendTag += '<a data-remodal-target="modal">';
    appendTag += '<img src="' + value.avater_img + '"></a>';
    appendTag += '</div><!--//user_thumb-->';
    appendTag += '<div class="comment">' + value.description + '</div><!--//comment--></div><!--//upperinfo-->';
    appendTag += '<div class="footerinfo"><p class="putcontainer">put <a href="#">container</a>' +  value.created_at + '</p>';
 appendTag += '<div class="gear_rating">';
    for(i = 0; i<5; i++) {
        if (value.evaluation_num > i) {
            appendTag += '<i class="rate_on"><img src="' + baseUrl + '/images/rate_thunder-on.svg" type="image/svg+xml"></i>';
        } else {
            appendTag += '<i class="rate_off"><img src="' + baseUrl + '/images/rate_thunder-off.svg" type="image/svg+xml"></i>';
        }
    }
    appendTag += '<p>' + value.evaluation_num + '<span>THUNDER</span></p>';
    appendTag += '</div></div><!--//footerinfo--></div>';
    $('.public_comment').append(appendTag);
}
