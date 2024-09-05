<?php

// Pastikan file ini tidak diakses langsung
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
$table_name = $wpdb->prefix . 'pembinaan_pegawai';

// Ambil semua data pegawai dari tabel
$results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

?>

<div class="wrap">
    <h1 class="wp-heading-inline">Daftar Pegawai</h1>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th scope="col" class="manage-column column-cb check-column">ID</th>
                <th scope="col" class="manage-column">Nama</th>
                <th scope="col" class="manage-column">NIP</th>
                <th scope="col" class="manage-column">NRP</th>
                <th scope="col" class="manage-column">Status Fungsional</th>
                <th scope="col" class="manage-column">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)) : ?>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?php echo esc_html($row['id']); ?></td>
                        <td><?php echo esc_html($row['nama']); ?></td>
                        <td><?php echo esc_html($row['nip']); ?></td>
                        <td><?php echo esc_html($row['nrp']); ?></td>
                        <td><?php echo esc_html($row['status_fungsional']); ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=edit_pegawai&id=' . $row['id']); ?>">Edit</a> |
                            <a href="<?php echo admin_url('admin.php?page=delete_pegawai&id=' . $row['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">Tidak ada data pegawai yang tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
