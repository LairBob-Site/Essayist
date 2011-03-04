<?php

// INIT ROUTINES
add_action('init', 'datapoints_register');

function datapoints_register () {
    $labels = array(
        'name' => _x('Data Points', 'post type general name'),
        'singular_name' => _x('Data Point', 'post type singular name'),
        'add_new' => _x('Add New', 'datapoints'),
        'add_new_item' => __('Add New Data Point'),
        'edit_item' => __('Edit Data Point'),
        'new_item' => __('New Data Point'),
        'view_item' => __('View Data Point'),
        'search_items' => __('Search Data Point'),
        'not_found' => __('No data points found'),
        'not_found_in_trash' => __('No data points found in Trash'),
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

    register_post_type('datapoints', $args);
    register_taxonomy_for_object_type('subjects', 'datapoints');
    register_taxonomy_for_object_type('themes', 'datapoints');
}


add_action('admin_init', 'admin_init_datapoints');
function admin_init_datapoints() {
    add_meta_box("datapoint-meta", "Source Info", "datapoint_source", "datapoints", "side", "high");
}

function datapoint_source() {
    global $post;

    $custom = get_post_custom($post->ID);
    $dp_source_author = $custom["dp_source_author"][0];
    $dp_source_name = $custom["dp_source_name"][0];
    $dp_source_url = $custom["dp_source_url"][0];
    $dp_source_pub_date = $custom["dp_source_pub_date"][0];
?>
    <label>Author</label>
    <input name="dp_source_author" value="<?php echo $dp_source_author; ?>" /><br/>
    <label>Source</label>
    <input name="dp_source_name" value="<?php echo $dp_source_name; ?>" /><br/>
    <label>Link</label>
    <input name="dp_source_url" value="<?php echo $dp_source_url; ?>" /><br/>
    <label>Pub. Date</label>
    <input name="dp_source_pub_date" value="<?php echo $dp_source_pub_date; ?>" />
<?php
}

add_action('save_post', 'datapoint_save');
function datapoint_save() {
    global $post;

    update_post_meta($post->ID, "dp_source_author", $_POST["dp_source_author"]);
    update_post_meta($post->ID, "dp_source_name", $_POST["dp_source_name"]);
    update_post_meta($post->ID, "dp_source_url", $_POST["dp_source_url"]);
    update_post_meta($post->ID, "dp_source_pub_date", $_POST["dp_source_pub_date"]);
}

add_filter("manage_edit-datapoints_columns", "datapoint_edit_columns");
function datapoint_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Data Point Title",
        "description" => "Description",
        "dp_source_author" => "Author",
        "dp_source_name" => "Source",
        "dp_source_pub_date" => "Date",
        "themes" => "Themes",
        "subjects" => "Subjects"
    );

    return($columns);
}

add_action("manage_datapoints_posts_custom_column", "datapoint_custom_columns");
function datapoint_custom_columns($column) {
    global $post;


    switch ($column) {
        case "description":
            the_excerpt();
            break;
        case "dp_source_name":
            $custom = get_post_custom();
            echo $custom["dp_source_name"][0];
            break;
        case "dp_source_author":
            $custom = get_post_custom();
            echo $custom["dp_source_author"][0];
            break;
        case "dp_source_pub_date":
            $custom = get_post_custom();
            echo $custom["dp_source_pub_date"][0];
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
add_filter('post_updated_messages', 'datapoint_updated_messages');

function datapoint_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['datapoints'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Data Point updated. <a href="%s">View data point</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Data Point updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Data Point restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Data Point published. <a href="%s">View data point</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Data Point saved.'),
    8 => sprintf( __('Data Point submitted. <a target="_blank" href="%s">Preview data point</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Data Point scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview data point</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Data Point draft updated. <a target="_blank" href="%s">Preview data point</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

?>