<?php
session_start();
require_once 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: masuk.php');
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id_user = '$user_id'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

// Proses update password
if (isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verifikasi password lama
    if (password_verify($old_password, $user['password'])) {
        if ($old_password !== $new_password) {
            if ($new_password === $confirm_password) {
                if (strlen($new_password) >= 6) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_query = "UPDATE users SET password = '$hashed_password' WHERE id_user = '$user_id'";
                    if (mysqli_query($koneksi, $update_query)) {
                        echo "<script>
                            alert('Password berhasil diubah! Silakan login kembali.');
                            window.location.href = 'masuk.php';
                        </script>";
                        exit();
                    } else {
                        $error_message = "Gagal memperbarui password!";
                    }
                } else {
                    $error_message = "Password minimal 6 karakter!";
                }
            } else {
                $error_message = "Konfirmasi password tidak cocok!";
            }
        } else {
            $error_message = "Password baru tidak boleh sama dengan password lama!";
        }
    } else {
        $error_message = "Password lama salah!";
    }
}

// Proses update email
if (isset($_POST['update_email'])) {
    $new_email = $_POST['new_email'];
    
    // Validasi email
    if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $update_query = "UPDATE users SET email = '$new_email' WHERE id_user = '$user_id'";
        if (mysqli_query($koneksi, $update_query)) {
            // Refresh data user
            $result = mysqli_query($koneksi, $query);
            $user = mysqli_fetch_assoc($result);
            $success_message = "Email berhasil diperbarui!";
        } else {
            $error_message = "Gagal memperbarui email!";
        }
    } else {
        $error_message = "Format email tidak valid!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style_profil.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="masuk.php" class="logo-link">
                <img src="./public/foto/logo.png" alt="Logo Sipera" class="logo" />
            </a>
            <div class="nav-links">
                <div class="user-menu-dropdown">
                    <button class="user-button">
                        Halo, <?php echo htmlspecialchars($user['nama_lengkap']); ?>!
                    </button>
                    <div class="user-dropdown-content" id="userDropdown">
                        <a href="rapat_saya.php">kembali</a>
                        <a href="masuk.php">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="profile-section">
            <div class="container">
                <h1 class="main-title">Profil Pengguna Saya 💼</h1>
                <p class="subtitle">Kelola informasi akun dan keamanan Anda.</p>

                <div class="profile-container">
                    
                    <div class="profile-info neumorphic-panel">
                        <h2>Data Akun Dasar</h2>
                        
                        <div class="photo-upload-container">
                            <div class="profile-photo-wrapper">
                                <img src="./public/foto/default-user.png" alt="Foto Profil" id="profileImage" class="profile-photo">
                            </div>
                            <label for="photoUpload" class="neumorphic-btn btn-secondary">
                                Ganti Foto
                            </label>
                            <input type="file" id="photoUpload" accept="image/*" style="display: none;">
                        </div>

                        <div class="data-display-group">
                            <label class="data-label">Nama Lengkap</label>
                            <p class="data-value"><?php echo htmlspecialchars($user['nama_lengkap']); ?></p>
                        </div>
                        <div class="data-display-group">
                            <label class="data-label">NIK / NIM</label>
                            <p class="data-value"><?php echo htmlspecialchars($user['nik']); ?></p>
                        </div>
                        <div class="data-display-group">
                            <label class="data-label">Jabatan</label>
                            <p class="data-value"><?php echo htmlspecialchars($user['jabatan']); ?></p>
                        </div>
                        <div class="data-display-group">
                            <label class="data-label">Email (Tersimpan)</label>
                            <p class="data-value"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>

                    <div class="profile-settings-form">
                        
                        <div class="settings-block neumorphic-form">
                            <h3>Ubah Kata Sandi</h3>
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-error" style="background-color: #ff4444; color: #ffffff; border: 2px solid #cc0000; font-weight: 700; font-size: 16px; padding: 12px 20px; margin-bottom: 20px; border-radius: 8px; text-align: center; text-transform: uppercase; animation: shake 0.5s ease-in-out;"><?php echo $error_message; ?></div>
                            <?php endif; ?>
                            <?php if (isset($success_message)): ?>
                                <div class="alert alert-success"><?php echo $success_message; ?></div>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="old_password" class="neumorphic-label">Kata Sandi Lama</label>
                                    <input type="password" id="old_password" name="old_password" required class="neumorphic-input" placeholder="Masukkan kata sandi lama Anda">
                                </div>
                                <div class="form-group">
                                    <label for="new_password" class="neumorphic-label">Kata Sandi Baru</label>
                                    <input type="password" id="new_password" name="new_password" required class="neumorphic-input" placeholder="Minimal 6 karakter">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="neumorphic-label">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" id="confirm_password" name="confirm_password" required class="neumorphic-input" placeholder="Ulangi kata sandi baru">
                                </div>
                                <button type="submit" name="update_password" class="neumorphic-btn btn-primary">
                                    🔑 Perbarui Kata Sandi
                                </button>
                            </form>
                        </div>

                        <div class="settings-block neumorphic-form">
                            <h3>Ubah Email</h3>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="current_email" class="neumorphic-label">Email Saat Ini</label>
                                    <input type="email" id="current_email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled class="neumorphic-input" style="opacity: 0.7;">
                                </div>
                                <div class="form-group">
                                    <label for="new_email" class="neumorphic-label">Email Baru</label>
                                    <input type="email" id="new_email" name="new_email" required class="neumorphic-input" placeholder="Masukkan alamat email baru Anda">
                                </div>
                                <button type="submit" name="update_email" class="neumorphic-btn btn-primary">
                                    📧 Perbarui Email
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; 2025 Sipera POLIBATAM - All rights reserved.</p>
        </div>
    </footer>

    <script>
        // SCRIPT JAVASCRIPT untuk mengurus Foto Profil
        document.getElementById('photoUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        
        // SCRIPT JAVASCRIPT untuk User Dropdown (dikutip dari halaman sebelumnya)
        document.addEventListener('DOMContentLoaded', function() {
            const userButton = document.querySelector('.user-button');
            const dropdownContent = document.querySelector('.user-dropdown-content');

            userButton.addEventListener('click', function() {
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }
            });

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.user-menu-dropdown')) {
                    dropdownContent.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>