var baseUrl = getDomain();
$(document).ready(function () {

    // コンテナ新規登録ゾーン表示
    $(document).on("click", "#create_container", function() {
        $("#create_container_zone").show();
    });

    // モーダルオープン
    $(document).on("click", "#container_open", function() {
        $('#tmp_list_3').empty();
        // メインビューから記事IDを引き継ぐ
        var article_id = $(this).attr("data-article-id");
        $("#target_article_id").val(article_id);
        console.log(article_id);
        // ページング無しのリスト表示
        var list = new List("#tmp_list_3", {
            url : getDomain() + consUrlJs.listPath[3],
            method : "post",
            templete_id : 3,
            isPaging : 0,
            listLoadedFlag : 1,
            is_selfuser : 1,
            is_container_owner : 1,
            container_list_type : 1
        });
        list.get();
    });

    $(document).on("click", "#add_new_container_btn", function(eo) {
        $("#make_container_error").remove();
        if ($("#add_container").val() == "") {
            console.log("error_container_add");
            errorMsg = '<p id="make_container_error" class="regist-error">コンテナ名を入力して下さい</p>'
            $(".input_text").after(errorMsg);
            return;
        }
        var containerName = $("#add_container").val();
        var url = baseUrl + consUrlJs.userContainerRegistPath;
        $.post(url, {MakeContainer : containerName}, function(data, httpStatus) {
            if (data.message !== undefined) {
                alert(data.message);
                return;
            }
            console.log(data);
            alert("コンテナを作成しました");
            $("#add_container").val("");
            $("#create_container_zone").hide();
            $("#tmp_list_3").empty();
            var list = new List("#tmp_list_3", {
                url : getDomain() + consUrlJs.listPath[3],
                method : "post",
                templete_id : 3,
                isPaging : 0,
                listLoadedFlag : 1,
                is_selfuser : 1,
                is_container_owner : 1,
                container_list_type : 1
            });
            list.get();
            //showContainerList(0, data);
        });
    });

    // コンテナを削除する
    $(document).on("click", ".container_del", function(eo) {
        if (!confirm("コンテナを削除します\nよろしいですか？")) {
            return true;
        }
        var params = {};
        params['container_id'] = $(this).attr("data-target-container");
        var url = baseUrl + consUrlJs.containerDeleteSendPath;
        if (params['container_id'] === undefined) {
            alert("コンテナが見つかりません");
        }
        var parentElement = $(this).parent();
        $.post(url, params, function(data, status) {
            if (data.message !== undefined) {
                alert(data.message);
                return;
            }
            alert("コンテナを削除しました");
            parentElement.remove();
        });
    });

    // コンテナのロック
    var toggle_click_flag = 1;
 $(document).on("click", ".triangle", function(eo) {
        if (toggle_click_flag) {
            toggle_click_flag = 0;
            var params = {};
            params['container_id'] = $(this).attr("data-target-container");

            var currentClassName = "unlock";
            var afterClassName = "lock";
            params['status'] = 0;
            if ($(this).hasClass("lock")) {
                params['status'] = 1;
                currentClassName = "lock";
                afterClassName = "unlock";
            }
            var url = baseUrl + consUrlJs.containerLockSendPath;
            if (params['container_id'] === undefined) {
                alert("コンテナが見つかりません");
                toggle_click_flag = 1;
            }
            var _this = this;
            $.post(url, params, function(data, satatus) {
                console.log(data);
                $(_this).removeClass(currentClassName);
                $(_this).addClass(afterClassName);
                toggle_click_flag = 1;
            });
        }
    });

    // ログをpickする
    $(document).on("click", ".addPick", function(eo) {
        var params = {};
        params['container_id'] = $(this).attr("data-target-container");
        console.log(params);
        params['article_id'] = $("#target_article_id").val();
        var url = baseUrl + consUrlJs.addPickToContainerPath;
        $.post(url, params, function(data, status) {
            console.log(data.article);
            if (data.article !== undefined) {
                $("#clip_icon_img_" + data.article.id).attr("src", baseUrl + "/images/ico-pick-on.svg");
            }
            alert(data.message);
        });
    });

    // コンテナ中のログ削除
    $(document).on("click", "#deleteContainersLog", function(eo) {
        var article_id = $(this).attr("data-article_id");
        var container_id = $("#container_id").val();
        var url = baseUrl + consUrlJs.delContainerLogPath;
        var targetElement = $(this).parent();
        $.post(url, {"article_id" : article_id, "container_id" : container_id }, function(data, status) {
            if (data.message !== undefined) {
                alert(data.message);
                return;
            }
            targetElement.remove();
        });
    });

    // コンテナ編集保存
    $(document).on("click", "#container_save_btn", function(eo) {
        var url = baseUrl + consUrlJs.containerEditSavePath;
        var params = {};
        params["container_id"] = $("#container_id").val();
        params["name"] = $("#container_name_val").val();
        var checkFlag = $("#toggle_container_status:checked").val();
        if (checkFlag === undefined) {
            checkFlag = 0;
        }
        params["status"] = checkFlag;
        $.post(url, params, function(data, status) {
            console.log(data);
            $("#container_name_val").val(data.name);
            if (data.status) {
                $("#toggle_container_status:checked").attr("checked", "checked");
            } else {
                $("#toggle_container_status:checked").attr("checked", "");
            }
        });
    });

});
