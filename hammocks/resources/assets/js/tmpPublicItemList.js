var baseUrl = getDomain();
var storage_path = getStoragePath();
List.prototype.showItemList = function (length) {
    var appendTag = '<section class="card publicitemcard">';
    var _this = this;
    return function(index, value) {
        var haveClassName = "disable";
        var wantClassName = "disable";
        console.log(value.have_want_status);
        if (value.have_want_status == 2) {
            wantClassName = "active";
        } else if (value.have_want_status) {
            haveClassName = "active";
        }
        if (index > 0) {
            appendTag += '<section class="card publicitemcard">';
        }
        appendTag += '<a href="' + baseUrl + '/master/item/' + value.id + '">';
        appendTag += '<div class="pic squarebox">';
        appendTag += '<img class="img_resize" id="item_pict_' + value.id + '" src="' + storage_path + value.public_img + '">';
        if (value.price) {
            appendTag += '<div class="triangle"></div>';
            appendTag += '<p class="price"><span>' + value.price + '</span></p>';
        }
        appendTag += '</div><!--//pic--></a><!-- /.pubitempic -->';
        appendTag += '<div class="card_infomation">';
        appendTag += '<p class="brand_name">' + value.brand_name + '</p><!--//brand_name-->';
        appendTag += '<h1 class="card_name">' + value.name + '</h1><!--//card_name-->';
        appendTag += '<div class="card_status">';
        appendTag += '<div class="status_icon">';
        console.log(haveClassName);
        if (haveClassName == "active") {
            appendTag += '<div class="' + haveClassName + '"><img src="' + baseUrl + '/images/ico-have-on.svg" class="icon-button" id="have_1_' + value.id + '"><span class="count">' + value.have_count + '</span></div>';
        } else {
            appendTag += '<div class="' + haveClassName + '"><img src="' + baseUrl + '/images/ico-have-off.svg" class="icon-button" id="have_1_' + value.id + '"><span class="count">' + value.have_count + '</span></div>';
        }
        if (wantClassName == "active") {
            appendTag += '<div class="' + wantClassName + '"><img src="' + baseUrl + '/images/ico-want-on.svg" class="icon-button" id="want_2_' + value.id + '"><span class="count">' + value.want_count + '</span></div>';
        } else {
            appendTag += '<div class="' + wantClassName + '"><img src="' + baseUrl + '/images/ico-want-off.svg" class="icon-button" id="want_2_' + value.id + '"><span class="count">' + value.want_count + '</span></div>';
        }
        appendTag += '<div><img src="' + baseUrl + '/images/ico-sale.svg" type="image/svg+xml"><span class="count">' + value.sale_count + '</span></div>';
        appendTag += '</div><!--//status_icon--></div><!--//card_status--></div><!--//infomation--></section><!--//card-->';

        if (index == (length - 1)) {
            $(_this.element).append(appendTag);
            $(_this.element).enable_onload_for_images().done(function() {
                _this.initListFlags();
            });
        }
    }
};
