/**
 * 記事テンプレート
 */

var baseUrl = getDomain();
var storage_path = getStoragePath();

List.prototype.showArticlePhotoList = function (length) {
    var appendTag = '<section class="card articlecard">';
    var _this = this;
    return function(index, value) {
        
        if (index > 0) {
            appendTag += '<section class="card articlecard">';
        }
        if (isSelfUser()) {
            appendTag += '<div class="del_btn" data-article_id="' + value.id + '"></div>';
        }
        appendTag += '<a data-remodal-target="ArticlePreview" class="articleModalBtn" >';
        appendTag += '<div class="pic squarebox">';
        appendTag += '<img class="img_resize" data-article-id="' + value.id + '" src="' + storage_path + value.img_url + '">';
        appendTag += '</div><!--//pic--></a>';
        appendTag += '<div class="card_infomation">';
        appendTag += '<div class="authority_stamp">';
        appendTag += '<div class="user_thumb">';
        appendTag += '<a data-remodal-target="modal">';
        if (value.avater_img_url) {
            appendTag += '<img class="img_resize" src="' + value.avater_img_url + '">';
        } else {
            appendTag += '<img class="img_resize" src="' + baseUrl + '/images/user_default.png">';
        }
        appendTag += '</a></div><!--//user_thumb-->';
        appendTag += '<p class="name">' + value.user_name + '</p>';
        appendTag += '</div><!--//authority_stamp--></div><!--//infomation--></section>';

        if (index == (length - 1)) {
            $(_this.element).append(appendTag);
            $(_this.element).enable_onload_for_images().done(function() {
                _this.initListFlags();
            });
        }
    }
};
