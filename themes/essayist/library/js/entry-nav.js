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
            { easing: 'easeOutQuint'}
        );
    })

    var offNav = $('#primary').offset();
    var offContent = $('#entry-content').offset();

    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop(); // check the visible top of the browser

        if (offNav.top<scrollTop) {
            // $('#primary').css( {top : offContent.top} );
            $('#primary').addClass('fixed-nav');
        } else $('#primary').removeClass('fixed-nav');
    });
})