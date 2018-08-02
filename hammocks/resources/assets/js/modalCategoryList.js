var baseUrl = getDomain();
var html = "";
var brandHtml = "";
var url = baseUrl + consUrlJs.categorySearchListPath;
var selectCategoryUrl = baseUrl + consUrlJs.categorySelectSearchPath;
var selectGenreUrl = baseUrl + consUrlJs.genreSelectSearchPath;
var selectGenreSecondUrl = baseUrl + consUrlJs.genreSecondSelectSearchPath;
var selectCategoryBrandList = baseUrl + consUrlJs.modalBrandList;
var buttonClickFlag = true;

$(document).ready(function () {
    var activeId = getActiveClassId($('.active').attr('id'));
    // 初回デフォルトの表示
    if ($("#category_select_list").length) {
        dispCategories(activeId);
        dispBrands(null, null, 1);
    }
    // ビッグカテゴリが切り替わったら、再取得する
    //$(document).on("click", ".big_category_li", selectBigCategoryFunc);
    // カテゴリ、ジャンル、セカンドジャンル選択時の処理
    /*
    $(document).on("click", "span.category_li", selectListFunc);
    $(document).on("click", "span.genre_li", selectListFunc);
    $(document).on("click", "span.genre_second_li", selectListFunc);
    // ブランド選択時の処理
    $(document).on("click", ".brand_li", selectBrandListFunc);
    */
    //開閉メニュー用
    $(document).on("click", "div.slide_btn", function() {
        $(this).toggleClass("open");
        $(this).next().slideToggle();
    });

//selectで選択されたものだけ表示
 $('#BrandSelect').change(function() {
  // 選択されているvalue属性値を取り出す
  var selectVal = $("#BrandSelect option:selected").val();
  console.log(selectVal);

   if (selectVal == "ALL") {
       $(".brand_card").show();
   } else {
       $(".brand_card").hide();
       $(".select_" + selectVal).show();
   }
 });

});

function selectListFunc(eo) {
    // 諸々初期化
    // ボタンのタイトルを選択した項目に変更
    $("#category_list_button").html($(eo.target).html());
    // 表示していたアイテムを削除
    $(".result_area").empty();
    var ids = eo.target.id.split('-');
    var keyName = ids[0] + '_id';
    console.log(keyName);
    var id = ids[1];
    // ブランドの言語タイプを取得
    var type = $('.radiobtn:checked').val();
    $.post(selectCategoryUrl, { id : id, key : keyName }, categorySearchResultFunc);
}

function selectBrandListFunc(eo) {
    // 諸々初期化
    // ボタンのタイトルを選択した項目に変更
    $("#brand_list_button").html($(eo.target).html());
    // 表示していたアイテムを削除
    $(".result_area").empty();
    // ブランドモーダルのhtml内容を初期化
    var ids = eo.target.id.split('-');
    var keyName = ids[0] + '_id';
    var id = ids[1];
    $.post(selectCategoryUrl, { id : id, key : keyName }, categorySearchResultFunc);
}

function dispBrands(id, keyName, type) {
    $.post(selectCategoryBrandList, { id : id, key : keyName, lang_type : type}, showModalBrandList);
}

// brandモーダルのリスト入れ替え
function showModalBrandList(data, httpStatus) {
    if (Object.keys(data).length > 0) {
        $.each(data, showBrandList);
    }
}

// ブランドリストを表示する
function showBrandList(key, value) {
 brandHtml = '<li class="brand_card select_'+ key +'"><span class="initial">' + key + '</span>';
 brandHtml += '<ul class="brand_list">';
    if (Object.keys(value).length > 0) {
        $.each(value, showBrandChild);
    }
    brandHtml += '</ul>';
    brandHtml += '</li>';
    $("#modal_brand_list").append(brandHtml);
}

// ブランド子表示
function showBrandChild(key, value) {
 brandHtml += '<li data-remodal-action="close" class="brand_li" id="brands-' + value.id + '"><span>' + value.name + '</span></li>';
}

// アイテム表示
function categorySearchResultFunc(data, httpStatus) {
    if (Object.keys(data).length > 0) {
        $.each(data, showPublicItemList);
    }
}

// id分解処理
function getActiveClassId(id) {
    var ids = id.split('-');
    return ids[1];
}

// ビッグカテゴリ変更イベント
function selectBigCategoryFunc(eo) {
    if (buttonClickFlag) {
        // 諸々初期化
        // イベントロック
        buttonClickFlag = false;
        // 選択状態をロック
        $(".category_name li").removeClass("active");
        $(eo.target).addClass('active');
        // モーダルの中身を初期化
        $("#category_select_list").empty();
        // 選択時のbig_category_idを取得して、
        // big_category_idだけ抽出
        var activeId = getActiveClassId(eo.target.id);
        // モーダルにリストを表示
        dispCategories(activeId);
    }
}

// カテゴリ,ジャンル一覧取得
function dispCategories(activeId) {
    html = "";
    $.post(url, {big_category_id : activeId}, dispCategoryListFunc);
}

// 表示
function dispCategoryListFunc(data, httpStatus) {
    html += '<h1>' + data.name + '</h1>';
    html += '<ul class="collapse">';
    $.each(data.list, showCategoryList);
    html += '</ul>';
    $("#category_select_list").append(html);
    buttonClickFlag = true;
    return true;
}

// カテゴリのリストを生成
function showCategoryList(key, list) {
    html += '<li><span data-remodal-action="close" class="category_li" id="category-' + list.id + '">' + list.name + '</span>';
    if (list.genre.length > 0) {
     html += '<div class="slide_btn"></div>'
     html += '<ul class="first_layer">';
        $.each(list.genre, showGenreList);
        html += "</ul>";
    }
    html += "</li>";
}

// ジャンルのリストを生成
function showGenreList(key, list) {
    html += '<li><span data-remodal-action="close" class="genre_li" id="genre-' + list.id + '">' + list.name + '</span>';
    if (list.genre_second.length > 0) {
     html += '<div class="slide_btn"></div>'
     html += '<ul class="second_layer">';
        $.each(list.genre_second, showGenreSecondList);
        html += "</ul>";
    }
    html += "</li>";
}

// セカンドジャンルの生成
function showGenreSecondList(key, list) {
    html += '<li><span data-remodal-action="close" class="genre_second_li" id="genre_second-' + list.id + '">' + list.name + '</span></li>';
}



