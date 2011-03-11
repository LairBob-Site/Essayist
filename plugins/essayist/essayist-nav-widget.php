<?php

function buildDiv($currID, $currTitle) {
    $strTemp = '      <a href ="#' . $currID . '">' . $currTitle . '</a>' . "\n";
    return $strTemp;
}



class navTOCWidget extends WP_Widget {

    function navTOCWidget() {
        $widget_ops = array('classname' => 'navTOCWidget', 'description' => __("Article Navigation Widget"));
        $this->WP_Widget('helloworld', __('Hello World Example'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);

        // $strTOC = '<div class="navLinks">';
        $strTOC = '';
        $strTOC = $strTOC . buildDiv('section-01', 'Context');
        $strTOC = $strTOC . buildDiv('section-02', 'Consequences');
        $strTOC = $strTOC . buildDiv('section-03', 'Conclusions');
        // $strTOC = $strTOC . '    <a href="#section-01">Context</a>' . "\n";
        // $strTOC = $strTOC . '    <a href="#section-02">Consequences</a>' . "\n";
        // $strTOC = $strTOC . '    <a href="#section-03">Conclusions</a>' . "\n";
        // $strTOC = $strToc . '</div>';
        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
        // $lineOne = empty($instance['lineOne']) ? 'Hello' : $instance['lineOne'];
        // $lineTwo = empty($instance['lineTwo']) ? 'World' : $instance['lineTwo'];

# Before the widget
        echo $before_widget;

# The title
        // if ($title)
            // echo $before_title . $title . $after_title;

# Make the Hello World Example widget
        echo $strTOC;

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
