var storage_path = getStoragePath();
var baseUrl = getDomain();

function showPublicItemList(index, value) {
    var html = '<section class="result_card">';

    html += '<a href="' + baseUrl + '/public/item/' + value.id + '">';
 html += '<div class="pic squarebox">';
 html += '<img class="img_resize" src="' + storage_path + value.img_url + '"/>';
 html += '</div></a><!--//pic-->';
    html += '<div class="card_infomation">';
    html += '<p class="brand_name">' + value.brand_name + '</p><!--//brand_name-->';
    html += '<h1 class="item_name">' + value.name + '</h1><!--//card_name-->';
    html += '</div><!--//infomation--></section><!--//result_card-->';
    $('.result_area').append(html);
}
