<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk Akun - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style-daftar.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
</head>

<body>
    <main class="main-center">
        <div class="registration-container neumorphic-panel">
            <div class="header-section">
                <img src="./public/foto/logo.png" alt="Logo Sipera" class="logo" />
                <h1 class="main-title">Masuk ke Sipera</h1>
                <p class="subtitle">Gunakan NIM/NIP dan kata sandi akun Anda.</p>
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

            <form id="loginForm" method="POST" action="proses_login.php">
                <div class="form-group">
                    <label for="nim_nip" class="neumorphic-label">NIM / NIP</label>
                    <input type="text" id="nim_nip" name="nim_nip" placeholder="Masukkan NIM atau NIP Anda" required class="neumorphic-input" />
                </div>

                <div class="form-group">
                    <label for="password" class="neumorphic-label">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" required class="neumorphic-input" />
                    <small id="loginError" class="error-message"></small>
                </div>

                <p class="forgot-password"><a href="lupa-sandi.php">Lupa Kata Sandi?</a></p>

                <button type="submit" class="neumorphic-btn btn-primary">
                    ➡️ Masuk
                </button>
            </form>

            <p class="login-link">Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>
        </div>
    </main>

    <script>
    function handleLogin() {
        // Ambil nilai dari input NIM/NIP yang baru
        const nimNip = document.getElementById("nim_nip").value;
        const password = document.getElementById("password").value;
        const errorElement = document.getElementById("loginError");

        // --- SIMULASI LOGIKA LOGIN ---

        // Contoh simulasi: jika NIM/NIP=3312501035 dan password=123456
        if (nimNip === "3312501035" && password === "123456") {
            errorElement.style.display = "none";
            alert("Login Berhasil! Selamat datang, Admin.");

            // Arahkan ke halaman utama dashboard (misal: rapat-saya.html)
            window.location.href = "rapat-saya.php";
        } else {
            // Tampilkan pesan error jika login gagal
            errorElement.textContent =
                "⚠️ NIM/NIP atau Kata Sandi salah. Coba lagi.";
            errorElement.style.display = "block";
        }

        return false; // Mencegah formulir terkirim dan halaman me-refresh
    }
    </script>
</body>

</html>