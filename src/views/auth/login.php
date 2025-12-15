<main>
    <section class="login-section">
        <div class="neu-card login-card">
            <h1 class="auth-title">Masuk ke Sipera 🔐</h1>
            <p class="auth-subtitle">Gunakan NIK dan kata sandi akun Anda.</p>

            <div style="margin-bottom: 20px;">
                <?php Flasher::flash(); ?>
            </div>

            <form action="<?= BASEURL; ?>/auth/login" method="POST">
                <div class="form-group">
                    <label class="form-label">NIK / NIP</label>
                    <div class="input-group">
                        <input type="text" name="nik" class="neu-input" placeholder="Masukkan NIK/NIP" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        
                        <input type="password" name="password" id="passLogin" class="neu-input" placeholder="Masukkan Password" required style="padding-left: 45px;">
                        
                        <i class="fas fa-eye toggle-password" onclick="togglePass('passLogin', this)"></i>
                    </div>
                </div>

                <button type="submit" class="neu-btn btn-primary" style="width: 100%; margin-top: 20px;">
                    🚀 Masuk Sekarang
                </button>
            </form>

            <div class="auth-footer" style="margin-top: 20px;">
                <p>Belum punya akun? <a href="<?= BASEURL; ?>/auth/register" style="color: var(--secondary); font-weight: bold;">Daftar di sini</a></p>
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