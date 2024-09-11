<?php


namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\PegawaiModel;
use WP_Pembinaan\Models\HonorerModel;
use WP_Pembinaan\Models\NotifikasiModel;
use WP_Pembinaan\Controllers\NotifikasiController;
use WP_Pembinaan\Services\Utils;

class HonorerController {
  

    private $honorer_m;
    private $utils;

    
    public function __construct() {
        
        $this->honorer_m = new HonorerModel();
        $this->utils = new Utils();
        add_action('admin_post_add_honorer', array($this, 'add_honorer'));
        add_action('admin_post_edit_honorer', array($this, 'edit_honorer'));
        add_action('admin_post_delete_honorer', array($this, 'delete_honorer'));
    }

    public function activate() {
        $this->honorer_m->create_table();  // Panggil fungsi create_table dari honorerModel
    }

    public function get_model() {
        return $this->honorer_m;
    }

    public function add_honorer() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
            // Ambil data dari form dan sanitasi input
            $data = [
                'nama' => sanitize_text_field($_POST['nama']),
                'jabatan' => sanitize_text_field($_POST['jabatan']),
                'tanggal_lahir' => sanitize_text_field($_POST['tanggal_lahir']),
                'jenis_kelamin' => sanitize_text_field($_POST['jenis_kelamin']),
                'agama' => sanitize_text_field($_POST['agama']),
                'alamat' => sanitize_textarea_field($_POST['alamat']),
            ];
    
            // Masukkan data ke dalam database
            $this->honorer_m->insert($data);
    
            // Redirect setelah data berhasil ditambahkan
            wp_redirect(admin_url('admin.php?page=pegawai'));
            exit;
        }
    }
    

    public function edit_honorer() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = intval($_POST['id']);
            $data = [
                'nama' => sanitize_text_field($_POST['nama']),
                'jabatan' => sanitize_text_field($_POST['jabatan']),
                'gol_pangkat' => sanitize_text_field($_POST['gol_pangkat']),
                'nip' => sanitize_text_field($_POST['nip']),
                'nrp' => sanitize_text_field($_POST['nrp']),
                'no_hp' => sanitize_text_field($_POST['no_hp']),
                'status_fungsional' => sanitize_text_field($_POST['status_fungsional']),
                'is_pejabat_struktural' => isset($_POST['is_pejabat_struktural']) ? 1 : 0,
            ];
            $this->honorer_m->update($id, $data);

            wp_redirect(admin_url('admin.php?page=pegawai'));
            exit;
        }
    }

    public function delete_honorer() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);

            $this->honorer_m->delete($id);
        }   
        wp_redirect(admin_url('admin.php?page=pegawai'));
        exit;
    }

  
    
 

}
