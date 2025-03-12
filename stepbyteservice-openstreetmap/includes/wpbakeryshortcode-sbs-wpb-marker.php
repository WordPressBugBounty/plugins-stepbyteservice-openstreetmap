<?php

if (!defined('WPINC')) {
    die;
}

if (class_exists('WPBakeryShortCode')) {

    /**
     * WPBakery Page Builder shortcode marker
     */
    class WPBakeryShortCode_SBS_WPB_Marker extends WPBakeryShortCode {

        /**
         * Register module with specified parameters
         */
        public static function register_module() {
            $defaults = SBS_OpenStreetMap_Base::merge_default_marker_attributes(array());
            vc_map(array(
                'name' => __('SBS OpenStreetMap Marker', 'stepbyteservice-openstreetmap'),
                'base' => 'sbs_wpb_marker',
                'content_element' => true,
                'as_child' => array(
                    'only' => 'sbs_wpb_openstreetmap'
                ),
                'category' => esc_html__('Content', 'js_composer'),
                'description' => __('Configurable OpenStreetMap marker', 'stepbyteservice-openstreetmap'),
                'icon' => plugin_dir_url(__FILE__) . '../assets/icons/sbs-marker-icon.png',
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Determine Position By', 'stepbyteservice-openstreetmap'),
                        'param_name' => 'marker_source',
                        'group' => __('Marker', 'stepbyteservice-openstreetmap'),
                        'value' => array(
                            __('Address', 'stepbyteservice-openstreetmap') => 'address',
                            __('Coordinates', 'stepbyteservice-openstreetmap') => 'coordinates'
                        ),
                        'std' => $defaults['marker_source']
                    ),
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => __('Address', 'stepbyteservice-openstreetmap'),
                        'param_name' => 'marker_address',
                        'dependency' => array('element' => 'marker_source', 'value' => 'address'),
                        'group' => __('Marker', 'stepbyteservice-openstreetmap')
                    ),
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                        'heading' => __('Latitude', 'stepbyteservice-openstreetmap'),
                        'param_name' => 'marker_latitude',
                        'dependency' => array('element' => 'marker_source', 'value' => 'coordinates'),
                        'group' => __('Marker', 'stepbyteservice-openstreetmap')
                    ),
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                        'heading' => __('Longitude', 'stepbyteservice-openstreetmap'),
                        'param_name' => 'marker_longitude',
                        'dependency' => array('element' => 'marker_source', 'value' => 'coordinates'),
                        'group' => __('Marker', 'stepbyteservice-openstreetmap')
                    ),
                    array(
                        'type' => 'iconpicker',
                        'edit_field_class' => 'vc_col-sm-6',
                        'heading' => __('Icon', 'stepbyteservice-openstreetmap'),
                        'param_name' => 'marker_icon',
                        'settings' => array(
                            'type' => 'sbs-map-icons',
                        ),
                        'group' => __('Marker', 'stepbyteservice-openstreetmap')
                    ),
                    array(
                        'type' => 'dropdown',
                        'edit_field_class' => 'vc_col-sm-6',
                        'heading' => __('Color', 'stepbyteservice-openstreetmap'),
                        'param_name' => 'marker_color',
                        'group' => __('Marker', 'stepbyteservice-openstreetmap'),
                        'value' => array(
                            __('Red', 'stepbyteservice-openstreetmap') => 'red',
                            __('White', 'stepbyteservice-openstreetmap') => 'white',
                            __('Blue', 'stepbyteservice-openstreetmap') => 'dark_blue',
                            __('Green', 'stepbyteservice-openstreetmap') => 'green',
                            __('Black', 'stepbyteservice-openstreetmap') => 'black',
                            __('Orange', 'stepbyteservice-openstreetmap') => 'orange',
                            __('Yellow', 'stepbyteservice-openstreetmap') => 'yellow',
                        ),
                        'std' => $defaults['marker_color']
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => __('Popup Text', 'stepbyteservice-openstreetmap'),
                        'param_name' => 'content',
                        'group' => __('Marker', 'stepbyteservice-openstreetmap')
                    )
                )
            ));
        }

        /**
         * Returns generated HTML from shortcode
         * 
         * @param array $attributes
         * @param string|null $content
         * @return string
         */
        protected function content($attributes, $content = null) {
            $attributes = SBS_OpenStreetMap_Base::merge_default_marker_attributes($attributes);
            return SBS_OpenStreetMap_Base::get_content_marker($attributes, $content);
        }

    }

}