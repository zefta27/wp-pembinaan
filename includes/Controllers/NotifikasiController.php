<?php
namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\NotifikasiModel;
use WP_Pembinaan\Services\Utils;

class NotifikasiController {
    private $model;
    private $utils;

    public function __construct() {
        $this->model = new NotifikasiModel();
        $this->utils = new Utils();
        add_action('admin_post_add_notifikasi', array($this, 'add_notifikasi'));
        add_action('admin_post_nopriv_add_notifikasi', array($this, 'add_notifikasi')); // Jika juga untuk pengguna yang tidak login
        add_action('admin_post_hapus_notifikasi', array($this, 'hapus_notifikasi'));

    }

    public function index(){
        $notifikasi = $this->model->get_all();
        include_once WP_PEMBINAAN_PLUGIN_DIR . 'includes/views/notifikasi-view.php';
    
    }
    public function activate() {
        $this->model->create_table();  // Panggil fungsi create_table dari PegawaiModel
    }
   
    // Menambah notifikasi
    public function add_notifikasi() {
       
        // Cek apakah request-nya POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Cek validitas nonce
            if (!isset($_POST['notifikasi_nonce']) || !wp_verify_nonce($_POST['notifikasi_nonce'], 'notifikasi_add_action')) {
                wp_die(__('Invalid nonce specified', 'wp-pembinaan'));
            }
    
            // Proses data
            $data = [
                'nama' => sanitize_text_field($_POST['nama']),
                'deskripsi' => sanitize_textarea_field($_POST['deskripsi']),
                'tipe' => sanitize_text_field($_POST['tipe']),
                'tanggal' => sanitize_text_field($_POST['tanggal']),
                'date_created' => current_time('mysql'),
                'date_modified' => current_time('mysql')
            ];
    
            // Simpan ke model (pastikan model sudah ada dan benar)
            $this->model->add($data);
    
            // Redirect setelah sukses
            wp_redirect(admin_url('admin.php?page=Notifikasi'));
            exit;
        }
    }
    

    // Mengupdate notifikasi

    public function update($id, $data) {
        $this->model->update($id, $data);
        wp_redirect(admin_url('admin.php?page=Notifikasi'));
    }

    // Menghapus notifikasi
    public function hapus_notifikasi() {

        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
    
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->model->delete($id); // Pastikan model Anda sudah memiliki metode delete
        }
    
        wp_redirect(admin_url('admin.php?page=Notifikasi')); // Redirect ke halaman yang tepat setelah penghapusan
        exit;
    }
    public function add_ultah_from_nip($nama, $nip)
    {   
        // Ekstrak bulan dan hari dari NIP
        $bulan = substr($nip, 4, 2);
        $hari = substr($nip, 6, 2);

        // Buat tanggal lahir untuk tahun saat ini
        $tahun_sekarang = date("Y");
        $tanggal_lahir = $tahun_sekarang . '-' . $bulan . '-' . $hari;

        // Cek apakah tanggal lahir tahun ini sudah lewat atau belum
        $tanggal_sekarang = date("Y-m-d");
        if ($tanggal_lahir < $tanggal_sekarang) {
            // Tambahkan satu tahun jika tanggal ulang tahun sudah lewat
            $tanggal_lahir = ($tahun_sekarang + 1) . '-' . $bulan . '-' . $hari;
        }

        // Persiapkan data untuk disimpan
        $data = [
            'nama' => 'Ulang Tahun ' . $nama,
            'deskripsi' => 'Selamat ulang tahun ' . $nama . ' yang lahir pada tanggal ' . $tanggal_lahir,
            'tipe' => 'ulang tahun',
            'tanggal' => $tanggal_lahir,
            'chain' => $nip
        ];

        // Simpan data ke model
        $this->model->add($data);
    }
    public function add_kgb_from_pegawai($data){
        $data_notif = [
            'nama' => 'Kenaikan Gaji Berkala (KGB) '.$data['nama'],
            'deskripsi' => 'Kenaikan gaji berkala :'.$data['nama'].', pada tanggal :'.$this->utils->formatTanggal($data['kgb']),
            'tipe' => 'kgb',
            'tanggal'=> $this->utils->kurangkanDuaBulan($data['kgb']),
            'chain' => $data['nip']
        ];           
        $this->model->add($data_notif);
    }

}
