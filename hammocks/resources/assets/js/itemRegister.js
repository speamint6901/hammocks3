var baseUrl = getDomain();
const MAX_FILE_SIZE = 2097152;
const MIN_SIZE = 500;

$(document).ready(function () {
    checkRequire();
    // submit発火
    $('#regist-ok').click(itemRegist2Confirm);
    // 画像選択発火
    $('#img-uploader').on("click", setImgTrigger);
    $("#file-image").change(changeImgFile);
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
    // ブランドのフォーカス外れた
    $('#brandname').focusout(brandValidate);
    // ブランドのフォーカス
    $('#brandname').focus(function(eo) {
        $("#brand-error").remove();   
    });
    // ディスクリプションのフォーカス外れた
    $('#item-description').focusout(descriptionValidate);
    // ディスクリプションのフォーカス
    $('#item-description').focus(function(eo) {
        $("#description-error").remove();   
    });
    // コンテナを作成
    $(document).on("click", "#container-regist-btn", registUserContainer);
});

function itemRegist2Confirm(eo) {
    if (!$('#regist-ok').hasClass('regist-disable')) {
        $("#item-register-form").attr("action", baseUrl + consUrlJs.itemRegistActionPath);
        $("#item-register-form").submit();
    }
    return;
}

function brandValidate() {
    if ($('#brandname').val() == "") {
        var errorMessage = '<p id="brand-error" class="regist-error">ブランド名は必須項目です</p>'; 
        $(errorMessage).appendTo('#brand-wrap');
    } else {
        $('#brand-error').remove();
    }
    checkRequire(); 
}

function descriptionValidate() {
    checkRequire(); 
}

// 画像選択時の発火関数
function setImgTrigger(eo) {
    $("#file-image").trigger("click");
}

// 画像選択時のファイル取得
function changeImgFile(eo) {
    var file = validFiles(this.files);
    if (!file) {
        return;
    }
    setResizeImage(file);
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

// 画像のバリデーション
// OKならfileオブジェクトを返す
// NGならfalseを返す
function validFiles(files) {
    // エラーメッセージ初期化
    var errorMsg = "";
    $("#pict-error").remove();

    // ファイルが空かどうか
    if (!files.length) {
        return false;
    }
    var file = files[0];
    // ファイルサイズが規定値を超えてないか
    if (file.size > MAX_FILE_SIZE) {
        errorMsg = '<p id="pict-error" class="regist-error">2MB以内のファイルを選択して下さい</p>'
        $("#img-uploader").after(errorMsg);
        return false;
    }
    // jpg,png以外の画像が選択されてないか
    if (file.type != "image/jpeg" && file.type != "image/png") {
        errorMsg = '<p id="pict-error" class="regist-error">jpg,png画像を選択して下さい</p>'
        $("#img-uploader").after(errorMsg);
        return false;
    }
    return file;
}

// 画像リサイズ及びデータ化
function setResizeImage(file) {
    // 前回表示している画像があれば消す
    $("canvas").remove();

    // mimeTypeを取っておく
    var mimeType = file.type;

    // FileReaderインスタンスを生成
    var fr = new FileReader();

    // FileReader発火時の処理
    fr.onload = function(file_eo) {
        // canvasを生成
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        // 空のImageオブジェクトをインスタンス化
        var image = new Image();
        // FileReaderで読み込んだ結果をbase64でsrc属性に突っ込む
        image.src = file_eo.target.result;

        // 画像リサイズ処理
        image.onload = function(event){
            var dstWidth = this.width;  //現幅
            var dstHeight = this.height; //現高さ

            // 幅か高さが指定サイズを超えていたら、リサイズ処理発生
            if (this.width > MIN_SIZE || this.height > MIN_SIZE) {
                if (this.width > this.height) {
                    dstWidth = MIN_SIZE;
                    dstHeight = this.height * MIN_SIZE / this.width;
                } else {
                    dstHeight = MIN_SIZE;
                    dstWidth = this.width * MIN_SIZE / this.height;
                }

            }
            // canvasの幅と高さ確定
            canvas.width = dstWidth;
            canvas.height = dstHeight;
            // canvas描画
            ctx.drawImage(this, 0, 0, this.width, this.height, 0, 0, dstWidth, dstHeight);
            // リサイズ後の画像DataURLを取得
            var dataUrl = canvas.toDataURL(mimeType);
            // huddenタグにdataURLを突っ込む
            $("#pict-data-url").val(dataUrl);
            // hiddenタグにmimeTypeを突っ込む
            $("#pict-mimetype").val(mimeType);
            // canvas生成
            $("#thumb-area").after(canvas);
        };
    }
    // FileReader発火
    fr.readAsDataURL(file);
}

// 入力チェック
function checkRequire() {
    console.log("check!");
    if ($('#brand-id').val() && $('#file-image').val() && $("#itemname").val() && 
        $('#categoryselect').val() && $('#genreselect').val()) {
        console.log('active!!');
        $('#regist-ok').toggleClass();
    } else if (!$('#regist-ok').hasClass('regist-disable')) {
        $('#regist-ok').toggleClass();
    }
}

function registUserContainer(eo) {
    $("#make_container_error").remove();
    if ($("#make_container").val() == "") {
        errorMsg = '<p id="make_container_error" class="regist-error">コンテナ名を入力して下さい</p>'
        $("#make_container").after(errorMsg);
        return;
    }
    var containerName = $("#make_container").val();
    var url = baseUrl + consUrlJs.userContainerRegistPath;
    $.post(url, {MakeContainer : containerName}, function(data, httpStatus) {
        console.log(data);
        $("#containerselect").append(function() {
            return $("<option>").val(data.id).text(data.name);   
        });
        $('#containerselect option[value="' + data.id + '"]').attr("selected", "selected");
        $("#toggle-make_container").css("display", "none");
    });
}
