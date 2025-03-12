<?php
if (!defined('WPINC')) {
    die;
}

if (!class_exists('SBS_OpenStreetMap_Base')) {

    /**
     * Base class for components
     */
    abstract class SBS_OpenStreetMap_Base {

        /**
         * Migration Shortcodes
         */
        private static $migration_shortcodes = array(
            'sbs_wpb_openstreetmap' => 'sbs_wpb_marker',
            'sbs_openstreetmap' => 'sbs_marker'
        );

        /**
         * Constructor
         */
        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'check_enqueue_assets'), 0);
        }

        /**
         * Check if registered assets need to be enqueued. Returns the post if true, null otherwise.
         * 
         * @global WP_Post|null $post
         * @return WP_Post|null
         */
        public function check_enqueue_assets() {
            global $post;
            if (!is_a($post, 'WP_Post') || !is_singular())
                return null;
            return $post;
        }

        /**
         * Enqueue registered assets
         */
        public function enqueue_assets() {
            wp_enqueue_style('sbs-openstreetmap');
            wp_enqueue_script('sbs-openstreetmap');
        }

        /**
         * Create global openstreetmap object
         * 
         * @return array
         */
        public static function get_sbs_openstreetmap_object() {
            return array(
                'defaults' => self::merge_default_attributes(array('destination_marker' => '0', 'center_marker' => '0')),
                'defaults_marker' => self::merge_default_marker_attributes(array()),
                'deprecated_styles' => self::get_deprecated_map_styles(),
                'map_styles' => self::get_map_styles(),
                'mapbox_styles' => self::get_mapbox_styles(),
                'routers' => self::get_router_options(),
                'geocoders' => self::get_geocoder_options(),
                'icons' => self::get_material_icons()
            );
        }

        /**
         * Merge given attributes with default values
         * 
         * @param array $attributes
         * @return array
         */
        public static function merge_default_attributes($attributes) {
            return shortcode_atts(array(
                'block_id' => '',
                'map_style' => 'OpenStreetMap.DE',
                'map_style_key' => null,
                'map_height' => '50',
                'zoom' => '15',
                'ctrl_mouse_zoom' => 'false',
                'latitude' => '52.4679888',
                'longitude' => '13.3257928',
                'routing' => 'false',
                'destination_marker' => '1',
                'router' => 'osrmv1',
                'router_key' => null,
                'show_attribution' => 'true',
                'geocoder' => 'nominatim',
                'geocoder_key' => null,
                'center_marker' => '1',
                'marker_list' => array(
                    self::merge_default_marker_attributes(array())
                ),
                    ), $attributes);
        }

        /**
         * Merge given marker attributes with default values
         * 
         * @param array $attributes
         * @return array
         */
        public static function merge_default_marker_attributes($attributes) {
            return shortcode_atts(array(
                'marker_source' => 'address',
                'marker_address' => '',
                'marker_latitude' => '52.4679888',
                'marker_longitude' => '13.3257928',
                'marker_center' => 'true',
                'marker_icon' => '',
                'marker_color' => 'dark_blue',
                    ), $attributes);
        }

        /**
         * Return deprecated map styles
         * 
         * @return array
         */
        public static function get_deprecated_map_styles() {
            return array(
                'openstreetmap_de' => 'OpenStreetMap.DE',
                'opentopomap' => 'OpenTopoMap',
                'stamen_toner' => 'Stadia.StamenToner',
                'stamen_toner_light' => 'Stadia.StamenTonerLite',
                'stamen_terrain' => 'Stadia.StamenTerrain',
                'stamen_watercolor' => 'Stadia.StamenWatercolor',
                'wikimedia' => 'OpenStreetMap.DE',
                'Stamen.Toner' => 'Stadia.StamenToner',
                'Stamen.TonerLite' => 'Stadia.StamenTonerLite',
                'Stamen.Terrain' => 'Stadia.StamenTerrain',
                'Stamen.Watercolor' => 'Stadia.StamenWatercolor',
            );
        }

        /**
         * Get mapbox styles
         * 
         * @return array
         */
        public static function get_mapbox_styles() {
            return array(
                'Streets' => 'mapbox/streets-v11',
                'Outdoors' => 'mapbox/outdoors-v11',
                'Light' => 'mapbox/light-v10',
                'Dark' => 'mapbox/dark-v10',
                'Satellite' => 'mapbox/satellite-v9',
            );
        }

        /**
         * Get provider with variants
         * 
         * @return array
         */
        public static function get_provider_with_variants() {
            $path = plugin_dir_path(__FILE__) . '../data/providers.json';
            $providerData = file_get_contents($path);
            $providers = json_decode($providerData, true);
            $providers['MapBox']['variants'] = array_keys(self::get_mapbox_styles());
            return $providers;
        }

        /**
         * Get map styles array from providers and their variants
         * 
         * @return array
         */
        public static function get_map_styles() {
            $styles = array();
            foreach (self::get_provider_with_variants() as $key => $provider) {
                if (isset($provider['variants'])) {
                    foreach ($provider['variants'] as $variant_key => $variant) {
                        $map_key = $key . '.' . str_replace(' ', '', $variant);
                        $styles[$map_key] = array(
                            'label' => $key . ' ' . $variant,
                            'dependency' => isset($provider['dependency']) ? $provider['dependency'] : null,
                            'terms' => isset($provider['terms']) ? $provider['terms'] : null,
                            'provider' => ucfirst($key),
                        );
                    }
                } else {
                    $styles[$key] = array(
                        'label' => ucfirst($key),
                        'dependency' => isset($provider['dependency']) ? $provider['dependency'] : null,
                        'terms' => isset($provider['terms']) ? $provider['terms'] : null,
                        'provider' => ucfirst($key)
                    );
                }
            }
            return $styles;
        }

        /**
         * Get Styles for one specific dependency
         * 
         * @param string $dependency
         * @return array
         */
        public static function get_dependent_styles($dependency) {
            $styles = array();
            foreach (self::get_map_styles() as $key => $style) {
                if ($style['dependency'] === $dependency) {
                    $styles[] = $key;
                }
            }
            return $styles;
        }

        /**
         * Get geocoder options
         * 
         * @return array
         */
        public static function get_geocoder_options() {
            return array(
                'nominatim' => array(
                    'label' => 'Nominatim',
                    'terms' => 'https://operations.osmfoundation.org/policies/nominatim/'
                ),
                'mapbox' => array(
                    'label' => 'Mapbox',
                    'dependency' => 'apikey',
                    'terms' => 'https://www.mapbox.com/legal/tos/'
                ),
            );
        }

        /**
         * Get router options
         * 
         * @return array
         */
        public static function get_router_options() {
            return array(
                'osrmv1' => array(
                    'label' => 'OSRM Demo Server',
                    'terms' => 'https://github.com/Project-OSRM/osrm-backend/wiki/Api-usage-policy'
                ),
                'mapbox' => array(
                    'label' => 'Mapbox',
                    'dependency' => 'apikey',
                    'terms' => 'https://www.mapbox.com/legal/tos/'
                )
            );
        }

        /**
         * Get material icons
         * 
         * @return array
         */
        public static function get_material_icons() {
            $path = plugin_dir_path(__FILE__) . '../data/icons.json';
            $iconData = file_get_contents($path);
            return json_decode($iconData, true);
        }

        /**
         * Generate and return HTML output from shortcode
         * 
         * @param array $attributes
         * @param string|null $content
         * @return string
         */
        public static function get_content($attributes, $content = null) {
            extract($attributes);
            $ctrl_mouse_zoom = filter_var($ctrl_mouse_zoom, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
            $show_attribution = filter_var($show_attribution, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
            $routing = filter_var($routing, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
            $deprecated_styles = self::get_deprecated_map_styles();
            if (array_key_exists($map_style, $deprecated_styles)) {
                $map_style = $deprecated_styles[$map_style];
            }
            $destination_marker = $destination_marker - 1;
            $center_marker = $center_marker - 1;
            //marker list
            preg_match_all('/[^\/](?:sbs_wpb_marker|sbs_marker)([^\]]*)(?:])([^\[]*)/i', $content, $matches, PREG_SET_ORDER);
            $marker_list = array();
            foreach ($matches as $marker) {
                $marker_atts = SBS_OpenStreetMap_Base::merge_default_marker_attributes(shortcode_parse_atts($marker[1]));
                if (!empty($marker[2])) {
                    $marker_atts['marker_text'] = $marker[2];
                }
                if (!in_array($marker_atts['marker_source'], array('address', 'coordinates'), true)) {
                    $marker_atts['marker_source'] = 'coordinates';
                }
                $marker_list[] = $marker_atts;
            }
            if (empty($block_id)) {
                $block_id = uniqid();
            }
            $id = 'sbs-openstreetmap-block-' . $block_id;
            $content = do_shortcode(shortcode_unautop($content));
            ob_start();
            ?><div
                id="<?php echo esc_attr($id) ?>" 
                class="sbs_openstreetmap_module" 
                data-map-style="<?php echo esc_attr($map_style); ?>"
                data-map-style-key="<?php echo esc_attr($map_style_key); ?>"
                data-zoom="<?php printf('%d', (int)$zoom); ?>" 
                data-ctrl-mouse-zoom="<?php echo esc_attr($ctrl_mouse_zoom); ?>" 
                data-latitude="<?php printf('%F', (float)$latitude); ?>" 
                data-longitude="<?php printf('%F', (float)$longitude); ?>" 
                data-routing="<?php echo esc_attr($routing); ?>" 
                data-destination-marker="<?php echo esc_attr($destination_marker); ?>" 
                data-router="<?php echo esc_attr($router); ?>" 
                data-router-key="<?php echo esc_attr($router_key); ?>" 
                data-show-attribution="<?php echo esc_attr($show_attribution); ?>" 
                data-geocoder="<?php echo esc_attr($geocoder); ?>" 
                data-geocoder-key="<?php echo esc_attr($geocoder_key); ?>" 
                data-center-marker="<?php echo esc_attr($center_marker); ?>"
                data-marker-list='<?php echo wp_json_encode($marker_list); ?>'>
                <div class="sbs_openstreetmap_container" style="padding-bottom: <?php printf('%d%%', (int)$map_height); ?>"></div>
                <div class="marker_list">
                    <?php echo wp_kses($content, wp_kses_allowed_html('post')); ?>
                </div>
            </div><?php
            return ob_get_clean();
        }

        /**
         * Generate and return HTML output from marker shortcode
         * 
         * @param array $attributes
         * @param string|null $content
         * @return string
         */
        public static function get_content_marker($attributes, $content = null) {
            extract($attributes);
            $marker_info = '';
            if ($marker_source === 'address') {
                $marker_info = $marker_address;
            } else {
                $marker_source = 'coordinates';
                $marker_info = 'lat: ' . $marker_latitude . ', lng: ' . $marker_longitude;
            }
            ob_start();
            ?><div class="marker_element"
                 data-marker-source="<?php echo esc_attr($marker_source); ?>" 
                 data-marker-address="<?php echo esc_attr($marker_address); ?>" 
                 data-marker-latitude="<?php printf('%F', (float)$marker_latitude); ?>" 
                 data-marker-longitude="<?php printf('%F', (float)$marker_longitude); ?>"
                 data-marker-icon="<?php echo esc_attr($marker_icon); ?>" 
                 data-marker-color="<?php echo esc_attr($marker_color); ?>"
                 data-marker-text="<?php echo esc_attr($content); ?>">Marker <span class="marker_number"></span> (<?php echo esc_html($marker_info); ?>)</div><?php
            return ob_get_clean();
        }

        /**
         * Filter content string to migrate old shortcodes
         * 
         * @param string $content
         * @return string
         */
        public static function migrate_shortcode($content) {
            if (false === strpos($content, '[sbs')) {
                return $content;
            }

            $pattern = get_shortcode_regex(array_keys(self::$migration_shortcodes));
            $content = preg_replace_callback("/$pattern/", array(__CLASS__, 'migrate_marker'), $content);
            $content = preg_replace_callback("/$pattern/", array(__CLASS__, 'migrate_map_atts'), $content);

            return $content;
        }

        /**
         * Migrate content of specified post
         * 
         * @param WP_Post $post
         */
        public static function migrate_post($post) {
            if (!empty($post->post_content))
                $post->post_content = static::migrate_shortcode($post->post_content);
        }

        /**
         * Preg Replace callback to replace shortcode strings
         * 
         * @param array $matches
         * @return string
         */
        private static function migrate_marker($matches) {
            if (strpos($matches[3], 'marker_') === false)
                return $matches[0];

            $atts = shortcode_parse_atts($matches[3]);
            if (!is_array($atts))
                return $matches[0];
            $marker_atts = array();
            foreach ($atts as $key => $value) {
                if ($key === 'marker_center' && $value == false) {
                    $atts['center_marker'] = '0';
                    unset($atts[$key]);
                } elseif (substr($key, 0, 7) === 'marker_') {
                    $marker_atts[$key] = $value;
                    unset($atts[$key]);
                }
            }

            $inner = self::get_shortcode_string(
                            self::$migration_shortcodes[$matches[2]],
                            $marker_atts,
                            $matches[5]
            );
            return self::get_shortcode_string(
                            $matches[2],
                            $atts,
                            $inner,
                            $matches[1] === '[' && $matches[6] === ']'
            );
        }

        /**
         * Preg Replace callback to replace shortcode strings
         * 
         * @param array $matches
         * @return string
         */
        private static function migrate_map_atts($matches) {
            if (strpos($matches[3], 'api_') === false && strpos($matches[3], 'access_') === false)
                return $matches[0];

            $atts = shortcode_parse_atts($matches[3]);
            if (!is_array($atts))
                return $matches[0];

            $map_styles = self::get_map_styles();
            if (empty($atts['map_style_key'])) {
                switch ($map_styles[$atts['map_style']]['dependency']) {
                    case 'apikey':
                        $atts['map_style_key'] = !empty($atts['api_key']) ? $atts['api_key'] : null;
                        break;
                    case 'accesstoken':
                        $atts['map_style_key'] = !empty($atts['access_token']) ? $atts['access_token'] : null;
                        break;
                }
            }
            return self::get_shortcode_string(
                            $matches[2],
                            $atts,
                            $matches[5],
                            $matches[1] === '[' && $matches[6] === ']'
            );
        }

        /**
         * Generate shortcode strings with given params
         * 
         * @param string $name
         * @param array $attributes
         * @param string $content
         * @param boolean|false $double_bracket
         * @return string
         */
        private static function get_shortcode_string($name, $attributes, $content, $double_bracket = false) {
            return sprintf(
                    "[%s%s%s]%s[/%s%s]",
                    $double_bracket ? '[' : '',
                    $name,
                    empty($attributes) ? '' : ' ' . self::get_attributes_string($attributes),
                    $content,
                    $name,
                    $double_bracket ? ']' : ''
            );
        }

        /**
         * Get attribute string from array
         * @param array $attributes
         * @return string
         */
        private static function get_attributes_string($attributes) {
            $result = array();
            foreach ($attributes as $key => $value)
                $result[] = $key . '="' . esc_attr($value) . '"';
            return implode(' ', $result);
        }
    }

}