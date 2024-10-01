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
            // Enqueue Bootstrap CSS & JS
            wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
            wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js', array('jquery'), null, true);

            // Enqueue DataTables CSS & JS
            wp_enqueue_style('datatable', 'https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css');
            wp_enqueue_style('datatable-css-bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css');
            wp_enqueue_style('datatable-css', 'https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap4.css');
            wp_enqueue_script('jquery','https://code.jquery.com/jquery-3.6.0.min.js');
            wp_enqueue_script('datatable-js', 'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js', array('jquery'), null, true);
            
            // Enqueue Font Awesome
            wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
            wp_enqueue_style('dashboard-styles', plugins_url('../../assets/css/admin.css', __FILE__), array(), '1.0.0', 'all');

        }
    }

    public function enqueue_public_assets() {
        wp_enqueue_style('dashboard-styles', plugins_url('../../assets/css/style.css', __FILE__), array(), '1.0.0', 'all');
    }
}
