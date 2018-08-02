var baseUrl = getDomain();
var storage_path = getStoragePath();

$(document).ready(function () {

    checkRequire()

    // プルダウン変更時のイベント
    $("#delivery_pattern").change(function() {
        checkRequire();
    });
    $("#delivery_company").change(function() {
        checkRequire();
    });
    $("#prefecture").change(function() {
        checkRequire();
    });
    $("#delivery_day_nums").change(function() {
        checkRequire();
    });

    $("#regist-ok").click(goToStep3);
});

// 次のステップへ
function goToStep3(eo) {
    if (checkRequire()) {
        $("#sale_register_step2").attr("method", "post");
        $("#sale_register_step2").attr("action", baseUrl + consUrlJs.itemSaleGotoStep3Path);
        $("#sale_register_step2").submit();
    } else {
        return;
    }
}

// 入力チェック
function checkRequire() {
    console.log("check!");
    if ($('#delivery_pattern').val() && $('#delivery_company').val() && 
        $("#prefecture").val() && $('#delivery_day_nums').val()) {
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
