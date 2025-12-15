<div style="height: 50px;"></div>

    <footer class="new-footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <div class="footer-brand">
                    <img src="<?= BASEURL; ?>/foto/logo.png" alt="Sipera Logo" class="footer-logo">
                    <h3>SIPERA</h3>
                </div>
                <p class="footer-desc">
                    Sistem Pengelolaan Rapat (SIPERA) Politeknik Negeri Batam. Solusi digital untuk manajemen jadwal, notulensi, dan absensi rapat yang efisien.
                </p>
                <div class="official-socials">
                    <a href="https://polibatam.ac.id" target="_blank" title="Website Polibatam"><i class="fas fa-globe"></i></a>
                    <a href="https://youtube.com/polibatam" target="_blank" title="YouTube Polibatam"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>QUICK LINKS</h4>
                <ul class="footer-links">
                    <li><a href="<?= BASEURL; ?>">Beranda</a></li>
                    <li><a href="<?= BASEURL; ?>/auth/login">Masuk</a></li>
                    <li><a href="<?= BASEURL; ?>/auth/register">Daftar</a></li>
                    <li><a href="https://learning.polibatam.ac.id" target="_blank">E-Learning</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>TIM PENGEMBANG</h4>
                <ul class="team-list">
                    <li>
                        <a href="https://www.instagram.com/haikal.zfmbrq?igsh=bjByc3FvbXJ1bTdx" target="_blank">
                            <i class="fab fa-instagram"></i> Haikal Mubaroq Zafia
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/robi_yahya3?igsh=MW8wcXZpd21udGQ0aw==" target="_blank">
                            <i class="fab fa-instagram"></i> Robi Yahya Harahap
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/voltrhiro?igsh=MXNuZjNuZDBjOHo1cg==" target="_blank">
                            <i class="fab fa-instagram"></i> Rangga Surya Saputra
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/fenni17v?igsh=bHZlNmw5MGE2dTA3" target="_blank">
                            <i class="fab fa-instagram"></i> Fenni Patrik Simanjuntak
                        </a>
                    </li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>CONTACT US</h4>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Ahmad Yani, Batam Kota, Kepulauan Riau, Indonesia</p>
                    <p><i class="fas fa-phone"></i> +62-877-6735-1842</p>
                    <p><i class="fas fa-envelope"></i> info@polibatam.ac.id</p>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2025 SIPERA Polibatam. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            if (menuToggle && navLinks) {
                menuToggle.addEventListener('click', function() {
                    menuToggle.classList.toggle('is-active');
                    navLinks.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>