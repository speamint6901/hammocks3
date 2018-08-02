// listオブジェクト
var UserAuth = function() {
};

UserAuth.keyDownFunc = function(eo) {
    var _this = this;
    var funcName = eo.target.id + "Func";
    setTimeout(function() {
        UserAuth[funcName](eo);
    }, 100);
}

UserAuth.nameFunc = function(eo) {
};

var SignUp = function() {
};

SignUp.prototype = Object.create(UserAuth.prototype, {value: {constructor: SignUp}});

SignUp.prototype.params = {
    name : "",
    email : "",
    password : "",
    password_confirmation : "",
    agree : ""
};

SignUp.prototype.eventTypes = {
    name : ["keyDown", "paste", "focusout"],
    email : ["keyDown", "paste", "focusout"],
    password : ["keyDown", "paste", "focusout"],
    password_confirmation : ["keyDown", "paste", "focusout"],
    agree : ["click"]
};

SignUp.prototype.init = function() {
    console.log("signup init");
    this.addFormEventListner();
};

SignUp.prototype.addFormEventListner = function() {
    $(document).on("click", "#agree", function(eo) {
        var btnElement = $("#submit");
        var facebookBtn = $("#facebook_btn");
        var twitterBtn = $("#twitter_btn");
        console.log(btnElement);
        var checkedElem = eo.target.id + ":checked";
        if ($("#agree:checked").val()) {
            btnElement.removeClass("disable-b");
            facebookBtn.removeClass("disable-b");
            twitterBtn.removeClass("disable-b");
        } else {
            btnElement.addClass("disable-b");
            facebookBtn.addClass("disable-b");
            twitterBtn.addClass("disable-b");
        }
    });
};

SignUp.prototype.formEventDetail = function(n) {
    
}

//Login.prototype = Object.create(UserAuth.prototype, {value: {constructor: Login}});

