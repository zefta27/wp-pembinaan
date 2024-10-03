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

<?php 
    if (isset($_GET['edit_success']) && $_GET['edit_success'] == '1') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Data  berhasil diedit.', 'text-domain'); ?></p>
        </div>
        <?php
    }
    if (isset($_GET['insert_success']) && $_GET['insert_success'] == '1') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Data  berhasil ditambahkan.', 'text-domain'); ?></p>
        </div>
        <?php
    }
    if (isset($_GET['delete_success']) && $_GET['delete_success'] == '1') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Data  berhasil dihapus.', 'text-domain'); ?></p>
        </div>
        <?php
    }
?>
<div class="wrap">

<!-- Nav tabs -->
<h2 class="nav-tab-wrapper">
    <a href="#tab-pegawai" class="nav-tab nav-tab-active">Pegawai Negeri Sipil</a>
    <a href="#tab-ptt" class="nav-tab">Pegawai Honorer</a>
</h2>

<!-- Tab 1: Daftar Pegawai -->
<div id="tab-pegawai" class="tab-content active" style="padding-top:20px;">
    <div class="callout bg__blue--light">
        <button type="button" class="btn outline__orange" data-toggle="modal" data-target="#tambahPegawaiModal">
            Tambah Pegawai
        </button>
        <button type="button" class="btn outline__green" data-toggle="modal" data-target="#tambahCsvModal">
            Upload File Pegawai (Via CSV)
        </button>
        <i class="fa fa-plus fa-large-icon"></i> <!-- Large Icon -->
    </div>
    
    <!-- Modal Tambah Pegawai-->
    <div class="modal fade" id="tambahPegawaiModal" tabindex="-1" aria-labelledby="tambahPegawaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content__orange">
                <div class="modal-header modal-header__orange">
                    <h5 class="modal-title modal-title__orange" id="tambahPegawaiModalLabel">Tambah Pegawai Baru</h5>
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
                            <select name="agama" id="agama" class="form-control" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen Protestan">Kristen Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>
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
    <!-- End Modal Tambah Pegawai -->

     <!-- Modal Tambah CSV-->
    <div class="modal fade" id="tambahCsvModal" tabindex="-1" aria-labelledby="tambahCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content__green">
                <div class="modal-header modal-header__green">
                    <h5 class="modal-title modal-title__green" id="tambahCsvModalLabel">Tambah Pegawai Baru (Upload XLSX File)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahCsv" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" enctype="multipart/form-data">
                    <?php wp_nonce_field('csv_upload_action', 'csv_nonce'); ?>
                    <input type="hidden" name="action" value="upload_csv_pegawai">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="csv_file">Upload XLSX File</label>
                            <div class="outline__green outline__green--callout">
                                Untuk penguploadtannya diharapkan menggunakan file 
                            </div>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".xlsx" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" class="btn btn-primary bg__green" value="Upload">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Tambah CSV -->


    <!-- Modal Edit Pegawai -->
    <div class="modal fade" id="editPegawaiModal" tabindex="-1" aria-labelledby="editPegawaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content__orange">
                <div class="modal-header modal-header__orange">
                    <h5 class="modal-title modal-title__orange" id="editPegawaiModalLabel"><span class="dashicons dashicons-edit"></span>&nbspEdit Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditPegawai" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" enctype="multipart/form-data">
                    <?php wp_nonce_field('pegawai_edit_action', 'pegawai_nonce'); ?>
                    <input type="hidden" name="action" value="edit_pegawai">
                    <input type="hidden" id="edit-id" name="id"> <!-- Hidden field untuk ID -->
                    <input type="hidden" id="edit-nip_lama" name="nip_lama"> <!-- Hidden field untuk ID -->
                    <input type="hidden" id="edit-kgb_lama" name="kgb_lama"> <!-- Hidden field untuk ID -->
                    
                    <!-- Form input yang akan diisi otomatis -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit-nama">Nama</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-status_fungsional">Status Fungsional</label>
                            <select class="form-control" id="edit-status_fungsional" name="status_fungsional" required>
                                <option value="Jaksa">Jaksa</option>
                                <option value="Tata Usaha">Tata Usaha</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="edit-jabatan" name="jabatan" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-golongan">Golongan/Pangkat</label>
                            <!-- <input type="text" class="form-control" id="edit-golongan" name="gol_pangkat" required> -->
                            <select class="form-control" id="edit-golongan" name="gol_pangkat" required style="max-width:100% !important;">
                                <!-- Golongan/Pangkat dynamically populated by JavaScript -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-eselon">Eselon</label>
                            <select name="eselon" id="edit-eselon" class="form-control" style="max-width: 100%;">
                                <option value="Non Eselon">Non Eselon</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-bidang">Bidang</label>
                            <select name="bidang" id="edit-bidang" class="form-control" style="max-width: 100%;">
                                <option value="Non Bidang">Non Bidang</option>
                                <option value="Pembinaan">Pembinaan</option>
                                <option value="Intelijen">Intelijen</option>
                                <option value="Pemulihan Aset & Barang Rampasan">Pemulihan Aset & Barang Rampasan</option>
                                <option value="Perdata dan Tata Usaha">Perdata dan Tata Usaha</option>
                                <option value="Tindak Pidana Umum">Tindak Pidana Umum</option>
                                <option value="Tindak Pidana Khusus">Tindak Pidana Khusus</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-nip">NIP</label>
                            <input type="text" class="form-control" id="edit-nip" name="nip" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-nrp">NRP</label>
                            <input type="text" class="form-control" id="edit-nrp" name="nrp" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-no_hp">No HP</label>
                            <input type="text" class="form-control" id="edit-no_hp" name="no_hp" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-kgb">KGB (Kenaikan Gaji Berkala)</label>
                            <input type="date" class="form-control" id="edit-kgb" name="kgb" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-agama">Agama</label>
                            <select name="agama" id="edit-agama" class="form-control" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen Protestan">Kristen Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" class="btn bg__orange" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Edit Pegawai -->


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
                    <td class="btn-area-table">
                        <button type="button" class="button btn btn-primary btn-custom outline__orange" 
                            onclick="fillEditModal(
                                '<?php echo $employee->id; ?>',
                                '<?php echo addslashes($employee->nama); ?>',
                                '<?php echo addslashes($employee->jabatan); ?>',
                                '<?php echo addslashes($employee->gol_pangkat); ?>',
                                '<?php echo addslashes($employee->nip); ?>',
                                '<?php echo addslashes($employee->nrp); ?>',
                                '<?php echo addslashes($employee->no_hp); ?>',
                                '<?php echo addslashes($employee->status_fungsional); ?>',
                                '<?php echo addslashes($employee->kgb); ?>',
                                '<?php echo addslashes($employee->bidang); ?>',
                                '<?php echo addslashes($employee->agama); ?>',
                                '<?php echo addslashes($employee->eselon); ?>'
                            )" data-toggle="modal" data-target="#editPegawaiModal">
                            <span class="dashicons dashicons-edit"></span> Edit
                        </button>

                        <a href="<?php echo esc_url(admin_url('admin-post.php?action=delete_pegawai&id=' . $employee->id.'&nip='.$employee->nip)); ?>" class="button delete-button btn btn-danger outline__red" onclick="return confirm('Are you sure you want to delete this employee?');">
                            <span class="dashicons dashicons-trash"></span> Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?php echo esc_url(admin_url('admin-post.php?action=delete_all_pegawai')); ?>" class="button delete-button btn btn-danger outline__red" onclick="return confirm('Are you sure you want to delete this employee?');">
                <span class="dashicons dashicons-trash"></span> Hapus Semua Pegawai
            </a>
