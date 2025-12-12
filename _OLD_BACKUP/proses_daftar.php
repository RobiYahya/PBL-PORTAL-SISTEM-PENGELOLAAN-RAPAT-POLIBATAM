<?php
// ============================================
// PROSES DAFTAR - Tangkap data dari form daftar.php
// ============================================

require_once 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $nim = trim($_POST['nim'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? 'mahasiswa');
    
    // --- VALIDASI INPUT ---
    
    // 1. Cek field kosong
    if (empty($nama) || empty($nim) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Semua field harus diisi!";
        header("Location: daftar.php");
        exit;
    }
    
    // 2. Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid!";
        header("Location: daftar.php");
        exit;
    }
    
    // 3. Cek password cocok
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Konfirmasi password tidak cocok!";
        header("Location: daftar.php");
        exit;
    }
    
    // 4. Cek panjang password
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password minimal 6 karakter!";
        header("Location: daftar.php");
        exit;
    }
    
    // --- CEK DUPLIKAT DI DATABASE ---
    
    // Cek NIK sudah ada
    $query_cek_nik = "SELECT id_user FROM users WHERE nik = ?";
    $stmt = $koneksi->prepare($query_cek_nik);
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "NIM/NIP sudah terdaftar!";
        $stmt->close();
        header("Location: daftar.php");
        exit;
    }
    $stmt->close();
    
    // Cek Email sudah ada
    $query_cek_email = "SELECT id_user FROM users WHERE email = ?";
    $stmt = $koneksi->prepare($query_cek_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email sudah terdaftar!";
        $stmt->close();
        header("Location: daftar.php");
        exit;
    }
    $stmt->close();
    
    // --- HASH PASSWORD DAN INSERT KE DATABASE ---
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $query_insert = "INSERT INTO users (nik, nama_lengkap, email, password, jabatan) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query_insert);
    
    if (!$stmt) {
        $_SESSION['error'] = "Error query: " . $koneksi->error;
        header("Location: daftar.php");
        exit;
    }
    
    $stmt->bind_param("sssss", $nim, $nama, $email, $password_hash, $jabatan);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        $stmt->close();
        $koneksi->close();
        header("Location: masuk.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
        $stmt->close();
        $koneksi->close();
        header("Location: daftar.php");
        exit;
    }
} else {
    // Jika bukan POST, redirect ke daftar
    header("Location: daftar.php");
    exit;
}
?>
