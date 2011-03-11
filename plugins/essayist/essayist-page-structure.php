<?php

if (!is_admin()) { // instruction to only load if it is not the admin area
    // register your script location, dependencies and version
    wp_register_script('navHandlers',
            get_stylesheet_directory_uri() . '/library/js/entry-nav.js',
            array('jquery')
    );
    wp_register_script('easing',
            get_stylesheet_directory_uri() . '/library/js/jquery.easing.1.3.js',
            array('jquery')
    );
    wp_register_script('scrollTo',
            get_stylesheet_directory_uri() . '/library/js/jquery.scrollTo.js',
            array('jquery', 'easing')
    );
    wp_register_script('localScroll',
            get_stylesheet_directory_uri() . '/library/js/jquery.localscroll.js',
            array('scrollTo')
    );
    // enqueue the script
    wp_enqueue_script('easing');
    wp_enqueue_script('scrollTo');
    wp_enqueue_script('localScroll');
    wp_enqueue_script('navHandlers');
}

// TODO: Find a way to suppress the title output altogether -- this approach still outputs an empty div into the page
function stripTitle($text) {
    return '';
}

?>
