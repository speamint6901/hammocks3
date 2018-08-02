var scrollflag = 1;
// ページング処理
var doSomething = function() {
    var defer = $.Deferred();
    $(window).on("scroll", function() {
        var offset = $("#page").val();
        if (offset != "max") {
            var scrollHeight = $(document).height();
            var scrollPosition = $(window).height() + $(window).scrollTop();
            if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
                getItemListFunc(offset);
                $("#card_flex").on("drow", function() {
                    defer.resolve();
                });
            }
        }
    });
    return defer.promise();
}

// フラグが落ちてるとイベントが発火しない
$(function() {
    if (scrollflag) {
        scrollflag = 0;
        var promise = doSomething();
        promise.done(function() {
            scrollflag = 1;
        });
    }
});
