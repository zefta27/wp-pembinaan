<?php

namespace WP_Pembinaan;

use WP_Pembinaan\Admin\Menu as AdminMenu;
use WP_Pembinaan\Public\Assets as PublicAssets;

use WP_Pembinaan\Controllers\PegawaiController;

class Main {
    private $pegawai_controller;
    private $admin_menu;
    private $public_assets;

    public function __construct() {
        $this->pegawai_controller = new PegawaiController();
        $this->admin_menu = new AdminMenu();
        $this->public_assets = new PublicAssets();
    }

    public function run() {
        $this->admin_menu->initialize();
        $this->public_assets->initialize();
        $this->activate();
    }

    public function activate() {
        try {
            $this->pegawai_controller->activate();
        } catch (\Exception $e) {
            error_log('Error during activation: ' . $e->getMessage());
            wp_die('Error during activation: ' . $e->getMessage());
        }
    }

    public function deactivate() {
        // Handle plugin deactivation if needed
    }
}
