<?php
// Nama File: create.php
// Deskripsi: Form untuk membuat pengajuan rapat baru.
?>
<main>
    <section class="meeting-creation-section" style="padding: 40px 0;">
        <div class="container">
            <h1 style="text-align: center; color: var(--secondary); margin-bottom: 10px;">Buat Rapat Baru 📝</h1>
            <p style="text-align: center; color: #666; margin-bottom: 30px;">Silakan isi formulir pengajuan rapat.</p>
            
            <div style="max-width: 800px; margin: 0 auto 20px auto;">
                <?php Flasher::flash(); ?>
            </div>
            <form id="meetingForm" class="neu-card" action="<?= BASEURL; ?>/rapat/store" method="POST" style="max-width: 800px; margin: 0 auto;">
                
                <div class="form-group">
                    <label class="form-label">Judul Rapat</label>
                    <input type="text" name="judul_rapat" placeholder="Contoh: Rapat Koordinasi" required class="neu-input" />
                </div>

                <div class="form-row">
                    <div class="form-group half-width">
                        <label class="form-label">Lokasi / Ruangan</label>
                        
                        <select name="ruangan_rapat" class="neu-input" required>
                            <option value="" disabled selected>-- Pilih Ruangan --</option>
                            <option value="GU 601">GU 601</option>
                            <option value="GU 604">GU 604</option>
                            <option value="GU 606">GU 606</option>
                            <option value="GU 701">GU 701</option>
                            <option value="GU 702">GU 702</option>
                            <option value="GU 704">GU 704</option>
                            <option value="GU 705">GU 705</option>
                            <option value="GU 706">GU 706</option>
                            <option value="GU 805">GU 805</option>
                            <option value="TA 10.4">TA 10.4</option>
                            <option value="TA 12.3A">TA 12.3A</option>
                            <option value="Auditorium Utama">Auditorium Kampus</option>
                        </select>
                    </div>
                    
                    <input type="hidden" name="status" value="menunggu_konfirmasi">
                </div>

                <div class="form-row">
                    <div class="form-group third-width">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal_rapat" required class="neu-input" />
                    </div>
                    <div class="form-group half-width">
                        <label class="form-label">Jam Mulai</label>
                        <input type="text" name="jam_mulai" class="neu-input timepicker" placeholder="Pilih jam mulai..." required>
                    </div>

                    <div class="form-group half-width">
                        <label class="form-label">Jam Selesai</label>
                        <input type="text" name="jam_selesai" class="neu-input timepicker" placeholder="Pilih jam selesai..." required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Agenda / Deskripsi</label>
                    <textarea name="agenda" rows="4" placeholder="Jelaskan agenda rapat secara singkat..." required class="neu-input"></textarea>
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
                                        <label style="display: flex; align-items: center; margin-bottom: 8px; cursor: pointer;">
                                            <input type="checkbox" name="peserta[]" value="<?= $u['id_user']; ?>" style="margin-right: 10px; transform: scale(1.2);">
                                            <span>
                                                <b><?= $u['nama_lengkap']; ?></b> <small style="color:#666;">(<?= ucfirst($u['jabatan']); ?>)</small>
                                            </span>
                                        </label>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="color: #999; font-style: italic;">Tidak ada user lain.</p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <div class="button-group" style="text-align: right; margin-top: 20px;">
                    <a href="<?= BASEURL; ?>/rapat" class="neu-btn btn-danger" style="margin-right: 10px;">Batal</a>
                    <button type="submit" class="neu-btn btn-primary">
                        📤 Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
        
        <script>
                document.addEventListener('DOMContentLoaded', function() {
                    flatpickr(".timepicker", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true,
                        minTime: "00:00",
                        maxTime: "23:00",
                        minuteIncrement: 30
                    });
                });
        </script>
    </section>
</main>