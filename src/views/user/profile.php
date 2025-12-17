<?php
// Nama File: profile.php
// Deskripsi: Halaman untuk mengelola profil pengguna (ganti foto, password, dll).
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]
?>
<main>
    <section class="profile-section">
        <div class="container">
            <h1 class="text-center mt-20">Profil Pengguna 👤</h1>
            <div class="text-center mb-20"><?php Flasher::flash(); ?></div>
            
            <form action="<?= BASEURL; ?>/user/update" method="POST" enctype="multipart/form-data" class="neu-card">
                <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($data['user']['foto']); ?>" />
                
                <div class="profile-container">
                    <div class="profile-photo-section">
                        <div class="profile-photo-wrapper">
                            <?php 
                                $foto = (!empty($data['user']['foto'])) ? BASEURL . '/foto/profil/' . $data['user']['foto'] : BASEURL . '/foto/default.png';
                            ?>
                            <img id="img-preview" src="<?= htmlspecialchars($foto); ?>" class="profile-photo" alt="Foto Profil" />
                        </div>
                        <label class="neu-btn btn-primary mt-10">
                            📷 Ganti Foto
                            <input type="file" name="foto_profil" class="d-none" onchange="previewImage(this)" />
                        </label>
                    </div>

                    <div class="profile-settings-form">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($data['user']['nama_lengkap']); ?>" class="neu-input" />
                        </div>
                        
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" value="<?= htmlspecialchars($data['user']['nik']); ?>" class="neu-input input-readonly" readonly />
                        </div>

                        <div class="form-group">
                            <label>Jabatan / Role</label>
                            <input type="text" value="<?= htmlspecialchars(ucfirst($data['user']['jabatan'])); ?>" class="neu-input input-role" readonly />
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($data['user']['email']); ?>" class="neu-input" />
                        </div>

                        <div class="form-group border-top-sep">
                            <label>Ganti Password (Opsional)</label>
                            <input type="password" name="password_baru" placeholder="Biarkan kosong jika tidak ganti" class="neu-input" />
                        </div>

                        <div class="form-actions text-right mt-20">
                            <a href="<?= BASEURL; ?>/rapat" class="neu-btn btn-danger mr-10 decoration-none">
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
            const reader = new FileReader(); // PERBAIKAN: Gunakan const, bukan var
            reader.onload = function(e) { document.getElementById('img-preview').src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>