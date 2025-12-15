<?php
// MENCEGAH CACHE BROWSER (Agar saat logout tidak bisa di-back)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $data['judul']; ?></title>
    
    <link rel="icon" href="<?= BASEURL; ?>/foto/logo.png" type="image/png">
    
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/global.css" />
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/app.css" />
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="<?= BASEURL; ?>" class="logo-link">
                <img src="<?= BASEURL; ?>/foto/logo.png" alt="Logo Sipera" class="logo" />
            </a>

            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            
            <div class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <div class="user-menu-dropdown">
                        <button class="user-button" id="userBtn" onclick="toggleUserMenu()">
                            <i class="fas fa-user-circle" style="font-size: 1.1em;"></i>
                            
                            <span style="margin-left: 8px;"><?= $_SESSION['nama']; ?></span> 
                            
                            <i class="fas fa-caret-down" id="arrowIcon" style="margin-left: 5px; transition: 0.3s;"></i>
                        </button>
                        
                        <div class="user-dropdown-content" id="userDropdown">
                            <a href="<?= BASEURL; ?>/rapat">
                                <i class="fas fa-calendar-alt" style="width: 20px;"></i> Rapat Saya
                            </a>
                            <a href="<?= BASEURL; ?>/user/profile">
                                <i class="fas fa-user" style="width: 20px;"></i> Profil
                            </a>
                            <div style="border-top: 1px solid #ddd; margin: 5px 0;"></div>
                            <a href="<?= BASEURL; ?>/auth/logout" style="color: red;">
                                <i class="fas fa-sign-out-alt" style="width: 20px;"></i> Keluar
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
        // 1. Script Hamburger Menu Mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('mobile-menu');
            const navLinks = document.querySelector('.nav-links');

            if (menuToggle && navLinks) {
                menuToggle.addEventListener('click', function() {
                    menuToggle.classList.toggle('is-active');
                    navLinks.classList.toggle('active');
                });
            }
        });

        // 2. Script Dropdown User (KLIK, BUKAN HOVER)
        function toggleUserMenu() {
            var dropdown = document.getElementById("userDropdown");
            var arrow = document.getElementById("arrowIcon");
            
            // Toggle class 'show' (Buka/Tutup)
            dropdown.classList.toggle("show");
            
            // Putar panah
            if (dropdown.classList.contains("show")) {
                arrow.style.transform = "rotate(180deg)";
            } else {
                arrow.style.transform = "rotate(0deg)";
            }
        }

        // 3. Tutup menu jika klik DI LUAR tombol
        window.onclick = function(event) {
            if (!event.target.closest('.user-button')) {
                var dropdowns = document.getElementsByClassName("user-dropdown-content");
                var arrow = document.getElementById("arrowIcon");
                
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                        if(arrow) arrow.style.transform = "rotate(0deg)";
                    }
                }
            }
        }
    </script>

    <?php if (isset($_SESSION['popup_type'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['popup_type']; ?>',
                title: '<?= $_SESSION['popup_title']; ?>',
                text: '<?= $_SESSION['popup_text']; ?>',
                confirmButtonColor: '#f0a500'
            });
        </script>
        <?php unset($_SESSION['popup_type'], $_SESSION['popup_title'], $_SESSION['popup_text']); ?>
    <?php endif; ?>
</body>
</html>