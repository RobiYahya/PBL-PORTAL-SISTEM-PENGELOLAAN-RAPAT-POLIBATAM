<main>
    <section class="meeting-creation-section" style="padding: 40px 0;">
        <div class="container">
            <h1 style="text-align: center; margin-bottom: 20px;">Edit Rapat <span style="color: #666;">#<?= $data['rapat']['id_rapat']; ?></span></h1>
            
            <form class="neu-card" action="<?= BASEURL; ?>/rapat/update" method="POST" style="max-width: 800px; margin: 0 auto;">
                <input type="hidden" name="id_rapat" value="<?= $data['rapat']['id_rapat']; ?>">

                <div class="form-group">
                    <label class="form-label">Judul Rapat</label>
                    <input type="text" name="judul_rapat" value="<?= $data['rapat']['judul_rapat']; ?>" required class="neu-input" />
                </div>

                <div class="form-row">
                    <div class="form-group half-width">
                        <label class="form-label">Ruangan</label>
                        <input type="text" name="lokasi" value="<?= $data['rapat']['lokasi']; ?>" required class="neu-input" />
                    </div>
                    
                    <div class="form-group half-width">
                        <label class="form-label">Status</label>
                        <select name="status" class="neu-input">
                            <option value="terjadwal" <?= ($data['rapat']['status'] == 'terjadwal') ? 'selected' : ''; ?>>Terjadwal</option>
                            <option value="draft" <?= ($data['rapat']['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                            <option value="selesai" <?= ($data['rapat']['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                            <option value="dibatalkan" <?= ($data['rapat']['status'] == 'dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group third-width">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal_rapat" value="<?= date('Y-m-d', strtotime($data['rapat']['tgl_rapat'])); ?>" required class="neu-input" />
                    </div>
                    <div class="form-group third-width">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="<?= date('H:i', strtotime($data['rapat']['jam_mulai'])); ?>" required class="neu-input" />
                    </div>
                    <div class="form-group third-width">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="<?= ($data['rapat']['jam_selesai']) ? date('H:i', strtotime($data['rapat']['jam_selesai'])) : ''; ?>" class="neu-input" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Undang Peserta</label>
                    <div class="neu-input" style="height: 200px; overflow-y: auto; padding: 10px;">
                        <?php if (!empty($data['users'])): ?>
                            <?php foreach ($data['users'] as $u): ?>
                                <?php 
                                    if ($u['id_user'] == $_SESSION['user_id']) continue;
                                    $isChecked = in_array($u['id_user'], $data['peserta_ids']) ? 'checked' : '';
                                ?>
                                <label style="display: flex; align-items: center; margin-bottom: 8px; cursor: pointer;">
                                    <input type="checkbox" name="peserta[]" value="<?= $u['id_user']; ?>" <?= $isChecked; ?> style="margin-right: 10px; transform: scale(1.2);">
                                    <span><?= $u['nama_lengkap']; ?> <small style="color: #666;">(<?= ucfirst($u['jabatan']); ?>)</small></span>
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Agenda / Deskripsi</label>
                    <textarea name="deskripsi" rows="4" required class="neu-input"><?= $data['rapat']['deskripsi']; ?></textarea>
                </div>

                <div class="button-group" style="text-align: right; margin-top: 20px;">
                    <a href="<?= BASEURL; ?>/rapat" class="neu-btn btn-secondary">Batal</a>
                    <button type="submit" class="neu-btn btn-primary">💾 Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
</main>