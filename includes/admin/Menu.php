<?php

namespace WP_Pembinaan\Admin;

class Menu {
    public function initialize() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'WP Pembinaan',
            'WP Pembinaan',
            'manage_options',
            'wp-pembinaan',
            array($this, 'display_admin_page'),
            'dashicons-admin-home',
            6
        );

        add_submenu_page(
            'wp-pembinaan',
            'Pegawai',
            'Pegawai',
            'manage_options',
            'pegawai',
            array($this, 'display_pegawai_page')
        );
    }

    public function display_admin_page() {
        echo '<div class="wrap"><h1>WP Pembinaan Admin Page</h1></div>';
    }

    public function display_pegawai_page() {
        $pegawai_controller = new \WP_Pembinaan\Controllers\PegawaiController();
        $pegawai_controller->display_page();
    }
}
