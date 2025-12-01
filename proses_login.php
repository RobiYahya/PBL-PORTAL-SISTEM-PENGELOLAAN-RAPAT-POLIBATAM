<?php
// ============================================
// PROSES LOGIN - Tangkap data dari form masuk.php
// ============================================

require_once 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim_nip = trim($_POST['nim_nip'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validasi input
    if (empty($nim_nip) || empty($password)) {
        $_SESSION['error'] = "NIM/NIP dan password harus diisi!";
        header("Location: masuk.php");
        exit;
    }
    
    // Query cek user di database (gunakan prepared statement)
    $query = "SELECT id_user, nik, nama_lengkap, email, password, jabatan FROM users WHERE nik = ?";
    $stmt = $koneksi->prepare($query);
    
    if (!$stmt) {
        $_SESSION['error'] = "Error query: " . $koneksi->error;
        header("Location: masuk.php");
        exit;
    }
    
    $stmt->bind_param("s", $nim_nip);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password menggunakan password_verify
        if (password_verify($password, $user['password'])) {
            // Login berhasil - set session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['nik'] = $user['nik'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['jabatan'] = $user['jabatan'];
            $_SESSION['login'] = true;
            
            $stmt->close();
            $koneksi->close();
            
            // Redirect ke dashboard
            header("Location: rapat-saya.php");
            exit;
        } else {
            // Password salah
            $_SESSION['error'] = "Password salah!";
            $stmt->close();
            $koneksi->close();
            header("Location: masuk.php");
            exit;
        }
    } else {
        // User tidak ditemukan
        $_SESSION['error'] = "NIM/NIP tidak ditemukan!";
        $stmt->close();
        $koneksi->close();
        header("Location: masuk.php");
        exit;
    }
} else {
    // Jika bukan POST, redirect ke login
    header("Location: masuk.php");
    exit;
}
?>
