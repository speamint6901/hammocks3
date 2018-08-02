var baseUrl = getDomain();
var itemTypingFlag = 1;

$(document).ready(function () {
    checkRequire();
    $(".pict_result_disp").css("display", "none");
    // タグ
    // submit発火
    $('#regist-ok').click(itemRegist2Complete);

    var dropzone = myAwesomeDropzone("#my-awesome-dropzone", "#my-preview-dropzone", "item", 1);

    // ファイル追加した時の処理を継承
    dropzone.on("addedfile", function(file, message) {
        if (this.files.length) {
            console.log("addfiles");
            $("#pict-ok").val(1);
            checkRequire();
        }
    });

    // 画像をアップした状態では画像アップ不可にする
    dropzone.on("maxfilesreached", function(file, message) {
        this.disable();
    });

    // ファイル削除した時の処理を継承
    dropzone.on("removedfile", function(file, message) {
        console.log(this.files.length);
        if (!$('#regist-ok').hasClass('disable-b')) {
            $('#regist-ok').toggleClass('disable-b');
        }
        if ( ! this.files.length) {
            $("#pict-ok").val(0);
        }
    });

    // urlスレイピング
    $(document).on('click', '#pict-select-url-button', urlSlapeFunc);
    $(document).on('click', '.web_pict_img', selectWebImageFunc);

    // プルダウン連動
    // 大カテゴリ
    $("#categoryselect").change(bigCategorySelect);
    // カテゴリ
    $(document).on('change', '#genreselect', categorySelect);
    // ジャンル
    $(document).on('change', '#sub_genreselect', genreSelect);

    $("#item_name").keydown(itemKeyUpFunc);
    $(document).on("paste", "#item_name", itemKeyUpFunc);
    $("#item_name").focus(function() {checkRequire(); });

});

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
    //　検索文字列の取得
    var word = $(eo.target).val();
    // 2文字以上で検索
    itemTypingFlag = 1;
    checkRequire();
}

// 登録完了
function itemRegist2Complete(eo) {
    if (!$('#regist-ok').hasClass('disable-b')) {
        $("#item-register-form").attr("action", baseUrl + consUrlJs.itemRegistActionConfirm);
        $("#item-register-form").submit();
    }
    return;
}

function descriptionValidate() {
    checkRequire(); 
}

// ドラッグ＆ドロップ時のファイル取得
function draggerFunc(eo) {
    eo.preventDefault();
    $('#drop-zone').removeClass('over');
    var files = eo.originalEvent.dataTransfer.files;
    var file = validFiles(files);
    if (!file) {
        return;
    }
    setResizeImage(file);
}

// 入力チェック
function checkRequire(async_toggle) {
    var categorySelector = $("#categoryselect");
    console.log(categorySelector.length);
    console.log($('#pict-ok').val());
    console.log($("#pict_result_img").val());
    if (($('#pict-ok').val() || $("#pict_result_img").val()) && ($("#item_name").val() &&
        $('#categoryselect').val() && $('#genreselect').val())) {
        console.log("check ok");
        if ($('#regist-ok').hasClass('disable-b')) {
            $('#regist-ok').toggleClass('disable-b');
        }
    } else if (!$('#regist-ok').hasClass('disable-b')) {
        console.log("check ng");
        $('#regist-ok').toggleClass('disable-b');
    }
}

// ビッグカテゴリ変更時
function bigCategorySelect(eo) {
    checkRequire();
    var big_category_id = $(eo.target).val();
    bigCategoryListUrl = baseUrl + consUrlJs.bigCategoryListPath;
    $('#genreselect').remove();
    $('#sub_genreselect').remove();
    $('#sub-sub_genreselect').remove();
    $.post(bigCategoryListUrl, { CategorySelect : big_category_id }, dispCategoryPullDown);
}

// カテゴリ変更時
function categorySelect(eo) {
    checkRequire();
    var category_id = $(eo.target).val();
    categoryListUrl = baseUrl + consUrlJs.categoryListPath;
    $('#sub_genreselect').remove();
    $('#sub-sub_genreselect').remove();
    $.post(categoryListUrl, { genreselect : category_id }, dispGenrePullDown);
}

// ジャンル変更時
function genreSelect(eo) {
    checkRequire();
    var genre_id = $(eo.target).val();
    genreListUrl = baseUrl + consUrlJs.genreListPath;
    $('#sub-sub_genreselect').remove();
    $.post(genreListUrl, { Sub_GenreSelect : genre_id }, dispSecondGenrePullDown);
}

// カテゴリプルダウン表示
function dispCategoryPullDown(data, httpStatus) {
    var pullDown = '<select name="GenreSelect" id="genreselect" class="selectform">';
    pullDown = _setOptionValue(data, pullDown);
    if ($('#genreselect').length == 0) {
        $('#categoryselect').after(pullDown);
    }
}

// ジャンルプルダウン表示
function dispGenrePullDown(data, httpStatus) {
    if ( ! data.length) {
        return;
    }
    var pullDown = '<select name="Sub_GenreSelect" id="sub_genreselect" class="selectform">';
    pullDown = _setOptionValue(data, pullDown);
    if ($('#sub_genreselect').length == 0) {
        $('#genreselect').after(pullDown);
    }
}

// サブジャンルプルダウンを表示
function dispSecondGenrePullDown(data, httpStatus) {
    if ( ! data.length) {
        return;
    }
    var pullDown = '<select name="Sub-sub_GenreSelect" id="sub-sub_genreselect" class="selectform">';
    pullDown = _setOptionValue(data, pullDown);
    if ($('#sub-sub_genreselect').length == 0) {
        $('#sub_genreselect').after(pullDown);
    }
}

// optionタグを設定
function _setOptionValue(data, pullDown) {
    pullDown += '<option value="">-- 選択 --</option>';
    $.each(data, function(index, value) {
        pullDown += '<option value="' + value.id + '">' + value.name + '</option>';
    });
    pullDown += '</select>';
    return pullDown;
}


// コンテナ登録
function registUserContainer(eo) {
    if ($("#make_container").val() == "") {
        errorMsg = '<p id="make_container_error" class="regist-error">コンテナ名を入力して下さい</p>'
        $("#make_container").after(errorMsg);
        return;
    }
    var containerName = $("#make_container").val();
    var url = baseUrl + consUrlJs.userContainerRegistPath;
    $.post(url, {MakeContainer : containerName}, function(data, httpStatus) {
        $("#containerselect").append(function() {
            return $("<option>").val(data.id).text(data.name);   
        });
        $('#containerselect option[value="' + data.id + '"]').attr("selected", "selected");
        $("#toggle-make_container").css("display", "none");
    });
}
