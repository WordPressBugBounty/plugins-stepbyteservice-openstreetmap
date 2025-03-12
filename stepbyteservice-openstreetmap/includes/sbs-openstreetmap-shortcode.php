<?php

if (!defined('WPINC')) {
    die;
}

if (!class_exists('SBS_OpenStreetMap_Shortcode')) {

    /**
     * WordPress shortcode
     */
    class SBS_OpenStreetMap_Shortcode extends SBS_OpenStreetMap_Base {

        /**
         * Constructor
         */
        public function __construct() {
            parent::__construct();
            add_shortcode('sbs_openstreetmap', array($this, 'get_shortcode_content'));
            add_shortcode('sbs_marker', array($this, 'get_shortcode_content_marker'));
        }

        /**
         * Enqueue assets if needed
         */
        public function check_enqueue_assets() {
            $post = parent::check_enqueue_assets();
            if (!is_null($post) && (has_shortcode($post->post_content, 'sbs_openstreetmap') || has_shortcode($post->post_content, 'sbs_marker')))
                $this->enqueue_assets();
        }

        /**
         * Returns generated HTML from shortcode
         * 
         * @param array $attributes
         * @param string|null $content
         * @return string
         */
        public function get_shortcode_content($attributes, $content = null) {
            $attributes = parent::merge_default_attributes($attributes);
            $content = str_replace(array('<br/>', '<br />'), '', $content);
            return parent::get_content($attributes, $content);
        }
        
         /**
         * Returns generated HTML from marker shortcode
         * 
         * @param array $attributes
         * @param string|null $content
         * @return string
         */
        public function get_shortcode_content_marker($attributes, $content = null) {
            $attributes = parent::merge_default_marker_attributes($attributes);
            return parent::get_content_marker($attributes, $content);
        }

    }

}
