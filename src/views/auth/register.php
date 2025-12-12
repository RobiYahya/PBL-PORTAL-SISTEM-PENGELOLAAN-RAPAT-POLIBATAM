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
                    <label>NIK / NIDN</label>
                    <input type="text" name="nik" placeholder="Nomor Induk Karyawan" required class="neu-input">
                </div>

                <div class="form-group">
                    <label>Email Aktif</label>
                    <input type="email" name="email" placeholder="email@polibatam.ac.id" required class="neu-input">
                </div>

                <div class="form-group">
                    <label>Daftar Sebagai</label>
                    <select name="jabatan" class="neu-input">
                        <option value="dosen">Dosen / Anggota Rapat</option>
                        <option value="admin">Admin / Ketua Rapat</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" required class="neu-input">
                </div>

                <div class="form-group">
                    <label>Ulangi Kata Sandi</label>
                    <input type="password" name="ulangi_password" placeholder="Ketik ulang sandi" required class="neu-input">
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
</main>