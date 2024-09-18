<?php
namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\NotifikasiModel;
use WP_Pembinaan\Models\PegawaiModel;
use WP_Pembinaan\Services\Utils;

class NotifikasiController {
    private $notifikasi_m;
    private $pegawai_m;
    private $utils;

    public function __construct() {
        $this->notifikasi_m = new NotifikasiModel();
        $this->pegawai_m = new PegawaiModel();
        $this->utils = new Utils();
        add_action('admin_post_add_notifikasi', array($this, 'add_notifikasi'));
        add_action('admin_post_nopriv_add_notifikasi', array($this, 'add_notifikasi')); // Jika juga untuk pengguna yang tidak login
        add_action('admin_post_hapus_notifikasi', array($this, 'hapus_notifikasi'));
        add_action('template_redirect', array($this, 'cek_renewal'));
        add_filter('query_vars', array($this, 'add_query_vars'));

    }
    
    public function index(){
        $notifikasi = $this->notifikasi_m->get_all();
        include_once WP_PEMBINAAN_PLUGIN_DIR . 'includes/views/notifikasi-view.php';
    
    }
    public function activate() {
        $this->notifikasi_m->create_table();  // Panggil fungsi create_table dari PegawaiModel
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
            $this->notifikasi_m->add($data);
    
            // Redirect setelah sukses
            wp_redirect(admin_url('admin.php?page=Notifikasi'));
            exit;
        }
    }
    

    // Mengupdate notifikasi

    public function update($id, $data) {
        $this->notifikasi_m->update($id, $data);
        wp_redirect(admin_url('admin.php?page=Notifikasi'));
    }

    // Menghapus notifikasi
    public function hapus_notifikasi() {

        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
    
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->notifikasi_m->delete($id); // Pastikan model Anda sudah memiliki metode delete
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
        $this->notifikasi_m->add($data);
    }
    public function add_kgb_from_pegawai($data){
        $data_notif = [
            'nama' => 'Kenaikan Gaji Berkala (KGB) '.$data['nama'],
            'deskripsi' => 'Kenaikan gaji berkala :'.$data['nama'].', pada tanggal :'.$this->utils->formatTanggal($data['kgb']),
            'tipe' => 'kgb',
            'tanggal'=> $this->utils->kurangkanDuaBulan($data['kgb']),
            'chain' => $data['nip']
        ];           
        $this->notifikasi_m->add($data_notif);
    }

    public function initialize() {
        add_rewrite_rule(
            '^cek_renewal/?$',  // URL yang diakses oleh user
            'index.php?cek_renewal_page=1',  // Query var yang digunakan oleh WP
            'top'  // Prioritas tinggi
        );
    }

    public function cek_renewal(){
        if (get_query_var('cek_renewal_page')) {
           
            $cek_kgb = $this->notifikasi_m->cek_renewal('kgb');
            $cek_birthday = $this->notifikasi_m->cek_renewal('ulang tahun');
            if (!empty($cek_kgb)) {
                foreach ($cek_kgb as $record) {
                    // Menghitung tanggal dua tahun kedepan dari tanggal record
                    $new_date_notif = date('Y-m-d', strtotime($record->tanggal . ' +2 years'));
                    $new_date_kgb = date('Y-m-d', strtotime($record->tanggal . ' +2 years +1 day'));
            
                    // Mempersiapkan data yang sama dengan tanggal yang baru
                    $data = [
                        'nama'       => $record->nama,
                        'deskripsi'  => 'Kenaikan gaji berkala :'.$record->nama.', pada tanggal :'.$this->utils->formatTanggal($new_date_kgb),
                        'tipe'       => $record->tipe,
                        'tanggal'    => $new_date_notif,
                        'chain'      => $record->chain,
                        'date_created' => current_time('mysql', 1)  // Menggunakan waktu saat ini
                    ];
                    
                    // Menyisipkan data ke dalam database
                    if(empty($this->notifikasi_m->cek_existing_date($record->tipe, $record->chain, $new_date_notif)))
                    {
                        $this->notifikasi_m->add($data);
                        $this->pegawai_m->update_kgb($record->chain, $new_date_kgb);
                        print_r($data);
                    }else{
                        echo "Notif tanggal kgb sudah ada di database";
                    }
                }
            }
            if(!empty($cek_birthday)){
                foreach ($cek_birthday as $record1) {
                    // Menghitung tanggal dua tahun kedepan dari tanggal record
                    $new_date_notif = date('Y-m-d', strtotime($record1->tanggal . ' +1 years'));
                    
                    // Mempersiapkan data yang sama dengan tanggal yang baru
                    $data = [
                        'nama'       => $record1->nama,
                        'deskripsi'  => 'Selamat ulang tahun ' . $record1->nama . ' yang lahir pada tanggal ' . $record1->tanggal,
                        'tipe'       => $record1->tipe,
                        'tanggal'    => $new_date_notif,
                        'chain'      => $record1->chain,
                        'date_created' => current_time('mysql', 1)  // Menggunakan waktu saat ini
                    ];
                    
                    // Menyisipkan data ke dalam database
                    if(empty($this->notifikasi_m->cek_existing_date($record1->tipe, $record1->chain, $new_date_notif)))
                    {
                        $this->notifikasi_m->add($data);
                        print_r($data);
                    }else{
                        echo "Notif tanggal ulang tahun sudah ada di database";
                    }
                    exit();
                }
            }
            else{
                echo " Tidak ada data yang di perbaharui";
                exit();
            }
            // include plugin_dir_path(__FILE__) . '../Views/dashboard-view.php';
        }
    }

    public function add_query_vars($vars) {
        $vars[] = 'cek_renewal_page';
        return $vars;
    }
}
