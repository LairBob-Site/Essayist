// function lockSectionNav() {
jQuery(document).ready(function ($) {
    // $(primary).css('top', $(section-01).offset().top);
    // var primaryTop = jQuery(document).(primary);
    $('#primary').localScroll();
    // alert("Here");

    var offset = $('#primary').offset();

    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop(); // check the visible top of the browser

        if (offset.top<scrollTop) $('#primary').addClass('fixed-nav');
        else $('#primary').removeClass('fixed-nav');
    });
})

// }
