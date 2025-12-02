<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rapat Saya - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style_rapat_saya.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
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
                    <div class="user-dropdown-content" id="userDropdown">
                        <a href="profil.php">Profil Saya</a>
                        <a href="masuk.php">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="dashboard-section">
            <div class="container">
                <h1 class="main-title">Rapat Saya 🚀</h1>
                <p class="subtitle">Kelola semua jadwal rapat yang telah Anda buat.</p>

                <a href="buat_rapat.php" class="new-meeting-btn-link">
                    <div class="neumorphic-btn-create">
                        ➕ Buat Rapat Baru
                        <span class="btn-description">Klik di sini untuk menjadwalkan rapat baru.</span>
                    </div>
                </a>

                <div class="stats-panel">
                    <div class="stat-card neumorphic-card">
                        <h3>Rapat Terjadwal</h3>
                        <p class="stat-value text-primary">12</p>
                    </div>
                    <div class="stat-card neumorphic-card">
                        <h3>Rapat Dibatalkan</h3>
                        <p class="stat-value text-canceled">03</p>
                    </div>
                    <div class="stat-card neumorphic-card">
                        <h3>Rapat Selesai </h3>
                        <p class="stat-value text-success">07</p>
                    </div>
                </div>

                <div class="neumorphic-tabs">
                    <button class="tab-button active" onclick="showTab('terjadwal')">Terjadwal (3)</button>
                    <button class="tab-button" onclick="showTab('dibatalkan')">Dibatalkan (1)</button>
                    <button class="tab-button" onclick="showTab('selesai')">Selesai (8)</button>
                </div>

                <div id="rapat-terjadwal" class="tab-content active">
                    <div class="meeting-item neumorphic-item status-terjadwal">
                        <div class="meeting-details">
                            <span class="meeting-status-tag">Terjadwal</span>
                            <a href="detail_rapat.php?id=105" class="meeting-title">Rapat Tahunan Anggaran 2026</a>
                            <p class="meeting-info">🗓️ 25 Des 2025 | 🕘 09:00 WIB | 📍 Ruangan A-101</p>
                        </div>
                        <div class="meeting-actions">
                            <a href="atur_rapat.php?id=105" class="action-btn btn-edit-link">📝 Edit</a>
                            <a href="detail_rapat.php?id=105" class="action-btn btn-view-link">👀 Detail</a>
                        </div>
                    </div>
                    <div class="meeting-item neumorphic-item status-terjadwal">
                        <div class="meeting-details">
                            <span class="meeting-status-tag">Terjadwal</span>
                            <a href="detail_rapat.php?id=106" class="meeting-title">Review Proyek Pengembangan Sipera
                                v2.0</a>
                            <p class="meeting-info">🗓️ 05 Jan 2026 | 🕘 13:00 WIB | 📍 Google Meet</p>
                        </div>
                        <div class="meeting-actions">
                            <a href="atur_rapat.php?id=106" class="action-btn btn-edit-link">📝 Edit</a>
                            <a href="detail_rapat.php?id=106" class="action-btn btn-view-link">👀 Detail</a>
                        </div>
                    </div>
                </div>

                <div id="rapat-dibatalkan" class="tab-content">
                    <div class="meeting-item neumorphic-item status-dibatalkan">
                        <div class="meeting-details">
                            <span class="meeting-status-tag">Dibatalkan</span>
                            <a href="detail_rapat.php?id=107" class="meeting-title">Rencana Pembukaan Prodi Baru
                                (Dibatalkan)</a>
                            <p class="meeting-info">🗓️ 01 Nov 2025 | 🕘 10:00 WIB | 📍 Ruang Rapat Direktur</p>
                        </div>
                        <div class="meeting-actions">
                            <a href="atur_rapat.php?id=107" class="action-btn btn-edit-link">📝 Lihat Detail</a>

                        </div>
                    </div>
                </div>
                <div id="rapat-selesai" class="tab-content">
                    <div class="meeting-item neumorphic-item status-selesai">
                        <div class="meeting-details">
                            <span class="meeting-status-tag">Selesai</span>
                            <a href="detail_rapat.php?id=108" class="meeting-title">Pengumuman Perubahan Jadwal
                                Semester</a>
                            <p class="meeting-info">🗓️ 15 Des 2025 | 🕘 10:00 WIB | 📍 Auditorium</p>
                        </div>
                        <div class="meeting-actions">
                            <a href="detail_rapat.php?id=108" class="action-btn btn-view-link">👀 Detail</a>
                        </div>12
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
    // SCRIPT JAVASCRIPT untuk mengontrol User Dropdown (dikutip dari halaman sebelumnya)
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
    });

    // SCRIPT JAVASCRIPT untuk mengontrol Tab Rapat
    function showTab(tabName) {
        // Sembunyikan semua konten tab
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        // Hapus status active dari semua tombol tab
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });

        // Tampilkan konten tab yang dipilih
        document.getElementById('rapat-' + tabName).classList.add('active');
        // Tandai tombol tab yang dipilih
        document.querySelector(`.tab-button[onclick="showTab('${tabName}')"]`).classList.add('active');
    }

    // Inisialisasi: Sembunyikan semua tab kecuali yang pertama saat load
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    document.getElementById('rapat-terjadwal').classList.add('active');
    </script>
</body>

</html>