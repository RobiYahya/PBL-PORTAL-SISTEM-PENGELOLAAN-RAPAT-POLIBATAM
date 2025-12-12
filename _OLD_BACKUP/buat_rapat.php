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
$query = "SELECT * FROM users WHERE id_user = '$user_id'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Rapat Baru - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style_buat_rapat.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
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
                    <div class="user-dropdown-content">
                        <a href="profil.php">Profil Saya</a>
                        <a href="rapat_saya.php">Rapat Saya</a>
                        <a href="masuk.php">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="meeting-creation-section">
            <div class="container">
                <h1 class="main-title">Buat Rapat Baru 📝</h1>
                <p class="subtitle">Silakan isi detail rapat yang akan Anda jadwalkan.</p>
                
                <form id="meetingForm" class="neumorphic-form" action="proses_rapat.php" method="POST">
                    
                    <div class="form-group">
                        <label for="judul_rapat" class="neumorphic-label">Judul Rapat</label>
                        <input
                            type="text"
                            id="judul_rapat"
                            name="judul_rapat"
                            placeholder="Contoh: Rapat Koordinasi Akhir Tahun"
                            required
                            class="neumorphic-input"
                        />
                    </div>

                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="ruangan_rapat" class="neumorphic-label">Ruangan Rapat (Tulis Manual)</label>
                            <input
                                type="text"
                                id="ruangan_rapat"
                                name="ruangan_rapat"
                                placeholder="Contoh: Ruangan R-301, Gedung C"
                                required
                                class="neumorphic-input"
                            />
                        </div>

                        <div class="form-group half-width">
                            <label for="status_rapat" class="neumorphic-label">Status Awal Rapat</label>
                            <select id="status_rapat" name="status_rapat" required class="neumorphic-select">
                                <option value="Draft" selected>Draft (Belum Dipublikasi)</option>
                                <option value="Terjadwal">Terjadwal</option>
                                <option value="Mendesak">Mendesak</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group third-width">
                            <label for="tanggal_rapat" class="neumorphic-label">Tanggal Rapat</label>
                            <input
                                type="date"
                                id="tanggal_rapat"
                                name="tanggal_rapat"
                                required
                                class="neumorphic-input"
                            />
                        </div>

                        <div class="form-group third-width">
                            <label for="jam_mulai" class="neumorphic-label">Jam Mulai</label>
                            <input
                                type="time"
                                id="jam_mulai"
                                name="jam_mulai"
                                required
                                class="neumorphic-input"
                            />
                        </div>
                        
                        <div class="form-group third-width">
                            <label for="jam_selesai" class="neumorphic-label">Jam Selesai</label>
                            <input
                                type="time"
                                id="jam_selesai"
                                name="jam_selesai"
                                class="neumorphic-input"
                            />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tujuan_rapat" class="neumorphic-label">Tujuan Rapat (Agenda Utama)</label>
                        <textarea
                            id="tujuan_rapat"
                            name="tujuan_rapat"
                            rows="4"
                            placeholder="Jelaskan tujuan utama rapat dan agenda singkat"
                            required
                            class="neumorphic-textarea"
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label class="neumorphic-label">Tentukan Anggota Rapat (Target Peserta)</label>
                        <div class="neumorphic-checkbox-group">
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" name="target_rapat[]" value="dosen">
                                <span class="checkmark"></span>
                                Untuk Seluruh Dosen
                            </label>
                            
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" name="target_rapat[]" value="pegawai">
                                <span class="checkmark"></span>
                                Untuk Seluruh Pegawai
                            </label>
                            
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" name="target_rapat[]" value="mahasiswa">
                                <span class="checkmark"></span>
                                Untuk Seluruh Mahasiswa
                            </label>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="reset" class="neumorphic-btn btn-secondary">
                            🗑️ Hapus Form
                        </button>
                        <button type="submit" class="neumorphic-btn btn-primary">
                            🚀 Simpan & Terbitkan Rapat
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; 2025 Sipera POLIBATAM - All rights reserved.</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SCRIPT JAVASCRIPT untuk mengontrol User Dropdown 
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