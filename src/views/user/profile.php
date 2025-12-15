<main>
    <section class="profile-section" style="padding: 40px 0;">
        <div class="container">
            <h1 style="text-align: center;">Profil Pengguna 👤</h1>
            <div style="text-align: center; margin-bottom: 20px;"><?php Flasher::flash(); ?></div>
            
            <form action="<?= BASEURL; ?>/user/update" method="POST" enctype="multipart/form-data" class="neu-card">
                <input type="hidden" name="foto_lama" value="<?= $data['user']['foto']; ?>">
                
                <div class="profile-container">
                    <div style="text-align: center; flex: 1;">
                        <div class="profile-photo-wrapper">
                            <?php 
                                $foto = (!empty($data['user']['foto'])) ? BASEURL . '/foto/profil/' . $data['user']['foto'] : BASEURL . '/foto/default.png';
                            ?>
                            <img id="img-preview" src="<?= $foto; ?>" class="profile-photo">
                        </div>
                        <label class="neu-btn btn-primary" style="margin-top: 10px;">
                            📷 Ganti Foto
                            <input type="file" name="foto_profil" style="display: none;" onchange="previewImage(this)">
                        </label>
                    </div>

                    <div class="profile-settings-form">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?= $data['user']['nama_lengkap']; ?>" class="neu-input">
                        </div>
                        
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" value="<?= $data['user']['nik']; ?>" class="neu-input" readonly style="background: #e0e0e0; cursor: not-allowed;">
                        </div>

                        <div class="form-group">
                            <label>Jabatan / Role</label>
                            <input type="text" value="<?= ucfirst($data['user']['jabatan']); ?>" class="neu-input" readonly style="background: #e0e0e0; cursor: not-allowed; font-weight: bold; color: var(--secondary);">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= $data['user']['email']; ?>" class="neu-input">
                        </div>

                        <div class="form-group" style="border-top: 1px solid #ccc; padding-top: 10px;">
                            <label>Ganti Password (Opsional)</label>
                            <input type="password" name="password_baru" placeholder="Biarkan kosong jika tidak ganti" class="neu-input">
                        </div>

                        <div style="text-align: right; margin-top: 20px;">
                            <a href="<?= BASEURL; ?>/rapat" class="neu-btn btn-danger" style="margin-right: 10px; text-decoration: none;">
                                ⬅ Kembali
                            </a>
                            <button type="submit" class="neu-btn btn-primary">💾 Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { document.getElementById('img-preview').src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>