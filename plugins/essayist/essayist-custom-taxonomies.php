<?php

add_action('init', 'subjects_register');
add_action('init', 'themes_register');

function subjects_register() {
    register_taxonomy(
            "subjects",
            "post",
            array(
                "hierarchical" => true,
                "label" => "Subjects",
                "singular_label" => "Subject",
                "rewrite" => true,
                "show_ui" => true)
    );
}

function themes_register() {
    register_taxonomy(
            "themes",
            "post",
            array(
                "hierarchical" => true,
                "label" => "Themes",
                "singular_label" => "Theme",
                "rewrite" => true,
                "show_ui" => true)
    );
}

?>