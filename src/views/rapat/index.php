<?php
// Nama File: index.php
// Deskripsi: Dashboard utama menampilkan daftar rapat (terjadwal, selesai, batal).
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]
?>
<main>
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <?php 
            $pengajuan = array_filter($data['rapat'], function($r) {
                return $r['status'] == 'menunggu_konfirmasi';
            });
        ?>
        <?php if (!empty($pengajuan)): ?>
        <div class="neu-card alert-warning">
            <h3 class="alert-title">🔔 Permintaan Persetujuan (<?= count($pengajuan); ?>)</h3>
            <?php foreach ($pengajuan as $p): ?>
                <div class="approval-item">
                    <div>
                        <strong class="font-bold" style="font-size: 1.1em;"><?= htmlspecialchars($p['judul_rapat']); ?></strong><br />
                        <small>Oleh: <?= htmlspecialchars($p['pembuat']); ?></small>
                    </div>
                    <div>
                        <a href="<?= BASEURL; ?>/rapat/edit/<?= htmlspecialchars($p['id_rapat']); ?>" class="neu-btn btn-secondary" style="font-size: 0.8rem;">Review</a>
                        <a href="<?= BASEURL; ?>/rapat/approve/<?= htmlspecialchars($p['id_rapat']); ?>" class="neu-btn btn-success" style="font-size: 0.8rem;">✔ ACC</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <section class="dashboard-section" style="padding: 20px 0;">
        <div class="container">
            <div class="row"><div class="col-12"><?php Flasher::flash(); ?></div></div>

            <div class="dashboard-header">
                <h1 class="text-secondary font-bold">Rapat Saya 🚀</h1>
                
                <?php if ($_SESSION['role'] != 'admin'): ?>
                    <a href="<?= BASEURL; ?>/rapat/create" class="neu-btn btn-primary mt-10">➕ Ajukan Rapat Baru</a>
                <?php endif; ?>

                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" onkeyup="searchRapat()" placeholder="Cari judul rapat, ruangan, atau tanggal..." class="neu-input search-input" />
                </div>
            </div>

            <div class="neumorphic-tabs">
                <button class="tab-button active" onclick="showTab('terjadwal')">Terjadwal (<?= $data['count_terjadwal']; ?>)</button>
                <button class="tab-button" onclick="showTab('selesai')">Selesai (<?= $data['count_selesai']; ?>)</button>
                <button class="tab-button" onclick="showTab('dibatalkan')">Dibatalkan (<?= $data['count_dibatalkan']; ?>)</button>
            </div>

            <div id="rapat-terjadwal" class="tab-content active">
                <?php if (!empty($data['terjadwal'])): ?>
                    <?php foreach ($data['terjadwal'] as $rapat): ?>
                        <div class="neu-card meeting-item"> 
                            <div class="meeting-details">
                                <span class="status-tag st-terjadwal">Terjadwal</span>
                                <a href="<?= BASEURL; ?>/rapat/detail/<?= htmlspecialchars($rapat['id_rapat']); ?>" class="meeting-title-link">
                                    <?= htmlspecialchars($rapat['judul_rapat']); ?>
                                </a>
                                <p class="meeting-info">🗓️ <?= date('d M Y', strtotime($rapat['tgl_rapat'])); ?> | 📍 <?= htmlspecialchars($rapat['lokasi']); ?></p>
                            </div>
                            <div class="meeting-actions">
                                <?php if ($rapat['id_pembuat'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin'): ?>
                                    <a href="<?= BASEURL; ?>/rapat/edit/<?= htmlspecialchars($rapat['id_rapat']); ?>" class="neu-btn btn-secondary" style="font-size: 0.8em;">📝 Edit</a>
                                    <a href="<?= BASEURL; ?>/rapat/cancel/<?= htmlspecialchars($rapat['id_rapat']); ?>" class="neu-btn btn-danger" style="font-size: 0.8em;" onclick="return confirm('Batalkan rapat?')">🚫 Batal</a>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size: 0.8em;">(Undangan)</span>
                                <?php endif; ?>
                                <a href="<?= BASEURL; ?>/rapat/detail/<?= htmlspecialchars($rapat['id_rapat']); ?>" class="neu-btn btn-primary" style="font-size: 0.8em;">Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">📅 Belum ada rapat terjadwal.</p>
                <?php endif; ?>
            </div>

            <div id="rapat-selesai" class="tab-content">
                <?php if (!empty($data['selesai'])): ?>
                    <?php foreach ($data['selesai'] as $rapat): ?>
                        <div class="neu-card meeting-item">
                            <div class="meeting-details">
                                <span class="status-tag st-selesai">Selesai</span>
                                <span class="meeting-title-link" style="color: #333;"><?= htmlspecialchars($rapat['judul_rapat']); ?></span>
                                <p class="meeting-info">🗓️ <?= date('d M Y', strtotime($rapat['tgl_rapat'])); ?> | 📍 <?= htmlspecialchars($rapat['lokasi']); ?></p>
                            </div>
                            
                            <div class="meeting-actions">
                                <?php if (!empty($rapat['file_notulen'])): ?>
                                    <a href="<?= BASEURL; ?>/files/notulen/<?= htmlspecialchars($rapat['file_notulen']); ?>" target="_blank" class="neu-btn btn-success" style="font-size: 0.8em;">
                                        📥 Download Notulen
                                    </a>
                                <?php else: ?>
                                    <?php if ($rapat['id_pembuat'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin'): ?>
                                        <button onclick="openModal('<?= htmlspecialchars($rapat['id_rapat']); ?>', '<?= htmlspecialchars($rapat['judul_rapat']); ?>')" class="neu-btn btn-primary" style="font-size: 0.8em;">
                                            📤 Upload Notulen
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 0.8em; font-style: italic;">Belum ada notulen</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <a href="<?= BASEURL; ?>/rapat/detail/<?= htmlspecialchars($rapat['id_rapat']); ?>" class="neu-btn btn-secondary" style="font-size: 0.8em;">Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">✅ Belum ada rapat selesai.</p>
                <?php endif; ?>
            </div>

            <div id="rapat-dibatalkan" class="tab-content">
                <?php if (!empty($data['dibatalkan'])): ?>
                    <?php foreach ($data['dibatalkan'] as $rapat): ?>
                        <div class="neu-card meeting-item">
                            <div class="meeting-details">
                                <span class="status-tag st-batal">Dibatalkan</span>
                                <span class="meeting-title-link text-muted"><?= htmlspecialchars($rapat['judul_rapat']); ?></span>
                                <p class="meeting-info"><?= date('d M Y', strtotime($rapat['tgl_rapat'])); ?></p>
                            </div>
                            
                            <div class="meeting-actions">
                                <?php if ($rapat['id_pembuat'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin'): ?>
                                    <a href="<?= BASEURL; ?>/rapat/delete/<?= $rapat['id_rapat']; ?>" 
                                       class="neu-btn btn-danger" 
                                       style="font-size: 0.8em; padding: 8px 15px;"
                                       onclick="return confirm('⚠️ PERINGATAN: Rapat ini akan dihapus PERMANEN dan tidak bisa dikembalikan. Lanjutkan?')">
                                       <i class="fas fa-trash"></i> Hapus
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">🚫 Tidak ada data sampah.</p>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <div id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; justify-content: center; align-items: center;">
        <div class="neu-card" style="background: white; padding: 30px; width: 90%; max-width: 400px; position: relative;">
            <h3 class="mb-20">Upload Notulen 📄</h3>
            <p id="modalRapatTitle" class="text-secondary font-bold mb-20"></p>
            
            <form action="<?= BASEURL; ?>/rapat/uploadNotulen" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_rapat" id="modalIdRapat" />
                
                <div class="form-group">
                    <label class="d-block mb-10">Pilih File (PDF/DOC)</label>
                    <input type="file" name="file_notulen" class="neu-input" required accept=".pdf,.doc,.docx" />
                </div>

                <div class="text-right mt-20">
                    <button type="button" onclick="closeModal()" class="neu-btn btn-danger mr-10">Batal</button>
                    <button type="submit" class="neu-btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const showTab = (tabName) => {
            document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
            document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
            
            const targetTab = document.getElementById('rapat-' + tabName);
            if(targetTab) targetTab.style.display = 'block';
            
            document.querySelectorAll('.tab-button').forEach(btn => {
                if(btn.textContent.toLowerCase().includes(tabName)) btn.classList.add('active');
            });
        }

        const searchRapat = () => {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let items = document.getElementsByClassName('meeting-item');
            let tabContents = document.querySelectorAll('.tab-content');
            let tabNav = document.querySelector('.neumorphic-tabs');
            let emptyMessages = document.querySelectorAll('.tab-content > p');

            if (input.length > 0) {
                if(tabNav) tabNav.style.display = 'none';
                emptyMessages.forEach(p => p.style.display = 'none');
                tabContents.forEach(content => content.style.display = 'block');

                for (let i = 0; i < items.length; i++) {
                    let text = items[i].innerText.toLowerCase();
                    items[i].style.display = text.includes(input) ? "" : "none";
                }
            } else {
                if(tabNav) tabNav.style.display = 'flex';
                for (let i = 0; i < items.length; i++) items[i].style.display = "";
                emptyMessages.forEach(p => p.style.display = "");
                
                let activeBtn = document.querySelector('.tab-button.active');
                if (activeBtn) {
                    if(activeBtn.innerText.includes('Terjadwal')) showTab('terjadwal');
                    else if(activeBtn.innerText.includes('Selesai')) showTab('selesai');
                    else if(activeBtn.innerText.includes('Dibatalkan')) showTab('dibatalkan');
                } else {
                    showTab('terjadwal');
                }
            }
        }

        const openModal = (id, title) => {
            document.getElementById('modalIdRapat').value = id;
            document.getElementById('modalRapatTitle').innerText = title;
            document.getElementById('uploadModal').style.display = 'flex';
        }

        const closeModal = () => {
            document.getElementById('uploadModal').style.display = 'none';
        }

        document.addEventListener('click', function(event) {
            let modal = document.getElementById('uploadModal');
            if (modal && modal.style.display === 'flex') {
                if (event.target == modal) closeModal();
            }
        });
    </script>
</main>