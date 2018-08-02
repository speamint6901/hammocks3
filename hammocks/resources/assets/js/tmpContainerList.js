/**
 * コンテナテンプレート
 */

var baseUrl = getDomain();
var storage_path = getStoragePath();

List.prototype.showContainerList = function (length) {
    var appendTag = "";
    var _this = this;
    return function(index, value) {
        appendTag += '<section class="card containercard" data-target-container="' + value.id + '">';
        if (_this.options.is_selfuser) {
            if (value.status == 1) {
                appendTag += '<a class="triangle unlock" data-target-container="' + value.id + '"><span></span></a>';
            } else {
                appendTag += '<a class="triangle lock" data-target-container="' + value.id + '"><span></span></a>';
            }
            appendTag += '<div class="del_btn container_del" data-target-container="' + value.id + '"></div>';
        }
        if (_this.options.container_list_type == 0) {
            appendTag += '<a href="' + baseUrl + '/user/garage/pick/container/' + value.users_id + '/' + value.id + '">';
        } else {
            appendTag += '<span class="addPick" data-target-container="' + value.id + '">';
        }
        appendTag += '<ul class="container_thumb">';
        if (value.items[0] !== undefined) {
            appendTag += '<li class="pic squarebox"><img  class="img_resize" src="' + storage_path + value.items[0].article.img_url + '"></li>';
        } else {
            appendTag += '<li class="pic squarebox"><img src="' + baseUrl + '/images/container_default.svg"></li>';
        }
        if (value.items[1] !== undefined) {
            appendTag += '<li class="pic squarebox"><img  class="img_resize" src="' + storage_path + value.items[1].article.img_url + '"></li>';
        } else {
            appendTag += '<li class="pic squarebox"><img src="' + baseUrl + '/images/container_default.svg"></li>';
        }
        if (value.items[2] !== undefined) {
            appendTag += '<li class="pic squarebox"><img  class="img_resize" src="' + storage_path + value.items[2].article.img_url + '"></li>';
        } else {
            appendTag += '<li class="pic squarebox"><img src="' + baseUrl + '/images/container_default.svg"></li>';
        }
        if (value.items[3] !== undefined) {
            appendTag += '<li class="pic squarebox"><img  class="img_resize" src="' + storage_path + value.items[3].article.img_url + '"></li>';
        } else {
            appendTag += '<li class="pic squarebox"><img src="' + baseUrl + '/images/container_default.svg"></li>';
        }
        appendTag += '</ul>';
        if (_this.options.container_list_type == 0) {
            appendTag += '</a>';
        } else {
            appendTag += '</span>';
        }
        appendTag += '<p class="container_name">' + value.name + '</p><!--//brand_name-->';
        appendTag += '</section><!--//.containercard-->';
        if (index == (length - 1)) {
            $(_this.element).append(appendTag);
            $(_this.element).enable_onload_for_images().done(function() {
                _this.initListFlags();
            });
        }

    }
}
