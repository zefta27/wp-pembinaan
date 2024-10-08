<?php

namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\NotifikasiModel;
use WP_Pembinaan\Models\PegawaiModel;
use WP_Pembinaan\Models\HonorerModel;
use WP_Pembinaan\Services\Utils;

class DashboardController {
    private $notifikasi_m;   
    private $pegawai_m;
    private $honorer_m;
    private $utils;

    public function __construct() {
        $this->notifikasi_m = new NotifikasiModel();
        $this->pegawai_m = new PegawaiModel();
        $this->honorer_m = new HonorerModel();
        $this->utils = new Utils();
        // Daftarkan tindakan untuk menangani template dan query var
        add_action('template_redirect', array($this, 'index'));
        add_filter('query_vars', array($this, 'add_query_vars'));
   
    }
   
      
    
    // Fungsi untuk menangani tampilan halaman dashboard
    public function index() {
        $grouped_notifications = $this->notifikasi_m->grouping_timeline();
        $c_pegawai = $this->pegawai_m->get_count();
        $c_tata_usaha = $this->pegawai_m->get_count_sel_by_status_fungsional('Tata Usaha');
        $c_jaksa = $this->pegawai_m->get_count_sel_by_status_fungsional('Jaksa');
        $c_honorer = $this->honorer_m->get_count();
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
