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
                    <label for="nik" class="form-label">NIK / NIDN</label>
                    <input type="text" id="nik" name="nik" placeholder="Contoh: 3312..." required class="neu-input">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required class="neu-input">
                </div>

                <div class="form-actions" style="margin-top: 20px;">
                    <button type="submit" class="neu-btn btn-primary" style="width: 100%;">🚀 Masuk Sekarang</button>
                </div>
            </form>

            <div class="auth-footer" style="margin-top: 20px;">
                <p>Belum punya akun? <a href="<?= BASEURL; ?>/auth/register" style="color: var(--secondary); font-weight: bold;">Daftar di sini</a></p>
            </div>
        </div>
    </section>
</main>