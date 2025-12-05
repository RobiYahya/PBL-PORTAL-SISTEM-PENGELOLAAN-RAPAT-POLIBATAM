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

// Proses pembuatan rapat baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Ambil data dari form buat_rapat.php
    $judul_rapat = mysqli_real_escape_string($koneksi, $_POST['judul_rapat']);
    $ruangan_rapat = mysqli_real_escape_string($koneksi, $_POST['ruangan_rapat']);
    $status_rapat = mysqli_real_escape_string($koneksi, $_POST['status_rapat']);
    $tanggal_rapat = $_POST['tanggal_rapat'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $tujuan_rapat = mysqli_real_escape_string($koneksi, $_POST['tujuan_rapat']);
    
    // Gabungkan tanggal dan jam untuk format datetime
    $tanggal_rapat_datetime = $tanggal_rapat . ' ' . $jam_mulai;
    
    // Normalisasi status rapat sesuai database
    $status_db = 'draft'; // default
    $prioritas_db = 'normal'; // default
    if ($status_rapat == 'Terjadwal') {
        $status_db = 'terjadwal';
        $prioritas_db = 'normal';
    } elseif ($status_rapat == 'Mendesak') {
        $status_db = 'terjadwal'; // Mendesak dianggap terjadwal
        $prioritas_db = 'mendesak';
    }
    
    // Insert data rapat ke tabel rapat
    $query_rapat = "INSERT INTO rapat (id_user, judul_rapat, deskripsi, tanggal_rapat, jam_selesai, lokasi, status, prioritas) 
                    VALUES ('$user_id', '$judul_rapat', '$tujuan_rapat', '$tanggal_rapat_datetime', '$jam_selesai', '$ruangan_rapat', '$status_db', '$prioritas_db')";
    
    if (mysqli_query($koneksi, $query_rapat)) {
        $id_rapat = mysqli_insert_id($koneksi);
        
        // Proses target peserta/anggota rapat
        if (isset($_POST['target_rapat']) && is_array($_POST['target_rapat'])) {
            foreach ($_POST['target_rapat'] as $target) {
                // Base query untuk mencari user dengan jabatan yang sesuai
                $query_users = "SELECT id_user FROM users WHERE jabatan = '$target'";
                
                // Jika target adalah mahasiswa dan ada jurusan yang dipilih
                if ($target === 'mahasiswa' && isset($_POST['jurusan']) && is_array($_POST['jurusan']) && !empty($_POST['jurusan'])) {
                    // Filter mahasiswa berdasarkan jurusan yang dipilih
                    $jurusan_list = "'" . implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($_POST['jurusan']), $koneksi), $_POST['jurusan'])) . "'";
                    $query_users .= " AND jurusan IN ($jurusan_list)";
                }
                
                $result_users = mysqli_query($koneksi, $query_users);
                
                while ($user = mysqli_fetch_assoc($result_users)) {
                    $id_user_target = $user['id_user'];
                    
                    // Insert ke tabel peserta_rapat
                    $query_peserta = "INSERT INTO peserta_rapat (id_rapat, id_user, status_kehadiran) 
                                    VALUES ('$id_rapat', '$id_user_target', 'hadir')
                                    ON DUPLICATE KEY UPDATE status_kehadiran = 'hadir'";
                    mysqli_query($koneksi, $query_peserta);
                }
            }
        }
        
        // Notifikasi sukses
        echo "<script>
            alert('Rapat \"$judul_rapat\" (ID #$id_rapat) berhasil dibuat dan disimpan!');
            window.location.href = 'rapat_saya.php';
        </script>";
        exit();
        
    } else {
        // Error handling
        echo "<script>
            alert('Gagal membuat rapat. Silakan coba lagi!');
            window.location.href = 'buat_rapat.php';
        </script>";
        exit();
    }
}

// Jika bukan POST, redirect ke halaman buat rapat
header('Location: buat_rapat.php');
exit();
?>
