var baseUrl = getDomain();
var itemTypingFlag = 1;
var itemRatingUrl = baseUrl + consUrlJs.itemRatingPath;

$(document).ready(function () {

    // rate更新
    $(document).on('click', '#rate_execute_btn', function(eo) {
        var rate = $('#UserItemRating input:checked').val();
        var items_id = $('#items_id').val();
        if (rate) {
            var postData = { "rate" : rate , "items_id" : items_id };
            $.post(itemRatingUrl, postData, resultExecuteRateFunc);
        }
    });

});

// rate更新
function resultExecuteRateFunc(data, status) {
    console.log(data);
    if (Object.keys(data).length > 0) {
        $("#thunder_img_icon").attr("src", baseUrl + "/images/rate/thunder_5set-" + data.average_path_name + ".svg");
        var dispText = data.average + "<span>THUNDER</span>";
        $("#rate_disp_area").html(dispText);
    }
}
