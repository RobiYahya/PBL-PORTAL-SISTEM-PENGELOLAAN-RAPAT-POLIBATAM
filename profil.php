<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style-profil.css" />
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
                        Halo, Admin!
                    </button>
                    <div class="user-dropdown-content" id="userDropdown">
                        <a href="rapat-saya.html">kembali</a>
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
                            <p class="data-value">Haikal Mubaroq Zafia</p>
                        </div>
                        <div class="data-display-group">
                            <label class="data-label">NIM / NIDN</label>
                            <p class="data-value">3312501035</p>
                        </div>
                        <div class="data-display-group">
                            <label class="data-label">Kata Sandi (Tersimpan)</label>
                            <p class="data-value">********</p>
                        </div>
                        <div class="data-display-group">
                            <label class="data-label">Email (Tersimpan)</label>
                            <p class="data-value">haikalzafia@gmail.com</p>
                        </div>
                    </div>

                    <div class="profile-settings-form">
                        
                        <div class="settings-block neumorphic-form">
                            <h3>Ubah Kata Sandi</h3>
                            <form>
                                <div class="form-group">
                                    <label for="old_password" class="neumorphic-label">Kata Sandi Lama</label>
                                    <input type="password" id="old_password" required class="neumorphic-input" placeholder="Masukkan kata sandi lama Anda">
                                </div>
                                <div class="form-group">
                                    <label for="new_password" class="neumorphic-label">Kata Sandi Baru</label>
                                    <input type="password" id="new_password" required class="neumorphic-input" placeholder="Minimal 8 karakter">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="neumorphic-label">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" id="confirm_password" required class="neumorphic-input" placeholder="Ulangi kata sandi baru">
                                </div>
                                <button type="submit" class="neumorphic-btn btn-primary">
                                    🔑 Perbarui Kata Sandi
                                </button>
                            </form>
                        </div>

                        <div class="settings-block neumorphic-form">
                            <h3>Ubah Email</h3>
                            <form>
                                <div class="form-group">
                                    <label for="current_email" class="neumorphic-label">Email Saat Ini</label>
                                    <input type="email" id="current_email" value="budi.santoso@polibatam.ac.id" disabled class="neumorphic-input" style="opacity: 0.7;">
                                </div>
                                <div class="form-group">
                                    <label for="new_email" class="neumorphic-label">Email Baru</label>
                                    <input type="email" id="new_email" required class="neumorphic-input" placeholder="Masukkan alamat email baru Anda">
                                </div>
                                <button type="submit" class="neumorphic-btn btn-primary">
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