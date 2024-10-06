<div class="wrap">
    <div class="container">
        <div class="col">
            <h2>Setting Notifikasi</h1>
            <table class="table">
                <tr>
                    <td>Laporan Triwulan</td>
                    <td>
                        <select name="is_aktif_laptri" id="">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Laporan Bulanan</td>
                    <td>
                        <select name="is_aktif_lapbul" id="">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Laporan Tahunan</td>
                    <td>
                        <select name="is_aktif_lapbul" id="">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col">
            <h2>Tipe Notifikasi</h2>
            <table class="table">
                
                <?php
                    foreach($tnotifikasis as $tnotifikasi)
                    {
                ?>
                    <tr>
                        <td><?= $tnotifikasi->nama ?></td>
                        <td><span><?= $tnotifikasi->warna ?></span></td>
                    </tr>
                <?php
                    }
                ?>
            </table>

        </div>
    </div> 
</div>