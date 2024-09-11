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
        // Periksa apakah query var 'dashboard_page' ada
        $notifikasi = $this->notifikasi_model->get_now_to_future();

        if (get_query_var('dashboard_page')) {
            include plugin_dir_path(__FILE__) . '../views/dashboard-view.php';
            exit;
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
