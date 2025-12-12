<main>
    <section class="meeting-creation-section" style="padding: 40px 0;">
        <div class="container">
            <h1 style="text-align: center; color: var(--secondary); margin-bottom: 10px;">Buat Rapat Baru 📝</h1>
            <p style="text-align: center; color: #666; margin-bottom: 30px;">Silakan isi detail rapat.</p>
            
            <form id="meetingForm" class="neu-card" action="<?= BASEURL; ?>/rapat/store" method="POST" style="max-width: 800px; margin: 0 auto;">
                
                <div class="form-group">
                    <label class="form-label">Judul Rapat</label>
                    <input type="text" name="judul_rapat" placeholder="Contoh: Rapat Koordinasi" required class="neu-input" />
                </div>

                <div class="form-row">
                    <div class="form-group half-width">
                        <label class="form-label">Lokasi / Ruangan</label>
                        <input type="text" name="ruangan_rapat" placeholder="Contoh: R-301" required class="neu-input" />
                    </div>
                    
                    <div class="form-group half-width">
                        <label class="form-label">Status Awal</label>
                        <select name="status_rapat" class="neu-input">
                            <option value="Terjadwal">Terjadwal</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group third-width">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal_rapat" required class="neu-input" />
                    </div>
                    <div class="form-group third-width">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" required class="neu-input" />
                    </div>
                    <div class="form-group third-width">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="neu-input" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Agenda / Deskripsi</label>
                    <textarea name="tujuan_rapat" rows="4" placeholder="Jelaskan agenda..." required class="neu-input"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Undang Peserta</label>
                    
                    <div class="neu-input" style="height: 250px; overflow-y: auto; padding: 15px;">
                        
                        <div style="border-bottom: 1px solid #ccc; margin-bottom: 15px;">
                            <strong>Grup:</strong>
                            <label style="display: flex; align-items: center; margin: 10px 0; cursor: pointer;">
                                <input type="checkbox" name="target_rapat[]" value="dosen" style="margin-right: 10px; transform: scale(1.2);"> 
                                <span>Seluruh Dosen</span>
                            </label>
                            <label style="display: flex; align-items: center; margin: 10px 0; cursor: pointer;">
                                <input type="checkbox" name="target_rapat[]" value="admin" style="margin-right: 10px; transform: scale(1.2);"> 
                                <span>Seluruh Admin</span>
                            </label>
                        </div>

                        <div>
                            <strong>Perorangan:</strong>
                            <?php if (!empty($data['users'])): ?>
                                <?php foreach ($data['users'] as $u): ?>
                                    <?php if ($u['id_user'] != $_SESSION['user_id']): ?>
                                        <label style="display: flex; align-items: center; margin-bottom: 8px; cursor: pointer;">
                                            <input type="checkbox" name="peserta[]" value="<?= $u['id_user']; ?>" style="margin-right: 10px; transform: scale(1.2);">
                                            <span>
                                                <b><?= $u['nama_lengkap']; ?></b> <small>(<?= ucfirst($u['jabatan']); ?>)</small>
                                            </span>
                                        </label>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <div class="button-group" style="text-align: right; margin-top: 20px;">
                    <button type="submit" class="neu-btn btn-primary">🚀 Simpan & Terbitkan</button>
                </div>
            </form>
        </div>
    </section>
</main>