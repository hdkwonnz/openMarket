$(window).on(function () {
    $(".my_loader").fadeOut("slow");
});
! function (a)
{
    jQuery(window).bind("unload", function () { }), a(document).ready(function () {
        a(".my_loader").hide(), a("form").on("submit", function () {
            a("form").validate(), a("form").valid() ? (a(".my_loader").show(), a("form").valid() || a(".my_loader").hide()) : a(".my_loader").hide()
        }), a('a:not([href^="#"])').on("click", function () {
            "" != a(this).attr("href") && a(".my_loader").show(), a(this).is('[href*="Download"]') && a(".my_loader").hide()
        }), a("a:not([href])").click(function () {
            a(".my_loader").hide()
        }), a('a[href*="javascript:void(0)"]').click(function () {
            a(".my_loader").hide()
        }), a(".export").click(function () {
            setTimeout(function () {
                a(".my_loader").fadeOut("fast")
            }, 1e3)
        })
    })
}(jQuery);
