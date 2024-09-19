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
    
<!-- Nav tabs -->
<h2 class="nav-tab-wrapper">
    <a href="#tab-pegawai" class="nav-tab nav-tab-active">Pegawai Negeri Sipil</a>
    <a href="#tab-ptt" class="nav-tab">Pegawai Honorer</a>
</h2>

<!-- Tab 1: Daftar Pegawai -->
<div id="tab-pegawai" class="tab-content active" style="padding-top:20px;">
    <div class="callout bg-orange-light">
        <button type="button" class="btn btn-primary outline-orange" data-toggle="modal" data-target="#tambahPegawaiModal">
            <i class="fa fa-plus"></i>&nbsp; Tambah Pegawai
        </button>
        <i class="fa fa-plus fa-large-icon"></i> <!-- Large Icon -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="tambahPegawaiModal" tabindex="-1" aria-labelledby="tambahPegawaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPegawaiModalLabel">Tambah Pegawai Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahPegawai" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" enctype="multipart/form-data">
                    <?php wp_nonce_field('pegawai_add_action', 'pegawai_nonce'); ?>
                    <input type="hidden" name="action" value="add_pegawai">

                    <div class="modal-body">
                        <!-- Form untuk menambahkan pegawai baru -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>

                        <div class="form-group">
                            <label for="status_fungsional">Status Fungsional</label>
                            <select class="form-control" id="status_fungsional" name="status_fungsional" required style="max-width:100% !important;">
                                <option value="Jaksa">Jaksa</option>
                                <option value="Tata Usaha">Tata Usaha</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                        </div>

                        <div class="form-group">
                            <label for="gol_pangkat">Golongan/Pangkat</label>
                            <select class="form-control" id="gol_pangkat" name="gol_pangkat" required style="max-width:100% !important;">
                                <!-- Golongan/Pangkat dynamically populated by JavaScript -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eselon">Eselon</label>
                            <select name="eselon" id="eselon" class="form-control" style="max-width: 100%;">
                                <option value="Non Eselon">Non Eselon</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bidang">Bidang</label>
                            <select name="bidang" id="bidang" class="form-control" style="max-width: 100%;">
                                <option value="Pembinaan">Pembinaan</option>
                                <option value="Intelijen">Intelijen</option>
                                <option value="Pemulihan Aset & Barang Rampasan">Pemulihan Aset & Barang Rampasan</option>
                                <option value="Perdata dan Tata Usaha">Perdata dan Tata Usaha</option>
                                <option value="Tindak Pidana Umum">Tindak Pidana Umum</option>
                                <option value="Tindak Pidana Khusus">Tindak Pidana Khusus</option>
                                <option value="Non Bidang">Non Bidang</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" required>
                        </div>

                        <div class="form-group">
                            <label for="nrp">NRP</label>
                            <input type="text" class="form-control" id="nrp" name="nrp" required>
                        </div>

                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                        </div>

                        <div class="form-group">
                            <label for="kgb">KGB (Kenaikan Gaji Berkala)</label>
                            <input type="date" class="form-control" id="kgb" name="kgb" required>
                        </div>

                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <input type="text" class="form-control" id="agama" name="agama" required>
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>

            </div>
        </div>
    </div>
    <table id="pegawaiTable" class="wp-list-table widefat fixed striped display">
        <thead>
            <tr>
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
                    <td><?php echo $employee->nama; ?></td>
                    <td><?php echo $employee->jabatan; ?></td>
                    <td><?php echo $employee->gol_pangkat; ?></td>
                    <td><?php echo $employee->nip; ?></td>
                    <td><?php echo $employee->nrp; ?></td>
                    <td><?php echo $employee->no_hp; ?></td>
                    <td><?php echo $employee->status_fungsional; ?></td> 
                    <td><?php echo $employee->kgb; ?></td>
                    <td style="display:flex;flex-direction:column;gap:6px;">
                        <a href="<?php echo esc_url(admin_url('admin-post.php?action=delete_pegawai&id=' . $employee->id.'&nip='.$employee->nip)); ?>" class="button delete-button btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">
                            <span class="dashicons dashicons-trash"></span> Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Tab 2: Pegawai Tidak Tetap (PTT) -->
<div id="tab-ptt" class="tab-content"  style="padding-top:20px;">

    <div class="callout bg-orange-light">
        <button type="button" class="btn btn-primary bg-orange" data-toggle="modal" data-target="#tambahHonorerModal">
            Tambah Pegawai Honorer
        </button>
        <i class="fa fa-plus fa-large-icon"></i> <!-- Large Icon -->
    </div>
  

    <!-- Modal -->
    <div class="modal fade" id="tambahHonorerModal" tabindex="-1" aria-labelledby="tambahHonorerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPegawaiModalLabel">Tambah Pegawai Honorer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahHonorer" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" >
                        <?php wp_nonce_field('honorer_add_action', 'honorer_nonce'); ?>
                        <input type="hidden" name="action" value="add_honorer">
                        <div class="modal-body">
                        <!-- Form untuk menambahkan pegawai honorer baru -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <input type="text" class="form-control" id="agama" name="agama" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <table id="pttTable" class="wp-list-table widefat fixed striped display">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Agama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($honorers as $honorer) : ?>
            <tr>
                <td><?php echo $honorer->nama; ?></td>
                <td><?php echo $honorer->jabatan; ?></td>
                <td><?php echo date('d-m-Y', strtotime($honorer->tanggal_lahir)); ?></td>
                <td><?php echo $honorer->jenis_kelamin; ?></td>
                <td><?php echo $honorer->alamat; ?></td>
                <td><?php echo $honorer->agama; ?></td>
                <td>
                    <a href="#" class="button edit-button btn">
                        <span class="dashicons dashicons-edit"></span> Edit
                    </a>
                    <a href="#" class="button delete-button btn btn-danger">
                        <span class="dashicons dashicons-trash"></span> Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>


<!-- JavaScript for handling tabs and DataTables -->
<script>
jQuery(document).ready(function($) {
    // Initialize DataTables for both tables
    $('#pegawaiTable').DataTable();
    $('#pttTable').DataTable();

    // Tab switching logic
    $('h2.nav-tab-wrapper a').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');

        // Remove active class from all tabs and add it to the clicked tab
        $('h2.nav-tab-wrapper a').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');

        // Hide all tab contents and show the selected one
        $('.tab-content').removeClass('active');
        $(target).addClass('active');
    });
});
</script>

<style>
/* Styling for tabs */
.nav-tab-wrapper {
    margin-bottom: 20px;
}


.nav-tab-active {
    background: #0073aa;
    color: #fff;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Adjust table styling */
.wp-list-table {
    margin-top: 20px;
}
</style>


    
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
    document.getElementById('status_fungsional').addEventListener('change', function() {
        populateGolPangkat('status_fungsional', 'gol_pangkat');
    });

    function populateGolPangkat(statusFungsionalElementId, golPangkatElementId) {
        var statusFungsional = document.getElementById(statusFungsionalElementId).value;
        var golPangkatSelect = document.getElementById(golPangkatElementId);
        golPangkatSelect.innerHTML = ''; // Kosongkan options

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

    // Trigger change event to populate gol_pangkat on modal open
    document.getElementById('status_fungsional').dispatchEvent(new Event('change'));
</script>

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
