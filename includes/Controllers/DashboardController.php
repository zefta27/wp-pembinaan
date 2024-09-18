<?php

namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\NotifikasiModel;
use WP_Pembinaan\Services\Utils;

class DashboardController {
    private $notifikasi_model;
    private $utils;

    public function __construct() {
        $this->notifikasi_model = new NotifikasiModel();
        $this->utils = new Utils();
        // Daftarkan tindakan untuk menangani template dan query var
        add_action('template_redirect', array($this, 'index'));
        add_filter('query_vars', array($this, 'add_query_vars'));
   
    }
   
      
    
    // Fungsi untuk menangani tampilan halaman dashboard
    public function index() {
        $grouped_notifications = $this->notifikasi_model->grouping_timeline();
    
        // Include the view file and pass the grouped data to it
        if (get_query_var('dashboard_page')) {
            include plugin_dir_path(__FILE__) . '../Views/dashboard-view.php';
        }
    }
    

    // Fungsi untuk menambahkan aturan rewrite untuk halaman dashboard
    public function initialize() {
        add_rewrite_rule(
            '^dashboard/?$',  // URL yang diakses oleh user
            'index.php?dashboard_page=1',  // Query var yang digunakan oleh WP
            'top'  // Prioritas tinggi
        );
    }

    // Fungsi untuk menambahkan query var 'dashboard_page' agar bisa dikenali oleh WP
    public function add_query_vars($vars) {
        $vars[] = 'dashboard_page';
        return $vars;
    }
}
