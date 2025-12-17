<?php
// Nama File: login.php
// Deskripsi: Halaman login pengguna menggunakan NIK.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]
?>
<main>
    <section class="login-section">
        <div class="neu-card login-card">
            <h1 class="auth-title">Masuk ke Sipera 🔐</h1>
            <p class="auth-subtitle">Gunakan NIK dan kata sandi akun Anda.</p>

            <div class="mb-20">
                <?php Flasher::flash(); ?>
            </div>

            <form action="<?= BASEURL; ?>/auth/login" method="POST">
                <div class="form-group">
                    <label class="form-label">NIK</label>
                    <div class="input-group">
                        <input type="text" name="nik" class="neu-input" placeholder="Masukkan NIK" required autofocus />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sandi</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="passLogin" class="neu-input" placeholder="Masukkan Kata Sandi"/>
                        <i class="fas fa-eye toggle-password" onclick="togglePass('passLogin', this)"></i>
                    </div>
                </div>

                <button type="submit" class="neu-btn btn-primary w-100 mt-20">
                    🚀 Masuk Sekarang
                </button>
            </form>

            <div class="text-center mt-20">
                <p>Belum punya akun? <a href="<?= BASEURL; ?>/auth/register" class="text-secondary font-bold">Daftar di sini</a></p>
            </div>
        </div>
    </section>
    <script>
        const togglePass = (inputId, icon) => {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</main>