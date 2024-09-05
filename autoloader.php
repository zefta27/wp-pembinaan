<?php
// Fungsi autoloader
function my_plugin_autoloader($class_name) {
    // Hanya mengautoload kelas yang dimulai dengan prefix tertentu (misalnya: My_Plugin)
    if (strpos($class_name, 'WP_Pembinaan') !== false) {
        // Konversi nama kelas menjadi nama file
        $file_name = strtolower(str_replace('_', '-', $class_name)) . '.php';
        
        // Tentukan path dari file yang harus di-load
        $file = plugin_dir_path(__FILE__) . 'inc/class-' . $file_name;
        
        // Jika file ditemukan, include file tersebut
        if (file_exists($file)) {
            include $file;
        }
    }
}
// Daftarkan autoloader
spl_autoload_register('my_plugin_autoloader');
