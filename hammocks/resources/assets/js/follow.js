var storage_path = getStoragePath();
var baseUrl = getDomain();
var apiUrl = baseUrl + consUrlJs.followActionPath;
var ajaxPost = {};
var flag = true;

$(document).ready(function () {
   $(document).on("click", "#follow_btn", toggleFollowFunc);
});

var toggleFollowFunc = function(e) {
    if (flag) {
        flag = false;
        var users_id = getUsersId();
        ajaxPost = $.post(apiUrl, {"users_id" : users_id});
        ajaxPost.done(function(data, httpStatus) {
            if ($("#follow_btn").hasClass("unfollow")) {
                $("#follow_btn").html("follow");
            } else {
                $("#follow_btn").html("unfollow");
            }
            $("#follow_btn").toggleClass('unfollow');
            $("#follower_count_area").html(data.user_follower_count);
            flag = true;
        });
    }
};
