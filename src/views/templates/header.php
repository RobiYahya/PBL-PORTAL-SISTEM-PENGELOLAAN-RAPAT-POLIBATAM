<?php
// Nama File: header.php
// Deskripsi: Header global untuk template utama aplikasi, memuat resource CSS/JS dan navigasi.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

// MATIKAN CACHE
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($data['judul']); ?></title>
    
    <link rel="icon" href="<?= BASEURL; ?>/foto/logo.png" type="image/png" />
    
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/global.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/app.css?v=<?= time(); ?>" />
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="<?= BASEURL; ?>" class="logo-link">
                <img src="<?= BASEURL; ?>/foto/logo.png" alt="Logo Sipera" class="logo" />
            </a>

            <button class="menu-toggle" id="mobile-menu" onclick="toggleMobileMenu(event)">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            
            <div class="nav-links" id="navLinks">
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <div class="user-menu-dropdown">
                        <button class="user-button" id="userBtn" onclick="toggleUserMenu(event)">
                            <i class="fas fa-user-circle" style="font-size: 1.1em;"></i>
                            <span style="margin-left: 8px;"><?= htmlspecialchars($_SESSION['nama']); ?></span> 
                            <i class="fas fa-caret-down" id="arrowIcon" style="margin-left: 5px; transition: 0.3s;"></i>
                        </button>
                        
                        <div class="user-dropdown-content" id="userDropdown">
                            <a href="<?= BASEURL; ?>/rapat">
                                <i class="fas fa-calendar-alt"></i> Rapat Saya
                            </a>
                            <a href="<?= BASEURL; ?>/user/profile">
                                <i class="fas fa-user"></i> Profil
                            </a>
                            <div class="divider"></div>
                            <a href="<?= BASEURL; ?>/auth/logout" class="menu-logout">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </a>
                        </div>
                    </div>

                <?php else: ?>
                    <a href="<?= BASEURL; ?>/auth/login" class="btn btn-masuk">Masuk</a>
                    <a href="<?= BASEURL; ?>/auth/register" class="btn btn-daftar">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <script>
        function toggleMobileMenu(e) {
            e.stopPropagation();
            const menuToggle = document.getElementById('mobile-menu');
            const navLinks = document.getElementById('navLinks');
            menuToggle.classList.toggle('is-active');
            navLinks.classList.toggle('active');
        }

        function toggleUserMenu(e) {
            e.stopPropagation();
            const dd = document.getElementById('userDropdown');
            const arrow = document.getElementById('arrowIcon');
            dd.classList.toggle('show');
            
            if (dd.classList.contains('show')) {
                arrow.style.transform = "rotate(180deg)";
            } else {
                arrow.style.transform = "rotate(0deg)";
            }
        }

        document.addEventListener('click', function(e) {
            const navLinks = document.getElementById('navLinks');
            const menuToggle = document.getElementById('mobile-menu');
            const dd = document.getElementById('userDropdown');
            const userBtn = document.getElementById('userBtn');

            if (navLinks.classList.contains('active') && !navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
                menuToggle.classList.remove('is-active');
                navLinks.classList.remove('active');
            }

            if (dd.classList.contains('show') && !dd.contains(e.target) && !userBtn.contains(e.target)) {
                dd.classList.remove('show');
                document.getElementById('arrowIcon').style.transform = "rotate(0deg)";
            }
        });
    </script>

    <?php if (isset($_SESSION['popup_type'])): ?>
        <script>
            Swal.fire({
                icon: '<?= htmlspecialchars($_SESSION['popup_type']); ?>',
                title: '<?= htmlspecialchars($_SESSION['popup_title']); ?>',
                text: '<?= htmlspecialchars($_SESSION['popup_text']); ?>',
                confirmButtonColor: '#f0a500'
            });
        </script>
        <?php unset($_SESSION['popup_type'], $_SESSION['popup_title'], $_SESSION['popup_text']); ?>
    <?php endif; ?>
</body>
</html>