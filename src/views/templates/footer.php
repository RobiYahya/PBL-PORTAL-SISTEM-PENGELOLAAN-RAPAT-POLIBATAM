<footer class="footer">
        <div class="container footer-content">
            <p>&copy; 2025 All rights reserved.</p>
        </div>
    </footer>

    <script>
    function toggleNotifications() {
        const dropdown = document.getElementById('notificationDropdown');
        if(dropdown) dropdown.classList.toggle('show');
    }

    // Simulasikan penyimpanan status bintang ke Local Storage
    const starredNotifications = JSON.parse(localStorage.getItem('starredNotifs')) || [];

    document.addEventListener('DOMContentLoaded', () => {
        // Listener untuk menutup dropdown saat klik di luar
        document.addEventListener('click', function(event) {
            const dropdownArea = document.querySelector('.notification-dropdown');
            if (dropdownArea && !dropdownArea.contains(event.target)) {
                const dropdownContent = document.getElementById('notificationDropdown');
                if(dropdownContent) dropdownContent.classList.remove('show');
            }
        });

        // Script untuk User Dropdown (Jika ada)
        const userButton = document.querySelector('.user-button');
        const userDropdown = document.querySelector('.user-dropdown-content');
        if (userButton && userDropdown) {
            userButton.addEventListener('click', function() {
                userDropdown.style.display = 
                    userDropdown.style.display === 'block' ? 'none' : 'block';
            });
        }
    });
    </script>
</body>
</html>