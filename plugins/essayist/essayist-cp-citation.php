<?php

// INIT ROUTINES -- test
add_action('init', 'citations_register');

function citations_register() {
    $labels = array(
        'name' => _x('Citations', 'post type general name'),
        'singular_name' => _x('Citation', 'post type singular name'),
        'add_new' => _x('Add New', 'citations'),
        'add_new_item' => __('Add New Citation'),
        'edit_item' => __('Edit Citation'),
        'new_item' => __('New Citation'),
        'view_item' => __('View Citation'),
        'search_items' => __('Search Citations'),
        'not_found' => __('No citations found'),
        'not_found_in_trash' => __('No citations found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt')
    );

    register_post_type('citations', $args);
    register_taxonomy_for_object_type('subjects', 'citations');
    register_taxonomy_for_object_type('themes', 'citations');
}


add_action('admin_init', 'admin_init_citations');
function admin_init_citations() {
    add_meta_box("citation_source-meta", "Source Info", "citation_source", "citations", "side", "high");
}

function citation_source() {
    global $post;

    $custom = get_post_custom($post->ID);
    $source_author = $custom["source_author"][0];
    $source_name = $custom["source_name"][0];
    $source_url = $custom["source_url"][0];
?>
    <label>Author</label>
    <input name="source_author" value="<?php echo $source_author; ?>" /><br/>
    <label>Source</label>
    <input name="source_name" value="<?php echo $source_name; ?>" /><br/>
    <label>Link</label>
    <input name="source_url" value="<?php echo $source_url; ?>" /><br/>
<?php
}

add_action('save_post', 'citation_save');
function citation_save() {
    global $post;

    update_post_meta($post->ID, "source_author", $_POST["source_author"]);
    update_post_meta($post->ID, "source_name", $_POST["source_name"]);
    update_post_meta($post->ID, "source_url", $_POST["source_url"]);
}

add_filter("manage_edit-citations_columns", "citation_edit_columns");
function citation_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Citation Title",
        "description" => "Description",
        "source_author" => "Author",
        "source_name" => "Source",
        
        "themes" => "Themes",
        "subjects" => "Subjects"
    );

    return($columns);
}

add_action("manage_citations_posts_custom_column", "citation_custom_columns");
function citation_custom_columns($column) {
    global $post;

    $custom = get_post_custom();

    switch ($column) {
        case "description":
            the_excerpt();
            break;
        case "source_name":
            echo $custom["source_name"][0];
            break;
        case "source_author":
            echo $custom["source_author"][0];
            break;



        case "themes":
            echo get_the_term_list($post->ID, 'themes', '', ', ', '');
            break;
        case "subjects":
            echo get_the_term_list($post->ID, 'subjects', '', ', ', '');
            break;
    }
}

//add filter to ensure the text Book, or book, is displayed when user updates a book
add_filter('post_updated_messages', 'citation_updated_messages');

function citation_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['citations'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Citation updated. <a href="%s">View citation</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Citation updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Citation restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Citation published. <a href="%s">View citation</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Citation saved.'),
    8 => sprintf( __('Citation submitted. <a target="_blank" href="%s">Preview citation</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Citation scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview citation</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Citation draft updated. <a target="_blank" href="%s">Preview citation</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

add_shortcode('citation', 'citation_display');



?>