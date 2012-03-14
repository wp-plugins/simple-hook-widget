<?php
/*
  Plugin Name: Simple Hook Widget
  Plugin URL: http://wordpress.org/extend/plugins/simple-hook-widget/
  Description: Creates a custom hook within a sidebar in place of a widget
  Version: 2
  Author: Eddie Moya
  Author URL: http://eddiemoya.com
 */

/*
  Copyright (C) 2011 Eddie Moya (eddie.moya+wp[at]gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

class Simple_Hook_Widget extends WP_Widget {

    /**
     * @author Eddie Moya
     */
    function register_widget() {
        add_action('widgets_init', array(__CLASS__, '_register_widget'));
    }

    /**
     * @author Eddie Moya
     */
    function _register_widget() {
        register_widget(__CLASS__);
    }

    /**
     * Widget setup.
     */
    function Simple_Hook_Widget() {
        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'simple-hook',
            'description' => 'Creates a custom hook within a sidebar in place of a widget');

        /* Widget control settings. */
        //$control_ops = array('width' => 200, 'height' => 350);

        /* Create the widget. */
        parent::WP_Widget('simple-hook', 'Simple Hook', $widget_ops);
    }

    function widget($args, $instance) {
        extract($args);

        $hook = str_replace(' ', '-', strtolower(htmlspecialchars(strip_tags($instance['hook']))));

        //Do the damn thing.
        do_action($hook);
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['hook'] = str_replace(' ', '-', strtolower(htmlspecialchars(strip_tags($new_instance['hook']))));        
        
        do_action('simplehook_' . $instance['hook']);

        return $new_instance;
    }

    function form($instance) {

        $defaults = array('hook' => apply_filters('simple-hook-default', ''));
        $instance = wp_parse_args((array) $instance, $defaults);
        $hook_list = apply_filters('simple-hook-list', array());
        
        
        if(!empty($hook_list)){
            $fields = array(
                array(
                    'field_id' => 'hook',
                    'type' => 'select',
                    'label' => 'Select Hook',
                    'options' => $hook_list
                )
            );
        } else {
            $fields = array(
                array(
                    'field_id' => 'hook',
                    'type' => 'text',
                    'label' => 'Enter Hook'
                )
            );
        }

        $this->form_fields($fields, $instance);
    }
    
    
    function form_fields($fields, $instance){
        foreach($fields as $field){
            extract($field);
            
            $args = array (
                'style' => (isset($style)) ? $style : '',
                'options' => (isset($options)) ? $options : array()
            );
            $this->form_field($field_id, $type, $label, $args, $instance);
        }
    }
    
    function form_field($field_id, $type, $label, $args, $instance){
        
        ?><p><?php
        
        switch ($type){
            case 'text':
                ?>
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php echo $label; ?>: </label>
                <input id="<?php echo $this->get_field_id( $field_id ); ?>" style="<?php echo $style; ?>" class="widefat" name="<?php echo $this->get_field_name( $field_id ); ?>" value="<?php echo $instance[$field_id]; ?>" />
                <?php break;
            
            case 'select':
                $options = $args['options'];
                $selected_option = $instance[$field_id];
  
                ?>
                    <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php echo $label; ?>: </label>
                    <select id="<?php echo $this->get_field_id( $field_id ); ?>" class="widefat" name="<?php echo $this->get_field_name($field_id); ?>">
                        <?php
                            foreach ( $options as $value => $label ) : 
                                $selected = ($selected_option == $value) ? 'selected="selected"' : ''; 
                                ?><option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $label ?></option><?php
                            endforeach; 
                        ?>
                    </select>
                    
				<?php break;
                
        }
        
        ?></p><?php
    }
}

Simple_Hook_Widget::register_widget();
