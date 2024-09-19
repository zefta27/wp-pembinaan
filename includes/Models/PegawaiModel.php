<?php

namespace WP_Pembinaan\Models;

class PegawaiModel {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'pegawai';
    }

    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nama varchar(255) NOT NULL,
            jabatan varchar(255) NOT NULL,
            gol_pangkat varchar(255) NOT NULL,
            nip varchar(255) NOT NULL,
            nrp varchar(255) NOT NULL,
            no_hp varchar(255) NOT NULL,
            bidang varchar(255) NOT NULL,
            eselon varchar(255) NOT NULL,
            status_fungsional varchar(255) NOT NULL,
            is_pejabat_struktural boolean NOT NULL DEFAULT false,
            tanggal_lahir date NOT NULL,
            kgb date NOT NULL,
            agama varchar(255) NOT NULL, -- New agama column
            foto varchar(255) DEFAULT NULL, -- New foto column with default NULL
            PRIMARY KEY  (id)
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

    public function update_kgb($nip, $kgb) {
        global $wpdb;
        $wpdb->update($this->table_name, ['kgb'=>$kgb], ['nip' => $nip]);
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

    public function get_count_by_status_fungsional()
    {
        global $wpdb;
        
        // Mengambil jumlah data yang dikelompokkan berdasarkan status_fungsional
        $results = $wpdb->get_results("
            SELECT status_fungsional, COUNT(*) as total 
            FROM $this->table_name 
            GROUP BY status_fungsional
        ");
    
        return $results;
    }
    public function get_count_sel_by_status_fungsional($status_fungsional)
    {
        global $wpdb;
        // Menggunakan %s untuk string dan prepare() untuk keamanan
        $query = $wpdb->prepare("SELECT COUNT(*) FROM $this->table_name WHERE status_fungsional = %s", $status_fungsional);
        return $wpdb->get_var($query);
    }

    public function get($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id));
    }
}
