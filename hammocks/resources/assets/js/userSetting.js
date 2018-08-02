var baseUrl = getDomain();
var storage_path = getStoragePath();
var typingFlag = 1;

validation.fields = {
    profile_name : {max : 100},
    profile_name_kana : {max : 100},
    post_code : {max : 8},
    birth : {},
    prefecture : {},
    city : {max : 200},
    address : {max : 200}
};

$(document).ready(function () {

    // 画像アップローダーのインスタンス取得
    // ユーザーアバター用
    var dropzone = myAwesomeDropzone("#my-awesome-dropzone", "#my-preview-dropzone", "user_avater", 1);
    // ガレージ背景画像用
    var dropzone2 = myAwesomeDropzone("#my-awesome-dropzone2", "#my-preview-dropzone2", "user_background", 1);

    // 画像をアップした状態では画像アップ不可にする
    dropzone.on("maxfilesreached", function(file) {
        this.disable();
        $("#setting_tab_avater").removeClass("disable-b");
    });
    dropzone2.on("maxfilesreached", function(file) {
        this.disable();
        $("#setting_tab_background").removeClass("disable-b");
    });
    // 画像削除したら更新ボタンがdisableになる
    dropzone.on("removedfile", function(file) {
        $("#setting_tab_avater").addClass("disable-b");
    });

    dropzone2.on("removedfile", function(file) {
        $("#setting_tab_background").addClass("disable-b");
    });

    // アバター等の更新
    var userImageUrl = baseUrl + consUrlJs.userImageUpdatePath;
    $("#setting_tab_avater").on("click", function(eo) {
        if ($("#setting_tab_avater").hasClass("disable-b")) {
            return;
        }
        $.post(userImageUrl, {"type" : "user_avater" }, function(data, status) {
            $("#setting_tab_avater").addClass("disable-b");
            alert("アバターを変更しました");
            console.log(data);
        });
    });

    // 背景画像の更新
    $("#setting_tab_background").on("click", function(eo) {
        if ($("#setting_tab_background").hasClass("disable-b")) {
            return;
        }
        $.post(userImageUrl, { "type" : "user_background" }, function(data, status) {
            $("#setting_tab_background").addClass("disable-b");
            alert("背景画像を変更しました");
            console.log(data);
        });
    });

    // tab1の更新
    $("#setting_tab1_btn").on("click", function(eo) {
        if ($(eo.target).hasClass("disable-b")) {
            return;
        }
        var tab1Inputs = $(".setting_tab1");
        $(eo.target).addClass("disable-b");
        updateTab1AreaFunc(consUrlJs.userSettingPath[0], tab1Inputs, eo.target);
    });

    // パスワード変更
    $("#updatePassword").on("click", function(eo) {
        var url = baseUrl + consUrlJs.passwordUpdatePath;
        var params = {};
        params["password"] = $("#password").val();
        params["new_password"] = $("#new_password").val();
        params["re_password"] = $("#re_password").val();
        $.post(url, params, function(data, status) {
            alert(data.message);
        });
    });
});

function updateTab1AreaFunc(url, tab1Inputs, eventElement) {

    // バリデーション初期化
    validation.init();

    var params = {};

    tab1Inputs.each(function(index, value) {
        var id = "#" + value.id;
        validation.valid(value.id, $(id).val());
        params[value.id] = $(id).val();
    });

    if (validation.isValid) {
        $.post(url, {"params" : params}, function(data, status) {
            console.log(data);
            alert("更新しました");
            $(eventElement).removeClass("disable-b");
        });
    }
}
