/**
 * 記事詳細モーダルテンプレート
 */

var baseUrl = getDomain();
var storage_path = getStoragePath();

ModalDetail.prototype.showArticle = function (value) {

    var appendTag = '<button data-remodal-action="close" class="remodal-close"></button>';
    appendTag += '<div class="articleclip_recta"></div>';
    appendTag += '<div class="articleclip" data-remodal-target="ClipToContainer" data-article-id="' + value.article_id + '" id="container_open">';
    if (value.is_self_pick) {
     appendTag += '<img id="clip_icon_img_' + value.article_id + '" src="' + baseUrl + '/images/ico-pick-on.svg" type="image/svg+xml">';
    } else {
        appendTag += '<img id="clip_icon_img_' + value.article_id + '" src="' + baseUrl + '/images/ico-pick-off.svg" type="image/svg+xml">';
    }
    appendTag += '</div>';
    appendTag += '<div class="gear_article">';
    appendTag += '<div class="article-header">';
    appendTag += '<div class="gear_name">';
    appendTag += '<p class="brand_name">' + value.brands_name + '</p><!--//brand_name-->';
    appendTag += '<h1 class="card_name"><a href="' + baseUrl + '/master/item/' + value.items_id + '">' + value.items_name + '</a></h1><!--//card_name-->';
    appendTag += '<input type="hidden" id="items_id" value="' + value.items_id + '">';
    if (value.is_store) {
        appendTag += '<p class="sale_flag button btn_size-S">sale</p>';
    }
    appendTag += '</div><!-- /.giear_name --></div><!-- /.article-header -->';


    appendTag += '<article>';


    appendTag += '<div class="paragraph">';
    appendTag += '<div class="article_img">';
    appendTag += '<img class="" src="' + storage_path + value.img_url + '" alt="">';
    appendTag += '</div><!--//article_img-->';
    appendTag += '<p>' + value.article_text + '</p>';
    appendTag += '</div><!-- /.paragraph -->';
    appendTag += '<div class="paragraph-footer">';
    appendTag += '<div class="tagarea common_bottom">';
    appendTag += '<div class="tag_nav">';
    appendTag += '<i><img src="' + baseUrl + '/images/icon_tag.svg" type="image/svg+xml"></i>';
    appendTag += '<ul id="user_item_tag_list">';
    $.each(value.tags, function(index, v) {
        appendTag += '<li><a href="' + baseUrl + '/search/tag/' + v.tag_id + '">' + v.tag_name + '</li>';
    });
    appendTag += '</ul></div><!--//tag_nav-->';
    appendTag += '</div><!--//tagarea-->';

 appendTag += '<a href="' + baseUrl + '/user/log/' + value.user_items_id + '" class="timelinebtn">Gear Time Line<i class="fa fa-external-link" aria-hidden="true"></i></a>';

    appendTag += '<div class="clearfix"></div>';
    appendTag += '</div><!-- /.paragraph-footer -->';


 appendTag += '</article>';


    appendTag += '<footer class="article-footer">';
    appendTag += '<div class="authority_stamp common_bottom">';
    appendTag += '<div class="user_thumb">';
    appendTag += '<a data-remodal-target="modal">';
    if (value.avater_img_url) {
        appendTag += '<img src="' + value.avater_img_url + '">';
    } else {
        appendTag += '<img src="' + baseUrl + '/images/user_default.png">';
    }
    appendTag += '</a></div><!--//user_thumb-->';
    appendTag += '<p class="name">' + value.users_name + '</p>';
    appendTag += '</div><!--//authority_stamp-->';
    appendTag += '<div class="card_infomation common_bottom">';
    appendTag += '<p class="brand_name"><a>' + value.brands_name + '</a></p><!--//brand_name-->';
    appendTag += '<h1 class="card_name">';
    appendTag += '<a href="' + baseUrl + '/master/item/' + value.items_id + '">' + value.items_name + '</a>';
    appendTag += '</h1><!--//card_name-->';
    if (value.is_store) {
        appendTag += '<p class="sale_flag button btn_size-S">sale</p>';
    }
    appendTag += '<div class="card_status">';
    appendTag += '<div class="ratingarea common_bottom">';
    appendTag += '<div class="gear_rating">';
    appendTag += '<i class="rate_result">';
    if (value.evaluation_average_path) {
        appendTag += '<img id="thunder_img_icon" src="' + baseUrl + '/images/rate/thunder_5set-' + value.evaluation_average_path + '.svg" type="image/svg+xml">';
    } else {
        appendTag += '<img id="thunder_img_icon" src="' + baseUrl + '/images/rate/thunder_5set-0-0.svg" type="image/svg+xml">';
    }
    appendTag += '</i>';
    appendTag += '<p id="rate_disp_area">' + value.evaluation_num + '<span>THUNDER</span></p>';
    appendTag += '</div><!--//rating-->';
    appendTag += '</div><!--//ratingarea-->';
    appendTag += '<div class="category_nav common_bottom">';
    appendTag += '<ul>';
    appendTag += '<li><a href="' + baseUrl + '/search/select/category/' + value.category_id + '">' + value.category_name + '</a></li>';
    if (value.genre_name) {
        appendTag += '<li><a href="' + baseUrl + '/search/select/genre/' + value.genre_id + '">' + value.genre_name + '</a></li>';
    }
    if (value.genre_second_name) {
        appendTag += '<li><a href="' + baseUrl + '/search/select/genre_second/' + value.genre_second_id + '">' + value.genre_second_name + '</a></li>';
    }
    appendTag += '</ul>';
    appendTag += '</div><!--//category_nav--></div><!--//card_status--></div><!--//card_infomation-->';
    appendTag += '</footer>';



 appendTag += '</div><!--//gear_artilce-->';
    appendTag += '<div class="modalbtn_set">';
    appendTag += '<button data-remodal-action="cancel" class="button btn_size-M reset_cancell-b">閉じる</button>';
    appendTag += '</div><!--//modalbtn_set-->';
    appendTag += '</div><!-- //remodal -->';

    $(this.element).append(appendTag);
    $(this.element).enable_onload_for_images().done(function() {
        //_this.initListFlags();
    });
};
