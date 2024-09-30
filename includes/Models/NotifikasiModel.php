<?php
namespace WP_Pembinaan\Models;

class NotifikasiModel {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'notifikasi';
    }

    // Membuat tabel notifikasi
    public function create_table() {
        global $wpdb;
    
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $this->table_name;
    
        // Cek apakah tabel sudah ada, jika belum maka buat tabel
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            deskripsi TEXT NOT NULL,
            tipe VARCHAR(50) NOT NULL,
            tanggal DATE NOT NULL,
            chain VARCHAR(255) DEFAULT NULL,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
            date_modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) $charset_collate;";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    

    // Mendapatkan semua notifikasi
    public function get_all() {
        global $wpdb;
        // Tambahkan ORDER BY untuk mengurutkan berdasarkan kolom tanggal dari yang terdekat (ASC)
        $query = "SELECT * FROM {$this->table_name} ORDER BY tanggal ASC";
        return $wpdb->get_results($query);
    }
    

    public function get_now_to_future() {
        global $wpdb;
    
        // Ambil semua notifikasi yang tanggalnya mulai dari hari ini dan seterusnya
        $query = $wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE tanggal >= %s ORDER BY tanggal ASC Limit 4 ",
            date('Y-m-d') // Format tanggal untuk hari ini
        );
    
        return $wpdb->get_results($query);
    }
    public function cek_renewal($tipe) {
        global $wpdb;
        $yesterday = date('Y-m-d', strtotime('-1 day')); // Menghitung tanggal kemarin
    
        $query = $wpdb->prepare(
            "SELECT * FROM {$this->table_name}
             WHERE tipe = %s
             AND tanggal = %s", 
             $tipe, $yesterday
        );
    
        return $wpdb->get_results($query);
    }

 
    public function cek_existing_date($tipe, $chain, $tanggal) {
        global $wpdb;
       
        $query = $wpdb->prepare(
            "SELECT * FROM {$this->table_name}
             WHERE tipe = '%s'
             AND tanggal = %s
             AND chain = %s", 
            $tipe, $tanggal, $chain
        );
    
        return $wpdb->get_results($query);
    }
    
    // public function cek_kgb_notif($tanggal, $)

    public function grouping_timeline() {
        global $wpdb;
        $query = $wpdb->prepare(
            "SELECT tanggal, tipe, nama, deskripsi
             FROM {$this->table_name}
             WHERE tanggal >= %s
             ORDER BY tanggal ASC, tipe limit 3",
            date('Y-m-d') // Today's date
        );
        
        $results = $wpdb->get_results($query);
        $grouped = [];
    
        foreach ($results as $row) {
            $formatted_date = date('d - m - Y', strtotime($row->tanggal));
            $grouped[$formatted_date][$row->tipe][] = [
                'nama' => $row->nama,
                'deskripsi' => $row->deskripsi
            ];
        }
    
        return $grouped;
    }
    
    
    // Menambah notifikasi baru
    public function add($data) {
        global $wpdb;
        $wpdb->insert($this->table_name, $data);
        return $wpdb->insert_id;
    }

    // Mengupdate notifikasi
    public function update($id, $data) {
        global $wpdb;
        return $wpdb->update($this->table_name, $data, ['id' => $id]);
    }

    // Menghapus notifikasi
    public function delete($id) {
        global $wpdb;
        return $wpdb->delete($this->table_name, ['id' => $id]);
    }

    public function delete_by_chain($chain) {
        global $wpdb;
        return $wpdb->delete($this->table_name, ['chain' => $chain]);
    }

    

    // Mendapatkan notifikasi berdasarkan ID
    public function get_by_id($id) {
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id);
        return $wpdb->get_row($query);
    }
}
