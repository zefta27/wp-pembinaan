<?php

namespace WP_Pembinaan\Models;

class PegawaiModel {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'pembinaan_pegawai';
    }

    // Fungsi untuk membuat tabel pegawai
    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nama varchar(255) NOT NULL,
            nip varchar(18) NOT NULL UNIQUE,
            nrp varchar(10) NOT NULL,
            status_fungsional varchar(50) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Fungsi untuk memasukkan data pegawai baru
    public function insert($data) {
        global $wpdb;
        $wpdb->insert($this->table_name, $data);
        return $wpdb->insert_id;  // Mengembalikan ID dari data yang baru dimasukkan
    }

    // Fungsi untuk menghapus data pegawai berdasarkan ID
    public function delete($id) {
        global $wpdb;
        return $wpdb->delete($this->table_name, ['id' => $id]);
    }

    // Fungsi untuk mendapatkan semua data pegawai
    public function get_all() {
        global $wpdb;
        $query = "SELECT * FROM $this->table_name";
        return $wpdb->get_results($query);
    }

    // Fungsi untuk memperbarui data pegawai
    public function update($id, $data) {
        global $wpdb;
        $wpdb->update($this->table_name, $data, ['id' => $id]);
    }
}
