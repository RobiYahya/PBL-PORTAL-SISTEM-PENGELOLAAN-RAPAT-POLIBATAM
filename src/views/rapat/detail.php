<?php
// Nama File: detail.php
// Deskripsi: Menampilkan detail lengkap rapat, agenda, dan peserta.
?>
<main>
    <section class="detail-section" style="padding: 40px 0;">
        <div class="container">
            <a href="<?= BASEURL; ?>/rapat" class="neu-btn btn-secondary mb-20" style="display: inline-block;">⬅ Kembali ke Dashboard</a>
            
            <div class="neu-card mb-30" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
                <div>
                    <h1 class="text-secondary" style="margin: 0;"><?= htmlspecialchars($data['rapat']['judul_rapat']); ?></h1>
                    <p class="text-muted mt-10">Dibuat oleh: <strong><?= htmlspecialchars($data['rapat']['pembuat']); ?></strong></p>
                    
                    <?php 
                        $st = strtolower(trim($data['rapat']['status'])); 
                        $statusClass = 'st-terjadwal'; // Default
                        
                        if ($st == 'selesai') {
                            $statusClass = 'st-selesai'; 
                        } elseif ($st == 'dibatalkan' || $st == 'batal') {
                            $statusClass = 'st-batal';   
                        } elseif ($st == 'menunggu_konfirmasi') {
                            $statusClass = 'st-draft';   
                        }
                    ?>
                    <span class="status-tag <?= $statusClass; ?> mt-10">
                        <?= ucfirst(str_replace('_', ' ', $st)); ?>
                    </span>
                </div>

                <div style="display: flex; gap: 10px;">
                    
                    <?php if ($_SESSION['role'] == 'admin' && $st == 'menunggu_konfirmasi'): ?>
                        
                        <a href="<?= BASEURL; ?>/rapat/reject/<?= htmlspecialchars($data['rapat']['id_rapat']); ?>" 
                           class="neu-btn btn-danger" 
                           onclick="return confirm('Yakin ingin MENOLAK pengajuan rapat ini?')">
                           ❌ Tolak
                        </a>

                        <a href="<?= BASEURL; ?>/rapat/approve/<?= htmlspecialchars($data['rapat']['id_rapat']); ?>" 
                           class="neu-btn btn-success" 
                           onclick="return confirm('Setujui dan terbitkan rapat ini?')">
                           ✅ Setujui (ACC)
                        </a>

                    <?php endif; ?>
                    <?php if ($data['rapat']['id_pembuat'] == $_SESSION['user_id'] && $st == 'terjadwal'): ?>
                        <a href="<?= BASEURL; ?>/rapat/cancel/<?= htmlspecialchars($data['rapat']['id_rapat']); ?>" class="neu-btn btn-danger" onclick="return confirm('Yakin batalkan rapat ini?')">🚫 Batal Rapat</a>
                    <?php endif; ?>

                </div>
            </div>

            <div class="detail-grid">
                
                <div>
                    <div class="neu-card mb-20">
                        <h3 style="border-bottom: 2px solid var(--primary); padding-bottom: 10px; margin-top: 0;">📌 Informasi</h3>
                        
                        <div class="mb-20">
                            <strong class="text-muted">Hari, Tanggal:</strong><br />
                            <span class="font-bold" style="font-size: 1.1em;">
                                <?= date('l, d F Y', strtotime($data['rapat']['tgl_rapat'])); ?>
                            </span>
                        </div>

                        <div class="mb-20">
                            <strong class="text-muted">Waktu:</strong><br />
                            <span class="text-secondary font-bold" style="font-size: 1.1em;">
                                <?= date('H:i', strtotime($data['rapat']['jam_mulai'])); ?> - 
                                <?= date('H:i', strtotime($data['rapat']['jam_selesai'])); ?> WIB
                            </span>
                        </div>

                        <div>
                            <strong class="text-muted">Lokasi:</strong><br />
                            <span class="font-bold" style="font-size: 1.1em;">
                                <?= htmlspecialchars($data['rapat']['lokasi']); ?>
                            </span>
                        </div>
                    </div>

                    <?php if ($data['rapat']['id_pembuat'] == $_SESSION['user_id'] && $st == 'terjadwal'): ?>
                    <div class="neu-card">
                        <h3>⚙️ Kelola</h3>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <a href="<?= BASEURL; ?>/rapat/edit/<?= htmlspecialchars($data['rapat']['id_rapat']); ?>" class="neu-btn btn-secondary">📝 Edit Rapat</a>
                            <a href="<?= BASEURL; ?>/rapat/absensi/<?= htmlspecialchars($data['rapat']['id_rapat']); ?>" class="neu-btn btn-primary">📋 Mulai Absensi</a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="neu-card mb-20">
                        <h3>📝 Agenda</h3>
                        <div class="neu-input" style="min-height: 100px; background: #e9ecef; border: 1px solid #ddd;">
                            <p style="white-space: pre-line; margin: 0; color: #333; line-height: 1.6;">
                                <?= htmlspecialchars($data['rapat']['deskripsi']); ?>
                            </p>
                        </div>
                        
                        <?php if ($data['rapat']['file_notulen']): ?>
                            <a href="<?= BASEURL; ?>/files/notulen/<?= htmlspecialchars($data['rapat']['file_notulen']); ?>" target="_blank" class="neu-btn btn-success d-block w-100 mt-20">
                                📥 Download Notulen
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="neu-card">
                        <h3>👥 Peserta (<?= count($data['peserta']); ?>)</h3>
                        <div style="max-height: 400px; overflow-y: auto;">
                            <table class="w-100" style="border-collapse: collapse;">
                                <?php foreach ($data['peserta'] as $p): ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 12px 5px;">
                                            <strong><?= htmlspecialchars($p['nama_lengkap']); ?></strong><br />
                                            <small class="text-muted"><?= htmlspecialchars($p['jabatan']); ?></small>
                                        </td>
                                        <td class="text-right">
                                            <?php 
                                                // [PERBAIKAN] Logika Cek Status Kehadiran agar tidak "Menunggu" terus
                                                $statusHadir = strtolower(trim($p['status_kehadiran']));
                                                $bgClass = 'bg-secondary';
                                                
                                                if($statusHadir == 'hadir') {
                                                    $bgClass = 'bg-success';
                                                } elseif($statusHadir == 'izin') {
                                                    $bgClass = 'bg-warning';
                                                } elseif($statusHadir == 'sakit') {
                                                    $bgClass = 'bg-info';
                                                } elseif($statusHadir == 'alpa' || $statusHadir == 'alpha') {
                                                    $bgClass = 'bg-danger';
                                                }
                                            ?>
                                            <span class="status-badge <?= $bgClass; ?>">
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
        </div>
    </section>
</main>