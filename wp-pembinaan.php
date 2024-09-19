<?php
/**
 * Plugin Name: WP Pembinaan
 * Description: A starter plugin for WP Pembinaan.
 * Version: 1.0
 * Author: Zefta Adetya
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('WP_PEMBINAAN_VERSION', '1.0');
define('WP_PEMBINAAN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('UMUR_PENSIUN_JAKSA',60);
define('UMUR_PENSIUN_TU',58);

// Include Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use WP_Pembinaan\Main;

function run_wp_pembinaan() {
    $plugin = new Main();
    $plugin->run();
}

run_wp_pembinaan();
