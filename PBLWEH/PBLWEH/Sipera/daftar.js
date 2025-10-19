document.addEventListener('DOMContentLoaded', () => {
    const registrationForm = document.getElementById('registrationForm');

    registrationForm.addEventListener('submit', function(event) {
        event.preventDefault(); 
        
        const name = document.getElementById('name');
        const nim = document.getElementById('nim');
        const email = document.getElementById('email');
        const whatsapp = document.getElementById('whatsapp');
        const password = document.getElementById('password');

        resetErrors();

        let isValid = true;

        if (name.value.trim() === '') {
            showError('nameError', 'Nama tidak boleh kosong');
            isValid = false;
        }

        if (!/^\d{10}$/.test(nim.value)) {
            showError('nimError', 'NIM harus terdiri dari 10 digit angka');
            isValid = false;
        }
        
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email.value)) {
            showError('emailError', 'Format email tidak valid');
            isValid = false;
        }

        if (!/^\d{10,15}$/.test(whatsapp.value)) {
            showError('whatsappError', 'Nomor WhatsApp harus 10-15 digit');
            isValid = false;
        }

        if (password.value.length < 6) {
            showError('passwordError', 'Password minimal harus 6 karakter');
            isValid = false;
        }

        if (isValid) {
            alert('Pendaftaran Berhasil! Anda akan diarahkan ke halaman masuk.');
            window.location.href = 'masuk.html';
        }
    });

    function showError(errorElementId, message) {
        const errorElement = document.getElementById(errorElementId);
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function resetErrors() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(msg => {
            msg.style.display = 'none';
        });
    }
});