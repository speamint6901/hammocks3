var btnFlag = 1;
// ページング処理
var doSomething = function() {
    var defer = $.Deferred();
    $(document).on("click", "#loading_btn", function(eo) {
        $("#loading_btn").hide();
        var page = $("#page").val();
        if (page != "max") {
            getItemListFunc();
            $("#card_flex").on("drow", function(eo) {
                defer.resolve();
            });
        }
    });
    return defer.promise();
}

// フラグが落ちてるとイベントが発火しない
$(function() {
    if (btnFlag) {
        btnFlag = 0;
        var promise = doSomething();
        promise.done(function() {
            btnFlag = 1;
            if (page != "max") {
                $("#loading_btn").show();
            }
        });
    }
});
