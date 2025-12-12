<main>
    <section class="detail-section" style="padding: 40px 0;">
        <div class="container">
            <a href="<?= BASEURL; ?>/rapat" class="neu-btn btn-secondary" style="margin-bottom: 20px; display: inline-block;">⬅ Kembali ke Dashboard</a>
            
            <div class="neu-card" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
                <div>
                    <h1 style="margin: 0; color: var(--secondary);"><?= htmlspecialchars($data['rapat']['judul_rapat']); ?></h1>
                    <p style="color: #666; margin-top: 5px;">Dibuat oleh: <strong><?= htmlspecialchars($data['rapat']['pembuat']); ?></strong></p>
                    
                    <?php 
                        $st = strtolower($data['rapat']['status']); // Pastikan huruf kecil semua
                        $statusClass = 'status-terjadwal'; // Default Biru

                        if ($st == 'selesai') {
                            $statusClass = 'status-selesai'; // Hijau
                        } elseif ($st == 'batal' || $st == 'dibatalkan') {
                            $statusClass = 'status-batal'; // Merah
                        } elseif ($st == 'draft') {
                            $statusClass = 'status-draft'; // Abu
                        }
                    ?>
                    <span class="status-tag <?= $statusClass; ?>" style="margin-top: 10px;">
                        <?= ucfirst($st); ?>
                    </span>
                </div>

                <?php if ($data['rapat']['id_pembuat'] == $_SESSION['user_id'] && $st == 'terjadwal'): ?>
                    <a href="<?= BASEURL; ?>/rapat/cancel/<?= $data['rapat']['id_rapat']; ?>" class="neu-btn btn-danger" onclick="return confirm('Yakin batalkan?')">🚫 Batal</a>
                <?php endif; ?>
            </div>

            <div class="detail-content-grid" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
                
                <div>
                    <div class="neu-card" style="margin-bottom: 20px;">
                        <h3 style="border-bottom: 2px solid var(--primary); padding-bottom: 10px; margin-top: 0;">📌 Informasi</h3>
                        <p><strong>Hari, Tanggal:</strong><br><?= date('l, d F Y', strtotime($data['rapat']['tgl_rapat'])); ?></p>
                        <p><strong>Waktu:</strong><br><?= date('H:i', strtotime($data['rapat']['jam_mulai'])); ?> WIB</p>
                        <p><strong>Lokasi:</strong><br><?= htmlspecialchars($data['rapat']['lokasi']); ?></p>
                    </div>

                    <?php if ($data['rapat']['id_pembuat'] == $_SESSION['user_id'] && $st == 'terjadwal'): ?>
                    <div class="neu-card">
                        <h3>⚙️ Kelola</h3>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <a href="<?= BASEURL; ?>/rapat/edit/<?= $data['rapat']['id_rapat']; ?>" class="neu-btn btn-secondary">📝 Edit Rapat</a>
                            <a href="<?= BASEURL; ?>/rapat/absensi/<?= $data['rapat']['id_rapat']; ?>" class="neu-btn btn-primary">📋 Mulai Absensi</a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="neu-card" style="margin-bottom: 20px;">
                        <h3>📝 Agenda</h3>
                        <div class="neu-input" style="min-height: 100px; background: #e9ecef;">
                            <p style="white-space: pre-line;"><?= htmlspecialchars($data['rapat']['deskripsi']); ?></p>
                        </div>
                        <?php if ($data['rapat']['file_notulen']): ?>
                            <a href="<?= BASEURL; ?>/files/notulen/<?= $data['rapat']['file_notulen']; ?>" target="_blank" class="neu-btn btn-success" style="margin-top: 10px; background: var(--success); color: white;">📥 Download Notulen</a>
                        <?php endif; ?>
                    </div>

                    <div class="neu-card">
                        <h3>👥 Peserta (<?= count($data['peserta']); ?>)</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <?php foreach ($data['peserta'] as $p): ?>
                                <tr style="border-bottom: 1px solid #ccc;">
                                    <td style="padding: 10px;"><strong><?= htmlspecialchars($p['nama_lengkap']); ?></strong><br><small><?= $p['jabatan']; ?></small></td>
                                    <td style="text-align: right;">
                                        <span style="background: #ccc; padding: 3px 10px; border-radius: 10px; font-size: 0.8em; color: #333;">
                                            <?= ucfirst($p['status_kehadiran'] ?: 'Menunggu'); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>