import 'flowbite';


$(document).ready(function() {
    $(document).scroll(function () {
        var scroll = $(this).scrollTop();
        var topDist = $("#container").position();
        if (scroll > topDist.top) {
        $('nav').css({
            "position": "fixed",
            "width": "100%",
            "opacity": "1", // Tambahkan opacity untuk fade-in
        }).fadeIn(); // Fade-in tetap diaktifkan untuk smooth transition
    } else {
        $('nav').css({
            "position": "static",
            "width": "100%",
            "opacity": "0.7", // Berikan efek semi-transparan saat static
        });
    }
    });
})
