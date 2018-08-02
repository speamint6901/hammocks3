var baseUrl = getDomain();

$(document).ready(function () {

    $(document).on("click", "#logEditBtn", function(eo) {
        $("#item-description").val("");
        var article_id = $(eo.target).parent().attr("data-article-id");
        $("#logEditArticleId").val(article_id);
        // ログの記事をコメント編集フォームに反映する
        var article_text = $("#article_text_" + article_id).html();
        $("#item-description").val(article_text);
    });

    // ログ編集送信
    $(document).on("click", "#logEditSendBtn", function(eo) {
        var url = baseUrl + consUrlJs.logEditSendPath;
        var params = {};
        params["article_text"] = $('#item-description').val();
        console.log(params["article_text"]);
        params["article_id"] = $("#logEditArticleId").val();
        if (!params["article_text"]) {
            alert("本文が入力されていない為、更新出来ませんでした");  
            return;
        }

        if (params["article_text"].length > 5000) {
            alert("5000文字以内で入力して下さい");
            return;
        }

        $.post(url, params, function(data, status) {
            if (data.message !== undefined) {
                alert(data.message);    
                return;
            }
            $("#article_text_" + data.id).html(data.article_text);
            alert("ログを更新しました");
        });
    });

    // ログ削除
    $(document).on("click", "#deleteLogLink", function(eo) {
        if (!confirm("ログを削除します\nよろしいですか？")) {
            return false;
        }
        return;
        var url = baseUrl + consUrlJs.logDeleteSendPath;
        var params = {};
        params["article_id"] = $("#logEditArticleId").val();
        if (params["article_id"] === undefined) {
            params["article_id"] = $(this).attr("data-article_id");
        }
        $.post(url, params, function(data, status) {
            console.log(data);
            if (!data.status && data.message !== undefined) {
                alert(data.message);
                return;
            }
            //$("#timeline_warp_" + data.article_id).remove();
            alert("ログを削除しました");
            location.reload();
        });
    });

});
