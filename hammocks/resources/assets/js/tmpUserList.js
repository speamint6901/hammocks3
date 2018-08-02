/**
 * ユーザーリストテンプレート
 */

var baseUrl = getDomain();
var storage_path = getStoragePath();

List.prototype.showUserList = function (length) {
    var appendTag = '<div class="listbox list-user">';
    var _this = this;
    return function(index, value) {

        if (index > 0) {
            appendTag += '<div class="listbox list-user">';
        }
        appendTag += '<div class="left_area">';
        appendTag += '<div class="user_thumb">';
        appendTag += '<a href="' + baseUrl + '/user/garage/' + value.users_id + '">';
        if (value.avater_img_url) {
            appendTag += '<img class="img_resize" src="' + value.avater_img_url + '">';
        } else {
            appendTag += '<img class="img_resize" src="' + baseUrl + '/images/user_default.png">';
        }
        appendTag += '</a></div><!--//user_thumb--></div><!--/.left_area-->';
        appendTag += '<div class="right_area">';
        appendTag += '<p class="name">' + value.name + '</p>';
        appendTag += '</div><!--/.right_area--></div><!-- /.listbox -->';

        if (index == (length - 1)) {
            $(_this.element).append(appendTag);
            $(_this.element).enable_onload_for_images().done(function() {
                _this.initListFlags();
            });
        }
    }
}
