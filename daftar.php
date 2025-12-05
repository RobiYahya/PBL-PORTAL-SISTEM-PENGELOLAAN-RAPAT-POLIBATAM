<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun Baru - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style_daftar.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
</head>

<body>
    <main class="main-center">
        <div class="registration-container neumorphic-panel">
            <div class="header-section">
                <img src="./public/foto/logo.png" alt="Logo Sipera" class="logo" />
                <h1 class="main-title">Daftar Akun Sipera</h1>
                <p class="subtitle">Silakan isi data diri Anda untuk membuat akun baru.</p>
            </div>

            <?php 
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<div style="color: #ff4d4d; background: #ffe6e6; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 0.95rem;">⚠️ ' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div style="color: #28a745; background: #d4edda; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 0.95rem;">✅ ' . htmlspecialchars($_SESSION['success']) . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            
            <form id="registrationForm" method="POST" action="proses_daftar.php">
                
                <div class="form-group">
                    <label for="nama" class="neumorphic-label">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        placeholder="Masukkan nama lengkap Anda"
                        required
                        class="neumorphic-input"
                    />
                </div>

                <div class="form-group">
                    <label for="nim" class="neumorphic-label">NIM / NIP</label>
                    <input
                        type="text"
                        id="nim"
                        name="nim"
                        placeholder="Masukkan NIM atau NIP Anda"
                        required
                        class="neumorphic-input"
                    />
                </div>

                <div class="form-group">
                    <label for="jabatan" class="neumorphic-label">Jabatan</label>
                    <select
                        id="jabatan"
                        name="jabatan"
                        required
                        class="neumorphic-input"
                        onchange="toggleJurusan()"
                    >
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Pegawai">Pegawai</option>
                        <option value="Mahasiswa">Mahasiswa</option>
                    </select>
                </div>

                <div id="jurusanGroup" style="display: none;" class="form-group">
                    <label for="jurusan" class="neumorphic-label">Jurusan</label>
                    <select
                        id="jurusan"
                        name="jurusan"
                        class="neumorphic-input"
                    >
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Rekayasa Keamanan Siber">Rekayasa Keamanan Siber</option>
                        <option value="Teknik Geomatika">Teknik Geomatika</option>
                        <option value="Teknologi Permainan">Teknologi Permainan</option>
                        <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                        <option value="Teknologi Rekayasa Multimedia">Teknologi Rekayasa Multimedia</option>
                        <option value="Animasi">Animasi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email" class="neumorphic-label">Email Aktif</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="contoh: user@polibatam.ac.id"
                        required
                        class="neumorphic-input"
                    />
                </div>

                <div class="form-group">
                    <label for="password" class="neumorphic-label">Kata Sandi</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Buat kata sandi minimal 6 karakter"
                        required
                        class="neumorphic-input"
                    />
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="neumorphic-label">Konfirmasi Kata Sandi</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Masukkan ulang kata sandi Anda"
                        required
                        class="neumorphic-input"
                    />
                    <small id="passwordError" class="error-message"></small>
                </div>
                
                <button type="submit" class="neumorphic-btn btn-primary">
                    ✅ Daftar Sekarang
                </button>
            </form>
            
            <p class="login-link">Sudah punya akun? <a href="masuk.php">Masuk di sini</a></p>
        </div>
    </main>
    
    <script>
    function validateForm() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorElement = document.getElementById('passwordError');
        const minLength = 6;

        if (password.length < minLength) {
            errorElement.textContent = `⚠️ Kata sandi wajib minimal ${minLength} karakter!`;
            errorElement.style.display = 'block';
            return false;
        }

        if (password !== confirmPassword) {
            errorElement.textContent = "⚠️ Konfirmasi kata sandi tidak cocok!";
            errorElement.style.display = 'block';
            return false; 
        } else {
            errorElement.textContent = "";
            errorElement.style.display = 'none';
            alert("Pendaftaran berhasil! Silakan masuk menggunakan akun Anda.");
            window.location.href = 'masuk.php';
            return false; 
        }
    }

    /* ========== FUNCTION TAMBAHAN YANG DIMINTA ========== */
    function toggleJurusan() {
        const jabatanSelect = document.getElementById('jabatan');
        const jurusanGroup = document.getElementById('jurusanGroup');
        
        if (jabatanSelect.value === 'Mahasiswa') {
            jurusanGroup.style.display = 'block';
            document.getElementById('jurusan').required = true;
        } else {
            jurusanGroup.style.display = 'none';
            document.getElementById('jurusan').required = false;
            document.getElementById('jurusan').value = '';
        }
    }
    </script>
</body>
</html>
