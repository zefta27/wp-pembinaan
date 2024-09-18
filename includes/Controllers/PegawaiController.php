<?php


namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\PegawaiModel;
use WP_Pembinaan\Models\NotifikasiModel;
use WP_Pembinaan\Models\HonorerModel;
use WP_Pembinaan\Controllers\NotifikasiController;
use WP_Pembinaan\Services\Utils;

class PegawaiController {
    private $pegawai_model;
    private $notifikasi_controller;
    private $notifikasi_model;
    private $honorer_m ; 
    private $utils;

    public function __construct() {
        $this->pegawai_model = new PegawaiModel();
        $this->notifikasi_controller = new NotifikasiController();
        $this->notifikasi_model = new NotifikasiModel();
        $this->honorer_m = new HonorerModel();
        $this->utils = new Utils();
        add_action('admin_post_add_pegawai', array($this, 'add_pegawai'));
        add_action('admin_post_edit_pegawai', array($this, 'edit_pegawai'));
        add_action('admin_post_delete_pegawai', array($this, 'delete_pegawai'));
    }

    public function activate() {
        $this->pegawai_model->create_table();  // Panggil fungsi create_table dari PegawaiModel
    }

    public function get_model() {
        return $this->pegawai_model;
    }

    public function add_pegawai() {
       
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           
             // Handle image upload
            $foto = '';
            if (!empty($_FILES['foto']['name'])) {
                $uploaded_file = $_FILES['foto'];

                // WordPress file upload handler
                $upload_overrides = ['test_form' => false]; // Skip form validation
                $movefile = wp_handle_upload($uploaded_file, $upload_overrides);

                if ($movefile && !isset($movefile['error'])) {
                    // File is uploaded successfully, add the file URL to the data array
                    $foto = $movefile['url']; // Save the URL of the uploaded image
                } else {
                    // Handle upload error
                    echo "Error uploading file: " . $movefile['error'];
                    exit;
                }
            } 

            // Ambil data dari form
            $data = [
                'nama' => sanitize_text_field($_POST['nama']),
                'jabatan' => sanitize_text_field($_POST['jabatan']),
                'gol_pangkat' => sanitize_text_field($_POST['gol_pangkat']),
                'eselon' => sanitize_text_field($_POST['eselon']),
                'bidang' => sanitize_text_field($_POST['bidang']),
                'nip' => sanitize_text_field($_POST['nip']),
                'nrp' => sanitize_text_field($_POST['nrp']),
                'no_hp' => sanitize_text_field($_POST['no_hp']),
                'kgb' => sanitize_text_field($_POST['kgb']),
                'agama' => sanitize_text_field($_POST['agama']),
                'foto' => $foto, 
                'is_pejabat_struktural' => isset($_POST['is_pejabat_struktural']) ? 1 : 0,
                'status_fungsional' => sanitize_text_field($_POST['status_fungsional'])
            ];
          
            $nip = $data['nip'];
            $data['tanggal_lahir'] = $this->utils->nipToTanggalLahir($nip);
            // Tambahkan Notfikasi Ultah    
            $this->notifikasi_controller->add_ultah_from_nip($data['nama'], $nip);
            $this->notifikasi_controller->add_kgb_from_pegawai($data);
            $this->pegawai_model->insert($data); // Mengembalikan ID dari pegawai baru
            
            wp_redirect(admin_url('admin.php?page=pegawai'));
            exit;
        }
    }

    public function edit_pegawai() {
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
            $this->pegawai_model->update($id, $data);

            wp_redirect(admin_url('admin.php?page=pegawai'));
            exit;
        }
    }

    public function delete_pegawai() {
        if (isset($_GET['id'])&&isset($_GET['nip'])) {
            $id = intval($_GET['id']);
            $nip = intval($_GET['nip']);

            $this->pegawai_model->delete($id);
            $this->notifikasi_model->delete_by_chain($nip);
        }   
        wp_redirect(admin_url('admin.php?page=pegawai'));
        exit;
    }

    public function display_page() {
        $employees = $this->pegawai_model->get_all();
        $honorers = $this->honorer_m->get_all();
        include_once WP_PEMBINAAN_PLUGIN_DIR . 'includes/Views/pegawai-view.php';
    }
    
 

}
