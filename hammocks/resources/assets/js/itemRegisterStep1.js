var baseUrl = getDomain();
var storage_path = getStoragePath();
var brandListUrl = "";
var itemListUrl = baseUrl + consUrlJs.itemNamesPath;
var completionItemUrl = baseUrl + consUrlJs.completionItemPath;
var itemTypingFlag = 1;

$(document).ready(function () {
    if ($("#brand-id").val() != "") {
        $("#item_name").removeAttr("disabled");
    }
    // ブランド
    brandListUrl = baseUrl + consUrlJs.brandNamesPath;
    $.post(brandListUrl, getBrandNames);
    checkRequire();

    // 画像選択発火
    // ブランドのフォーカス外れた
    $('#brandname').focusout(brandValidate);
    // ブランドのフォーカス
    $('#brandname').focus(function(eo) {
        $(".regist-error").remove();
        $("#item_name").val("");
    });
    //$('#brandname').change(brandValidate);
    // ブランドその他チェックボックス
    $(document).on('change', '#brand-other', brandOtherCheck);

    // アイテム
    $("#item_name").keydown(itemKeyUpFunc);
    //$("#item_name").focusout(itemListFunc);
    //$("#item_name").focus(removeItemList);
    $(document).on("paste", "#item_name", itemKeyUpFunc);
    $(document).on('click', '.publicitemcard' , selectedItem);

    $(document).on('click', '#toStep2Btn', toStep2Func);
});

function brandValidate() {
    $('.regist-error').remove();
    if ($('#brand-id').val() == "") {
        var errorMessage = '<p id="brand-error" class="regist-error">ブランドを選択してください</p>';
        $(errorMessage).appendTo('#brand-wrap');
    }    
    checkRequire();
}

// その他選択時の処理
function brandOtherCheck(eo) {
    if ($('#brandname').val() != "") {
        $('#brandname').val("");
    }
    if ($(this).is(':checked')) {
        var brandOtherId = $("#brand-other").val();
        $("#brand-id").val(brandOtherId);
        $("#change-select-brand").html("その他");
        $("#brand-name-hidden").val("その他");
        $("#brandname").attr("disabled","disabled");
        $("#brand-error").remove();
        $("#item_name").removeAttr("disabled");

        // アイテム
        $("#item_id_hidden").val("");
        $("#item_name").val("");
    } else {
        $("#brand-id").val("");
        $("#change-select-brand").html("");
        $("#brand-name-hidden").val("");
        $("#brandname").removeAttr("disabled");
        $("#item_name").attr("disabled","disabled");
    }
}

function toStep2Func(eo) {
    $("#item-register-form").attr("action", baseUrl + consUrlJs.itemRegistActionPath);
    $("#item-register-form").submit();
    var brand_id = $("#brand-id").val();
    $.ajax({
        async : false,
        url : baseUrl + consUrlJs.itemRegistActionPath,
        data : brand_id
    });
    return;
}

// autocompleteで使用するブランドリストを取得
function getBrandNames(data, httpStatus) {
    $('#brandname').autocomplete({
        source: data,
        minLength: 0,
        autoFocus: true,
        open: function(e, ui) {
            // フォーム値が更新されたらhiddenの値も削除
            $("#brand-id").val("");
            $("#change-select-brand").html("");
            $("#brand-name-hidden").val("");
        },
        focus: function(e, ui) {
            // idをhiddenタグに入れて、追加する
            $("#brand-id").val(ui.item.id);
            //$("#item_name").removeAttr("disabled");
            $("#item_name").attr("disabled","disabled");
            $("#change-select-brand").html(ui.item.value);
            $("#brand-name-hidden").val(ui.item.value);
        },
        select : function(e, ui) {
            // idをhiddenタグに入れて、追加する
            $("#brand-id").val(ui.item.id);
            $("#item_name").removeAttr("disabled");
            $("#change-select-brand").html(ui.item.value);
            $("#brand-name-hidden").val(ui.item.value);
        }
    });
}

// autocompleteで使用するアイテムをブランドIDで取得
function getItemNames(data, httpStatus) {
    $('#item_name').autocomplete({
        source: data,
        minLength: 0,
        autoFocus: true,
        open: function(e, ui) {
            // フォーム値が更新されたらhiddenの値も削除
            $("#item_id_hidden").val("");
        },
        focus: function(e, ui) {
            // idをhiddenタグに入れて、追加する
            $("#item_id_hidden").val(ui.item.id);

        },
        select : function(e, ui) {
            // idをhiddenタグに入れて、追加する
            $("#item_id_hidden").val(ui.item.id);
        }
    });
}

function brandValidate() {
    if ($('#brand-id').val() == "") {
        var errorMessage = '<p id="brand-error" class="regist-error">ブランドを選択してください</p>';
        $(errorMessage).appendTo('#brand-wrap');
    } else {
        $('#brand-error').remove();
    }
    checkRequire();
}

