var storage_path = getStoragePath();
var baseUrl = getDomain();
function showItemList(index, value) {

    var haveClassName = "disable";
    var wantClassName = "disable";
    if (value.status == 2) {
        wantClassName = "active";
    } else if (value.status) {
        haveClassName = "active";
    }
    var appendTag = '<section class="card">';
 appendTag += '<div class="pic squarebox"><img class="img_resize" src="' + storage_path + value.public_img + '"></div><!--//pic-->';
    appendTag += ' <div class="card_infomation"><p class="brand_name">' + value.brand_name + '</p><!--//brand_name--><h1 class="item_name">' + value.item_name + '</h1><!--//card_name-->';
    appendTag += '<div class="status_icon">';
    appendTag += '<div class="' + haveClassName + '"><img src="' + baseUrl + '/images/ico-have-off.svg" class="icon-button" id="have_1_' + value.user_item_id + '"><span class="count">' + value.have_count + '</span></div>';

    appendTag += '<div class="' + wantClassName + '"><img src="' + baseUrl + '/images/ico-want-off.svg" class="icon-button" id="want_2_' + value.user_item_id + '"><span class="count">' + value.want_count + '</span></div>';

    appendTag += '<div><img src="' + baseUrl + '/images/ico-pick-off.svg" class="icon-button-fav" id="fav_' + value.user_item_id + '"><span class="count">' + value.clip_count + '</span></div>';
    appendTag += '</div><!--//status_icon-->';
    appendTag += '</div><!--//card_infomation--></section><!--//card-->';
    $('.card_flex').append(appendTag);
}
