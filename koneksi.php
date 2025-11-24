<?php
// Konfigurasi Database
$host       = "localhost";
$user       = "root";
$password   = ""; 
<<<<<<< HEAD
$database   = "db_sipera";

=======
$database   = "db_sipera"; 
>>>>>>> 798dcddb89318e630fcc360bec96b39092ac495f
// Membuat Koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek Koneksi (Audit Awal)
if (!$koneksi) {
<<<<<<< HEAD
    // Jika gagal, matikan script dan buang errornya
=======
    // Jika gagal, matikan script dan ludahkan errornya
>>>>>>> 798dcddb89318e630fcc360bec96b39092ac495f
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// Opsional: Set charset agar support emoji/karakter khusus
mysqli_set_charset($koneksi, "utf8");
?>