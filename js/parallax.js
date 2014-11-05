function isScrolledIntoView(e) {
    var t = $(window).scrollTop();
    var n = t + $(window).height();
    var r = $(e).offset().top;
    var i = r + $(e).height();
    return i <= n && r >= t
}
function update() {
    var e = $window.scrollTop();
    if ($device == "desktop") {
        $("#blog").each(function () {
            var t = $(this);
            var n = t.width() / 25;
            $(this).css("backgroundPosition", "center " + "-" + Math.round((n + e) * velocity) + "px")
        });
        $("#portfolio").each(function () {
            var t = $(this);
            var n = t.width() / 25;
            $(this).css("backgroundPosition", "center " + "-" + Math.round((n + e) * velocity) + "px")
        });
        $("#contact").each(function () {
            var t = $(this);
            var n = t.width() / 25;
            $(this).css("backgroundPosition", "center " + "-" + Math.round((n + e) * velocity) + "px")
        })
    }
    if($device == "desktop")
        if($(document).scrollTop() > window.innerHeight)
            $(".navigation a").stop().animate({
                "color" : "#0c0c0c"
            }, 600);
        else
            $(".navigation a").stop().animate({
                "color" : "#fff"
            }, 600);
    else
        if($(document).scrollTop() > (window.innerHeight - ((window.innerHeight / 100) * 60)))
            $(".navigation a").stop().animate({
                "color" : "#0c0c0c"
            }, 600);
        else
            $(".navigation a").stop().animate({
                "color" : "#fff"
            }, 600);
}
var $window = $(window);
var velocity = .4;
$window.bind("scroll", update);