var baseUrl = getDomain();
var storage_path = getStoragePath();

List.prototype.showTimeline = function(res) {
    console.log(res.data);
    $.each(res.data, this.showTimelineList(res.data.length));
    if (res.current_page != res.last_page) {
        $(this.element).after('<p id="loading_btn" class="button btn_size-M">MORE</p>');
    }
}

List.prototype.showTimelineList = function(length) {
    var appendTag = "";
    var _this = this;
    return function(index, value) {
        //$("#tmp_list_4").append('<img src="' + baseUrl + '/images/loading01_r1_c1.gif" id="loading_icon">');
        var loginUserId = getLoginUserId();
        var ownerUserId = getOwnerUserId();
        console.log(ownerUserId);
        appendTag += '<article id="timeline_warp_' + value.id + '">';
        appendTag += '<header>';
        appendTag += '<h2 class="title"><time>' + value.created_at + '</time></h2>';
        appendTag += '</header>';
        appendTag += '<div class="paragraph">';
        appendTag += '<div class="article_img">';
        appendTag += '<img class="no_resize" src="' + storage_path + value.img_url + '" id="timeline_img">';
        appendTag += '</div><!--//article_img-->';
        appendTag += '<p id="article_text_' + value.id + '">' + value.article_text + '</p>';
        appendTag += '</div><!-- /.paragraph -->';
        appendTag += '<div class="paragraph-footer">';
        appendTag += '<div class="tagarea common_bottom">';
        appendTag += '<div class="tag_nav">';
        appendTag += '<i><img src="' + baseUrl + '/images/icon_tag.svg" type="image/svg+xml"></i>';
        appendTag += '<ul id="user_item_tag_list">';
        if (value.article2tags.length) {
            $.each(value.article2tags, function(key, v) {
                appendTag += '<a href="' + baseUrl + '/search/tag/' + v.tags.id + '"><li>' + v.tags.tag_text + '</li></a>';
            });
        }
        appendTag += '</ul>';
        appendTag += '</div><!--//tag_nav--></div><!--//tagarea-->';
        appendTag += '<div class="clearfix"></div>';
        appendTag += '<div class="status_icon set_5p common_bottom">';
        if (loginUserId) {
            appendTag += '<div>';
            appendTag += '<a data-remodal-target="ClipToContainer" id="container_open" data-article-id="' + value.id + '">';
            if (value.is_pick) {
                appendTag += '<img id="clip_icon_img_' + value.id + '" src="' + baseUrl + '/images/ico-pick-on.svg" type="image/svg+xml">';
            } else {
                appendTag += '<img id="clip_icon_img_' + value.id + '" src="' + baseUrl + '/images/ico-pick-off.svg" type="image/svg+xml">';
            }
            appendTag += '</a>';
            appendTag += '<span class="count">' + value.count + '</span>';
            appendTag += '</div>';
        }
        appendTag += '<div>';
        appendTag += '<a data-remodal-target="SNS_Share">';
        appendTag += '<img src="' + baseUrl + '/images/ico-share-off.svg" type="image/svg+xml">';
        appendTag += '</a>';
        appendTag += '<span class="count"></span>';
        appendTag += '</div>';
        appendTag += '<div>';
        appendTag += '<a data-remodal-target="Ban">';
        appendTag += '<img src="' + baseUrl + '/images/ico-ban-off.svg" type="image/svg+xml">';
        appendTag += '</a>';
        appendTag += '</div>';
        if (loginUserId && loginUserId == ownerUserId) {
            appendTag += '<div>';
            appendTag += '<a data-remodal-target="Edit-Log" data-article-id="' + value.id + '" id="logEditBtn">';
            appendTag += '<img src="' + baseUrl + '/images/ico-more.svg" type="image/svg+xml">';
            appendTag += '</a>';
            appendTag += '</div>';
        }
        appendTag += '</div><!--//status_icon-->';
        appendTag += '</div><!-- /.paragraph-footer -->';
        appendTag += '</article>';
        if (index == (length - 1)) {
            $(_this.element).append(appendTag);
            $(_this.element).enable_onload_for_images().done(function() {
                _this.initListFlags();
            });
        }
        //$('#tmp_list_4').append(appendTag);
    }
}
