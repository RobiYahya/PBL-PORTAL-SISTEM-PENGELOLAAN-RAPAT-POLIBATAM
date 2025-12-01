<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Rapat #105 - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style-detail-rapat.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
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
                        halo, semua!
                    </button>
                    <div class="user-dropdown-content">
                        <a href="masuk.php">kembali</a>
                        <a href="masuk.php">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="detail-section">
            <div class="container">
                
                <div class="main-header-card neumorphic-panel">
                    <div class="title-status-wrapper">
                        <h1 class="main-title">Rapat Tahunan Anggaran 2026</h1>
                        <span class="status-tag status-terjadwal">Terjadwal</span>
                    </div>
                    <p class="subtitle">ID Rapat: #105 | Pengirim: Admin Budi Santoso</p>
                </div>
                
                <div class="detail-content-grid">
                    
                    <div class="summary-column">
                        
                        <div class="neumorphic-card card-highlight">
                            <h2>🗓️ Waktu & Lokasi</h2>
                            <div class="highlight-info-group">
                                <span class="info-label">Tanggal Pelaksanaan</span>
                                <p class="info-value value-primary">25 Desember 2025</p>
                            </div>
                            <div class="highlight-info-group">
                                <span class="info-label">Pukul</span>
                                <p class="info-value">09:00 WIB - 11:00 WIB</p>
                            </div>
                            <div class="highlight-info-group">
                                <span class="info-label">Ruangan</span>
                                <p class="info-value value-primary">Ruangan A-101</p>
                            </div>
                        </div>

                        <div class="action-card neumorphic-card">
                            <h2>⚙️ Kelola Aksi</h2>
                            <button class="action-btn-lg btn-reminder">Akses Notulen</button>
                            <button class="action-btn-lg btn-download status-hidden">⬇️ Unduh File Notulen</button>
                        </div>
                        
                    </div>

                    <div class="main-content-column">
                        
                        <div class="neumorphic-card card-full-width">
                            <h2>🎯 Tujuan Rapat / Agenda Utama</h2>
                            <div class="content-box neumorphic-sunken">
                                <p>Mendiskusikan dan menyetujui draf anggaran tahunan Polibatam untuk tahun 2026. Menentukan alokasi dana prioritas untuk pengembangan infrastruktur dan SDM.</p>
                                <ul>
                                    <li>Poin 1: Review Kinerja Anggaran Tahun Sebelumnya.</li>
                                    <li>Poin 2: Presentasi dan Pengajuan Anggaran 2026 per Unit.</li>
                                    <li>Poin 3: Penetapan Prioritas Infrastruktur.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="neumorphic-card card-full-width">
                            <h2>👥 Peserta</h2>
                            <div class="content-box neumorphic-sunken">
                                <div class="target-group">
                                    <span class="target-label">Spesifik:</span>
                                    <p class="target-detail">Semua Kepala Jurusan, Direktur, Wakil Direktur I-III</p>
                                </div>
                                <div class="target-group">
                                    <span class="target-label">Status Konfirmasi:</span>
                                    <p class="target-detail value-success">10 dari 12 Peserta Telah Konfirmasi</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="neumorphic-card card-full-width summary-panel status-hidden">
                            <h2>📝 Hasil Rapat & Keputusan Kunci</h2>
                            <div class="content-box neumorphic-sunken">
                                <p>Rapat dilaksanakan sesuai jadwal dan menghasilkan beberapa keputusan kunci, termasuk persetujuan anggaran 2026 sebesar **Rp 50 Miliar** dan alokasi khusus untuk pembangunan Laboratorium AI.</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; 2025 Sipera POLIBATAM - All rights reserved.</p>
        </div>
    </footer>
    <script>
        // SCRIPT JAVASCRIPT untuk mengontrol User Dropdown (Konsisten)
        document.addEventListener('DOMContentLoaded', function() {
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
            
            // SIMULASI untuk menampilkan Notulen jika status rapat 'Selesai'
            const statusTag = document.querySelector('.status-tag');
            const summaryPanel = document.querySelector('.summary-panel');
            const downloadBtn = document.querySelector('.btn-download');

            // Contoh: Ganti ke 'Selesai' untuk melihat notulen
            // statusTag.textContent = 'Selesai'; 
            // statusTag.classList.remove('status-terjadwal');
            // statusTag.classList.add('status-selesai');

            if (statusTag.textContent.trim() === 'Selesai') {
                summaryPanel.classList.remove('status-hidden');
                downloadBtn.classList.remove('status-hidden');
            }
        });
    </script>
</body>
</html>