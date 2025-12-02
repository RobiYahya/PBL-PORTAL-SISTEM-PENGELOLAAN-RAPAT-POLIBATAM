<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda - Sipera</title>
    <link rel="stylesheet" href="../../public/css/style_home.css" />
    <link rel="stylesheet" href="../../public/css/responsive.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
</head>

<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="index.php" class="logo-link">
                <img src="../../public/foto/logo.png" alt="Logo Sipera" class="logo" />
            </a>
            <div class="nav-links">
                <a href="masuk.php" class="btn btn-masuk">Masuk</a>
                <a href="daftar.php" class="btn btn-daftar">Daftar</a>

                <div class="notification-dropdown">
                    <button class="notification-icon" onclick="toggleNotifications()">
                        🔔
                        <span class="badge" id="notificationBadge">3</span>
                    </button>

                    <div class="notification-content" id="notificationDropdown">
                        <div class="notification-header">Pemberitahuan</div>

                        <a href="../../../verifikasi_notif.php?id=101" class="notification-item" data-id="101">
                            <div class="item-details">
                                <p>
                                    <strong>Judul Rapat:</strong> Rapat Tahunan Anggaran 2026<br />
                                    <strong>Pemimpin Rapat:</strong> Dr. Ir. Muhammad Adam<br />
                                    <strong>Tanggal:</strong> 25 Nov 2025
                                </p>
                                <span class="time">22:04 11-11-2025</span>
                            </div>
                            <button class="star-icon" onclick="toggleStar(event, this, '101')">
                                ⭐
                            </button>
                        </a>

                        <a href="../../../verifikasi_notif.php?id=102" class="notification-item" data-id="102">
                            <div class="item-details">
                                <p>
                                    <strong>Judul Rapat:</strong> Proyek Pengembangan Sipera v2.0<br />
                                    <strong>Pemimpin Rapat:</strong> Bpk. Asep Saepudin, S.Kom<br />
                                    <strong>Tanggal:</strong> 05 Jan 2026
                                </p>
                                <span class="time">21:55 10-11-2025</span>
                            </div>
                            <button class="star-icon" onclick="toggleStar(event, this, '102')">
                                ⭐
                            </button>
                        </a>

                        <a href="../../../verifikasi_notif.php?id=103" class="notification-item" data-id="103">
                            <div class="item-details">
                                <p>
                                    <strong>Judul Rapat:</strong> Pengumuman Perubahan Jadwal Semester<br />
                                    <strong>Pemimpin Rapat:</strong> Direktur Polibatam<br />
                                    <strong>Tanggal:</strong> 15 Des 2025
                                </p>
                                <span class="time">21:50 10-11-2025</span>
                            </div>
                            <button class="star-icon" onclick="toggleStar(event, this, '103')">
                                ⭐
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="hero-section" id="home">
            <div class="container hero-content">
                <h1>
                    PORTAL SISTEM PENGELOLAAN RAPAT <br />
                    <span>POLIBATAM</span>
                </h1>
            </div>
        </section>

        <section class="contact-section" id="contact">
            <div class="container contact-container">
                <div class="contact-col contact-col-alamat">
                    <h3>ALAMAT</h3>
                    <p>
                        Jl. Ahmad Yani, Tlk. Tering,<br />Kec. Batam Kota, Kota Batam,<br />Kepulauan
                        Riau 29461,<br />Politeknik Negeri Batam
                    </p>
                </div>

                <div class="contact-col contact-col-sosmed">
                    <h3>MEDIA SOSIAL</h3>
                    <ul class="social-links">
                        <li>
                            <a href="#instagram"><img src="../../public/foto/instagram.png" alt="logo instagram" /></a>
                        </li>
                        <li>
                            <a href="#whatsapp"><img src="../../public/foto/whatsapp.png" alt="logo whatsapp" /></a>
                        </li>
                        <li>
                            <a href="#github"><img src="../../public/foto/github.png" alt="logo github" /></a>
                        </li>
                    </ul>
                </div>

                <div class="contact-col contact-col-kontak">
                    <h3>CONTACT KAMI</h3>
                    <p>
                        Email:
                        <a href="mailto:info@polibatam.ac.id">email@polibatam.ac.id</a><br />Telp: 0812345678
                    </p>
                </div>
            </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; 2025 All rights reserved.</p>
        </div>
    </footer>

    <script>
    function toggleNotifications() {
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('show');
    }

    // Simulasikan penyimpanan status bintang ke Local Storage
    const starredNotifications = JSON.parse(localStorage.getItem('starredNotifs')) || [];

    document.addEventListener('DOMContentLoaded', () => {
        // Pasang event listener untuk menutup dropdown saat klik di luar
        document.addEventListener('click', function(event) {
            const dropdownArea = document.querySelector('.notification-dropdown');
            if (dropdownArea && !dropdownArea.contains(event.target)) {
                document.getElementById('notificationDropdown').classList.remove('show');
            }
        });

        // Jalankan fungsi pengurutan saat halaman dimuat
        sortNotifications();

        // Set status awal bintang dari Local Storage
        document.querySelectorAll('.notification-item').forEach(item => {
            const id = item.getAttribute('data-id');
            const starButton = item.querySelector('.star-icon');
            if (starredNotifications.includes(id)) {
                item.classList.add('starred');
                starButton.textContent = '⭐'; // Bintang penuh
            } else {
                starButton.textContent = '☆'; // Bintang kosong
            }
        });
    });

    // FUNGSI INTI: Memindahkan notifikasi ke atas
    function sortNotifications() {
        const container = document.getElementById('notificationDropdown');
        const header = container.querySelector('.notification-header');
        const items = Array.from(container.querySelectorAll('.notification-item'));

        // Pisahkan item yang dibintangi dan yang tidak
        const starred = items.filter(item => item.classList.contains('starred'));
        const unstarred = items.filter(item => !item.classList.contains('starred'));

        // Urutkan yang tidak dibintangi berdasarkan waktu (opsional, di sini hanya urutan default)

        // Kosongkan container kecuali header
        container.innerHTML = '';
        container.appendChild(header);

        // Masukkan kembali yang dibintangi (di atas)
        starred.forEach(item => container.appendChild(item));

        // Masukkan kembali yang tidak dibintangi (di bawah)
        unstarred.forEach(item => container.appendChild(item));
    }

    // FUNGSI UNTUK MENGGANTI STATUS BINTANG
    function toggleStar(event, button, id) {
        event.preventDefault(); // Mencegah pindah ke detail-rapat.html
        event.stopPropagation(); // Mencegah dropdown tertutup

        const item = button.closest('.notification-item');
        const isStarred = item.classList.toggle('starred');

        if (isStarred) {
            // Tambahkan ID ke Local Storage dan ubah ikon
            if (!starredNotifications.includes(id)) {
                starredNotifications.push(id);
            }
            button.textContent = '⭐';
        } else {
            // Hapus ID dari Local Storage dan ubah ikon
            const index = starredNotifications.indexOf(id);
            if (index > -1) {
                starredNotifications.splice(index, 1);
            }
            button.textContent = '☆';
        }

        localStorage.setItem('starredNotifs', JSON.stringify(starredNotifications));

        // Lakukan pengurutan ulang untuk memindahkan item ke atas/bawah
        sortNotifications();
    }
    </script>
</body>

</html>