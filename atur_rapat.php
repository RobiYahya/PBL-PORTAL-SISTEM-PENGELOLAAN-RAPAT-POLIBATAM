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

// Ambil ID rapat dari URL
$id_rapat = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validasi: cek apakah rapat ada dan user adalah pembuat
$query_rapat = "SELECT * FROM rapat WHERE id_rapat = '$id_rapat' AND id_user = '$user_id'";
$result_rapat = mysqli_query($koneksi, $query_rapat);
$rapat = mysqli_fetch_assoc($result_rapat);

if (!$rapat) {
    echo "<script>alert('Rapat tidak ditemukan atau Anda tidak memiliki akses!'); window.location.href='rapat_saya.php';</script>";
    exit();
}

// Cek apakah rapat sudah dibatalkan
if ($rapat['status'] == 'dibatalkan') {
    echo "<script>alert('Rapat yang sudah dibatalkan tidak dapat diedit!'); window.location.href='detail_rapat.php?id=$id_rapat';</script>";
    exit();
}

// Cek apakah rapat sudah selesai
if ($rapat['status'] == 'selesai') {
    echo "<script>alert('Rapat yang sudah selesai tidak dapat diedit!'); window.location.href='detail_rapat.php?id=$id_rapat';</script>";
    exit();
}

// Proses update rapat
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_rapat = mysqli_real_escape_string($koneksi, $_POST['judul_rapat']);
    $ruangan_rapat = mysqli_real_escape_string($koneksi, $_POST['ruangan_rapat']);
    $status_rapat = mysqli_real_escape_string($koneksi, $_POST['status_rapat']);
    $tanggal_rapat = $_POST['tanggal_rapat'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $tujuan_rapat = mysqli_real_escape_string($koneksi, $_POST['tujuan_rapat']);
    
    // Gabungkan tanggal dan jam untuk format datetime
$tanggal_rapat_datetime = $tanggal_rapat . ' ' . $jam_mulai . ':00';
    
    // Normalisasi status rapat sesuai database
    $status_db = 'draft'; // default
    $prioritas_db = 'normal'; // default
    if ($status_rapat == 'Terjadwal') {
        $status_db = 'terjadwal';
        $prioritas_db = 'normal';
    } elseif ($status_rapat == 'Mendesak') {
        $status_db = 'terjadwal'; // Mendesak dianggap terjadwal
        $prioritas_db = 'mendesak';
    }
    
    // Update data rapat
    $update_query = "UPDATE rapat SET 
                     judul_rapat = '$judul_rapat', 
                     deskripsi = '$tujuan_rapat', 
                     tanggal_rapat = '$tanggal_rapat_datetime', 
                     jam_selesai = '$jam_selesai',
                     lokasi = '$ruangan_rapat', 
                     status = '$status_db',
                     prioritas = '$prioritas_db'
                     WHERE id_rapat = '$id_rapat' AND id_user = '$user_id'";
    
    if (mysqli_query($koneksi, $update_query)) {
        echo "<script>
            alert('Rapat \"$judul_rapat\" berhasil diperbarui!');
            window.location.href = 'rapat_saya.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Gagal memperbarui rapat: " . mysqli_error($koneksi) . "');
        </script>";
    }
}

// Ambil data peserta yang sudah ada untuk checkbox
$peserta_query = "SELECT DISTINCT u.jabatan FROM peserta_rapat pr 
                 JOIN users u ON pr.id_user = u.id_user 
                 WHERE pr.id_rapat = '$id_rapat' AND pr.id_user != '$user_id'";
$peserta_result = mysqli_query($koneksi, $peserta_query);
$peserta_terpilih = array();
while ($peserta = mysqli_fetch_assoc($peserta_result)) {
    $peserta_terpilih[] = $peserta['jabatan'];
}

// Format tanggal dan jam untuk form
$tanggal_rapat_form = date('Y-m-d', strtotime($rapat['tanggal_rapat']));
$jam_mulai_form = date('H:i', strtotime($rapat['tanggal_rapat']));
$jam_selesai_form = !empty($rapat['jam_selesai']) ? $rapat['jam_selesai'] : date('H:i', strtotime($rapat['tanggal_rapat']));

