<?php
session_start();
require_once 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: masuk.php');
    exit();
}

// Ambil data user yang login
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id_user = '$user_id'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

// Update otomatis rapat yang sudah lewat jam_selesai menjadi selesai
$update_selesai = "UPDATE rapat SET status = 'selesai' 
                   WHERE status = 'terjadwal' 
                   AND CONCAT(DATE(tanggal_rapat), ' ', IFNULL(jam_selesai, '23:59')) < NOW()";
$result_update = mysqli_query($koneksi, $update_selesai);

// Query rapat berdasarkan status (yang dibuat + diundang)
$query_terjadwal = "SELECT r.* FROM rapat r 
                    WHERE r.id_user = '$user_id' AND r.status = 'terjadwal'
                    UNION
                    SELECT r.* FROM rapat r 
                    JOIN peserta_rapat pr ON r.id_rapat = pr.id_rapat 
                    WHERE pr.id_user = '$user_id' AND r.status = 'terjadwal'
                    ORDER BY tanggal_rapat ASC";
$result_terjadwal = mysqli_query($koneksi, $query_terjadwal);

$query_dibatalkan = "SELECT r.* FROM rapat r 
                     WHERE r.id_user = '$user_id' AND r.status = 'dibatalkan'
                     UNION
                     SELECT r.* FROM rapat r 
                     JOIN peserta_rapat pr ON r.id_rapat = pr.id_rapat 
                     WHERE pr.id_user = '$user_id' AND r.status = 'dibatalkan'
                     ORDER BY tanggal_rapat DESC";
$result_dibatalkan = mysqli_query($koneksi, $query_dibatalkan);

$query_selesai = "SELECT r.* FROM rapat r 
                  WHERE r.id_user = '$user_id' AND r.status = 'selesai'
                  UNION
                  SELECT r.* FROM rapat r 
                  JOIN peserta_rapat pr ON r.id_rapat = pr.id_rapat 
                  WHERE pr.id_user = '$user_id' AND r.status = 'selesai'
                  ORDER BY tanggal_rapat DESC";
$result_selesai = mysqli_query($koneksi, $query_selesai);

