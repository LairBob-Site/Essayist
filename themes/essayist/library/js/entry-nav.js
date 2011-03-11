// function lockSectionNav() {
jQuery(document).ready(function ($) {
    // $(primary).css('top', $(section-01).offset().top);
    // var primaryTop = jQuery(document).(primary);
    $('#primary').localScroll();
    // alert("Here");

    $(window).scroll(function(){
        var objectTop = $('#primary').offset().top;
        var contentTop = $('#content').offset().top;
        var objectHeight = $('#primary').outerHeight();
        var windowScrollTop = $(window).scrollTop();
        var windowHeight = $(window).height();

        if  (windowScrollTop  > contentTop)
            $('#primary').css('top', windowScrollTop );
        else $('#primary').css('top', contentTop );
        // else if ((windowScrollTop+windowHeight) < (objectTop + objectHeight))
            // $('#primary').css('top', (windowScrollTop+windowHeight) - objectHeight);

        // $('#primary').html('Top: ' + $('#primary').position().top + 'px');

    });
})

// }
