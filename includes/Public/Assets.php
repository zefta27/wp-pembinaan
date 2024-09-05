<?php

namespace WP_Pembinaan\Public;

class Assets {
    public function initialize() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_assets'));
    }

    public function enqueue_admin_assets($hook) {
        // Load assets only on the plugin's admin pages
        if (strpos($hook, 'wp-pembinaan') !== false) {
            wp_enqueue_style('wp-pembinaan-admin-style', plugins_url('../../assets/css/admin-style.css', __FILE__));
            wp_enqueue_script('wp-pembinaan-admin-script', plugins_url('../../assets/js/admin-script.js', __FILE__), array('jquery'), null, true);
        }
    }

    public function enqueue_public_assets() {
        wp_enqueue_style('wp-pembinaan-public-style', plugins_url('../../assets/css/style.css', __FILE__));
        wp_enqueue_script('wp-pembinaan-public-script', plugins_url('../../assets/js/script.js', __FILE__), array('jquery'), null, true);
    }
}
