<?php

/*
  Plugin Name: Essayist
  Plugin URI: http://lairbob.com
  Description: Plugin for constructing essays out of modular components
  Author: Laurent R.O. Stanevich
  Version: 0.0.1
  Author URI: http://lairbob.com
 */

// Custom taxonomies need to be registered first, so that the custom objects can be linked to them later
include_once dirname(__FILE__) . '/essayist-custom-taxonomies.php';

include_once dirname(__FILE__) . '/essayist-cp-citation.php';
include_once dirname(__FILE__) . '/essayist-cp-data-point.php';

function signOffText() {
    return 'Thank you so much for reading! And remember to subscribe to our RSS feed. ';
}

function findNote() {
    $args = array(
        'relationship' => 'AND',
        'post_type' => 'notes',
        'tax_query' => array(
            'taxonomy' => 'sidebars',
            'field' => 'title',
            'terms' => 'epidemiology',
            'operator' => 'IN'
        )
    );

    $myposts = get_posts($args);

    $outString = '<ul>';

    foreach ($myposts as $post) :
        $outString .= '<li>' . $post->post_title . '</li>';
    endforeach;
    $outString .= '</ul>';

    return $outString;
}

add_shortcode('signoff', 'signOffText');

add_shortcode('notes', 'findNote');
?>