</div>

<!-- Tab 2: Pegawai Tidak Tetap (PTT) -->
<div id="tab-ptt" class="tab-content"  style="padding-top:20px;">

    <div class="callout bg__orange--light">
        <button type="button" class="btn btn-primary bg__orange" data-toggle="modal" data-target="#tambahHonorerModal">
            Tambah Pegawai Honorer
        </button>
        <i class="fa fa-plus fa-large-icon"></i> <!-- Large Icon -->
    </div>
  

    <!-- Tambah Modal -->
    <div class="modal fade" id="tambahHonorerModal" tabindex="-1" aria-labelledby="tambahHonorerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content__orange">
                <div class="modal-header modal-header__orange">
                    <h5 class="modal-title modal-title__orange" id="tambahPegawaiModalLabel">
                        <span class="dashicons dashicons-plus"></span>&nbsp
                        Tambah Pegawai Honorer
                    </h5>
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
                            <select name="agama" id="agama" class="form-control" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen Protestan">Kristen Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>   
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" class="btn btn-primary bg__orange" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Tambah modal -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editHonorerModal" tabindex="-1" aria-labelledby="editHonorerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content__orange">
                <div class="modal-header modal-header__orange">
                    <h5 class="modal-title modal-title__orange" id="editHonorerModalLabel">
                        <span class="dashicons dashicons-edit"></span>&nbsp
                        Edit Pegawai Honorer
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditHonorer" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" >
                    <?php wp_nonce_field('honorer_edit_action', 'honorer_edit_nonce'); ?>
                    <input type="hidden" name="action" value="edit_honorer">
                    <input type="hidden" id="edit-honorer-id" name="id">
                    <div class="modal-body">
                        <!-- Form untuk mengedit pegawai honorer -->
                        <div class="form-group">
                            <label for="edit-honorer-nama">Nama</label>
                            <input type="text" class="form-control" id="edit-honorer-nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-honorer-jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="edit-honorer-jabatan" name="jabatan" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-honorer-tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="edit-honorer-tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-honorer-jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="edit-jenis_kelamin" name="jenis_kelamin" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-honorer-agama">Agama</label>
                            <select name="agama" id="edit-honorer-agama" class="form-control" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen Protestan">Kristen Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>   
                        </div>
                        <div class="form-group">
                            <label for="edit-honorer-alamat">Alamat</label>
                            <textarea class="form-control" id="edit-honorer-alamat" name="alamat" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" class="btn btn-primary bg__orange" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end edit modal -->


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
                <td class="btn-area-table">
                    <button type="button" class="button btn btn-primary btn-custom outline__orange" 
                        onclick="fillEditHonorerModal(
                            '<?php echo $honorer->id; ?>',
                            '<?php echo addslashes($honorer->nama); ?>',
                            '<?php echo addslashes($honorer->jabatan); ?>',
                            '<?php echo addslashes($honorer->tanggal_lahir); ?>',
                            '<?php echo addslashes($honorer->jenis_kelamin); ?>',
                            '<?php echo addslashes($honorer->alamat); ?>',
                            '<?php echo addslashes($honorer->agama); ?>',
                        )" data-toggle="modal" data-target="#editHonorerModal">
                        <span class="dashicons dashicons-edit"></span> Edit
                    </button>

                    <a href="<?php echo esc_url(admin_url('admin-post.php?action=delete_honorer&id=' . $honorer->id)); ?>" class="button delete-button btn btn-danger outline__red" onclick="return confirm('Are you sure you want to delete this honorer?');">
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
    
