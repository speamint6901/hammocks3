var brandListUrl = "";
var tagListUrl = "";
var itemListUrl = "";
var bigCategoryListUrl = "";
var categoryListUrl = "";
var genreListUrl = "";
var baseUrl = getDomain();
const BRAND_OTHER_ID = 1;

$(document).ready(function () {
    brandListUrl = baseUrl + consUrlJs.brandNamesPath;
    tagListUrl = baseUrl + consUrlJs.tagsNamesPath;
    // ブランド
    $.post(brandListUrl, getBrandNames);
    // タグ
    $.post(tagListUrl, getTagNames);

    // プルダウン連動
    // 大カテゴリ
    $("#categoryselect").change(bigCategorySelect);
    // カテゴリ
    $(document).on('change', '#genreselect', categorySelect);
    // ジャンル
    $(document).on('change', '#sub_genreselect', genreSelect);

    // ブランドその他チェックボックス
    $(document).on('change', '#brand-other', brandOtherCheck);

    // アイテム
    $("#itemname").focusout(itemListFunc);
    $("#itemname").focus(removeItemList);
});

// その他選択時の処理
function brandOtherCheck(eo) {
    if ($('#brandname').val() != "") {
        $('#brandname').val("");
    }
    if ($(this).is(':checked')) {
        $("#brand-id").val(BRAND_OTHER_ID);
        $("#brandname").attr("disabled","disabled");
        $("#brand-error").remove();
    } else {
        $("#brand-id").val("");
        $("#brandname").removeAttr("disabled");
    }
}

function getBrandNames(data, httpStatus) {
    console.log(data);
    $('#brandname').autocomplete({
        source: data,
        minLength: 0,
        autoFocus: true,
        open: function(e, ui) {
            // フォーム値が更新されたらhiddenの値も削除
            $("#brand-id").val("");
        },
        focus: function(e, ui) {
            // idをhiddenタグに入れて、追加する
            $("#brand-id").val(ui.item.id);
        },
        select : function(e, ui) {
            // idをhiddenタグに入れて、追加する
            $("#brand-id").val(ui.item.id);
        }
    });
}

// タグ取得
function getTagNames(data, httpStatus) {
    console.log(data);
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

// アイテム取得
function itemListFunc(eo) {
    // エラーメッセージ初期化
    $('#item-error').remove();
    itemListUrl = baseUrl + consUrlJs.itemNamesPath;
    var name = $(eo.target).val();
    // 入力チェック
    if (name == "") {
        console.log("empty");
        var errorMessage = '<p id="item-error" class="regist-error">アイテム名は必須項目です</p>';
        $('#itemname').after(errorMessage);
    } else {
        // 入力した名前から候補を抽出する
        $.post(itemListUrl, { name : name }, function(data, httpStatus) {
            if (data.length) {
                autocompleteItemList(data, eo);
            }
        });
    }
    checkRequire();
}

// 再フォーカスでリスト削除及びhidden値削除
function removeItemList(eo) {
    $('.propose_itemlist').empty();
    $('#itemIdHiddun').val("");
}

// 候補の生成DOM追加
function autocompleteItemList(data, eo) {
    var itemListTag = '<ul>';
    $.each(data, function(index, value) {
        itemListTag += '<li class="autoItemList" id="item_' + value.id + '">' + value.name + '</li>';
    });
    itemListTag += '</ul>';
    $('.propose_itemlist').append(itemListTag);
    // イベントセット
    $(document).on('click', '.autoItemList', selectedItem)
}

// アイテム選択時の処理
function selectedItem(eo) {

    // エラー初期化
    $("#item-error").remove();

    var targetId = eo.target.id;
    var itemIdArray = targetId.split('_');
    var itemId = itemIdArray[1];
    var itemName = $(eo.target).html();
    var url = baseUrl + consUrlJs.hasItemByUser;

    $('#itemname').val(itemName);
    $('#itemIdHiddun').val(itemId);
    $('.propose_itemlist').empty();

    // アイテム重複登録チェック
    $.post(url, { item_id : itemId }, function(data, httpStatus) {
        if (data.has_item) {
            var errorMessage = '<p id="item-error" class="regist-error">すでに登録済みのアイテムです</p>';
            $('#itemname').after(errorMessage);
            $('#itemname').val("");
            $('#itemIdHiddun').val("");
            $('.propose_itemlist').empty();
        }
    });
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
    checkRequire();
}

// ジャンル変更時
function genreSelect(eo) {
    checkRequire();
    var genre_id = $(eo.target).val();
    console.log(genre_id);
    genreListUrl = baseUrl + consUrlJs.genreListPath;
    $('#sub-sub_genreselect').remove();
    $.post(genreListUrl, { Sub_GenreSelect : genre_id }, dispSecondGenrePullDown);
}

// カテゴリプルダウン表示
function dispCategoryPullDown(data, httpStatus) {
 var pullDown = '<select name="GenreSelect" id="genreselect" class="selectform">';
    pullDown = _setOptionValue(data, pullDown);
    $('#categoryselect').after(pullDown);
}

// ジャンルプルダウン表示
function dispGenrePullDown(data, httpStatus) {
    if ( ! data.length) {
        return;
    }
 var pullDown = '<select name="Sub_GenreSelect" id="sub_genreselect" class="selectform">';
    pullDown = _setOptionValue(data, pullDown);
    $('#genreselect').after(pullDown);
}

// サブジャンルプルダウンを表示
function dispSecondGenrePullDown(data, httpStatus) {
    if ( ! data.length) {
        return;
    }
 var pullDown = '<select name="Sub-sub_GenreSelect" id="sub-sub_genreselect" class="selectform">';
    pullDown = _setOptionValue(data, pullDown);
    $('#sub_genreselect').after(pullDown);
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
