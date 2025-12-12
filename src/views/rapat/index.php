<main>
    <section class="dashboard-section" style="padding: 40px 0;">
        <div class="container">
            
            <div class="row">
                <div class="col-12"><?php Flasher::flash(); ?></div>
            </div>

            <div style="text-align: center; margin-bottom: 40px;">
                <h1 style="color: var(--secondary); font-weight: 700;">Rapat Saya 🚀</h1>
                <p style="color: #666;">Kelola semua jadwal rapat yang telah Anda buat.</p>
                
                <a href="<?= BASEURL; ?>/rapat/create" class="neu-btn btn-primary" style="margin-top: 20px; font-size: 1.2em; padding: 15px 30px;">
                    ➕ Buat Rapat Baru
                </a>
            </div>

            <div class="stats-panel">
                <div class="neu-card stat-card">
                    <h3>Rapat Terjadwal</h3>
                    <p class="stat-value" style="color: var(--secondary);"><?= $data['count_terjadwal']; ?></p>
                </div>
                <div class="neu-card stat-card">
                    <h3>Rapat Dibatalkan</h3>
                    <p class="stat-value" style="color: var(--danger);"><?= $data['count_dibatalkan']; ?></p>
                </div>
                <div class="neu-card stat-card">
                    <h3>Rapat Selesai</h3>
                    <p class="stat-value" style="color: var(--success);"><?= $data['count_selesai']; ?></p>
                </div>
            </div>

            <div class="neumorphic-tabs">
                <button class="tab-button active" onclick="showTab('terjadwal')">Terjadwal (<?= $data['count_terjadwal']; ?>)</button>
                <button class="tab-button" onclick="showTab('dibatalkan')">Dibatalkan (<?= $data['count_dibatalkan']; ?>)</button>
                <button class="tab-button" onclick="showTab('selesai')">Selesai (<?= $data['count_selesai']; ?>)</button>
            </div>

            <div id="rapat-terjadwal" class="tab-content active">
                <?php if (!empty($data['terjadwal'])): ?>
                    <?php foreach ($data['terjadwal'] as $rapat): ?>
                        <div class="neu-card meeting-item">
                            <div class="meeting-details">
                                <span class="status-tag st-terjadwal">Terjadwal</span>
                                <a href="<?= BASEURL; ?>/rapat/detail/<?= $rapat['id_rapat']; ?>" class="meeting-title" style="display:block; font-size: 1.1em; font-weight:bold; margin: 5px 0; color: var(--secondary);">
                                    <?= htmlspecialchars($rapat['judul_rapat']); ?>
                                </a>
                                <p class="meeting-info" style="color: #666; font-size: 0.9em;">
                                    🗓️ <?= date('d M Y', strtotime($rapat['tgl_rapat'])); ?> | 
                                    🕘 <?= date('H:i', strtotime($rapat['jam_mulai'])); ?> | 
                                    📍 <?= htmlspecialchars($rapat['lokasi']); ?>
                                </p>
                            </div>
                            <div class="meeting-actions">
                                <?php if ($rapat['id_pembuat'] == $_SESSION['user_id']): ?>
                                    <a href="<?= BASEURL; ?>/rapat/edit/<?= $rapat['id_rapat']; ?>" class="neu-btn btn-secondary" style="padding: 5px 15px; font-size: 0.8em;">📝 Edit</a>
                                    <a href="<?= BASEURL; ?>/rapat/cancel/<?= $rapat['id_rapat']; ?>" class="neu-btn btn-danger" style="padding: 5px 15px; font-size: 0.8em;" onclick="return confirm('Batalkan rapat?')">🚫 Batal</a>
                                <?php else: ?>
                                    <span style="font-size: 0.8em; color: #666;">(Undangan)</span>
                                <?php endif; ?>
                                <a href="<?= BASEURL; ?>/rapat/detail/<?= $rapat['id_rapat']; ?>" class="neu-btn btn-primary" style="padding: 5px 15px; font-size: 0.8em;">👀 Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center;">📅 Belum ada rapat terjadwal.</p>
                <?php endif; ?>
            </div>

            <div id="rapat-dibatalkan" class="tab-content">
                <?php if (!empty($data['dibatalkan'])): ?>
                    <?php foreach ($data['dibatalkan'] as $rapat): ?>
                        <div class="neu-card meeting-item">
                            <div class="meeting-details">
                                <span class="status-tag st-batal">Dibatalkan</span>
                                <span class="meeting-title" style="display:block; font-weight:bold; color: #666;"><?= htmlspecialchars($rapat['judul_rapat']); ?></span>
                                <p class="meeting-info" style="font-size: 0.9em;"><?= date('d M Y', strtotime($rapat['tgl_rapat'])); ?></p>
                            </div>
                            <div class="meeting-actions">
                                <a href="<?= BASEURL; ?>/rapat/detail/<?= $rapat['id_rapat']; ?>" class="neu-btn btn-detail">👀 Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center;">🚫 Tidak ada data.</p>
                <?php endif; ?>
            </div>

            <div id="rapat-selesai" class="tab-content">
                <?php if (!empty($data['selesai'])): ?>
                    <?php foreach ($data['selesai'] as $rapat): ?>
                        <div class="neu-card meeting-item">
                            <div class="meeting-details">
                                <span class="status-tag st-selesai">Selesai</span>
                                <span class="meeting-title" style="display:block; font-weight:bold; color: #333;"><?= htmlspecialchars($rapat['judul_rapat']); ?></span>
                                <p class="meeting-info" style="font-size: 0.9em;"><?= date('d M Y', strtotime($rapat['tgl_rapat'])); ?></p>
                            </div>
                            <div class="meeting-actions">
                                <a href="<?= BASEURL; ?>/rapat/detail/<?= $rapat['id_rapat']; ?>" class="neu-btn btn-detail">👀 Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center;">✅ Belum ada rapat selesai.</p>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
            document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
            document.getElementById('rapat-' + tabName).style.display = 'block';
            
            // Cari tombol yang diklik (secara manual karena event)
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(btn => {
                if(btn.textContent.toLowerCase().includes(tabName)) btn.classList.add('active');
            });
        }
    </script>
</main>