
var validation = new Object();

validation = {
    isValid : true,
    fields : {},
    fieldName : "",
    fieldValue : "",
    validName : "",
    validRule : {},
    validErrorStock : {},
    init : function() {
        fieldName = "";
        fieldValue = "";
        validName = "";
        validRule = {};
        validErrorStock = {};
    },
    valid : function(fieldName, value) {
        this.fieldName = fieldName;
        this.fieldValue = value;
        this.validErrorStock[fieldName] = true;
        if (this.fields[fieldName] === undefined) {
            return;
        }
        $.each(this.fields[fieldName], function(validName, validRule) {
            validation.validName = validName;
            validation.validRule = validRule;
            if ( ! validation.doValid()) {
                validation.validErrorStock[validation.fieldName] = false;
                validation.isValid = false;
            }
        });
    },
    doValid : function() {
        if ( ! this.validErrorStock[this.fieldName]) {
            return false;
        }
        var label = $("#" + this.fieldName + "_label").html();
        var errorId = "#" + this.fieldName + "_error";
        $(errorId).html("");
        if (this.validName == "require") {
            if ( ! this.require(this.fieldValue)) {
                $(errorId).html(label + "は必須項目です");
                return false;
            }
        }
        if (this.validName == "email") {
            if ( ! this.email(this.fieldValue)) {
                $(errorId).html(label + "の形式に誤りがあります。");
                return false;
            }
        }
        if (this.validName == "max") {
            if (this.fieldValue.length > this.validRule) {
                $(errorId).html(label + "は" + this.validRule + "文字以下で入力して下さい");
                return false;
            }
        }
        return true;
    },
    email : function(data) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(data);
    },
    require : function(data) {
        if (data == "" || data === undefined) {
            return false;
        }
        return true;
    }
};
