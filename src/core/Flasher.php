<?php
// Nama File: Flasher.php
// Deskripsi: Menangani pesan notifikasi flash (alert) menggunakan session.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi'  => $aksi,
            'tipe'  => $tipe
        ];
    }

    public static function flash()
    {
        if( isset($_SESSION['flash']) ) {
            // Perbaikan Keamanan: htmlspecialchars untuk mencegah XSS
            // Perbaikan CSS: Hapus inline style, gunakan class utility bootstrap (mt-4, text-center)
            echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show mt-4 text-center" role="alert">
                    <strong>' . htmlspecialchars($_SESSION['flash']['pesan']) . '</strong> ' . htmlspecialchars($_SESSION['flash']['aksi']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            unset($_SESSION['flash']);
        }
    }
}