var baseUrl = getDomain();
var typingFlag = 1;

$(document).ready(function () {

    // 問題報告
    $(document).on("click", "#sendBanReport", function(eo) {
        var banReportUrl = baseUrl + consUrlJs.banReportSendPath;
        var params = {};
        params["type"] = $(".radiobtn:checked").val();
        params["text"] = $("#banReportText").val();
        if (params["text"].length > 2000) {
            alert("2000文字以内で入力してください");
            return;
        }
        params["user_items_id"] = getUserItemId();
        params["article_id"] = $("#container_open").attr("data-article-id");
        $.post(banReportUrl, params, function(data, status) {
            alert(data.message);
            // フォーム初期化
            $("#banReportText").val("");
        });
    });

    $(document).on("click", ".radiobtn", function(eo) {
        checkBanReportValid();
    });

    $("#banReportText").keydown(descriptionKeyDownAndPasteFunc);
    $(document).on("paste", "#banReportText", descriptionKeyDownAndPasteFunc);

});

// 文のタイピング時とペースト時の処理
function descriptionKeyDownAndPasteFunc(eo) {
    if (typingFlag) {
        typingFlag = 0;
        // 少し遅らせる
        setTimeout(function() {
            //　検索文字列の取得
            var word = $(eo.target).val();
            typingFlag = 1;
            if (word.length > 2000) {
                alert("2000文字以内で入力してください");
            }
            // ２文字以上ならバリデーションしない
            if (word.length > 1) {
                return;
            }
            checkBanReportValid();
        }, 100);

    }
}

function checkBanReportValid() {
    console.log("check");
    if ($('.radiobtn:checked').val() !== undefined && $('#banReportText').val()) {
        console.log("active");
        if ($('#sendBanReport').hasClass('disable-b')) {
            $('#sendBanReport').removeClass("disable-b");
        }
        return true;
    } else if (!$('#sendBanReport').hasClass('disable-b')) {
        $('#sendBanReport').addClass("disable-b");
    }
}
