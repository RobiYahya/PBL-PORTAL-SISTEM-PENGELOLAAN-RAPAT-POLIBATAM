<main>
    <section class="meeting-creation-section" style="padding: 40px 0;">
        <div class="container">
            <h1 style="text-align: center; color: var(--secondary); margin-bottom: 10px;">
                <?= ($_SESSION['role'] == 'admin') ? 'Review & Edit Rapat 📝' : 'Edit Rapat ✏️'; ?>
            </h1>
            
            <form id="meetingForm" class="neu-card" action="<?= BASEURL; ?>/rapat/update" method="POST" style="max-width: 800px; margin: 0 auto;">
                
                <input type="hidden" name="id_rapat" value="<?= $data['rapat']['id_rapat']; ?>">

                <div class="form-group">
                    <label class="form-label">Judul Rapat</label>
                    <input type="text" name="judul_rapat" value="<?= $data['rapat']['judul_rapat']; ?>" required class="neu-input" />
                </div>

                <div class="form-row">
                    <div class="form-group half-width">
                        <label class="form-label">Lokasi / Ruangan</label>
                        <input type="text" name="lokasi" value="<?= $data['rapat']['lokasi']; ?>" required class="neu-input" />
                    </div>
                    
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <div class="form-group half-width">
                            <label class="form-label">Status Rapat</label>
                            <select name="status" class="neu-input">
                                <option value="menunggu_konfirmasi" <?= ($data['rapat']['status'] == 'menunggu_konfirmasi') ? 'selected' : ''; ?>>Menunggu Konfirmasi</option>
                                <option value="terjadwal" <?= ($data['rapat']['status'] == 'terjadwal') ? 'selected' : ''; ?>>Terjadwal (ACC)</option>
                                <option value="selesai" <?= ($data['rapat']['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                <option value="dibatalkan" <?= ($data['rapat']['status'] == 'dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="status" value="<?= $data['rapat']['status']; ?>">
                        <div class="form-group half-width" style="visibility: hidden;"></div>
                    <?php endif; ?>
                </div>

                <div class="form-row">
                    <div class="form-group third-width">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal_rapat" value="<?= $data['rapat']['tgl_rapat']; ?>" required class="neu-input" />
                    </div>
                    <div class="form-group third-width">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="<?= $data['rapat']['jam_mulai']; ?>" required class="neu-input" />
                    </div>
                    <div class="form-group third-width">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="<?= $data['rapat']['jam_selesai']; ?>" class="neu-input" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Agenda / Deskripsi</label>
                    <textarea name="deskripsi" rows="4" required class="neu-input"><?= $data['rapat']['deskripsi']; ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Undang Peserta</label>
                    
                    <div class="neu-input" style="height: 250px; overflow-y: auto; padding: 15px;">
                        
                        <div style="border-bottom: 1px solid #ccc; margin-bottom: 15px; padding-bottom: 10px;">
                            <strong style="display:block; margin-bottom:10px;">Grup:</strong>
                            <label style="display: flex; align-items: center; margin: 5px 0; cursor: pointer;">
                                <input type="checkbox" name="target_rapat[]" value="dosen" style="margin-right: 10px; transform: scale(1.2);"> 
                                <span>Seluruh Dosen</span>
                            </label>
                            </div>

                        <div>
                            <strong style="display:block; margin-bottom:10px;">Perorangan:</strong>
                            <?php if (!empty($data['users'])): ?>
                                <?php foreach ($data['users'] as $u): ?>
                                    
                                    <?php if ($u['id_user'] != $_SESSION['user_id'] && $u['jabatan'] != 'admin'): ?>
                                        
                                        <?php 
                                            // Cek apakah user ini sudah diundang sebelumnya?
                                            $isChecked = in_array($u['id_user'], $data['peserta_ids']) ? 'checked' : ''; 
                                        ?>

                                        <label style="display: flex; align-items: center; margin-bottom: 8px; cursor: pointer;">
                                            <input type="checkbox" name="peserta[]" value="<?= $u['id_user']; ?>" <?= $isChecked; ?> style="margin-right: 10px; transform: scale(1.2);">
                                            <span>
                                                <b><?= $u['nama_lengkap']; ?></b> <small style="color:#666;">(<?= ucfirst($u['jabatan']); ?>)</small>
                                            </span>
                                        </label>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="color: #999;">Tidak ada user lain.</p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <div class="button-group" style="text-align: right; margin-top: 20px;">
                    <a href="<?= BASEURL; ?>/rapat" class="neu-btn btn-danger" style="margin-right: 10px;">Batal</a>
                    <button type="submit" class="neu-btn btn-primary">💾 Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
</main>