// Hitung total
$total_terjadwal = mysqli_num_rows($result_terjadwal);
$total_dibatalkan = mysqli_num_rows($result_dibatalkan);
$total_selesai = mysqli_num_rows($result_selesai);
?>
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
                        Halo, <?php echo htmlspecialchars($user['nama_lengkap']); ?>!
                    </button>
                    <div class="user-dropdown-content" id="userDropdown">
                        <a href="profil.php">Profil Saya</a>
                        <a href="buat_rapat.php">Buat Rapat</a>
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
                        <p class="stat-value text-primary"><?php echo $total_terjadwal; ?></p>
                    </div>
                    <div class="stat-card neumorphic-card">
                        <h3>Rapat Dibatalkan</h3>
                        <p class="stat-value text-canceled"><?php echo $total_dibatalkan; ?></p>
                    </div>
                    <div class="stat-card neumorphic-card">
                        <h3>Rapat Selesai</h3>
                        <p class="stat-value text-success"><?php echo $total_selesai; ?></p>
                    </div>
                </div>

                <div class="neumorphic-tabs">
                    <button class="tab-button active" onclick="showTab('terjadwal')">Terjadwal (<?php echo $total_terjadwal; ?>)</button>
                    <button class="tab-button" onclick="showTab('dibatalkan')">Dibatalkan (<?php echo $total_dibatalkan; ?>)</button>
                    <button class="tab-button" onclick="showTab('selesai')">Selesai (<?php echo $total_selesai; ?>)</button>
                </div>

                <!-- TAB TERJADWAL -->
                <div id="rapat-terjadwal" class="tab-content active">
                    <?php if (mysqli_num_rows($result_terjadwal) > 0): ?>
                        <?php while ($rapat = mysqli_fetch_assoc($result_terjadwal)): ?>
                            <div class="meeting-item neumorphic-item status-terjadwal">
                                <div class="meeting-details">
                                    <span class="meeting-status-tag">Terjadwal</span>
                                    <a href="detail_rapat.php?id=<?php echo $rapat['id_rapat']; ?>" class="meeting-title"><?php echo htmlspecialchars($rapat['judul_rapat']); ?></a>
                                    <p class="meeting-info">
                                        🗓️ <?php echo date('d M Y', strtotime($rapat['tanggal_rapat'])); ?> |
                                        🕘 <?php echo date('H:i', strtotime($rapat['tanggal_rapat'])); ?> WIB |
                                        📍 <?php echo htmlspecialchars($rapat['lokasi']); ?>
                                    </p>
                                </div>

                                <div class="meeting-actions">
                                    <?php if ($rapat['id_user'] == $user_id): ?>
                                        <a href="atur_rapat.php?id=<?php echo $rapat['id_rapat']; ?>" class="action-btn btn-edit-link">📝 Edit</a>
                                    <?php else: ?>
                                        <a href="absensi.php?id=<?php echo $rapat['id_rapat']; ?>" class="action-btn btn-absensi-link">✅ Absensi</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>📅 Belum ada rapat terjadwal</p>
                            <a href="buat_rapat.php" class="btn-link">Buat rapat baru</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- TAB DIBATALKAN -->
                <div id="rapat-dibatalkan" class="tab-content">
                    <?php if (mysqli_num_rows($result_dibatalkan) > 0): ?>
                        <?php while ($rapat = mysqli_fetch_assoc($result_dibatalkan)): ?>
                            <div class="meeting-item neumorphic-item status-dibatalkan">
                                <div class="meeting-details">
                                    <span class="meeting-status-tag">Dibatalkan</span>
                                    <a href="detail_rapat.php?id=<?php echo $rapat['id_rapat']; ?>" class="meeting-title"><?php echo htmlspecialchars($rapat['judul_rapat']); ?></a>
                                    <p class="meeting-info">
                                        🗓️ <?php echo date('d M Y', strtotime($rapat['tanggal_rapat'])); ?> |
                                        🕘 <?php echo date('H:i', strtotime($rapat['tanggal_rapat'])); ?> WIB |
                                        📍 <?php echo htmlspecialchars($rapat['lokasi']); ?>
                                    </p>
                                </div>

                                <div class="meeting-actions">
                                    <!-- EDIT DIHAPUS SESUAI PERMINTAAN -->
                                    <a href="detail_rapat.php?id=<?php echo $rapat['id_rapat']; ?>" class="action-btn btn-view-link">👀 Detail</a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-state"><p>🚫 Tidak ada rapat yang dibatalkan</p></div>
                    <?php endif; ?>
                </div>

                <!-- TAB SELESAI -->
                <div id="rapat-selesai" class="tab-content">
                    <?php if (mysqli_num_rows($result_selesai) > 0): ?>
                        <?php while ($rapat = mysqli_fetch_assoc($result_selesai)): ?>
                            <div class="meeting-item neumorphic-item status-selesai">
                                <div class="meeting-details">
                                    <span class="meeting-status-tag">Selesai</span>
                                    <a href="detail_rapat.php?id=<?php echo $rapat['id_rapat']; ?>" class="meeting-title"><?php echo htmlspecialchars($rapat['judul_rapat']); ?></a>
                                    <p class="meeting-info">
                                        🗓️ <?php echo date('d M Y', strtotime($rapat['tanggal_rapat'])); ?> |
                                        🕘 <?php echo date('H:i', strtotime($rapat['tanggal_rapat'])); ?> WIB |
                                        📍 <?php echo htmlspecialchars($rapat['lokasi']); ?>
                                    </p>
                                </div>

                                <div class="meeting-actions">
                                    <?php if ($rapat['id_user'] == $user_id): ?>
                                        <a href="atur_rapat.php?id=<?php echo $rapat['id_rapat']; ?>" class="action-btn btn-edit-link">📝 Edit</a>
                                    <?php endif; ?>
                                    <a href="detail_rapat.php?id=<?php echo $rapat['id_rapat']; ?>" class="action-btn btn-view-link">👀 Detail</a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-state"><p>✅ Belum ada rapat yang selesai</p></div>
                    <?php endif; ?>
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
        document.addEventListener('DOMContentLoaded', function() {
            const userButton = document.querySelector('.user-button');
            const dropdownContent = document.querySelector('.user-dropdown-content');

            userButton.addEventListener('click', function() {
                dropdownContent.style.display =
                    dropdownContent.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.user-menu-dropdown')) {
                    dropdownContent.style.display = 'none';
                }
            });
        });

        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            document.getElementById('rapat-' + tabName).classList.add('active');
            document.querySelector(`.tab-button[onclick="showTab('${tabName}')"]`).classList.add('active');
        }
    </script>

</body>
</html>
