<?php

if (!defined('WPINC')) {
    die;
}

if (!class_exists('SBS_OpenStreetMap_WPBakery')) {

    /**
     * WPBakery Page Builder content element
     */
    class SBS_OpenStreetMap_WPBakery extends SBS_OpenStreetMap_Base {

        /**
         * Constructor
         */
        public function __construct() {
            parent::__construct();
            add_action('vc_before_init', array($this, 'register_params'));
            add_action('vc_before_init', array($this, 'register_modules'));
            add_action('vc_before_init', array($this, 'register_wpbakery_assets'));
            add_action('vc_backend_editor_enqueue_js_css', array($this, 'enqueue_assets'));
            add_action('vc_frontend_editor_enqueue_js_css', array($this, 'enqueue_assets'));
            add_action('vc_load_iframe_jscss', array($this, 'enqueue_assets'));
            add_filter('vc_iconpicker-type-sbs-map-icons', array($this, 'iconpicker_sbs_map_icons'));
            add_filter('vc_form_fields_render_field_sbs_wpb_openstreetmap_map_style_param_value', array($this, 'sbs_filter_deprecated_styles'));
        }

        /**
         * Enqueue assets if needed
         */
        public function check_enqueue_assets() {
            $post = parent::check_enqueue_assets();
            if (!is_null($post) && (has_shortcode($post->post_content, 'sbs_wpb_openstreetmap') || has_shortcode($post->post_content, 'sbs_wpb_marker')))
                $this->enqueue_assets();
        }
        
        /**
         * Register assets for WPBakery
         */
        public function register_wpbakery_assets() {
            wp_register_style('sbs-openstreetmap-wpbakery-editor', plugins_url(SBS_Plugin_OpenStreetMap::getAssetFilename('../assets/css/wpbakeryeditor.css'), __FILE__), array(), SBS_WP_OPENSTREETMAP_VERSION);
            wp_enqueue_style('sbs-openstreetmap-wpbakery-editor');
        }

        /**
         * External link param
         * 
         * @param array $settings
         * @param string $value
         * @return string
         */
        public function external_link_settings_field($settings, $value) {
            return sprintf('<fieldset name="%s" class="external_link_block wpb_vc_param_value %s %s_field  ' . esc_attr($settings['class']) . '">'
                    . '<a href="%s" class="wpb-external-link" target="_blank">%s</a>'
                    . '</fieldset>',
                    esc_attr($settings['param_name']),
                    esc_attr($settings['param_name']),
                    esc_attr($settings['type']),
                    esc_attr($value),
                    esc_attr($settings['link_text'])
            );
        }

        /**
         * Text only param
         * 
         * @param array $settings
         * @param string $value
         * @return string
         */
        public function text_only_settings_field($settings, $value) {
            return sprintf('<fieldset name="%s" class="text_only_block wpb_vc_param_value %s %s_field ' . esc_attr($settings['class']) . '">'
                    . '<div class="wpb-text-only">%s</div>'
                    . '</fieldset>',
                    esc_attr($settings['param_name']),
                    esc_attr($settings['param_name']),
                    esc_attr($settings['type']),
                    esc_attr($value)
            );
        }

        /**
         * Register modules
         */
        public function register_modules() {
            require_once __DIR__ . '/wpbakeryshortcode-sbs-wpb-openstreetmap.php';
            require_once __DIR__ . '/wpbakeryshortcode-sbs-wpb-marker.php';

            WPBakeryShortCode_SBS_WPB_OpenStreetMap::register_module();
            WPBakeryShortCode_SBS_WPB_Marker::register_module();
        }

        /**
         * Register custom params
         */
        public function register_params() {
            vc_add_shortcode_param('external_link', array($this, 'external_link_settings_field'));
            vc_add_shortcode_param('text_only', array($this, 'text_only_settings_field'));
        }

        /**
         * Add Material icons to list for iconpicker
         * 
         * @param array $icons
         * @return array
         */
        public function iconpicker_sbs_map_icons($icons) {
            return array_merge($icons, parent::get_material_icons());
        }

        /**
         * Get wpBakery Style List
         * 
         * @return array
         */
        public static function get_wpbakery_styles() {
            $styles = array();
            foreach (parent::get_map_styles() as $key => $style) {
                $styles[$style['label']] = $key;
            }
            return $styles;
        }

        /**
         * Get routing service list
         * 
         * @return array
         */
        public static function get_routing_services() {
            $routers = array();
            foreach (parent::get_router_options() as $key => $router) {
                $routers[$router['label']] = $key;
            }
            return $routers;
        }

        /**
         * Get geocoding service list
         * 
         * @return array
         */
        public static function get_geocoding_services() {
            $geocoders = array();
            foreach (parent::get_geocoder_options() as $key => $geocoder) {
                $geocoders[$geocoder['label']] = $key;
            }
            return $geocoders;
        }

        /**
         * get external routing links
         * 
         * @return array
         */
        public static function get_routing_links() {
            $params = array();
            foreach (parent::get_router_options() as $key => $router) {
                $param = array(
                    'type' => 'external_link',
                    'param_name' => 'external_link_router_' . strtolower($key),
                    'heading' => null,
                    'value' => $router['terms'],
                    'link_text' => $router['label'] . ' ' . __('Terms of Use', 'stepbyteservice-openstreetmap'),
                    'group' => __('Routing', 'stepbyteservice-openstreetmap'),
                    'dependency' => array(
                        'element' => 'router',
                        'value' => $key
                    )
                );
                $params[] = $param;
            }
            return $params;
        }

        /**
         * get external geocoding links
         * 
         * @return array
         */
        public static function get_geocoding_links() {
            $params = array();
            foreach (parent::get_geocoder_options() as $key => $geocoder) {
                $param = array(
                    'type' => 'external_link',
                    'param_name' => 'external_link_geocoder_' . strtolower($key),
                    'heading' => null,
                    'value' => $geocoder['terms'],
                    'link_text' => $geocoder['label'] . ' ' . __('Terms of Use', 'stepbyteservice-openstreetmap'),
                    'group' => __('Geocoding', 'stepbyteservice-openstreetmap'),
                    'dependency' => array(
                        'element' => 'geocoder',
                        'value' => $key
                    )
                );
                $params[] = $param;
            }
            return $params;
        }

        /**
         * get services depending on apikey
         * 
         * @param string $service
         * @return array
         */
        public static function get_dependent_service($service) {
            if ($service === 'geocoder') {
                $service_provider = parent::get_geocoder_options();
            } else if ($service === 'router') {
                $service_provider = parent::get_router_options();
            }
            $dependent = array();
            foreach ($service_provider as $key => $provider) {
                if (isset($provider['dependency'])) {
                    $dependent[] = $key;
                }
            }
            return $dependent;
        }

        /**
         * get external provider links
         * 
         * @return array
         */
        public static function get_provider_links() {
            $params = array();
            foreach (parent::get_provider_with_variants() as $key => $provider) {
                $param = array(
                    'type' => 'external_link',
                    'param_name' => 'external_link_' . strtolower($key),
                    'heading' => null,
                    'value' => $provider['terms'],
                    'link_text' => $key . ' ' . __('Terms of Use', 'stepbyteservice-openstreetmap'),
                    'group' => __('Map', 'stepbyteservice-openstreetmap'),
                    'dependency' => array(
                        'element' => 'map_style',
                        'value' => SBS_OpenStreetMap_WPBakery::get_terms_dependent_styles($key)
                    )
                );
                $params[] = $param;
            }
            return $params;
        }

        /**
         * get styles for dependency of externbal provider links
         * 
         * @param string $provider_key
         * @return array
         */
        public static function get_terms_dependent_styles($provider_key) {
            $dependent_styles = array();
            foreach (parent::get_map_styles() as $key => $value) {
                if (substr($key, 0, strlen($provider_key)) === $provider_key) {
                    $dependent_styles[] = $key;
                }
            }
            return $dependent_styles;
        }

        /**
         * point deprecated style values to new style values for dropdown
         * 
         * @param string value
         * @return string
         */
        public function sbs_filter_deprecated_styles($value) {
            $deprecated_styles = parent::get_deprecated_map_styles();
            if (array_key_exists($value, $deprecated_styles)) {
                $value = $deprecated_styles[$value];
            }
            return $value;
        }

    }

}
