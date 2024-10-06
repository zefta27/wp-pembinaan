<?php
namespace WP_Pembinaan\Models;

class TipeNotifikasiModel {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'tipe_notifikasi';
    }

    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            warna VARCHAR(7) NOT NULL, /* Format hexa warna */
            is_aktif TINYINT(1) DEFAULT 0, /* Status aktif: 0 = tidak aktif, 1 = aktif */
            auto_notif TINYINT(1) DEFAULT 0, /* Auto notif: 0 = manual, 1 = otomatis */
            tanggal_notif BIGINT(20) DEFAULT 0, /* Tanggal notif dalam bentuk angka */
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Insert default data setelah tabel dibuat
        $this->insert_default_data();
    }

    private function insert_default_data() {
        $default_notifications = [
            ['nama' => 'Ulang Tahun', 'warna' => $this->generate_random_color()],
            ['nama' => 'KGB', 'warna' => $this->generate_random_color()],
            ['nama' => 'Kenaikan Pangkat', 'warna' => $this->generate_random_color()],
            ['nama' => 'Laporan Triwulan', 'warna' => $this->generate_random_color()],
            ['nama' => 'Laporan Tahunan', 'warna' => $this->generate_random_color()],
            ['nama' => 'Satya Lencana', 'warna' => $this->generate_random_color()],
            ['nama' => 'Pengumuman', 'warna' => $this->generate_random_color()],
            ['nama' => 'Zoom Meeting', 'warna' => $this->generate_random_color()],
            ['nama' => 'Lainnya', 'warna' => $this->generate_random_color()],
        ];

        foreach ($default_notifications as $notif) {
             // Default tanggal notif 0 (belum ada)
            $this->insert($notif);
        }
    }

    private function generate_random_color() {
        // Menghasilkan warna soft secara acak dalam format hexa
        $r = mt_rand(150, 255);
        $g = mt_rand(150, 255);
        $b = mt_rand(150, 255);
        return sprintf("#%02x%02x%02x", $r, $g, $b);
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

    public function get_count() {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM $this->table_name");
    }

    public function get($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id));
    }
    public function truncate() {
        global $wpdb;
        $wpdb->query("TRUNCATE TABLE $this->table_name");
    }
    
}
