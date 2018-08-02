var baseUrl = getDomain();
var storage_path = getStoragePath();
var brandListUrl = "";
var itemTypingFlag = 1;

$(document).ready(function () {

    // 画像アップローダーのインスタンス取得
    var dropzone = myAwesomeDropzone("#my-awesome-dropzone", "#my-preview-dropzone", "sale_item", 4);
    // ファイル追加時の入力チェック
    dropzone.on("addedfile", function(file, message) {
        console.log(this.files.length);
        checkRequire();
    });
    // 画像をアップした状態では画像アップ不可にする
    dropzone.on("maxfilesreached", function(file, message) {
        this.disable();
    });   
    // ファイル削除時の入力チェック
    dropzone.on("removedfile", function(file, message) {
        // 画像ファイルが０になれば、ボタンをdisable
        if ( ! this.files.length) {
            $("#pict-ok").val(0);
            if (!$("#regist-ok").hasClass("disable-b")) {
                $("#regist-ok").addClass("disable-b");
            }
        }
    });

    // 説明文のイベント２種（タイピング、ペースト）
    $("#item-description").keydown(descriptionKeyDownAndPasteFunc);
    $(document).on("paste", "#item-description", descriptionKeyDownAndPasteFunc);

    // プルダウン変更時のイベント
    $("#item_condition").change(function() {
        checkRequire();
    });

    $("#regist-ok").click(goToStep2);
});

// 次のステップへ
function goToStep2(eo) {
    if (checkRequire()) {
        $("#sale_register_step1").attr("method", "post");
        $("#sale_register_step1").attr("action", baseUrl + consUrlJs.itemSaleGotoStep2Path);
        $("#sale_register_step1").submit();
    } else {
        alert("入力されてない項目があります");
    }
    return;
}

// 説明文のタイピング時とペースト時の処理
function descriptionKeyDownAndPasteFunc(eo) {
    if (itemTypingFlag) {
        itemTypingFlag = 0;
        // 少し遅らせる
        setTimeout(function() {
            //　検索文字列の取得
            var word = $(eo.target).val();
            // 2文字以上で検索
            itemTypingFlag = 1;    
            checkRequire();
        }, 100);

    }
}

// 入力チェック
function checkRequire() {
    console.log("check!");
    if ($('#pict-ok').val() && $('#item-description').val() && $("#item_condition").val()) {
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
