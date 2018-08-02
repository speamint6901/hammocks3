/**
 * セールアイテムテンプレート
 */

var baseUrl = getDomain();
var storage_path = getStoragePath();

List.prototype.showUserItemList = function (length) {
    var appendTag = '<section class="card salecard">';
    var _this = this;
    return function(index, value) {
        if (index > 0) {
            appendTag += '<section class="card salecard">';
        }
        appendTag += '<div class="user_thumb">';
        if (value.avater_img_url) {
            appendTag += '<img src="' + value.avater_img_url + '">';
        } else {
            appendTag += '<img src="' + baseUrl + '/images/user_default.png">';
        }
        appendTag += '</div><!--//user_thumb-->';
        appendTag += '<a href="' + baseUrl + '/user/item/sale/' + value.user_item_id + '">';
        appendTag += '<div class="pic squarebox">';
        appendTag += '<img class="img_resize" src="' + storage_path + value.img_url + '">';
        appendTag += '</div><!--//pic--></a>';
        appendTag += '<div class="card_infomation">';
        appendTag += '<p class="brand_name">' + value.brand_name + '</p><!--//brand_name-->';
        appendTag += '<h1 class="card_name">' + value.item_name + '</h1><!--//card_name-->';
        appendTag += '<div class="card_status">';
        appendTag += '<p class="price"><span>' + value.price + '</span></p>';
        appendTag += '</div><!--//card_status--></div><!--//infomation--></section><!--//card-->';

        if (index == (length - 1)) {
            $(_this.element).append(appendTag);
            $(_this.element).enable_onload_for_images().done(function() {
                _this.initListFlags();
            });
        }
    }
}
