const MAX_FILE_SIZE = 2097152;
const MIN_SIZE = 500;
var baseUrl = getDomain();
var uploaderUrl = baseUrl + consUrlJs.uploaderPath;
var removeUrl = baseUrl + consUrlJs.imageRemoveUrl;
var addedFlag = 0;

 var myAwesomeDropzone = function(mainContainer, previewContainer, uploadType, maxFileNum) {
  Dropzone.autoDiscover = false;

  var dropzoneOptions = {
   url: uploaderUrl,
   paramName : "file",
   parallelUploads:1,
   acceptedFiles:'image/*', // 画像ファイルのみ
   maxFiles:maxFileNum,
   maxFilesize:2,
   dictFileTooBig: "ファイルが大きすぎます。 ({{filesize}}MiB). 最大サイズ: {{maxFilesize}}MiB.",
   dictInvalidFileType: "画像ファイルを選択してください。",
   dictMaxFilesExceeded: "一度にアップロード出来るのは" + maxFileNum + "ファイルまでです。",
   dictDefaultMessage: "画像を選択",
   dictRemoveFile: "削除",
   addRemoveLinks: true,
   uploadMultiple: false,
   autoProcessQueue: false,
   previewsContainer:  previewContainer,
   addedCount:0,
   init: function() {
        this.on("maxfilesreached", function(file) {
            this.disable();
        });
   },
   accept: function(file, done) {
       // 前回表示している画像があれば消す
       $("canvas").remove();
       $("#thumb-area").empty();
       if (maxFileNum > 1 && addedFlag == 1) {
            $(mainContainer).removeClass("dropzone");
       }
       // mimeTypeを取っておく
       var mimeType = file.type;

       // FileReaderインスタンスを生成
       var fr = new FileReader();
       // FileReader発火時の処理
       //fr.onload = function(file_eo) {
       console.log(uploaderUrl);
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
                var file_name = file.name.split(".");
                var file_name_key = file_name[0];
                var id = $("#multi_id").val();
                if (typeof id === "undefined") {
                    id = 1;
                }
                $.ajax({
                    method: "POST",
                    url: uploaderUrl,
                    data: {"file_name":file_name_key, "data_url":dataUrl, "mime_type":mimeType, "id":id, "cache_key":uploadType},
                    success: function(data, dataType) {
                        console.log(data);
                        if (data.message !== undefined) {
                            alert(data.message);
                            return;
                        }
                        addedFlag = 1;
                    }
                });
            };
        };
        // FileReader発火
        fr.readAsDataURL(file);
        return done();
   },
   removedfile: function(file) {
       console.log("parent!");
       var file_name = file.name.split(".");
       var file_name_key = file_name[0];
       var id = $("#multi_id").val();
       console.log(id);
       if (typeof id === "undefined" || id == "") {
           id = 1;
       }
       console.log(uploadType);
       $.ajax({
            method: "POST",
            url: removeUrl,
            data: {file_name : file_name_key, "id" : id, "cache_key" : uploadType},
            success: function(data, dataType) {
                console.log(data);
                if (data.message !== undefined) {
                    alert(data.message);
                    return;
                }
                var _ref;
                if (file.previewElement) {
                  if ((_ref = file.previewElement) != null) {
                    _ref.parentNode.removeChild(file.previewElement);
                  }
                }
            }
       });
       this.enable();
   },
   drop: function(e) {
       this.element.classList.remove("selected");
   },
   dragover: function(e) {
    this.element.classList.add("selected");
   },
   dragleave: function(e) {
    this.element.classList.remove("selected");
   },
   error: function(file, message) {
       if (this.maxFiles > 1) {
           alert(message);
       }
    //this.removeFile(this.files[0]);
   }
  };

  myDropzone = new Dropzone(mainContainer, dropzoneOptions);
  return myDropzone;
 }

// urlスクレイピング
function urlSlapeFunc(eo) {
    var postUrl = baseUrl + consUrlJs.urlSlapeAction;
    var params = {url : $("#pict-select-url").val() };
    $.post(postUrl, params, dispModalImageListFunc);
}

// webスクレイピング画像の選択
function selectWebImageFunc(eo) {
    var imgUrl = $(eo.target).attr('src');
    $("#pict_result_img").val(imgUrl);
    $("#pict_result_disp_img").attr('src', imgUrl);
    $(".pict_result_disp").css("display", "block");
    // アップロード側の画像を空にする
    $("#pict-data-url").val("");
    // アップロード側のmimetypeを空にする
    $("#pict-mimetype").val("");
    checkRequire();
}

// スクイピングした画像のモーダル表示
function dispModalImageListFunc(data, httpStatus) {
    $("#modal_pict_select_url_list").empty();
    if (Object.keys(data).length > 0) {
        var html = "<ul>";
        $.each(data, function(key, value) {
            html += '<li><img data-remodal-action="confirm" class="web_pict_img" src="' + value + '"></li>';
        });
        html += "<ul>";
        $("#modal_pict_select_url_list").append(html);
    }
}

// 画像選択時の発火関数
function setImgTrigger(eo) {
    console.log("trigger");
    $("#file-image").trigger("click");
}

// 画像選択時のファイル取得
function changeImgFile(eo) {
    console.log(this.files);
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
    console.log(files);
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
    $("#thumb-area").empty();
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
            // webスクレイピング側の画像を空にする
            $("#pict_result_img").val("");
            // canvas生成
            $("#thumb-area").after(canvas);
            checkRequire();
        };
    }
    // FileReader発火
    fr.readAsDataURL(file);
}

// 画像リサイズ及びデータ化(セールアイテム）
function setResizeSaleImage(file) {
    // 前回表示している画像があれば消す
    $("canvas").remove();
    $("#thumb-area").empty();
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
            fr.result = dataUrl;
            //return {"dataUrl":dataUrl, "mimeType":mimeType};
            // huddenタグにdataURLを突っ込む
            $("#pict-data-url").val(dataUrl);
            // hiddenタグにmimeTypeを突っ込む
            $("#pict-mimetype").val(mimeType);
            // webスクレイピング側の画像を空にする
            //$("#my-preview-dropzone").after(canvas);
        };
        //return fr.result;
    }
    // FileReader発火
    fr.readAsDataURL(file);
    return fr;
}
