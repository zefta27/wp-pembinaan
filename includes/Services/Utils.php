<?php
namespace WP_Pembinaan\Services;

class Utils {
    function formatTanggal($tanggal) {
        // Gunakan \DateTime untuk mengakses kelas bawaan PHP
        $date = \DateTime::createFromFormat('Y-m-d', $tanggal);

        // Pastikan objek DateTime berhasil dibuat
        if (!$date) {
            return 'Tanggal tidak valid';
        }

        // Menggunakan IntlDateFormatter untuk format tanggal dalam bahasa Indonesia
        $fmt = new \IntlDateFormatter(
            'id_ID', // Locale bahasa Indonesia
            \IntlDateFormatter::LONG, // Format panjang (09 Agustus 2024)
            \IntlDateFormatter::NONE, // Tidak perlu waktu
            'Asia/Jakarta', // Zona waktu
            \IntlDateFormatter::GREGORIAN // Kalender Gregorian
        );

        // Format tanggal
        return $fmt->format($date);
    }
    function kurangkanDuaBulan($tanggalAsli)
    {
        
        // Buat objek DateTime dari tanggal tersebut

        $tanggal = \DateTime::createFromFormat('Y-m-d', $tanggalAsli); // Tambahkan backslash di depan DateTime
    
        // Kurangi dua bulan dari tanggal tersebut
        $tanggal->modify('-2 months');

        // Format kembali tanggal menjadi Y-m-d jika diperlukan
        $tanggalBaru = $tanggal->format('Y-m-d');
        
        return $tanggalBaru;
    }

    public function nipToTanggalLahir($nip){
        
            $tahun = substr($nip, 0, 4);
            $bulan = substr($nip, 4, 2);
            $hari = substr($nip, 6, 2);
    
            // Format menjadi YYYY-MM-DD
            $tanggal_lahir = $tahun . '-' . $bulan . '-' . $hari;
            
            return $tanggal_lahir;
           
        
    }
    public function nipToTanggalMasuk($nip){
        $tahun = substr($nip, 8, 4);
        $bulan = substr($nip, 12, 2);
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); // Tentukan tanggal terakhir bulan tersebut
        $tanggal_masuk = $tahun . '-' . $bulan . '-' . $tanggal;
            
        return $tanggal_masuk;

    }
    public function convertToUmur($tanggal_lahir, $tanggal_perbandingan){
        // Gunakan \DateTime untuk merujuk pada kelas DateTime bawaan PHP di global namespace
        $lahir = new \DateTime($tanggal_lahir);
        $perbandingan = new \DateTime($tanggal_perbandingan);
        
        // Hitung selisih antara kedua tanggal
        $selisih = $lahir->diff($perbandingan);
        
        // Umur dihitung dalam tahun
        $umur = $selisih->y;
        
        return $umur;
    }
    
    
} 
