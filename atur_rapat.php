<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Rapat - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style_buat_rapat.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
        /* CSS tambahan spesifik untuk halaman edit */
        .main-title span {
            color: var(--color-primary);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="masuk.php" class="logo-link">
                <img src="./public/foto/logo.png" alt="Logo Sipera" class="logo" />
            </a>
            <div class="nav-links">
                <div class="user-menu-dropdown">
                    <button class="user-button">
                        Halo, Admin!
                    </button>
                    <div class="user-dropdown-content">
                        <a href="profil.html">Profil Saya</a>
                        <a href="masuk.php">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="meeting-creation-section">
            <div class="container">
                <h1 class="main-title">Edit Detail Rapat <span>#105</span> 🛠️</h1>
                <p class="subtitle">Rapat: **Rapat Tahunan Anggaran 2026**. Perbarui informasi di bawah.</p>
                
                <form id="meetingForm" class="neumorphic-form" onsubmit="return simpanPerubahanRapat()">
                    
                    <div class="form-group">
                        <label for="judul_rapat" class="neumorphic-label">Judul Rapat</label>
                        <input
                            type="text"
                            id="judul_rapat"
                            name="judul_rapat"
                            value="Rapat Tahunan Anggaran 2026"
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
                                value="Ruangan A-101"
                                required
                                class="neumorphic-input"
                            />
                        </div>

                        <div class="form-group half-width">
                            <label for="status_rapat" class="neumorphic-label">Status Rapat</label>
                            <select id="status_rapat" name="status_rapat" required class="neumorphic-select">
                                <option value="Terjadwal" selected>Terjadwal</option>
                                <option value="Draft">Draft</option>
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
                                value="2025-12-25"
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
                                value="09:00"
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
                                value="11:00"
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
                            required
                            class="neumorphic-textarea"
                        >Mendiskusikan dan menyetujui draf anggaran tahunan Polibatam untuk tahun 2026. Menentukan alokasi dana prioritas untuk pengembangan infrastruktur dan SDM.</textarea>
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
                                <input type="checkbox" id="checkJurusan" name="target_rapat[]" value="Jurusan" checked>
                                <span class="checkmark"></span>
                                Untuk Jurusan Tertentu (Sebutkan)
                            </label>
                             <input
                                type="text"
                                id="inputJurusan"
                                name="detail_jurusan"
                                value="Semua Jurusan (Direktur, Wakil Direktur, Kepala Jurusan)"
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
                        <button type="submit" class="neumorphic-btn btn-primary">
                            ✅ Simpan Perubahan Rapat
                        </button>
                        <button type="button" class="neumorphic-btn btn-danger" onclick="confirmBatal()">
                            ❌ Batalkan Rapat Ini
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
        // FUNGSI UNTUK MENGHUBUNGKAN KE DETAIL RAPAT SETELAH DISIMPAN
        function simpanPerubahanRapat() {
            // Dapatkan ID Rapat dari URL (contoh: id=105)
            const urlParams = new URLSearchParams(window.location.search);
            // Ambil nilai 'id' dari URL. Jika tidak ada, gunakan '105' (ID dummy)
            const idRapat = urlParams.get('id') || '105'; 

            // Tampilkan notifikasi simulasi
            alert("Perubahan rapat ID #" + idRapat + " berhasil disimpan!");

            // Alihkan pengguna ke halaman detail rapat yang baru saja diedit
            window.location.href = 'detail_rapat.php?id=' + idRapat;

            return false; // SANGAT PENTING: Mencegah form submit default (page refresh)
        }

        // FUNGSI UNTUK MEMBATALKAN RAPAT
        function confirmBatal() {
            if (confirm("Apakah Anda yakin ingin membatalkan rapat ini? Rapat akan dipindahkan ke kategori 'Dibatalkan'.")) {
                alert("Rapat telah dibatalkan.");
                window.location.href = 'rapat_saya.php'; 
            }
        }
        
        // SCRIPT JAVASCRIPT untuk mengontrol tampilan input detail
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

                // Inisialisasi: tampilkan jika sudah checked dari data lama
                if (checkbox.checked) {
                     input.style.display = 'block';
                } else {
                     input.style.display = 'none';
                }

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