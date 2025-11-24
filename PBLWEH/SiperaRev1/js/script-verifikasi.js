document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('verificationForm');
    const rapatIdInput = document.getElementById('rapatId');
    const rapatIdDisplay = document.getElementById('rapat-id-display');

    // 1. Ambil ID Rapat dari URL (query parameter)
    const urlParams = new URLSearchParams(window.location.search);
    const rapatId = urlParams.get('id');

    if (rapatId) {
        rapatIdInput.value = rapatId;
        rapatIdDisplay.textContent = rapatId;
    } else {
        rapatIdDisplay.textContent = "Tidak Ditemukan";
        // Opsional: Alihkan ke halaman error atau beranda jika ID tidak ada
        // window.location.href = 'home-page.html';
    }

    // 2. Fungsi Validasi Form
    function validateForm() {
        let isValid = true;
        
        // Ambil Nilai
        const nama = document.getElementById('nama').value.trim();
        const nimNip = document.getElementById('nim_nip').value.trim();
        const email = document.getElementById('email').value.trim();
        
        // Cek Nama
        if (nama === "") {
            displayError('nama', 'Nama wajib diisi.');
            isValid = false;
        } else {
            clearError('nama');
        }

        // Cek NIM/NIP
        if (nimNip === "") {
            displayError('nim_nip', 'NIM/NIP wajib diisi.');
            isValid = false;
        } else {
            clearError('nim_nip');
        }

        // Cek Email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            displayError('email', 'Email wajib diisi.');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            displayError('email', 'Format email tidak valid.');
            isValid = false;
        } else {
            clearError('email');
        }

        return isValid;
    }

    // 3. Fungsi Tampilkan/Hapus Error
    function displayError(field, message) {
        document.getElementById(`error-${field}`).textContent = message;
        document.getElementById(`error-${field}`).style.display = 'block';
        document.getElementById(field).style.borderColor = '#dc3545';
    }

    function clearError(field) {
        document.getElementById(`error-${field}`).textContent = '';
        document.getElementById(`error-${field}`).style.display = 'none';
        document.getElementById(field).style.borderColor = 'transparent';
    }

    // 4. Handle Submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (validateForm()) {
            // Lakukan pengiriman data (simulasi)
            const data = {
                nama: document.getElementById('nama').value.trim(),
                nim_nip: document.getElementById('nim_nip').value.trim(),
                email: document.getElementById('email').value.trim(),
                rapat_id: rapatIdInput.value
            };

            // ---- SIMULASI PENYIMPANAN DATA SEMENTARA (OPSIONAL) ----
            console.log('Data Verifikasi Tersimpan:', data);
            
            // Simpan status akses ke Session Storage (agar tidak perlu mengisi lagi)
            sessionStorage.setItem('tempAccessGranted', 'true');
            sessionStorage.setItem('tempUserData', JSON.stringify({
                nama: data.nama,
                nim: data.nim_nip
            }));

            // ---- PENGALIHAN KE HALAMAN DETAIL RAPAT ----
            alert(`Verifikasi berhasil! Mengalihkan ke detail rapat ID ${rapatId}.`);
            window.location.href = `detail-rapat.html?id=${rapatId}`;
        }
    });
});