</div>

<!-- Edit Modal -->



<script type="text/javascript">
  
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

    
  
    // Trigger change event to populate gol_pangkat on page load
    document.getElementById('status_fungsional').dispatchEvent(new Event('change'));
    document.getElementById('edit-status_fungsional').addEventListener('change', function() {
        populateGolPangkat('edit-status_fungsional', 'edit-golongan');
    });

    function fillEditModal(id, nama, jabatan, golongan, nip, nrp, noHp, statusFungsional, kgb, bidang, agama, eselon) {
        // Set data ke dalam input di modal
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-jabatan').value = jabatan;
        document.getElementById('edit-nip').value = nip;
        document.getElementById('edit-nip_lama').value = nip;
        document.getElementById('edit-nrp').value = nrp;
        document.getElementById('edit-no_hp').value = noHp;
        document.getElementById('edit-kgb').value = kgb;
        document.getElementById('edit-kgb_lama').value = kgb;
        document.getElementById('edit-bidang').value = bidang;
        document.getElementById('edit-agama').value = agama;
        document.getElementById('edit-eselon').value = eselon;
        document.getElementById('edit-status_fungsional').value = statusFungsional;
        // document.getElementById('edit-status_fungsional').dispatchEvent(new Event('change'));
        populateGolPangkat('edit-status_fungsional', 'edit-golongan');
        document.getElementById('edit-golongan').value = golongan;
        
    }

    function fillEditHonorerModal(id, nama, jabatan, tanggal_lahir, jenis_kelamin, alamat, agama) {
    // Set data ke dalam input di modal edit
        document.getElementById('edit-honorer-id').value = id;
        document.getElementById('edit-honorer-nama').value = nama;
        document.getElementById('edit-honorer-jabatan').value = jabatan;
        document.getElementById('edit-honorer-tanggal_lahir').value = tanggal_lahir;
        document.getElementById('edit-honorer-jenis_kelamin').value = jenis_kelamin;
        document.getElementById('edit-honorer-alamat').value = alamat;
        document.getElementById('edit-honorer-agama').value = agama;
    }


</script>
