<?php
// MENCEGAH CACHE BROWSER
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
                        <button class="user-button">
                            Halo, <?= explode(' ', $_SESSION['nama'])[0]; ?>! ▾
                        </button>
                        <div class="user-dropdown-content">
                            <a href="<?= BASEURL; ?>/rapat">Rapat Saya</a>
                            <a href="<?= BASEURL; ?>/user/profile">Profil</a>
                            <a href="<?= BASEURL; ?>/auth/logout" style="color: red;">Keluar</a>
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