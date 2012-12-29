<?php

add_shortcode('html-inc', 'htmlInclude');

function htmlInclude($atts) {
    extract(shortcode_atts(array(
                "incfile" => 'test.html',
                "incdir" => 'test',
                    ), $atts));

    // TODO Add error-checking to filepath / filepath strings
    // $strIncFileName = dirname(__FILE__) . '/includes/' . $incdir . '/' . $incfile;
    $strIncFileName = 'http://lairbob.com/essays-html/' . $incdir . '/' . $incfile;

    $strIncFile = file_get_contents($strIncFileName);

    // Apply any other shortcodes that are embedded within the content
    $strIncFile = do_shortcode($strIncFile);
    // $strIncFile = wpautop($strIncFile);

    // Explode the include string into an array of individual lines
    $expIncFile = explode("\n", $strIncFile);

    // Reassemble the array of lines back into a single string, eventually applying custom logic
    $outIncFile = "";
    for ($i = 0; $i < count($expIncFile); $i++) {
        $outIncFile = $outIncFile . "\n" . $expIncFile[$i]; //write value by index
    }

    return $outIncFile;
}

?>