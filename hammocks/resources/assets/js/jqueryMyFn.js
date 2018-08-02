(function($) {
$.fn.extend({
    enable_action_flag : 1,
    get_enable_action : function() {
        return this.enable_action;
    },
    enable_onload_for_images: function() {
        var deferred = new $.Deferred();
        var div = this[0];
        var imgs = this.find("img.img_resize");
        if (imgs.length == 0) {
            imgs = this.find("img.no_resize");
        }
        var count = imgs.length;
        if (count==0 && div.onload) div.onload.call(div, count);
        var loaded = 0;
        var _this = this;
        imgs.one("load", function (e) {
            // イメージが読み込まれた
            loaded++;
            if (loaded === count) {// && div.onload) {
                deferred.resolve();
                _this.enable_action = 1;
                //div.onload.call(div, count);
            }
        }).each(function () {
            if ($(this).hasClass("img_resize")) {
                $(this).resizeOne(); 
            }
            if ( this.complete || this.readyState === 4) { 
                $(this).load();
            }
        });
        return deferred.promise();
    },
    all_loaded : function () {
        var div = this[0];
        var img = this.find("img.img_resize");       
        var all_done = new Array();
        img.each(function (i, img) {
            var promise = new $.Deferred();
            all_done[i] = promise;
            $(this).resizeOne();
            img.onload = function () {
                promise.resolve();
            }
        });
        return $.when.apply(null, all_done);
    },
});
})(jQuery);
