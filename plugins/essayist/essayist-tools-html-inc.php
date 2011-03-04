<?php

add_shortcode('html-inc', 'htmlInclude');

function htmlInclude($atts) {
    extract(shortcode_atts(array(
        "incfile" => 'test.html',
         "incdir" => 'test',
     ), $atts));

    // TODO Add error-checking to filepath / filepath strings
    $strIncFile = dirname(__FILE__) . '/includes/' . $incdir . '/' . $incfile;

    return file_get_contents($strIncFile);
}

?>