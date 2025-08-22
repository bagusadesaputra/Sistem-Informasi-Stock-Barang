 (function ($) {
    "use strict";

    /* ===== FUNGSI: Tambahkan class "active" di sidebar nav link sesuai URL aktif ===== */
    var path = window.location.href; 
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    /* ===== FUNGSI: Toggle sidebar navigation ===== */
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

})(jQuery);