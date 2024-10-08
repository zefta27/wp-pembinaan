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

        add_submenu_page(
            'wp-pembinaan',
            'Notifikasi',
            'Notifikasi',
            'manage_options',
            'Notifikasi',
            array($this, 'display_notifikasi_page')
        );
    }

    public function display_admin_page() {

        $admin_controller = new \WP_Pembinaan\Controllers\AdminController();
        $admin_controller->index();
     }

    public function display_pegawai_page() {
        $pegawai_controller = new \WP_Pembinaan\Controllers\PegawaiController();
        $pegawai_controller->display_page();
    }

    public function display_notifikasi_page(){
        $controller = new \WP_Pembinaan\Controllers\NotifikasiController();
        $controller->index();
    }
}
