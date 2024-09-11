<?php

namespace WP_Pembinaan;

use WP_Pembinaan\Admin\Menu as AdminMenu;
use WP_Pembinaan\Controllers\HonorerController;
use WP_Pembinaan\Public\Assets as PublicAssets;
use WP_Pembinaan\Controllers\PegawaiController;
use WP_Pembinaan\Controllers\NotifikasiController;
use WP_Pembinaan\Controllers\DashboardController;

class Main {
    private $pegawai_controller;
    private $honorer_controller;
    private $notifikasi_controller;
    private $dashboard_controller;
    private $admin_menu;
    private $public_assets;

    public function __construct() {
        $this->pegawai_controller = new PegawaiController();
        $this->honorer_controller = new HonorerController();
        $this->notifikasi_controller = new NotifikasiController();
        $this->dashboard_controller = new DashboardController();
        $this->admin_menu = new AdminMenu();
        $this->public_assets = new PublicAssets();
    }

    public function run() {
        // Inisialisasi menu admin dan aset publik
        $this->admin_menu->initialize();
        $this->public_assets->initialize();
        // Pastikan rewrite rules ditambahkan
        add_action('init', array($this->dashboard_controller, 'initialize'));

        // Aktifkan plugin
        $this->activate();
    }

    public function activate() {
        try {
            $this->pegawai_controller->activate();
            $this->notifikasi_controller->activate();
            $this->honorer_controller->activate();
            // Flush rewrite rules saat aktivasi plugin
            flush_rewrite_rules();
        } catch (\Exception $e) {
            error_log('Error during activation: ' . $e->getMessage());
            wp_die('Error during activation: ' . $e->getMessage());
        }
    }

    public function deactivate() {
        // Flush rewrite rules saat plugin dinonaktifkan
        flush_rewrite_rules();
    }
}
