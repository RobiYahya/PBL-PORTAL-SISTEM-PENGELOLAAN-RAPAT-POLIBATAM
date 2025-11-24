<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Rapat Baru - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="css/style-buat-rapat.css" /> 
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="home-page.html" class="logo-link">
                <img src="foto/logo.png" alt="Logo Sipera" class="logo" />
            </a>
            <div class="nav-links">
                <div class="user-menu-dropdown">
                    <button class="user-button">
                        Halo, Admin!
                    </button>
                    <div class="user-dropdown-content">
                        <a href="profil.html">Profil Saya</a>
                        <a href="masuk.html">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="meeting-creation-section">
            <div class="container">
                <h1 class="main-title">Buat Rapat Baru 📝</h1>
                <p class="subtitle">Silakan isi detail rapat yang akan Anda jadwalkan.</p>
                
                <form id="meetingForm" class="neumorphic-form" onsubmit="return simpanDanTerbitkanRapat()">
                    
                    <div class="form-group">
                        <label for="judul_rapat" class="neumorphic-label">Judul Rapat</label>
                        <input
                            type="text"
                            id="judul_rapat"
                            name="judul_rapat"
                            placeholder="Contoh: Rapat Koordinasi Akhir Tahun"
                            required
                            class="neumorphic-input"
                        />
                    </div>

                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="ruangan_rapat" class="neumorphic-label">Ruangan Rapat (Tulis Manual)</label>
                            <input
                                type="text"
                                id="ruangan_rapat"
                                name="ruangan_rapat"
                                placeholder="Contoh: Ruangan R-301, Gedung C"
                                required
                                class="neumorphic-input"
                            />
                        </div>

                        <div class="form-group half-width">
                            <label for="status_rapat" class="neumorphic-label">Status Awal Rapat</label>
                            <select id="status_rapat" name="status_rapat" required class="neumorphic-select">
                                <option value="Draft" selected>Draft (Belum Dipublikasi)</option>
                                <option value="Terjadwal">Terjadwal</option>
                                <option value="Mendesak">Mendesak</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group third-width">
                            <label for="tanggal_rapat" class="neumorphic-label">Tanggal Rapat</label>
                            <input
                                type="date"
                                id="tanggal_rapat"
                                name="tanggal_rapat"
                                required
                                class="neumorphic-input"
                            />
                        </div>

                        <div class="form-group third-width">
                            <label for="jam_mulai" class="neumorphic-label">Jam Mulai</label>
                            <input
                                type="time"
                                id="jam_mulai"
                                name="jam_mulai"
                                required
                                class="neumorphic-input"
                            />
                        </div>
                        
                        <div class="form-group third-width">
                            <label for="jam_selesai" class="neumorphic-label">Jam Selesai</label>
                            <input
                                type="time"
                                id="jam_selesai"
                                name="jam_selesai"
                                class="neumorphic-input"
                            />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tujuan_rapat" class="neumorphic-label">Tujuan Rapat (Agenda Utama)</label>
                        <textarea
                            id="tujuan_rapat"
                            name="tujuan_rapat"
                            rows="4"
                            placeholder="Jelaskan tujuan utama rapat dan agenda singkat"
                            required
                            class="neumorphic-textarea"
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label class="neumorphic-label">Tentukan Anggota Rapat (Target Peserta)</label>
                        <div class="neumorphic-checkbox-group">
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" name="target_rapat[]" value="Dosen">
                                <span class="checkmark"></span>
                                Untuk Seluruh Dosen
                            </label>
                            
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" id="checkJurusan" name="target_rapat[]" value="Jurusan">
                                <span class="checkmark"></span>
                                Untuk Jurusan Tertentu (Sebutkan)
                            </label>
                            <input
                                type="text"
                                id="inputJurusan"
                                name="detail_jurusan"
                                placeholder="Contoh: Jurusan Teknik Mesin, Jurusan Akuntansi"
                                class="neumorphic-input detail-input"
                            />
                            
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" id="checkProdi" name="target_rapat[]" value="Prodi">
                                <span class="checkmark"></span>
                                Untuk Program Studi (Sebutkan)
                            </label>
                            <input
                                type="text"
                                id="inputProdi"
                                name="detail_prodi"
                                placeholder="Contoh: D4 Mekatronika, D3 Akuntansi"
                                class="neumorphic-input detail-input"
                            />

                            <label class="neumorphic-checkbox">
                                <input type="checkbox" id="checkKelas" name="target_rapat[]" value="Kelas">
                                <span class="checkmark"></span>
                                Untuk Kelas Tertentu (Sebutkan Kelasnya)
                            </label>
                            <input
                                type="text"
                                id="inputKelas"
                                name="detail_kelas"
                                placeholder="Contoh: TI 3A, MKB 5B"
                                class="neumorphic-input detail-input"
                            />

                            <label class="neumorphic-checkbox">
                                <input type="checkbox" id="checkLainnya" name="target_rapat[]" value="Lainnya">
                                <span class="checkmark"></span>
                                Fitur Lainnya / Target Spesifik (Sebutkan)
                            </label>
                            <input
                                type="text"
                                id="inputLainnya"
                                name="detail_lainnya"
                                placeholder="Contoh: Seluruh Kepala Bagian, Semua Pegawai Kontrak"
                                class="neumorphic-input detail-input"
                            />
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="reset" class="neumorphic-btn btn-secondary">
                            🗑️ Hapus Form
                        </button>
                        <button type="submit" class="neumorphic-btn btn-primary">
                            🚀 Simpan & Terbitkan Rapat
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; 2025 Sipera POLIBATAM - All rights reserved.</p>
        </div>
    </footer>
    <script>
        // FUNGSI BARU: MENSIMULASIKAN PENYIMPANAN DAN MENGALIHKAN KE DETAIL RAPAT BARU
        function simpanDanTerbitkanRapat() {
            // 1. Simulasikan pembuatan ID Rapat baru
            const idRapatBaru = '999'; 
        
            // 2. Dapatkan nilai judul untuk notifikasi
            const judulRapat = document.getElementById('judul_rapat').value;
        
            // 3. Tampilkan notifikasi simulasi
            alert(`Rapat "${judulRapat}" (ID #${idRapatBaru}) berhasil diterbitkan dan siap dilihat di daftar rapat Anda!`);
        
            // 4. ALIHAKAN PENGGUNA KE HALAMAN RAPAT SAYA (rapat-saya.html)
            // Pengguna akan melihat rapat baru tersebut tercantum di sana.
            window.location.href = 'rapat-saya.html'; // <--- bakal kembali ke halaman rapat saya
        
            return false; // Mencegah form submit default
        }
        
        // SCRIPT JAVASCRIPT untuk mengatur tampilan input detail (Konsisten)
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = [
                { id: 'checkJurusan', input: 'inputJurusan' },
                { id: 'checkProdi', input: 'inputProdi' },
                { id: 'checkKelas', input: 'inputKelas' },
                { id: 'checkLainnya', input: 'inputLainnya' }
            ];

            checkboxes.forEach(item => {
                const checkbox = document.getElementById(item.id);
                const input = document.getElementById(item.input);

                // Inisialisasi: Sembunyikan input detail saat halaman dimuat
                input.style.display = 'none';
                input.removeAttribute('required'); // Pastikan tidak wajib diisi jika disembunyikan

                checkbox.addEventListener('change', function() {
                    // Tampilkan atau sembunyikan input detail berdasarkan status checkbox
                    if (this.checked) {
                        input.style.display = 'block';
                        input.setAttribute('required', 'required');
                    } else {
                        input.style.display = 'none';
                        input.removeAttribute('required');
                        input.value = ''; // Kosongkan nilai saat disembunyikan
                    }
                });
            });

             // SCRIPT JAVASCRIPT untuk mengontrol User Dropdown 
            const userButton = document.querySelector('.user-button');
            const dropdownContent = document.querySelector('.user-dropdown-content');

            userButton.addEventListener('click', function() {
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }
            });

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.user-menu-dropdown')) {
                    dropdownContent.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>