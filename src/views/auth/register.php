<main>
    <section class="login-section"> 
        <div class="neu-card login-card" style="max-width: 500px;"> 
            <h1 class="auth-title">Daftar Akun Baru 📝</h1>
            <p class="auth-subtitle">Silakan isi data diri Anda dengan lengkap.</p>

            <div style="margin-bottom: 20px;">
                <?php Flasher::flash(); ?>
            </div>

            <form action="<?= BASEURL; ?>/auth/prosesRegister" method="POST">
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Nama sesuai identitas" required class="neu-input">
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" placeholder="Nomor Induk Karyawan" required class="neu-input">
                </div>

                <div class="form-group">
                    <label>Email Aktif</label>
                    <input type="email" name="email" placeholder="email@polibatam.ac.id" required class="neu-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sandi</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="passReg1" class="neu-input" placeholder="Buat Password Aman" required>
                        <i class="fas fa-eye toggle-password" onclick="togglePass('passReg1', this)"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Kata Sandi</label>
                    <div class="password-wrapper">
                        <input type="password" name="ulangi_password" id="passReg2" class="neu-input" placeholder="Ketik Ulang Password" required>
                        <i class="fas fa-eye toggle-password" onclick="togglePass('passReg2', this)"></i>
                    </div>
                </div>

                <div class="form-actions" style="margin-top: 20px;">
                    <button type="submit" class="neu-btn btn-primary" style="width: 100%;">✨ Buat Akun</button>
                </div>
            </form>

            <div class="auth-footer" style="margin-top: 20px;">
                <p>Sudah punya akun? <a href="<?= BASEURL; ?>/auth/login" style="color: var(--secondary); font-weight: bold;">Masuk di sini</a></p>
            </div>
        </div>
    </section>
    <script>
        function togglePass(inputId, icon) {
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