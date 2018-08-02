
var smsSend = function(smsBtnElement, valElement, url) {
    $(smsBtnElement).on("click", function(eo) {
        var phone_num = $(valElement).val(); 
        if (typeof phone_num === "undefined" || phone_num =="") {
            alert("電話番号を入力してください");
            return;
        }
        $.post(url, {"phone" : phone_num}, function(data, status) {
            
        });
    });
}
