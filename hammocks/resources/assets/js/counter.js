var urlCounterPush = "";
var urlCounterFavPush = "";
var iconClickFlag = true;
var iconClickFavFlag = true;
var baseUrl = getDomain();

$(document).ready(function () {

    urlCounterPush = baseUrl + consUrlJs.pushWantHasPath;
    urlCounterPushFav = baseUrl + consUrlJs.pushFavPath;

    // 持ってる、欲しいカウント更新
    $(document).on('click', '.icon-button', counterFunc);

    // お気に入りカウント更新
    $(document).on('click', '.icon-button-fav', counterFuncFav);
});

// 持ってる、欲しいカウント更新
function counterFunc(eo) {

    if (iconClickFlag) {
        // 一度ボタンをロックする
        iconClickFlag = false;

        // イベントオブジェクトからIDを取得する
        var elemId = eo.currentTarget.id;
        var splitElemId = elemId.split('_');
        var requestUrl = urlCounterPush + splitElemId[1] + '/' + splitElemId[2];

        var jqXHR = $.post(requestUrl);

        jqXHR.done(function(data, httpStatus) {
            // カウントアップ・ダウン
            var want_id = null;
            var have_id = null;
            var haveClass = "disable";
            var wantClass = "disable";
            if (data['status'] == 2) {
                wantClass = "active";
            } else if (data['status']) {
                haveClass = "active";
            }

            if (splitElemId[1] == 2) {
                want_id = "#" + elemId; 
                have_id = "#have_1_" + splitElemId[2];
            } else {
                have_id = "#" + elemId;
                want_id = "#want_2_" + splitElemId[2];
            }

            $(have_id + " + span.count").html(data['have_count']);
            $(want_id + " + span.count").html(data['want_count']);
            if (haveClass == "active") {
                $(have_id).attr("src", baseUrl + "/images/ico-have-on.svg"); 
            } else {
                $(have_id).attr("src", baseUrl + "/images/ico-have-off.svg"); 
            }
            if (wantClass == "active") {
                $(want_id).attr("src", baseUrl + "/images/ico-want-on.svg"); 
            } else {
                $(want_id).attr("src", baseUrl + "/images/ico-want-off.svg"); 
            }
            //$(have_id).parent("div").attr('class', haveClass);
            //$(want_id).parent("div").attr('class', wantClass);
            iconClickFlag = true;
        });

        // 通信失敗時
        jqXHR.fail(function(aaa) {
            console.log(aaa);
            iconClickFlag = true;
        });
    }
}

// お気に入りカウント更新
function counterFuncFav(eo) {

    if (iconClickFavFlag) {
        // 一度ボタンをロックする
        iconClickFavFlag = false;

        // イベントオブジェクトからIDを取得する
        var elemId = eo.currentTarget.id;
        var splitElemId = elemId.split('_');
        var requestUrl = urlCounterPushFav + splitElemId[1];

        var jqXHR = $.post(requestUrl);

        // カウント更新
        jqXHR.done(function(data, httpStatus) {
            // カウントアップ・ダウン
            $("#" + elemId + " + span.count").html(data['clip_count']);
            iconClickFavFlag = true;
        });

        // 通信失敗時
        jqXHR.fail(function(aaa) {
            console.log(aaa);
            iconClickFavFlag = true;
        });
    } 
}
