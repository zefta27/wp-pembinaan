<?php
// notifikasi-view.php
?>

<div class="wrap">
   <!-- Tombol Tambah -->
    <div class="callout">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahNotifikasiModal">
        Tambah Notifikasi
        </button>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="tambahNotifikasiModal" tabindex="-1" aria-labelledby="tambahNotifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahNotifikasiModalLabel">Tambah Notifikasi Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahNotifikasi" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST"> 
                    <?php wp_nonce_field('notifikasi_add_action', 'notifikasi_nonce'); ?>
                    <input type="hidden" name="action" value="add_notifikasi">
                   
                    <div class="modal-body">
                        <!-- Form untuk menambahkan notifikasi baru -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tipe">Tipe</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="Ulang Tahun">Ulang Tahun</option>
                                <option value="KGB">Kenaikan Gaji Berkala</option>
                                <option value="Kenaikan Pangkat">Kenaikan Pangkat</option>
                                <option value="Laporan Triwulan">Laporan Triwulan</option>
                                <option value="Laporan Tahunan">Laporan Tahunan</option>
                                <option value="Satya Lencana">Satya Lencana</option>
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" class="form-control" name="tipe" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input value="simpan" type="submit" class="btn btn-primary" />
                    </div>
                </form>
        </div>
    </div>
    </div>

    <table id="notifikasiTable" class="wp-list-table widefat fixed striped table-view-list">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Tipe</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($notifikasi)): ?>
                <?php foreach ($notifikasi as $notif): ?>
                    <tr>
                        <td><?php echo esc_html($notif->nama); ?></td>
                        <td><?php echo esc_html($notif->deskripsi); ?></td>
                        <td><?php echo esc_html($notif->tipe); ?></td>
                        <td><?php echo esc_html($notif->tanggal); ?></td> <!-- Pastikan format tanggal sesuai -->
                        <td>
                            <a class="button btn" href="<?php echo admin_url('admin.php?page=edit_notifikasi&id=' . $notif->id); ?>">
                                <span class="dashicons dashicons-edit"></span> Edit
                            </a> 
                            <a class="button btn" href="<?php echo esc_url(admin_url('admin-post.php?action=hapus_notifikasi&id=' . $notif->id)); ?>" 
                            onclick="return confirm('Apakah Anda yakin?')">
                            <span class="dashicons dashicons-trash"></span> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Tidak ada notifikasi ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- JavaScript for Tab Switching and DataTables Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable
            jQuery('#notifikasiTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "order": [[3, "asc"]], // Urutkan kolom ke-4 (Tanggal) secara descending (DESC)
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ notifikasi per halaman",
                    "zeroRecords": "Tidak ada notifikasi ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada notifikasi tersedia",
                    "infoFiltered": "(difilter dari total _MAX_ notifikasi)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>



</div>
