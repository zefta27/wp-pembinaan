<?php


namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\PegawaiModel;
use WP_Pembinaan\Models\NotifikasiModel;
use WP_Pembinaan\Models\HonorerModel;
use WP_Pembinaan\Controllers\NotifikasiController;
use WP_Pembinaan\Services\Utils;

use PhpOffice\PhpSpreadsheet\IOFactory;

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
        add_action('admin_post_upload_csv_pegawai', array($this, 'upload_csv_pegawai'));
        add_action('admin_post_edit_pegawai', array($this, 'edit_pegawai'));
        add_action('admin_post_delete_pegawai', array($this, 'delete_pegawai'));
    }

    public function activate() {
        $this->pegawai_model->create_table();  // Panggil fungsi create_table dari PegawaiModel
    }

    public function get_model() {
        return $this->pegawai_model;
    }
  

    public function upload_csv_pegawai(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Assuming the uploaded Excel file is being handled as $_FILES['csv_file']
            $file_tmp = $_FILES['csv_file']['tmp_name'];
            
            // Load the Excel file
            $spreadsheet = IOFactory::load($file_tmp);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
    
            
            foreach ($rows as $index => $row) {
                // Skip header row (usually the first row)
                if ($index === 0) {
                    continue;
                }
    
                // Check if all fields in the row are empty
                if (empty($row[0]) && empty($row[1]) && empty($row[2]) && empty($row[3]) && empty($row[4]) && empty($row[5])) {
                    continue; // Skip this row
                }
    
                // Split the nip_nrp field into nip and nrp
                $nip_nrp = isset($row[4]) ? explode('/', $row[4]) : [];
                $nip = isset($nip_nrp[0]) ? trim($nip_nrp[0]) : null;
                $nrp = isset($nip_nrp[1]) ? trim($nip_nrp[1]) : null;
    
                // Determine the status_fungsional based on the presence of "Jaksa" in gol_pangkat
                $gol_pangkat = $row[3];
                $status_fungsional = (strpos($gol_pangkat, 'Jaksa') !== false) ? 'Jaksa' : 'Tata Usaha';

                $tanggal_lahir = $this->utils->nipToTanggalLahir($nip);

    
                $pegawai = [
                    'nama' => $row[1],
                    'jabatan' => $row[2],
                    'gol_pangkat' => $gol_pangkat,
                    'nip' => $nip,
                    'nrp' => $nrp,
                    'eselon' => $row[5],
                    'status_fungsional' => $status_fungsional,
                    'tanggal_lahir' => $tanggal_lahir
                ];
                $tanggal_masuk = $this->utils->nipToTanggalMasuk($nip);
                if (!$this->is_nip_exist($nip)) {
                    $this->notifikasi_controller->add_ultah_from_nip($pegawai['nama'], $nip);
                    $this->notifikasi_controller->add_satyalencana_from_pegawai($pegawai, $tanggal_masuk);
                    $this->pegawai_model->insert($pegawai); // Mengembalikan ID dari pegawai baru
                }
                
         
            
                // $pegawai_data[] = $pegawai;
            }
    
            wp_redirect(admin_url('admin.php?page=pegawai'));
            exit;
            
        }
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
            $tanggal_masuk = $this->utils->nipToTanggalMasuk($nip);
            
            if (!$this->is_nip_exist($nip)) {
                $this->notifikasi_controller->add_ultah_from_nip($data['nama'], $nip);
                $this->notifikasi_controller->add_kgb_from_pegawai($data);
                $this->notifikasi_controller->add_satyalencana_from_pegawai($data, $tanggal_masuk);
                $this->pegawai_model->insert($data); // Mengembalikan ID dari pegawai baru
                    
            }
          
            wp_redirect(admin_url('admin.php?page=pegawai'));
            exit;
        }
    }

    public function edit_pegawai()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         

            // Ambil data dari form
            $data = [
                'nama' => sanitize_text_field($_POST['nama']),
                'jabatan' => sanitize_text_field($_POST['jabatan']),
                'gol_pangkat' => sanitize_text_field($_POST['gol_pangkat']),
                // 'eselon' => sanitize_text_field($_POST['eselon']),
                // 'bidang' => sanitize_text_field($_POST['bidang']),
                'nip' => sanitize_text_field($_POST['nip']),
                'nrp' => sanitize_text_field($_POST['nrp']),
                'no_hp' => sanitize_text_field($_POST['no_hp']),
                'kgb' => sanitize_text_field($_POST['kgb']),
                // 'agama' => sanitize_text_field($_POST['agama']),
                'is_pejabat_struktural' => isset($_POST['is_pejabat_struktural']) ? 1 : 0,
                'status_fungsional' => sanitize_text_field($_POST['status_fungsional'])
            ];

            $this->notifikasi_model->delete_by_chain($data['nip']);
            print_r($data);
            exit();


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

    public function is_nip_exist($nip)
    {
        return $this->pegawai_model->get_by_nip($nip) > 0;
    }

    public function display_page() {
        $employees = $this->pegawai_model->get_all();
        $honorers = $this->honorer_m->get_all();
        include_once WP_PEMBINAAN_PLUGIN_DIR . 'includes/Views/pegawai-view.php';
    }

    
 

}
