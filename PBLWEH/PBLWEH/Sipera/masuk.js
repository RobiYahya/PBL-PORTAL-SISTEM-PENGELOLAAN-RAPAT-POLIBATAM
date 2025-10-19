document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const nama = document.getElementById('nama');
        const nim = document.getElementById('nim');
        const password = document.getElementById('password');
        
        resetErrors();

        let isValid = true;

        if (nama.value.trim() === '') {
            showError('namaError', 'Nama tidak boleh kosong');
            isValid = false;
        }

        if (nim.value.trim() === '' || !/^\d{10}$/.test(nim.value)) {
            showError('nimError', 'NIM harus terdiri dari 10 digit angka');
            isValid = false;
        }

        if (password.value.trim() === '') {
            showError('passwordError', 'Password tidak boleh kosong');
            isValid = false;
        }

        if (isValid) {
            alert('Login Berhasil! Anda akan diarahkan ke halaman dashboard.');
            window.location.href = 'dashboard/dashboard.html';
        }
    });

    function showError(errorElementId, message) {
        const errorElement = document.getElementById(errorElementId);
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function resetErrors() {
        const errorMessages = loginForm.querySelectorAll('.error-message');
        errorMessages.forEach(msg => {
            msg.style.display = 'none';
        });
    }
});