document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.login-form');
    
    // =======================================================
    // DEFINISI AKUN ADMIN (Hardcode untuk keperluan frontend)
    // Username: adminutama
    // Password: sipera2025
    // =======================================================
    const VALID_USERNAME = 'adminutama'; 
    const VALID_PASSWORD = 'sipera2025'; 
    const DASHBOARD_URL = 'dashboard-admin.html'; // Tentukan halaman tujuan

    function validateForm(event) {
        // Mencegah pengiriman form default untuk mengontrol alur secara manual
        event.preventDefault(); 
        
        const usernameInput = document.getElementById('username'); 
        const passwordInput = document.getElementById('password');

        const enteredUsername = usernameInput.value.trim();
        const enteredPassword = passwordInput.value.trim();

        // 1. Validasi Kolom Kosong
        if (enteredUsername === '' || enteredPassword === '') {
            alert('ID Pengguna dan Kata Sandi wajib diisi untuk masuk.');
            
            // Fokus ke input yang kosong
            if (enteredUsername === '') {
                usernameInput.focus();
            } else {
                passwordInput.focus();
            }
            return; 
        }

        // 2. Validasi Akun dan Sandi yang Benar
        if (enteredUsername === VALID_USERNAME && enteredPassword === VALID_PASSWORD) {
            // Jika BERHASIL, arahkan pengguna ke halaman dashboard
            window.location.href = DASHBOARD_URL; 
            return;
        } else {
            // Jika GAGAL
            alert('ID Pengguna atau Kata Sandi salah. Akses Ditolak!');
            passwordInput.value = ''; // Kosongkan field sandi
            passwordInput.focus();
            return;
        }
    }

    // Menghubungkan validasi ke event submit form
    if (form) {
        form.addEventListener('submit', validateForm);
    }
    
    // Menambahkan efek visual sederhana saat input difokuskan
    const inputs = document.querySelectorAll('.input-group input'); 

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.classList.add('input-focused');
        });

        input.addEventListener('blur', () => {
            input.classList.remove('input-focused');
        });
    });
});