// Normalisasi status untuk form
$status_form = 'Draft';
if ($rapat['status'] == 'terjadwal') {
    if ($rapat['prioritas'] == 'mendesak') {
        $status_form = 'Mendesak';
    } else {
        $status_form = 'Terjadwal';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Rapat - Sipera POLIBATAM</title>
    <link rel="stylesheet" href="./public/css/style_buat_rapat.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
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
                        Halo, <?php echo htmlspecialchars($user['nama_lengkap']); ?>!
                    </button>
                    <div class="user-dropdown-content">
                        <a href="profil.php">Profil Saya</a>
                        <a href="rapat_saya.php">Rapat Saya</a>
                        <a href="masuk.php">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="meeting-creation-section">
            <div class="container">
                <h1 class="main-title">Edit Rapat <span>#<?php echo $id_rapat; ?></span></h1>
                <p class="subtitle">Perbarui detail rapat yang telah Anda jadwalkan.</p>
                
                <form id="meetingForm" class="neumorphic-form" action="atur_rapat.php?id=<?php echo $id_rapat; ?>" method="POST">
                    
                    <div class="form-group">
                        <label for="judul_rapat" class="neumorphic-label">Judul Rapat</label>
                        <input
                            type="text"
                            id="judul_rapat"
                            name="judul_rapat"
                            value="<?php echo htmlspecialchars($rapat['judul_rapat']); ?>"
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
                                value="<?php echo htmlspecialchars($rapat['lokasi']); ?>"
                                placeholder="Contoh: Ruangan R-301, Gedung C"
                                required
                                class="neumorphic-input"
                            />
                        </div>

                        <div class="form-group half-width">
                            <label for="status_rapat" class="neumorphic-label">Status Rapat</label>
                            <select id="status_rapat" name="status_rapat" required class="neumorphic-select">
                                <option value="Draft" <?php echo ($status_form == 'Draft') ? 'selected' : ''; ?>>Draft (Belum Dipublikasi)</option>
                                <option value="Terjadwal" <?php echo ($status_form == 'Terjadwal') ? 'selected' : ''; ?>>Terjadwal</option>
                                <option value="Mendesak" <?php echo ($status_form == 'Mendesak') ? 'selected' : ''; ?>>Mendesak</option>
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
                                value="<?php echo $tanggal_rapat_form; ?>"
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
                                value="<?php echo $jam_mulai_form; ?>"
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
                                value="<?php echo $jam_selesai_form; ?>"
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
                        ><?php echo htmlspecialchars($rapat['deskripsi']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="neumorphic-label">Tentukan Anggota Rapat (Target Peserta)</label>
                        <div class="neumorphic-checkbox-group">
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" name="target_rapat[]" value="dosen" <?php echo (in_array('dosen', $peserta_terpilih)) ? 'checked' : ''; ?>>
                                <span class="checkmark"></span>
                                Untuk Seluruh Dosen
                            </label>
                            
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" name="target_rapat[]" value="pegawai" <?php echo (in_array('pegawai', $peserta_terpilih)) ? 'checked' : ''; ?>>
                                <span class="checkmark"></span>
                                Untuk Seluruh Pegawai
                            </label>
                            
                            <label class="neumorphic-checkbox">
                                <input type="checkbox" name="target_rapat[]" value="mahasiswa" <?php echo (in_array('mahasiswa', $peserta_terpilih)) ? 'checked' : ''; ?>>
                                <span class="checkmark"></span>
                                Untuk Seluruh Mahasiswa
                            </label>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="button" onclick="window.location.href='rapat_saya.php'" class="neumorphic-btn btn-secondary">
                            ❌ Batal
                        </button>
                        <button type="button" onclick="batalkanRapat()" class="neumorphic-btn btn-danger">
                            🚫 Batalkan Rapat
                        </button>
                        <button type="submit" class="neumorphic-btn btn-primary">
                            💾 Simpan Perubahan
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
        function batalkanRapat() {
            if (confirm('Apakah Anda yakin ingin membatalkan rapat ini?')) {
                window.location.href = 'batalkan_rapat.php?id=<?php echo $id_rapat; ?>';
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
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
