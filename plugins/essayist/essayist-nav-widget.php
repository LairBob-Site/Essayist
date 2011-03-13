<?php

function trimLeft($currHaystack, $currNeedle) {
    $posNeedle = strpos($currHaystack, $currNeedle);

    if (strpos > 1) {
        return substr($currHaystack, (-1 * (strlen($currHaystack) - $posNeedle)) );
    } else {
        return 'L';
        // return 'ERROR (LEFT TRIM): Could not find "' .  $currNeedle . '" in "' . $currHaystack . '"';
    }
}

function trimRight($currHaystack, $currNeedle) {
    $posNeedle = strpos($currHaystack, $currNeedle);

    if (strpos > 1) {
        return substr($currHaystack, $posNeedle );
    } else {
        return 'R';
        // return 'ERROR (RIGHT TRIM): Could not find "' .  $currNeedle . '" in "' . $currHaystack . '"';
    }
}

function findAttr($currString, $currAttr) {
    $posAttr = strpos($currString, $currAttr);
    $strTemp = trimLeft($currString, $currAttr);
    $strTemp = trimLeft($strTemp, '"');
    $strTemp = trimRight($strTemp, '"');
    return $strTemp;
}

class navTOCWidget extends WP_Widget {

    function navTOCWidget() {
        $widget_ops = array('classname' => 'navTOCWidget', 'description' => __("Article Navigation Widget"));
        $this->WP_Widget('helloworld', __('Hello World Example'), $widget_ops, $control_ops);
    }

    function buildDiv($currID, $currTitle) {
        $strTemp = '<div class="nav-section-label" id="nav-' . $currID . '" dest="' . $currID . '">' . "\n";
        $strTemp = $strTemp . '      ' . $currTitle . "\n";
        $strTemp = $strTemp . '</div>' . "\n \n";
        return $strTemp;
    }

    function findInfo($currDiv) {
        // $posIDEnd = strpos($currDiv, '"', $posIDStart + 1);
        // $strTemp = substr($currDiv, $posID, ($posIDEnd - $posIDStart + 1));
        return findAttr($currDiv, "id");
    }

    function scanContent() {
        global $post;

        $strContent = $post->post_content;
        $strContent = do_shortcode($strContent);

        $doc = new DOMDocument();
        $doc->loadHTML(do_shortcode($post->post_content));
        $divs = $doc->getElementsByTagName('div');

        $strTOC = $this->buildDiv('content', 'Top');
        foreach($divs as $div) {
            if ($div->hasAttribute('class')) {
                if (strpos($div->getAttribute('class'), 'nav-content-section') !== false) {
                    $strTOC = $strTOC . $this->buildDiv($div->getAttribute('id'), $div->getAttribute('title'));
                }
            }
        }

        $strTOC = $strTOC . $this->buildDiv('comments', 'Comments');

        return ($strTOC);
    }

    function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);

# Before the widget
        echo $before_widget;

# The title
        // if ($title)
            // echo $before_title . $title . $after_title;

# Make the Hello World Example widget
        echo $this->scanContent();

# After the widget
        echo $after_widget;
    }

    /**
     * Saves the widgets settings.
     *
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['lineOne'] = strip_tags(stripslashes($new_instance['lineOne']));
        $instance['lineTwo'] = strip_tags(stripslashes($new_instance['lineTwo']));

        return $instance;
    }

    /**
     * Creates the edit form for the widget.
     *
     */
    function form($instance) {
//Defaults
        $instance = wp_parse_args((array) $instance, array('title' => '', 'lineOne' => 'Hello', 'lineTwo' => 'World'));

        $title = htmlspecialchars($instance['title']);
        $lineOne = htmlspecialchars($instance['lineOne']);
        $lineTwo = htmlspecialchars($instance['lineTwo']);

# Output the options
        echo '<p style="text-align:right;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 250px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';
# Text line 1
        echo '<p style="text-align:right;"><label for="' . $this->get_field_name('lineOne') . '">' . __('Line 1 text:') . ' <input style="width: 200px;" id="' . $this->get_field_id('lineOne') . '" name="' . $this->get_field_name('lineOne') . '" type="text" value="' . $lineOne . '" /></label></p>';
# Text line 2
        echo '<p style="text-align:right;"><label for="' . $this->get_field_name('lineTwo') . '">' . __('Line 2 text:') . ' <input style="width: 200px;" id="' . $this->get_field_id('lineTwo') . '" name="' . $this->get_field_name('lineTwo') . '" type="text" value="' . $lineTwo . '" /></label></p>';
    }

}

add_action('widgets_init', 'initNavWidgets');

function initNavWidgets() {
    register_widget('navTOCWidget');
}

?>
