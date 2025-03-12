<?php

if (!defined('WPINC')) {
    die;
}

if (class_exists('WPBakeryShortCodesContainer')) {

    /**
     * WPBakery Page Builder shortcode
     */
    class WPBakeryShortCode_SBS_WPB_OpenStreetMap extends WPBakeryShortCodesContainer {

        /**
         * Register module with specified parameters
         */
        public static function register_module() {
            $defaults = SBS_OpenStreetMap_Base::merge_default_attributes(array());
            vc_map(array(
                'name' => __('SBS OpenStreetMap', 'stepbyteservice-openstreetmap'),
                'base' => 'sbs_wpb_openstreetmap',
                'as_parent' => array(
                    'only' => 'sbs_wpb_marker'
                ),
                'show_settings_on_create' => true,
                'is_container' => true,
                'content_element' => true,
                'category' => esc_html__('Content', 'js_composer'),
                'description' => __('Configurable OpenStreetMap module', 'stepbyteservice-openstreetmap'),
                'icon' => plugin_dir_url(__FILE__) . '../assets/icons/sbs-openstreetmap-icon.png',
                'admin_enqueue_js' => plugin_dir_url(__FILE__) . SBS_Plugin_OpenStreetMap::getAssetFilename('../assets/js/sbs-wpb-backend.js'),
                'front_enqueue_js' => plugin_dir_url(__FILE__) . SBS_Plugin_OpenStreetMap::getAssetFilename('../assets/js/sbs-wpb-frontend.js'),
                'js_view' => 'VcColumnView',
                'params' => array_merge(
                        array(
                            array(
                                'type' => 'dropdown',
                                'edit_field_class' => 'vc_col-sm-6',
                                'heading' => __('Map Style', 'stepbyteservice-openstreetmap'),
                                'param_name' => 'map_style',
                                'admin_label' => true,
                                'group' => __('Map', 'stepbyteservice-openstreetmap'),
                                'value' => SBS_OpenStreetMap_WPBakery::get_wpbakery_styles(),
                                'save_always' => true
                            )
                        ),
                        SBS_OpenStreetMap_WPBakery::get_provider_links(),
                        array(
                            array(
                                'type' => 'textfield',
                                'heading' => __("Map Style Key", 'stepbyteservice-openstreetmap'),
                                'param_name' => 'map_style_key',
                                'description' => __('You need an api key or acess token to use the chosen map style. Please inform yourself on the website of the provider.', 'stepbyteservice-openstreetmap'),
                                'group' => __('Map', 'stepbyteservice-openstreetmap'),
                                'dependency' => array(
                                    'element' => 'map_style',
                                    'value' => array_merge(SBS_OpenStreetMap_Base::get_dependent_styles('apikey'), SBS_OpenStreetMap_Base::get_dependent_styles('accesstoken'))
                                )
                            ),
                            array(
                                'type' => 'text_only',
                                'param_name' => 'whitelist_notice',
                                'heading' => null,
                                'value' => __('You need to whitelist your domain to use the chosen map style. Please inform yourself on the website of the provider.', 'stepbyteservice-openstreetmap'),
                                'group' => __('Map', 'stepbyteservice-openstreetmap'),
                                'dependency' => array(
                                    'element' => 'map_style',
                                    'value' => SBS_OpenStreetMap_Base::get_dependent_styles('whitelist')
                                )
                            ),
                            array(
                                'type' => 'dropdown',
                                'edit_field_class' => 'vc_col-sm-6',
                                'heading' => __('Map Height in Relation to Width', 'stepbyteservice-openstreetmap'),
                                'param_name' => 'map_height',
                                'group' => __('Map', 'stepbyteservice-openstreetmap'),
                                'value' => array(
                                    '20%' => '20',
                                    '30%' => '30',
                                    '50%' => '50',
                                    '60%' => '60',
                                    '100%' => '100'
                                ),
                                'std' => $defaults['map_height'],
                            ),
                            array(
                                'type' => 'dropdown',
                                'edit_field_class' => 'vc_col-sm-6',
                                'heading' => __('Zoom Level', 'stepbyteservice-openstreetmap'),
                                'param_name' => 'zoom',
                                'group' => __('Map', 'stepbyteservice-openstreetmap'),
                                'value' => array(
                                    '10' => '10',
                                    '11' => '11',
                                    '12' => '12',
                                    '13' => '13',
                                    '14' => '14',
                                    '15' => '15',
                                    '16' => '16',
                                    '17' => '17',
                                    '18' => '18',
                                    '19' => '19',
                                    '20' => '20'
                                ),
                                'std' => $defaults['zoom'],
                            ),
                            array(
                                'type' => 'checkbox',
                                'edit_field_class' => 'vc_col-sm-6',
                                'heading' => __('Zoom With CTRL-Key Only', 'stepbyteservice-openstreetmap'),
                                'param_name' => 'ctrl_mouse_zoom',
                                'group' => __('Map', 'stepbyteservice-openstreetmap'),
                                'value' => array(
                                    __('Yes', 'stepbyteservice-openstreetmap') => 'true'
                                ),
                                'std' => $defaults['ctrl_mouse_zoom']
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __("Latitude of the Map's Center", 'stepbyteservice-openstreetmap'),
                                'param_name' => 'latitude',
                                'description' => __('Only needed if marker is not the center of the map', 'stepbyteservice-openstreetmap'),
                                'group' => __('Map', 'stepbyteservice-openstreetmap')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __("Longitude of the Map's Center", 'stepbyteservice-openstreetmap'),
                                'param_name' => 'longitude',
                                'description' => __('Only needed if marker is not the center of the map', 'stepbyteservice-openstreetmap'),
                                'group' => __('Map', 'stepbyteservice-openstreetmap')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => __('Activate Routing', 'stepbyteservice-openstreetmap'),
                                'param_name' => 'routing',
                                'group' => __('Map', 'stepbyteservice-openstreetmap'),
                                'value' => array(
                                    __('Yes', 'stepbyteservice-openstreetmap') => 'true'
                                ),
                                'std' => $defaults['routing']
                            ),
                                                        array(
                                'type' => 'checkbox',
                                'heading' => __('Show Attribution', 'stepbyteservice-openstreetmap'),
                                'param_name' => 'show_attribution',
                                'description' => __('Attributions for content providers are shown as links on the bottom right corner of the map. If you disable the checkbox please consider the legal circumstances.', 'stepbyteservice-openstreetmap'),
                                'group' => __('Map', 'stepbyteservice-openstreetmap'),
                                'value' => array(
                                    __('Yes', 'stepbyteservice-openstreetmap') => 'true'
                                ),
                                'std' => $defaults['show_attribution']
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __("Default Routing Destination", 'stepbyteservice-openstreetmap'),
                                'param_name' => 'destination_marker',
                                'description' => __('Enter the number of the marker that should be the default routing destination. If no marker is supposed to be the routing destination enter 0. (The number is based on the order of the marker elements in the map element.)', 'stepbyteservice-openstreetmap'),
                                'group' => __('Routing', 'stepbyteservice-openstreetmap'),
                                'std' => $defaults['destination_marker'],
                                'dependency' => array(
                                    'element' => 'routing',
                                    'value' => 'true'
                                )
                            ),
                            array(
                                'type' => 'dropdown',
                                'edit_field_class' => 'vc_col-sm-6',
                                'heading' => __('Routing Service', 'stepbyteservice-openstreetmap'),
                                'param_name' => 'router',
                                'group' => __('Routing', 'stepbyteservice-openstreetmap'),
                                'value' => SBS_OpenStreetMap_WPBakery::get_routing_services(),
                                'dependency' => array(
                                    'element' => 'routing',
                                    'value' => 'true'
                                )
                            ),
                            array(
                                'type' => 'text_only',
                                'param_name' => 'router_notice',
                                'heading' => null,
                                'value' => __('This plugin uses OSRM`s demo server by default for demonstration purpose of the routing option. However it is not suitable for actual use as a routing service, as the server can deny access at any time or may not be available at all times. Please choose a different routing service for actual use on your website.', 'stepbyteservice-openstreetmap'),
                                'group' => __('Routing', 'stepbyteservice-openstreetmap'),
                                'dependency' => array(
                                    'element' => 'router',
                                    'value' => 'osrmv1'
                                )
                            ),
                        ),
                        SBS_OpenStreetMap_WPBakery::get_routing_links(),
                        array(
                            array(
                                'type' => 'textfield',
                                'heading' => __("Routing Key", 'stepbyteservice-openstreetmap'),
                                'param_name' => 'router_key',
                                'description' => __('You need an api key or an access token to use the chosen routing service. Please inform yourself on the website of the service provider. If chosen provider is same as map style provider, leave field empty to use key from map style key field.', 'stepbyteservice-openstreetmap'),
                                'group' => __('Routing', 'stepbyteservice-openstreetmap'),
                                'dependency' => array(
                                    'element' => 'router',
                                    'value' => SBS_OpenStreetMap_WPBakery::get_dependent_service('router')
                                )
                            ),
                            array(
                                'type' => 'text_only',
                                'param_name' => 'geocoder_notice',
                                'heading' => null,
                                'value' => __('Geocoding is used for translating an address to latitude and longitude when choosing address as source for the marker position or when routing is activated.', 'stepbyteservice-openstreetmap'),
                                'group' => __('Geocoding', 'stepbyteservice-openstreetmap'),
                            ),
                            array(
                                'type' => 'dropdown',
                                'edit_field_class' => 'vc_col-sm-6',
                                'heading' => __('Geocoding Service', 'stepbyteservice-openstreetmap'),
                                'param_name' => 'geocoder',
                                'group' => __('Geocoding', 'stepbyteservice-openstreetmap'),
                                'value' => SBS_OpenStreetMap_WPBakery::get_geocoding_services(),
                            ),
                        ),
                        SBS_OpenStreetMap_WPBakery::get_geocoding_links(),
                        array(
                            array(
                                'type' => 'textfield',
                                'heading' => __("Geocoding Key", 'stepbyteservice-openstreetmap'),
                                'param_name' => 'geocoder_key',
                                'description' => __('You need an api key or an access token to use the chosen geocoding service. Please inform yourself on the website of the service provider. If chosen provider is same as map style provider, leave field empty to use key from map style key field.', 'stepbyteservice-openstreetmap'),
                                'group' => __('Geocoding', 'stepbyteservice-openstreetmap'),
                                'dependency' => array(
                                    'element' => 'geocoder',
                                    'value' => SBS_OpenStreetMap_WPBakery::get_dependent_service('geocoder')
                                )
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __("Center Map on", 'stepbyteservice-openstreetmap'),
                                'param_name' => 'center_marker',
                                'description' => __('Enter the number of the marker that should be in the center of the map. If no marker is supposed to be in the center enter 0. (The number is based on the order of the marker elements in the map element.)', 'stepbyteservice-openstreetmap'),
                                'group' => __('Markers', 'stepbyteservice-openstreetmap'),
                                'std' => $defaults['center_marker']
                            )
                        )
                ),
                'default_content' => '[sbs_wpb_marker][/sbs_wpb_marker]'
            ));
        }

        /**
         * @param $title
         *
         * @return string
         */
        protected function outputTitle($title) {
            $icon = $this->settings('icon');
            if (filter_var($icon, FILTER_VALIDATE_URL)) {
                $icon = '';
            }
            $params = array(
                'icon' => $icon,
                'is_container' => $this->settings('is_container'),
                'title' => $title,
            );

            return '<h4 class="wpb_element_title"> ' . $this->getIcon($params) . esc_attr($title) . '</h4>';
        }

        /**
         * Override default getColumnControls
         *
         * @param string $controls
         * @param string $extended_css
         *
         * @return string
         * @throws \Exception
         */
        public function getColumnControls($controls = 'full', $extended_css = '') {

            $controls_html = array();

            if ('bottom-controls' === $extended_css) {
                $controls_html['start'] = '<div class="vc_controls vc_controls-visible controls_column' . (!empty($extended_css) ? " {$extended_css}" : '' ) . '">';
                $controls_html['end'] = '</div>';
                /* translators: %s plugin name */
                $controls_html['title'] = sprintf(esc_attr__('Append to this %s', 'js_composer'), strtolower($this->settings('name')));
            } else {
                $controls_html['start'] = '<div class="vc_controls' . (!empty($extended_css) ? " {$extended_css}" : '' ) . '"><div class="vc_controls-cc">';
                $controls_html['end'] = '</div></div>';
                /* translators: %s plugin name */
                $controls_html['title'] = sprintf(esc_attr__('Prepend to this %s', 'js_composer'), strtolower($this->settings('name')));
            }

            /* translators: %s plugin name */
            $controls_html['move'] = '<a class="vc_control-btn vc_element-name column_move vc_column-move" data-vc-control="move" href="#"><span class="vc_btn-content" title="' . sprintf(esc_attr__('Move this %s', 'js_composer'), strtolower($this->settings('name'))) . '"><i class="vc-composer-icon vc-c-icon-dragndrop"></i>' . esc_attr($this->settings('name')) . '</span></a>';
            $moveAccess = vc_user_access()->part('dragndrop')->checkStateAny(true, null)->get();
            if (!$moveAccess) {
                $controls_html['move'] = '';
            }
            if ('bottom-controls' === $extended_css) {
                $controls_html['add'] = '<a class="vc_control column_add" data-vc-control="add" href="#" title="' . $controls_html['title'] . '"><i class="vc-composer-icon vc-c-icon-add"></i>' . __('Add Marker', 'stepbyteservice-openstreetmap') . '</a>';
            } else {
                $controls_html['add'] = '<a class="vc_control-btn column_add" data-vc-control="add" href="#" title="' . $controls_html['title'] . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-add"></i></span></a>';
            }
            /* translators: %s plugin name */
            $controls_html['edit'] = '<a class="vc_control-btn column_edit" data-vc-control="edit" href="#" title="' . sprintf(esc_html__('Edit this %s', 'js_composer'), strtolower($this->settings('name'))) . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-mode_edit"></i></span></a>';
            /* translators: %s plugin name */
            $controls_html['clone'] = '<a class="vc_control-btn column_clone" data-vc-control="clone" href="#" title="' . sprintf(esc_html__('Clone this %s', 'js_composer'), strtolower($this->settings('name'))) . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-content_copy"></i></span></a>';
            /* translators: %s plugin name */
            $controls_html['delete'] = '<a class="vc_control-btn column_delete" data-vc-control="delete" href="#" title="' . sprintf(esc_html__('Delete this %s', 'js_composer'), strtolower($this->settings('name'))) . '"><span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-delete_empty"></i></span></a>';
            $controls_html['full'] = $controls_html['move'] . $controls_html['add'] . $controls_html['edit'] . $controls_html['clone'] . $controls_html['delete'];

            $editAccess = vc_user_access_check_shortcode_edit($this->shortcode);
            $allAccess = vc_user_access_check_shortcode_all($this->shortcode);

            if (!empty($controls)) {
                if (is_string($controls)) {
                    $controls = array($controls);
                }
                $controls_string = $controls_html['start'];
                foreach ($controls as $control) {
                    if (( $editAccess && 'edit' === $control ) || $allAccess) {
                        if (isset($controls_html[$control])) {
                            $controls_string .= $controls_html[$control];
                        }
                    }
                }

                return $controls_string . $controls_html['end'];
            }

            if ($allAccess) {
                return $controls_html['start'] . $controls_html['full'] . $controls_html['end'];
            } elseif ($editAccess) {
                return $controls_html['start'] . $controls_html['edit'] . $controls_html['end'];
            }

            return $controls_html['start'] . $controls_html['end'];
        }
        
        /**
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function contentAdmin( $atts, $content = null ) {
		$width = '';

		$atts = shortcode_atts( $this->predefined_atts, $atts );
		extract( $atts );
		$this->atts = $atts;
		$output = '';

		$output .= '<div ' . $this->mainHtmlBlockParams( $width, 1 ) . '>';
		if ( $this->backened_editor_prepend_controls ) {
			$output .= $this->getColumnControls( $this->settings( 'controls' ) );
		}
		$output .= '<div class="wpb_element_wrapper">';

		if ( isset( $this->settings['custom_markup'] ) && '' !== $this->settings['custom_markup'] ) {
			$markup = $this->settings['custom_markup'];
			$output .= $this->customMarkup( $markup );
		} else {
			$output .= $this->outputTitle( $this->settings['name'] );
                        $output .= $this->paramsHtmlHolders( $atts );
			$output .= '<div ' . $this->containerHtmlBlockParams( $width, 1 ) . '>';
			$output .= do_shortcode( shortcode_unautop( $content ) );
			$output .= '</div>';
		}

		$output .= '</div>';
		if ( $this->backened_editor_prepend_controls ) {
			$output .= $this->getColumnControls( 'add', 'bottom-controls' );

		}
		$output .= '</div>';

		return $output;
	}

        /**
         * Returns generated HTML from shortcode
         * 
         * @param array $attributes
         * @param string|null $content
         * @return string
         */
        protected function content($attributes, $content = null) {
            $attributes = SBS_OpenStreetMap_Base::merge_default_attributes($attributes);
            return SBS_OpenStreetMap_Base::get_content($attributes, $content);
        }

    }

}