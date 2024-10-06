<?php
namespace WP_Pembinaan\Controllers;

use WP_Pembinaan\Models\TipeNotifikasiModel;
use WP_Pembinaan\Services\Utils;

class AdminController {

    public function __construct() {
        $this->tipe_notifikasi_m = new TipeNotifikasiModel();
        $this->utils = new Utils();
   
    }
    
    public function index(){
        $tnotifikasis = $this->tipe_notifikasi_m->get_all();
        include_once WP_PEMBINAAN_PLUGIN_DIR . 'includes/Views/admin-view.php';
    
    }
    public function activate() {
        $this->tipe_notifikasi_m->create_table();  // Panggil fungsi create_table dari honorerModel
    }

}