var baseUrl = getDomain();
var storage_path = getStoragePath();
List.prototype.showUserItemList = function(length) {
    var appendTag = '<section class="card articlecard">';
    var _this = this;
    return function(index, value) {
        /*
        var loginUserId = getLoginUserId();
        var ownerUserId = getOwnerUserId();
        */
        var appendTag = '<section class="card articlecard">';
        if (index > 0) {
            appendTag += '<section class="card articlecard">';
        }
        appendTag += '<a href="' + baseUrl + '/user/log/' + value.user_item_id + '">';
        appendTag += '<div class="pic squarebox">';
        appendTag += '<img class="img_resize" src="' + storage_path + value.img_url + '">';
        appendTag += '</div><!--//pic--></a>';
        appendTag += '<div class="card_infomation">';
        appendTag += '<p class="brand_name">' + value.brand_name + '</p><!--//brand_name-->';
        appendTag += '<h1 class="card_name">' + value.item_name + '</h1><!--//card_name-->';
        appendTag += '<div class="authority_stamp">';
        appendTag += '<div class="user_thumb">';
        appendTag += '<a data-remodal-target="modal">';
        if (value.avater_img_url) {
            appendTag += '<img src="' + avater_img_url + '">';
        } else {
            appendTag += '<img src="' + baseUrl + '/images/user_default.png">';
        }
        appendTag += '</a></div><!--//user_thumb-->';
        appendTag += '<p class="name">' + value.user_name + '</p>';
        appendTag += '</div><!--//authority_stamp-->';
        appendTag += '</div><!--//infomation--></section><!--//card--></div><!--//card_flex-->';

        if (index == (length - 1)) {
            $(_this.element).append(appendTag);
            $(_this.element).enable_onload_for_images().done(function() {
                _this.initListFlags();
            });
        }
    }
};
