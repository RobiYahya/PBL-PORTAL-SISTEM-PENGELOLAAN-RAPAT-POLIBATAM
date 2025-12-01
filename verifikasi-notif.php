<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verifikasi Akses - Sipera</title>
    <link rel="stylesheet" href="./public/css/style-daftar.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    />
</head>
<body>
    <div class="main-center">
        <div class="registration-container neumorphic-panel">
            <div class="header-section">
                <img src="./public/foto/logo.png" alt="Logo Sipera" class="logo" />
                <h2 class="main-title">Akses Detail Rapat Terbatas</h2>
                <p class="subtitle">
                    Untuk melihat detail rapat (**ID Rapat: <span id="rapat-id-display"></span>**), harap masukkan data identitas Anda.
                </p>
                <p class="mt-10">
                    <small>Data ini hanya digunakan untuk pencatatan akses sementara.</small>
                </p>
            </div>

            <form id="verificationForm">
                <div class="form-group">
                    <label for="nama" class="neumorphic-label">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="neumorphic-input"
                        placeholder="Masukkan Nama Anda"
                        required
                    />
                    <div class="error-message" id="error-nama"></div>
                </div>

                <div class="form-group">
                    <label for="nim_nip" class="neumorphic-label">NIM / NIP</label>
                    <input
                        type="text"
                        id="nim_nip"
                        name="nim_nip"
                        class="neumorphic-input"
                        placeholder="Masukkan NIM/NIP Anda"
                        required
                    />
                    <div class="error-message" id="error-nim_nip"></div>
                </div>

                <div class="form-group">
                    <label for="email" class="neumorphic-label">Email Aktif</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="neumorphic-input"
                        placeholder="contoh: user@polibatam.ac.id"
                        required
                    />
                    <div class="error-message" id="error-email"></div>
                </div>
                
                <input type="hidden" id="rapatId" name="rapatId" value="" />

                <button type="submit" class="neumorphic-btn btn-primary">
                    Lanjutkan ke Detail Rapat
                </button>
                <div class="mt-20 text-center">
                    <a href="masuk.php">Sudah punya akun? Masuk</a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="js/script-verifikasi.js"></script>
</body>
</html>