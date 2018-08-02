var baseUrl = getDomain();
var itemTypingFlag = 1;
var itemRatingUrl = baseUrl + consUrlJs.itemRatingPath;

$(document).ready(function () {
    $(".pict_result_disp").css("display", "none");
    // タグ
    tagListUrl = baseUrl + consUrlJs.tagsNamesPath;
    $.post(tagListUrl, getTagNames);
    var dropzone = myAwesomeDropzone("#my-awesome-dropzone", "#my-preview-dropzone", "article", 1);

    // ファイル追加した時の処理を継承
    dropzone.on("addedfile", function(file, message) {
        console.log(this);
        if (this.files.length) {
            $("#pict-ok").val(1);
        }
    });

    // 画像をアップした状態では画像アップ不可にする
    // ファイル削除した時の処理を継承
    dropzone.on("removedfile", function(file, message) {
        console.log(this.files.length);
        if ( ! this.files.length) {
            $("#pict-ok").val(0);
        }
    });

    // submit
    $("#regist_btn").click(articleRegist2Complete);

});

// 登録完了
function articleRegist2Complete(eo) {
    //if (!$('#regist_btn').hasClass('disable-b')) {
    if (checkRequire()) {
        $("#article-register-form").attr("method", "post");
        $("#article-register-form").attr("action", baseUrl + consUrlJs.articleRegistActionPath);
        $("#article-register-form").submit();
    } else {
        alert("画像を投稿して下さい");
    }
    return;
}

// タグ取得
function getTagNames(data, httpStatus) {
    $('#tag-it').tagit({
        fieldName: "label",
        placeholderText:"タグをつけよう",
        availableTags: data,
        allowSpaces: true,
        singleField: true,
        itemName: 'item',
        ieldName: 'tags',
    });
}

// アイテム入力時にもチェック
function itemKeyUpFunc(eo) {
    if (itemTypingFlag) {
        itemTypingFlag = 0;
        setTimeout(function() {
            itemKeyUpDetailFunc(eo);
        }, 100);

    }
}

// KeyUpとpasteの共通関数
function itemKeyUpDetailFunc(eo) {
    // 一旦、イベントを落とす
    //$(document).off('click', '#regist-ok');
    //　検索文字列の取得
    var word = $(eo.target).val();
    console.log(word);
    // 2文字以上で検索
    itemTypingFlag = 1;    
    if ( ! word.length) {
        //checkRequire();
        /*
        $('#regist-ok').addClass('disable-b');
        $('#regist-ok').removeAttr("data-remodal-target");
        */
        return;
    }
    checkRequire();
}

// 入力チェック
function checkRequire() {
    if ($('#pict-ok').val()) {
        return true;
    } else {
        return false;
    }
}
