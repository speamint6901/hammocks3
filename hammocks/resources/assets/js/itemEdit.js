var baseUrl = getDomain();
var storage_path = getStoragePath();
var itemListUrl = baseUrl + consUrlJs.itemNamesPath;
var getOldDataUrl = baseUrl + consUrlJs.itemEditOldData;
var itemEditUrl = baseUrl + consUrlJs.itemEdit;
var user_items_id = getUserItemId();

$(document).ready(function () {

    $(".pict_result_disp").css("display", "none");

    $(document).on("click", "#item_edit_disp_btn", function(eo) {
        alert("編集モードに変更しました");
        $(".editmode").css("display", "block");
    });

    // ディスクリプション更新ボタン
    $(document).on("click","#description_edit_btn", function(eo) {
        var value = $("#item-description").val();
        var postData = { user_items_id : user_items_id, description : value };
        if (value != "") {
            $.post(itemEditUrl, postData, function(data, status) {
                $("p#item_info_description").html(data.description);
            });
        }
    });

    // タグ
    // タグ表示
    var tagListUrl = baseUrl + consUrlJs.tagsNamesPath;
    var getTagListUrl = baseUrl + consUrlJs.getDispTagListPath;
    $.post(getTagListUrl, { user_items_id : user_items_id }, getDispTagListFunc);
    $.post(tagListUrl, getTagNames);
    //$(document).on("click", "#tag_edit_btn", function(eo) {
    $("#tag_edit_btn").click(function(eo) {
        var tagList = $('#tag_edit_form [name="tagList"]').val();
        console.log(tagList);
        var postData = { user_items_id : user_items_id, tag : tagList, action : "add" };
        if (tagList != "") {
            $.post(itemEditUrl, postData, dispResultTagListFunc);
        } else {
            $.post(getTagListUrl, { user_items_id : user_items_id }, function(data, status) {
                dispResultTagList(data);       
            });
        }
    });

    // 画像選択発火
    $(document).on("click", "#img_uploader_form #img-uploader", setImgTrigger);
    $(document).on("change", "#file-image", changeImgFile);

    // 画像ドラッグ＆ドロップ発火
    $('#drop-zone').on('drop', draggerFunc).on('dragenter', function(){
        $('#drop-zone').addClass('over');
        return false;
    }).on('dragover', function(){
        $('#drop-zone').addClass('over');
        return false;
    }).on('dragleave', function(){
        $('#drop-zone').removeClass('over');
        return false;
    });

    // urlスレイピング
    $(document).on('click', '#pict-select-url-button', urlSlapeFunc);
    $(document).on('click', '.web_pict_img', updateSelectWebImageFunc);

    // 画像更新
    $(document).on('click', '#pict_edit_btn', uploadImageFunc);

    // rate更新
    $(document).on('click', '#rate_execute_btn', function(eo) {
        var rate = $('#rate_form input:checked').val();
        if (rate) {
            var postData = { user_items_id : user_items_id, "rate" : rate };
            $.post(itemEditUrl, postData, resultExecuteRateFunc);
        }
    });

});

// ユーザー評価
function resultExecuteRateFunc(data, status) {
    console.log(data);
    if (Object.keys(data).length > 0) {
        $("#thunder_img_icon").attr("src", baseUrl + "/images/rate/thunder_5set-" + data.average_path_name + ".svg");
        $("#rate_disp_area").html(data.average);
    }
}

// webスクレイピングアップロード処理
function updateSelectWebImageFunc(eo) {
    var imgUrl = $(eo.target).attr('src');
    if (imgUrl != "") {
        var siteImgUrl = $("#pict-select-url").val();
        $("#pict_result_disp_img").attr('src', imgUrl);
        $(".pict_result_disp").css("display", "block");
        // アップロード側の画像を空にする
        $("#pict-data-url").val("");
        // アップロード側のmimetypeを空にする
        $("#pict-mimetype").val("");   
        var postData = { "pict_result_img" : imgUrl, "site_img_url" : siteImgUrl, user_items_id : user_items_id };
        $.post(itemEditUrl, postData, changeNewImagePictFunc);
    }
}

// 画像post処理
function uploadImageFunc(eo) {
    if ($("#pict-data-url").val() != "" && $("#pict-mimetype").val() != "") {
        var pictDataUrl =  $("#pict-data-url").val();
        var pictMimetype = $("#pict-mimetype").val();
        var postData = { "pict-data-url" : pictDataUrl, "pict-mimetype" : pictMimetype, user_items_id : user_items_id };
        $.post(itemEditUrl, postData, changeNewImagePictFunc);
    }
    return;
}

// 画像入れ替え
function changeNewImagePictFunc(data, status) {
    console.log(data);
    $("#item_main_pict").attr("src", storage_path + data.img_url);
     //imageFit処理▼
     $('.squarebox').imagefit({
      mode: 'outside',
      force : 'true',
      halign : 'center',
      valign : 'middle',
      onStart: function (index, container, imagecontainer) {},
      onLoad: function (index, container, imagecontainer) {},
      onError: function (index, container, imagecontainer) {},
     });
}

// タグリスト取得結果
function getDispTagListFunc(data, status) {
    if (Object.keys(data).length > 0) {
        dispResultTagList(data);
        dispModalTagList(data);
    }
}

// タグリスト表示
function dispResultTagList(data) {
    // 一旦現在のリスト削除
    $("#user_item_tag_list").empty();
    $('#tag_edit_form [name="tagList"]').val("");

    var tagList = "";
    $.each(data, function(key, value) {
        tagList += "<li><a>" + value.tag_name + "</a></li>";
    });
    $("#user_item_tag_list").append(tagList);
}

// 表示処理を分ける
function dispModalTagList(data) {

    var tagModalList = "";
    $.each(data, function(key, value) {
        tagModalList += "<li>" + value.tag_name + "</li>";
    });
    $('ul#tag-it').append(tagModalList);
}

// 編集後のタグを表示
function dispResultTagListFunc(data, status) {
    if (Object.keys(data).length > 0) {
        if (data.message) {
            alert(data.message);
        }
        dispResultTagList(data);
    }
}

// タグ取得
function getTagNames(data) {
    console.log(data);
    $('ul#tag-it').tagit({
        fieldName: "tagList",
        placeholderText:"タグをつけよう",
        showAutocompleteOnFocus: true,
        availableTags: data,
        allowSpaces: true,
        singleField: true,
        itemName: 'item',
        tagLimit: 10,
        //ieldName: 'tags',
        beforeTagRemoved: function(e, ui) {
            var tagName = ui.tagLabel;
            var postData = { user_items_id : user_items_id, tag : tagName, action : "remove" };
            //$.post(itemEditUrl, postData, dispResultTagListFunc);
            $.post(itemEditUrl, postData, function(data, status) {
                dispResultTagListFunc(data);           
            });
        }
    });
}

// ダミー関数
function checkRequire() {
    return;
}
