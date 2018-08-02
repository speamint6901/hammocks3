var baseUrl = getDomain();
var smsSendUrl = baseUrl + consUrlJs.smsSendPath;

$(document).ready(function () {

    smsSend("#smsSend", "#phone_num", smsSendUrl);

});
