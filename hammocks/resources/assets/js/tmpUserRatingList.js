/**
 * アイテムレーティングユーザーリストテンプレート
 */

var baseUrl = getDomain();
var storage_path = getStoragePath();

List.prototype.showUserRatingList = function (length) {
    var appendTag = "";
    var _this = this;
    return function(index, value) {
        appendTag += '<div class="listbox list-gear_rating">';
        appendTag += '<a class="left_area" href="' + baseUrl + '/user/garage/' + value.user_id + '">';
        appendTag += '<div class="user_thumb">';
        if (value.avater_img_url) {
            appendTag += '<img class="img_resize" src="' + value.avater_img_url + '">';
        } else {
            appendTag += '<img class="img_resize" src="' + baseUrl + '/images/user_default.png">';
        }
     appendTag += '</div><!--//user_thumb-->';
        appendTag += '<p class="name">' + value.user_name + '</p>';
        appendTag += '</a><!--//left_area-->';
        appendTag += '<div class="right_area">';
        appendTag += '<div class="gear_rating">';
        appendTag += '<i class="rate_result">';
        appendTag += '<img id="thunder_img_icon" src="' + baseUrl + '/images/rate/thunder_5set-' + value.evaluation_num + '.svg" type="image/svg+xml">';
        appendTag += '</i>';
        appendTag += '<p id="rate_disp_area">' + value.evaluation_num + '<span>THUNDER</span></p>';
        appendTag += '</div><!--//rating-->';
        appendTag += '</div><!--/.right_area-->';
        appendTag += '</div><!-- /.listbox -->';

        if (index == (length - 1)) {
            console.log(appendTag);
            $(_this.element).append(appendTag);
            $(_this.element).enable_onload_for_images().done(function() {
                _this.initListFlags();
            });
        }
    }
}
