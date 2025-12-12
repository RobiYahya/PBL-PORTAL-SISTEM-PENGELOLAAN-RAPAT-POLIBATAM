<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Kata Sandi - Sipera POLIBATAM</title>
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
                <h1 class="main-title">Lupa Kata Sandi?</h1>
                <p class="subtitle">Masukkan NIM/NIP dan email Anda untuk memulai reset kata sandi.</p>
            </div>
            
            <form id="resetForm" onsubmit="return handleResetPassword()">
                
                <div class="form-group">
                    <label for="nim_nip" class="neumorphic-label">NIM / NIP</label>
                    <input
                        type="text"
                        id="nim_nip"
                        name="nim_nip"
                        placeholder="Masukkan NIM atau NIP terdaftar"
                        required
                        class="neumorphic-input"
                    />
                </div>

                <div class="form-group">
                    <label for="email" class="neumorphic-label">Email Terdaftar</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan email Anda"
                        required
                        class="neumorphic-input"
                    />
                    <small id="resetError" class="error-message"></small>
                </div>
                
                <button type="submit" class="neumorphic-btn btn-primary">
                    📧 Kirim Link Reset
                </button>
            </form>
            
            <p class="login-link">
                Ingat Kata Sandi? <a href="masuk.php">Kembali Masuk</a>
            </p>
        </div>
    </main>
    
    <script>
        function handleResetPassword() {
            const nimNip = document.getElementById('nim_nip').value;
            const email = document.getElementById('email').value;
            const errorElement = document.getElementById('resetError');

            // --- SIMULASI LOGIKA RESET PASSWORD ---
            
            // Simulasi: Verifikasi berhasil jika NIM/NIP dan email tidak kosong
            if (nimNip && email) {
                errorElement.style.display = 'none';
                
                alert("Link reset kata sandi telah berhasil dikirim ke email " + email + ".");
                
                // Setelah dikirim, arahkan kembali ke halaman login
                window.location.href = 'masuk.php'; 
            } else {
                // Pesan error jika salah satu kolom kosong (meskipun sudah ada required)
                errorElement.textContent = "⚠️ NIM/NIP dan Email harus diisi.";
                errorElement.style.display = 'block';
            }

            return false; // Mencegah formulir terkirim dan halaman me-refresh
        }
    </script>
</body>
</html>