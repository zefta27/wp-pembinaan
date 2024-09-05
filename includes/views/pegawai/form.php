<?php

// Pastikan file ini tidak diakses langsung
if (!defined('ABSPATH')) {
    exit;
}

// Inisialisasi variabel untuk form
$id = 0;
$nama = '';
$nip = '';
$nrp = '';
$status_fungsional = '';

// Periksa apakah sedang mengedit pegawai
if (isset($_GET['id'])) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'pembinaan_pegawai';
    $id = intval($_GET['id']);
    $pegawai = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
    
    if ($pegawai) {
        $nama = $pegawai['nama'];
        $nip = $pegawai['nip'];
        $nrp = $pegawai['nrp'];
        $status_fungsional = $pegawai['status_fungsional'];
    }
}

// Proses simpan data pegawai saat formulir disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'pembinaan_pegawai';
    
    $nama = sanitize_text_field($_POST['nama']);
    $nip = sanitize_text_field($_POST['nip']);
    $nrp = sanitize_text_field($_POST['nrp']);
    $status_fungsional = sanitize_text_field($_POST['status_fungsional']);
    
    if ($id > 0) {
        // Update data pegawai
        $wpdb->update(
            $table_name,
            [
                'nama' => $nama,
                'nip' => $nip,
                'nrp' => $nrp,
                'status_fungsional' => $status_fungsional
            ],
            ['id' => $id]
        );
    } else {
        // Insert data pegawai baru
        $wpdb->insert(
            $table_name,
            [
                'nama' => $nama,
                'nip' => $nip,
                'nrp' => $nrp,
                'status_fungsional' => $status_fungsional
            ]
        );
        $id = $wpdb->insert_id;
    }

    // Redirect ke halaman daftar pegawai setelah simpan
    wp_redirect(admin_url('admin.php?page=list_pegawai'));
    exit;
}
?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $id > 0 ? 'Edit Pegawai' : 'Tambah Pegawai'; ?></h1>

    <form method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="nama">Nama</label></th>
                    <td><input name="nama" type="text" id="nama" value="<?php echo esc_attr($nama); ?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="nip">NIP</label></th>
                    <td><input name="nip" type="text" id="nip" value="<?php echo esc_attr($nip); ?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="nrp">NRP</label></th>
                    <td><input name="nrp" type="text" id="nrp" value="<?php echo esc_attr($nrp); ?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="status_fungsional">Status Fungsional</label></th>
                    <td>
                        <select name="status_fungsional" id="status_fungsional" required>
                            <option value="Tata Usaha" <?php selected($status_fungsional, 'Tata Usaha'); ?>>Tata Usaha</option>
                            <option value="Jaksa" <?php selected($status_fungsional, 'Jaksa'); ?>>Jaksa</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php submit_button($id > 0 ? 'Update Pegawai' : 'Tambah Pegawai'); ?>
    </form>
</div>
