<?php

if (!defined('WPINC')) {
    die;
}

if (!class_exists('SBS_OpenStreetMap_Gutenberg')) {

    /**
     * Gutenberg block
     */
    class SBS_OpenStreetMap_Gutenberg extends SBS_OpenStreetMap_Base {

        /**
         * Constructor
         */
        public function __construct() {
            parent::__construct();
            add_action('init', array($this, 'register_block_assets'));
        }

        /**
         * Enqueue assets if needed
         */
        public function check_enqueue_assets() {
            $post = parent::check_enqueue_assets();
            if (!is_null($post) && function_exists('has_block') && has_block('stepbyteservice/openstreetmap', $post))
                $this->enqueue_assets();
        }

        /**
         * Register assets for Gutenberg block
         */
        public function register_block_assets() {
            wp_register_script(
                    'sbs-openstreetmap-block',
                    plugins_url(SBS_Plugin_OpenStreetMap::getAssetFilename('../assets/js/openstreetmap-block.js'), __FILE__),
                    array('wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-block-editor', 'sbs-openstreetmap'),
                    SBS_WP_OPENSTREETMAP_VERSION,
                    true
            );
            wp_set_script_translations('sbs-openstreetmap-block', 'stepbyteservice-openstreetmap', plugin_dir_path(__FILE__) . '../languages');
            wp_register_style(
                    'sbs-openstreetmap-block',
                    plugins_url(SBS_Plugin_OpenStreetMap::getAssetFilename('../assets/css/blockeditor.css'), __FILE__),
                    array('sbs-openstreetmap'),
                    SBS_WP_OPENSTREETMAP_VERSION
            );

            register_block_type('stepbyteservice/openstreetmap', array(
                'editor_script' => 'sbs-openstreetmap-block',
                'editor_style' => 'sbs-openstreetmap-block',
            ));
        }

    }

}
