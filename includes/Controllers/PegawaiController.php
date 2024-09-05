<?php


namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\PegawaiModel;

class PegawaiController {
    private $pegawai_model;

    public function __construct() {
        $this->pegawai_model = new PegawaiModel();

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
                'is_pejabat_struktural' => isset($_POST['is_pejabat_struktural']) ? 1 : 0,
                'status_fungsional' => sanitize_text_field($_POST['status_fungsional'])
            ];

            // Lakukan perhitungan atau logika sebelum insert
            $id = $this->pegawai_model->insert($data); // Mengembalikan ID dari pegawai baru
            // $this->kenaikan_gaji_service->calculate($id, $data['nip'], $data['nrp'], $data['status_fungsional']);
            // $this->kenaikan_pangkat_service->calculate($id, $data['nip'], $data['nrp']);

            // Redirect setelah proses selesai
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
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->pegawai_model->delete($id);
        }
        wp_redirect(admin_url('admin.php?page=pegawai'));
        exit;
    }

    public function display_page() {
        $employees = $this->pegawai_model->get_all();
        // include_once WP_PEMBINAAN_PLUGIN_DIR . 'includes/views/pegawai/view-pegawai-list.php';
    }
}
