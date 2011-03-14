jQuery(document).ready(function ($) {
    $('#primary').localScroll( {
        duration: 500,
        easing: 'easeOutExpo'
    } );

    $('.nav-section-label').click(function() {
        var destAnchor = "#" + $(this).attr("dest");

        $.scrollTo(
            destAnchor,
            750,
            { easing: 'easeOutQuint',
              offset: -50
            }
        );
    })

    var offNav = $('#primary').offset();
    var offMenu = $('#menu-all-navigation').offset();

    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop(); // check the visible top of the browser

        // The number subtracted here will be the amount that the nav widget is positioned down from the top of the window
        // It needs to match the 'top' value defined in the corresponding 'fixed-nav' CSS style
        if ((offNav.top - 50) <scrollTop) {
            $('#primary').addClass('fixed-nav');
        } else $('#primary').removeClass('fixed-nav');

        if ((offMenu.top - 0) <scrollTop) {
            $('#menu-all-navigation').addClass('fixed-menu');
        } else $('#menu-all-navigation').removeClass('fixed-menu');

    });
})