// アイテム取得
function itemListFunc(eo) {
    // エラーメッセージ初期化
    $('#item-error').remove();
    itemListUrl = baseUrl + consUrlJs.itemNamesPath;
    var name = $(eo.target).val();
    // 入力チェック
    if (name == "") {
        var errorMessage = '<p id="item-error" class="regist-error">アイテム名は必須項目です</p>';
        $('#item_name').after(errorMessage);
    }
    checkRequire();
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
    $(document).off('click', '#regist-ok');
    //　検索文字列の取得
    var word = $(eo.target).val();
    console.log(word);
    // 2文字以上で検索
    itemTypingFlag = 1;
    if ( ! word.length) {
        $('#regist-ok').addClass('disable-b');
        $('#regist-ok').removeAttr("data-remodal-target");
        return;
    }
    $('#regist-ok').attr("data-remodal-target", "GearSearch");
    $('#regist-ok').removeClass("disable-b");
    $(document).on('click', '#regist-ok', function(e) {
        var brands_id = $("#brand-id").val();
        var params = { brands_id : brands_id, word : word };
        console.log(params);
        $.post(completionItemUrl, params, dispCompletionListFunc);
    });
}

// アイテムの補完リストを表示
function dispCompletionListFunc(data, status) {
    console.log(data);
    itemTypingFlag = 1;
    console.log(data.items.length);
    $("#search_word_title").html("");
    $('#item_completion_area').empty();
    $(".result_txt").remove();
    if (data.items.length > 0) {
        // 表示処理
        $("#search_word_title").html(data.items[0].brand_name + 'の' + data.word + 'による検索結果');
        var html = "";
        $.each(data.items, function(key, item) {
         html += '<a href="' + baseUrl + '/master/item/' + item.items_id + '">';
         html += '<section class="listbox list-gear">';
         html += '<div class="left_area">';
         html += '<div class="pic squarebox">';
         html += '<img class="img_resize" id="item_pict_' + item.items_id + '" src="' + storage_path + item.img_url + '">';
         html += '</div><!--//pic-->';
         html += '</div><!--//left_area-->';
         html += '<div class="right_area card_infomation">';
         html += '<p class="brand_name">' + item.brand_name + '</p><!--//brand_name-->';
         html += '<h1 class="card_name">' + item.item_name + '</h1><!--//card_name-->';
         html += '</div><!--/.card_infomation--></section><!-- /.list-gearlist-gear --></a>';
         //$('#gear_search_result div#item_completion_area').append(html);
         //$('#item_pict_' + item.items_id).resizeOne();
         //$('#item_pict_' + item.items_id).attr("src", storage_path + item.img_url);
        });
        $('#gear_search_result div#item_completion_area').append(html);
        $('#gear_search_result div#item_completion_area').enable_onload_for_images().done(function() {
            $("#toStep2Btn").removeClass("disable-b");
        });
    } else {
        $("#search_word_title").html(data.word + 'による検索結果');
        var html = '<p class="result_txt">0件</p>';
        $("#search_word_title").after(html);
        $("#item_completion_area").empty();
        console.log("ccccccccc");
        if (!$(".modalbtn_set#toStep2Btn").hasClass("disable-b")) {
            console.log("bbbbb");
            $("#toStep2Btn").removeClass("disable-b");  
        }
    }
}

// アイテム選択時の処理
function selectedItem(eo) {

    // エラー初期化
    $("#item-error").remove();

    var targetId = eo.target.id;
    console.log(targetId);
    var itemIdArray = targetId.split('_');
    var itemId = itemIdArray[3];
    var elementName = "#comp_item_name_" + itemId;
    var itemName = $(elementName).html();
    var url = baseUrl + consUrlJs.hasItemByUser;
    // 補完リストを削除する
    $("#item_completion_area").empty();

    // アイテム重複登録チェック
    $.post(url, { item_id : itemId }, function(data, httpStatus) {
        if (data.has_item) {
            var errorMessage = '<p id="item-error" class="regist-error">すでに登録済みのアイテムです</p>';
            $('#item_name').after(errorMessage);
        } else {
            $('#item_name').val(itemName);
            $('#item_id_hidden').val(itemId);
            $('.propose_itemlist').empty();
        }
        checkRequire();
    });
}

// 再フォーカスでリスト削除及びhidden値削除
function removeItemList(eo) {
    $('.propose_itemlist').empty();
    $('#item_id_hidden').val("");
}

// 入力チェック
function checkRequire() {
    if ($('#brand-id').val() && $("#item_name").val()) {
        $('#regist-ok').attr("data-remodal-target", "GearSearch");
        if ($('#regist-ok').hasClass('disable-b')) {
            $('#regist-ok').toggleClass('disable-b');
        }
    } else {
        $('#regist-ok').removeAttr("data-remodal-target");
        if (!$('#regist-ok').hasClass('disable-b')) {
            $('#regist-ok').toggleClass('disable-b');
        }
    }
}
