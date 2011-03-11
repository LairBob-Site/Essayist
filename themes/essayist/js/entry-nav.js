// function lockSectionNav() {
jQuery(document).ready(function ($) {
    // $(primary).css('top', $(section-01).offset().top);
    // var primaryTop = jQuery(document).(primary);
    $('#primary').localScroll();
    alert("Here");

    $(window).scroll(function(){
        var objectTop = $('#primary').position().top;
        var contentTop = $('.entry-content').position().top;
        var objectHeight = $('#primary').outerHeight();
        var windowScrollTop = $(window).scrollTop();
        var windowHeight = $(window).height();

        if  (windowScrollTop  > objectTop)
            $('#primary').css('top', windowScrollTop );
        else if ((windowScrollTop+windowHeight) < (objectTop + objectHeight))
            $('#primary').css('top', (windowScrollTop+windowHeight) - objectHeight);

        // $('#primary').html('Top: ' + $('#primary').position().top + 'px');

    });
})

// }
