<?php
// Konfigurasi Database
$host       = "localhost";
$user       = "root";
$password   = ""; 
$database   = "db_sipera"; 

// Membuat Koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek Koneksi (Audit Awal)
if (!$koneksi) {
    // Jika gagal, matikan script dan ludahkan errornya
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
// Opsional: Set charset agar support emoji/karakter khusus
mysqli_set_charset($koneksi, "utf8");
?>