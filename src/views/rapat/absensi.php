<?php
// Nama File: absensi.php
// Deskripsi: Form untuk melakukan absensi manual peserta rapat.
?>
<main>
    <section style="padding: 40px 0;">
        <div class="container">
            <h1 class="text-center">📋 Form Absensi</h1>
            <p class="text-center">Rapat: <strong><?= htmlspecialchars($data['rapat']['judul_rapat']); ?></strong></p>

            <form action="<?= BASEURL; ?>/rapat/processAbsensi" method="POST" enctype="multipart/form-data" class="neu-card mt-20">
                <input type="hidden" name="id_rapat" value="<?= htmlspecialchars($data['rapat']['id_rapat']); ?>" />

                <table class="w-100 mb-20" style="border-collapse: collapse;">
                    <thead style="background: #ddd;">
                        <tr>
                            <th style="padding: 10px;">Nama</th>
                            <th>Hadir</th><th>Izin</th><th>Sakit</th><th>Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['peserta'] as $p): ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px;"><?= htmlspecialchars($p['nama_lengkap']); ?></td>
                                <td align="center"><input type="radio" name="status[<?= $p['id_user']; ?>]" value="hadir" <?= ($p['status_kehadiran']=='hadir')?'checked':''; ?> /></td>
                                <td align="center"><input type="radio" name="status[<?= $p['id_user']; ?>]" value="izin" <?= ($p['status_kehadiran']=='izin')?'checked':''; ?> /></td>
                                <td align="center"><input type="radio" name="status[<?= $p['id_user']; ?>]" value="sakit" <?= ($p['status_kehadiran']=='sakit')?'checked':''; ?> /></td>
                                <td align="center"><input type="radio" name="status[<?= $p['id_user']; ?>]" value="alpa" <?= ($p['status_kehadiran']=='alpa'||!$p['status_kehadiran'])?'checked':''; ?> /></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="border-top: 2px solid #ccc; padding-top: 20px;">
                    <h3>📂 Upload Notulen (Opsional)</h3>
                    <input type="file" name="file_notulen" class="neu-input" />
                </div>

                <div class="text-right mt-20">
                    <a href="<?= BASEURL; ?>/rapat/detail/<?= htmlspecialchars($data['rapat']['id_rapat']); ?>" class="neu-btn btn-secondary">Batal</a>
                    <button type="submit" class="neu-btn btn-primary">💾 Simpan & Selesaikan</button>
                </div>
            </form>
        </div>
    </section>
</main>