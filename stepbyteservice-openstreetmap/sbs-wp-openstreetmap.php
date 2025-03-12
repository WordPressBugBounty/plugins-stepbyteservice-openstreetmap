<?php

/**
 * Plugin Name:       OpenStreetMap for Gutenberg and WPBakery Page Builder (formerly Visual Composer)
 * Description:       OpenStreetMap Gutenberg block, WPBakery PageBuilder content element and standalone WordPress shortcode
 * Version:           1.2.0
 * Author:            Step-Byte-Service GmbH
 * Author URI:        https://www.step-byte-service.com
 * License:           GPLv2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       stepbyteservice-openstreetmap
 */
if (!defined('WPINC')) {
    die;
}

if (!class_exists('SBS_Plugin_OpenStreetMap')) {

    require __DIR__ . '/includes/sbs-openstreetmap-base.php';
    require __DIR__ . '/includes/sbs-openstreetmap-shortcode.php';
    require __DIR__ . '/includes/sbs-openstreetmap-gutenberg.php';
    require __DIR__ . '/includes/sbs-openstreetmap-wpbakery.php';

    define('SBS_WP_OPENSTREETMAP_VERSION', '1.2.0');
    define('SBS_WP_OPENSTREETMAP_DEBUG', false);

    class SBS_Plugin_OpenStreetMap
    {

        /**
         * Constructor
         * 
         * Initialize components
         */
        public function __construct()
        {
            add_action('init', array($this, 'register_assets'), 0);
            add_action('plugins_loaded', array($this, 'load_textdomain'));
            if (!defined('DISABLE_SBSOSM_MARKER_MIGRATION') || DISABLE_SBSOSM_MARKER_MIGRATION !== true) {
                add_filter('the_editor_content', array('SBS_OpenStreetMap_Base', 'migrate_shortcode'), 9);
                add_filter('the_content', array('SBS_OpenStreetMap_Base', 'migrate_shortcode'), 9);
                add_action('the_post', array('SBS_OpenStreetMap_Base', 'migrate_post'), 9);
            }
            new SBS_OpenStreetMap_Shortcode();
            new SBS_OpenStreetMap_Gutenberg();
            new SBS_OpenStreetMap_WPBakery();
        }

        /**
         * Register JavaScript and CSS files for WordPress frontend (also used by Gutenberg backend)
         */
        public function register_assets()
        {
            wp_register_style('sbs-openstreetmap', plugins_url(self::getAssetFilename('assets/css/style.css'), __FILE__), array(), SBS_WP_OPENSTREETMAP_VERSION);
            wp_register_script('sbs-openstreetmap', plugins_url(self::getAssetFilename('assets/js/sbs-wp-openstreetmap.js'), __FILE__), array(), SBS_WP_OPENSTREETMAP_VERSION, true);
            $script = 'window.stepbyteservice = window.stepbyteservice || {};';
            $script .= 'window.stepbyteservice.osmglobals = ' . wp_json_encode(SBS_OpenStreetMap_Base::get_sbs_openstreetmap_object());
            wp_add_inline_script('sbs-openstreetmap', $script, 'before');
        }

        /**
         * Load the text domain according to WordPress locale
         */
        public function load_textdomain()
        {
            load_textdomain(
                'stepbyteservice-openstreetmap',
                plugin_dir_path(__FILE__)
                    . 'languages/'
                    . 'stepbyteservice-openstreetmap'
                    . '-'
                    . (is_admin() ? get_user_locale() : get_locale())
                    . '.mo'
            );
        }

        public static function getAssetFilename($filename)
        {
            $debug = defined('SBS_WP_OPENSTREETMAP_DEBUG') && SBS_WP_OPENSTREETMAP_DEBUG;
            if (!$debug) {
                $filename = preg_replace('/(\.min)?(\.[^.]+)$/', '.min$2', $filename);
            }
            return $filename;
        }
    }

    new SBS_Plugin_OpenStreetMap();
}
