var baseUrl = getDomain();
var storage_path = getStoragePath();
itemTypingFlag = 1;

$(document).ready(function () {

    checkRequire()

    // 値段のイベント２種（タイピング、ペースト）
    $("#price").keydown(descriptionKeyDownAndPasteFunc);
    $(document).on("paste", "#price", descriptionKeyDownAndPasteFunc);

    $("#regist-ok").click(goToStep4);

});

// 次のステップへ
function goToStep4(eo) {
    if (checkRequire()) {
        $("#sale_register_step3").attr("method", "post");
        $("#sale_register_step3").attr("action", baseUrl + consUrlJs.itemSaleGotoStep4Path);
        $("#sale_register_step3").submit();
    } else {
        return;
    }
}

// 値段のタイピング時とペースト時の処理
function descriptionKeyDownAndPasteFunc(eo) {
    if (itemTypingFlag) {
        itemTypingFlag = 0;
        // 少し遅らせる
        setTimeout(function() {
            //　検索文字列の取得
            var word = $(eo.target).val();
            // 2文字以上で検索
            if ( ! word.match(/^\d+$/)) {
                $("#price_error_msg").html("半角数字で入力して下さい");
            } else {
                $("#price_error_msg").html("");
            }
            itemTypingFlag = 1;
            checkRequire();
        }, 100);

    }
}

// 入力チェック
function checkRequire() {
    console.log("check!");
    var value = $('#price').val();
    if (value && value.match(/^\d+$/)) {
        console.log('active!!');
        if ($('#regist-ok').hasClass('disable-b')) {
            $('#regist-ok').removeClass("disable-b");
        }
        return true;
    } else if (!$('#regist-ok').hasClass('disable-b')) {
        $('#regist-ok').addClass("disable-b");
    }
    return false;
}
