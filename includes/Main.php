<?php

namespace WP_Pembinaan;

use WP_Pembinaan\Admin\Menu as AdminMenu;
use WP_Pembinaan\Controllers\HonorerController;
use WP_Pembinaan\Public\Assets as PublicAssets;
use WP_Pembinaan\Controllers\PegawaiController;
use WP_Pembinaan\Controllers\NotifikasiController;
use WP_Pembinaan\Controllers\DashboardController;
use WP_Pembinaan\Controllers\AdminController;
use WP_Pembinaan\Models\TipeNotifikasiModel;

class Main {
    private $pegawai_controller;
    private $honorer_controller;
    private $notifikasi_controller;
    private $dashboard_controller;
    private $admin_menu;
    private $public_assets;
    private $admin_controller;
    private $tipe_notifikasi_model;

    public function __construct() {
        $this->pegawai_controller = new PegawaiController();
        $this->honorer_controller = new HonorerController();
        $this->notifikasi_controller = new NotifikasiController();
        $this->dashboard_controller = new DashboardController();
        $this->admin_menu = new AdminMenu();
        $this->public_assets = new PublicAssets();
        $this->admin_controller = new AdminController();
        $this->tipe_notifikasi_model = new TipeNotifikasiModel();
    }

    // Fungsi untuk inisialisasi plugin
    public function run() {
        // Inisialisasi menu admin dan aset publik
        $this->admin_menu->initialize();
        $this->public_assets->initialize();

        // Tambahkan rewrite rules
        add_action('init', array($this->dashboard_controller, 'initialize'));
        add_action('init', array($this->notifikasi_controller, 'initialize'));

        // Rewrite rules akan di-flush saat pertama kali diinisialisasi
        flush_rewrite_rules(); 
    }

    // Fungsi untuk aktivasi plugin
    public static function activate() {
        try {
            $plugin = new self(); // Instansiasi objek Main
            $plugin->pegawai_controller->activate();
            $plugin->notifikasi_controller->activate();
            $plugin->honorer_controller->activate();
            $plugin->admin_controller->activate();
            
            // Flush rewrite rules saat aktivasi
            flush_rewrite_rules();
        } catch (\Exception $e) {
            error_log('Error during activation: ' . $e->getMessage());
            wp_die('Error during activation: ' . $e->getMessage());
        }
    }

    // Fungsi untuk deaktivasi plugin
    public static function deactivate() {
        try {
            $plugin = new self(); // Instansiasi objek Main
            // Hapus semua data tipe notifikasi
            $plugin->tipe_notifikasi_model->truncate();
            
            // Flush rewrite rules saat deaktivasi
            flush_rewrite_rules();
        } catch (\Exception $e) {
            error_log('Error during deactivation: ' . $e->getMessage());
            wp_die('Error during deactivation: ' . $e->getMessage());
        }
    }
}
