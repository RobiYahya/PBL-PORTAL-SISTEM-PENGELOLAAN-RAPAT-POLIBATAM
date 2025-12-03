<?php
session_start();
require_once 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: masuk.php');
    exit();
}

// Ambil data user yang login
$user_id = $_SESSION['user_id'];

// Ambil ID rapat dari URL
$id_rapat = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validasi: cek apakah rapat ada dan user adalah pembuat
$query_rapat = "SELECT * FROM rapat WHERE id_rapat = '$id_rapat' AND id_user = '$user_id'";
$result_rapat = mysqli_query($koneksi, $query_rapat);
$rapat = mysqli_fetch_assoc($result_rapat);

if (!$rapat) {
    echo "<script>alert('Rapat tidak ditemukan atau Anda tidak memiliki akses!'); window.location.href='rapat_saya.php';</script>";
    exit();
}

// Update status rapat menjadi dibatalkan
$update_query = "UPDATE rapat SET status = 'dibatalkan' WHERE id_rapat = '$id_rapat' AND id_user = '$user_id'";

if (mysqli_query($koneksi, $update_query)) {
    echo "<script>
        alert('Rapat \"" . htmlspecialchars($rapat['judul_rapat']) . "\" berhasil dibatalkan!');
        window.location.href = 'rapat_saya.php';
    </script>";
    exit();
} else {
    echo "<script>
        alert('Gagal membatalkan rapat. Silakan coba lagi!');
        window.location.href='atur_rapat.php?id=$id_rapat';
    </script>";
}
?>
