<main class="main-center">
    <div class="registration-container neumorphic-panel">
        <div class="header-section">
            <img src="<?= BASEURL; ?>/foto/logo.png" alt="Logo Sipera" class="logo" />
            <h1 class="main-title">Lupa Kata Sandi?</h1>
            <p class="subtitle">Masukkan NIM/NIP dan email untuk reset kata sandi.</p>
        </div>
        
        <div class="row">
            <div class="col-12">
                <?php Flasher::flash(); ?>
            </div>
        </div>

        <form id="resetForm" method="POST" action="<?= BASEURL; ?>/auth/reset">
            <div class="form-group">
                <label for="nim_nip" class="neumorphic-label">NIM / NIP</label>
                <input type="text" id="nim_nip" name="nim_nip" placeholder="Masukkan NIM atau NIP terdaftar" required class="neumorphic-input" />
            </div>

            <div class="form-group">
                <label for="email" class="neumorphic-label">Email Terdaftar</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required class="neumorphic-input" />
            </div>
            
            <button type="submit" class="neumorphic-btn btn-primary">
                📧 Kirim Link Reset
            </button>
        </form>
        
        <p class="login-link">
            Ingat Kata Sandi? <a href="<?= BASEURL; ?>/auth/login">Kembali Masuk</a>
        </p>
    </div>
</main>