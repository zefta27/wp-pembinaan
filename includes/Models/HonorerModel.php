<?php

namespace WP_Pembinaan\Models;

class HonorerModel {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'honorer';
    }

    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            jabatan VARCHAR(100) NOT NULL,
            tanggal_lahir DATE NOT NULL,
            jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
            agama VARCHAR(50) NOT NULL,
            alamat TEXT NOT NULL,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function insert($data) {
        global $wpdb;
        $wpdb->insert($this->table_name, $data);
    }

    public function update($id, $data) {
        global $wpdb;
        $wpdb->update($this->table_name, $data, ['id' => $id]);
    }

    public function delete($id) {
        global $wpdb;
        $wpdb->delete($this->table_name, ['id' => $id]);
    }

    public function get_all() {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM $this->table_name");
    }
    public function get_count()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM $this->table_name");
    }

    public function get($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id));
    }
}
