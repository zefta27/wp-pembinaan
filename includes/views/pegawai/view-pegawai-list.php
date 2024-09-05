<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$gol_pangkat_jaksa = [
    "Ajun Jaksa Madya / (III/a)",
    "Ajun Jaksa / (III/b)",
    "Jaksa Pratama / (III/c)",
    "Jaksa Muda / (III/d)",
    "Jaksa Madya / (IV/a)",
    "Jaksa Utama Pratama / (IV/b)",
    "Jaksa Utama Muda / (IV/c)",
    "Jaksa Utama Madya / (IV/d)",
    "Jaksa Utama / (IV/e)"
];
$gol_pangkat_tu = [
    "Yuana Darma / (II/a)",
    "Muda Darma / (II/b)",
    "Madya Darma / (II/c)",
    "Sena Darma / (II/d)",
    "Yuana Wira / (III/a)",
    "Muda Wira / (III/b)",
    "Madya Wira / (III/c)",
    "Sena Wira / (III/d)",
    "Adi Wira / (IV/a)",
    "Nindya Wira / (IV/b)",
    "Muda pati / (IV/c)",
    "Madya pati / (IV/d)",
    "Sena pati / (IV/e)"
];

?>

<div class="wrap">
    <h1>Pegawai</h1>
    <button id="wp-pembinaan-add-pegawai-button" class="button button-primary">Tambah Pegawai</button>
  
    <div id="wp-pembinaan-add-pegawai-form" style="display: none;">
        <h2>Tambah Pegawai</h2>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="add_pegawai">
            <table class="form-table">
                <tr><th><label for="nama">Nama</label></th><td><input type="text" name="nama" required></td></tr>
                <tr>
                    <th><label for="status_fungsional">Status Fungsional</label></th>
                    <td>
                        <select name="status_fungsional" id="status_fungsional" required>
                            <option value="Jaksa">Jaksa</option>
                            <option value="Tata Usaha">Tata Usaha</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="bidang">Bidang</label></th>
                    <td>
                        <select name="bidang" id="bidang" required>
                                <option value="Non Bidang">Non Bidang</option>
                                <option value="Pembinaan">Pembinaan</option>
                                <option value="Intelijen">Intelijen</option>
                                <option value="Pidana Umum">Pidana Umum</option>
                                <option value="Pidana Khusus">Pidana Khusus</option>
                                <option value="Perdata dan Tata Usaha Negara">Perdata dan Tata Usaha Negara</option>
                                <option value="Barang Bukti dan Barang Rampasan">Barang Bukti dan Barang Rampasan</option>
                        </select>
                    </td>
                </tr>
                <tr><th><label for="jabatan">Jabatan</label></th><td><input type="text" name="jabatan" required></td></tr>
                <tr>
                    <th><label for="eselon">Eselon</label></th>
                    <td>
                        <select name="eselon" id="eselon" required>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III/a">III/a</option>
                            <option value="III/b">III/b</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="gol_pangkat">Golongan/Pangkat</label></th>
                    <td>
                        <select name="gol_pangkat" id="gol_pangkat" required>
                            <!-- Options will be dynamically populated by JavaScript -->
                        </select>
                    </td>
                </tr>
                <tr><th><label for="nip">NIP</label></th><td><input type="text" name="nip" required></td></tr>
                <tr><th><label for="nrp">NRP</label></th><td><input type="text" name="nrp" required></td></tr>
                <tr><th><label for="no_hp">No HP</label></th><td><input type="text" name="no_hp" required></td></tr>
                <tr><th><label for="kgb">KGB (Kenaikan Gaji Berkala)</label></th><td><input type="date" name="kgb" required></td></tr>
                
            </table>
            <input type="submit" class="button button-primary" value="Tambah Pegawai">
        </form>
    </div>

    <div id="wp-pembinaan-import-csv-form" style="display: none;">
        <h2>Import CSV</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="pegawai_csv" accept=".csv" required>
            <input type="submit" name="wp_pembinaan_import_csv" class="button button-primary" value="Import CSV">
        </form>
    </div>

    <h2>Daftar Pegawai</h2>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Golongan/Pangkat</th>
                <th>NIP</th>
                <th>NRP</th>
                <th>No HP</th>
                <th>Status Fungsional</th>
                <th>KGB</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee) : ?>
                <tr>
                    <td><?php echo $employee->id; ?></td>
                    <td><?php echo $employee->nama; ?></td>
                    <td><?php echo $employee->jabatan; ?></td>
                    <td><?php echo $employee->gol_pangkat; ?></td>
                    <td><?php echo $employee->nip; ?></td>
                    <td><?php echo $employee->nrp; ?></td>
                    <td><?php echo $employee->no_hp; ?></td>
                    <td><?php echo $employee->status_fungsional; ?></td>
                    <td><?php echo $employee->kgb; ?></td>
                    <td>
                        <a href="#" class="button edit-button" data-id="<?php echo $employee->id; ?>" data-nama="<?php echo $employee->nama; ?>" data-jabatan="<?php echo $employee->jabatan; ?>" data-gol_pangkat="<?php echo $employee->gol_pangkat; ?>" data-nip="<?php echo $employee->nip; ?>" data-nrp="<?php echo $employee->nrp; ?>" data-no_hp="<?php echo $employee->no_hp; ?>" data-status_fungsional="<?php echo $employee->status_fungsional; ?>">
                            <span class="dashicons dashicons-edit"></span> Edit
                        </a>
                        <a href="<?php echo esc_url(admin_url('admin-post.php?action=delete_pegawai&id=' . $employee->id)); ?>" class="button delete-button" onclick="return confirm('Are you sure you want to delete this employee?');">
                            <span class="dashicons dashicons-trash"></span> Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Pegawai</h2>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="edit_pegawai">
            <input type="hidden" name="id" id="edit_id">
            <table class="form-table">
                <tr><th><label for="edit_nama">Nama</label></th><td><input type="text" name="nama" id="edit_nama" required></td></tr>
                <tr><th><label for="edit_jabatan">Jabatan</label></th><td><input type="text" name="jabatan" id="edit_jabatan" required></td></tr>
                <tr>
                    <th><label for="edit_gol_pangkat">Golongan/Pangkat</label></th>
                    <td>
                        <select name="gol_pangkat" id="edit_gol_pangkat" required>
                            <!-- Options will be dynamically populated by JavaScript -->
                        </select>
                    </td>
                </tr>
                <tr><th><label for="edit_nip">NIP</label></th><td><input type="text" name="nip" id="edit_nip" required></td></tr>
                <tr><th><label for="edit_nrp">NRP</label></th><td><input type="text" name="nrp" id="edit_nrp" required></td></tr>
                <tr><th><label for="edit_no_hp">No HP</label></th><td><input type="text" name="no_hp" id="edit_no_hp" required></td></tr>
                <tr>
                    <th><label for="edit_status_fungsional">Status Fungsional</label></th>
                    <td>
                        <select name="status_fungsional" id="edit_status_fungsional" required>
                            <option value="Jaksa">Jaksa</option>
                            <option value="Tata Usaha">Tata Usaha</option>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="submit" class="button button-primary" value="Edit Pegawai">
        </form>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('wp-pembinaan-add-pegawai-button').addEventListener('click', function() {
        document.getElementById('wp-pembinaan-add-pegawai-form').style.display = 'block';
        document.getElementById('wp-pembinaan-import-csv-form').style.display = 'none';
    });

    document.getElementById('wp-pembinaan-import-csv-button').addEventListener('click', function() {
        document.getElementById('wp-pembinaan-import-csv-form').style.display = 'block';
        document.getElementById('wp-pembinaan-add-pegawai-form').style.display = 'none';
    });

    function populateGolPangkat(statusFungsionalElementId, golPangkatElementId) {
        var statusFungsional = document.getElementById(statusFungsionalElementId).value;
        var golPangkatSelect = document.getElementById(golPangkatElementId);
        golPangkatSelect.innerHTML = '';

        var golPangkatOptions = {
            'Jaksa': <?php echo json_encode($gol_pangkat_jaksa); ?>,
            'Tata Usaha': <?php echo json_encode($gol_pangkat_tu); ?>
        };

        golPangkatOptions[statusFungsional].forEach(function(option) {
            var opt = document.createElement('option');
            opt.value = option;
            opt.innerHTML = option;
            golPangkatSelect.appendChild(opt);
        });
    }

    document.getElementById('status_fungsional').addEventListener('change', function() {
        populateGolPangkat('status_fungsional', 'gol_pangkat');
    });

    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            var employee = {
                id: this.getAttribute('data-id'),
                nama: this.getAttribute('data-nama'),
                jabatan: this.getAttribute('data-jabatan'),
                gol_pangkat: this.getAttribute('data-gol_pangkat'),
                nip: this.getAttribute('data-nip'),
                nrp: this.getAttribute('data-nrp'),
                no_hp: this.getAttribute('data-no_hp'),
                status_fungsional: this.getAttribute('data-status_fungsional')
            };

            document.getElementById('edit_id').value = employee.id;
            document.getElementById('edit_nama').value = employee.nama;
            document.getElementById('edit_jabatan').value = employee.jabatan;
            document.getElementById('edit_nip').value = employee.nip;
            document.getElementById('edit_nrp').value = employee.nrp;
            document.getElementById('edit_no_hp').value = employee.no_hp;
            document.getElementById('edit_status_fungsional').value = employee.status_fungsional;

            populateGolPangkat('edit_status_fungsional', 'edit_gol_pangkat');
            document.getElementById('edit_gol_pangkat').value = employee.gol_pangkat;

            document.getElementById('editModal').style.display = 'block';
        });
    });

    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('editModal').style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('editModal')) {
            document.getElementById('editModal').style.display = 'none';
        }
    };

    // Trigger change event to populate gol_pangkat on page load
    document.getElementById('status_fungsional').dispatchEvent(new Event('change'));
    document.getElementById('edit_status_fungsional').addEventListener('change', function() {
        populateGolPangkat('edit_status_fungsional', 'edit_gol_pangkat');
    });
</script>
