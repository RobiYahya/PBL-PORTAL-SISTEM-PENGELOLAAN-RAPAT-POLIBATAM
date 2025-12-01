<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notulen - Portal Rapat Polibatam</title>
    <link rel="stylesheet" href="./public/css/style-buat-notulen.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet" />
</head>

<body>
    <header class="top-navbar">
        <div class="navbar-left">
            <a href="dashboard.html">
                <img src="./public/foto/logo.png" alt="Logo Sipera" class="logo" />
            </a>
        </div>
        <div class="navbar-right">
            <a href="rapat-saya.html" class="nav-link">Kembali</a>
        </div>
    </header>

    <main class="container notulen-main">
        <h1 class="main-title">📝 Input Notulen Rapat</h1>

        <section class="notulen-form-section neumorphism-card">
            <h2>Detail Rapat</h2>
            <form id="notulen-form" action="notulen-final.html" method="get">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Rapat:</label>
                        <input type="date" id="tanggal" name="tanggal" placeholder="dd/mm/yyyy" />
                    </div>

                    <div class="form-group">
                        <label for="waktu">Waktu Rapat:</label>
                        <input type="time" id="waktu" name="waktu" placeholder="--:--" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="tempat">Tempat / Ruang Rapat:</label>
                    <input type="text" id="tempat" name="tempat" placeholder="Contoh: GU Ruang 701" />
                </div>

                <div class="form-group">
                    <label for="pemimpin">Pemimpin Rapat:</label>
                    <input type="text" id="pemimpin" name="pemimpin" placeholder="Nama Pemimpin" />
                </div>

                <div class="form-group">
                    <label for="topik">Topik Rapat:</label>
                    <input type="text" id="topik" name="topik" placeholder="Contoh: Rapat Jurusan" />
                </div>

                <hr class="separator neumorphism-separator" />

                <h2>Isi Notulen</h2>
                <div class="form-group">
                    <label for="pembahasan">Poin-poin Pembahasan (Gunakan poin per baris):</label>
                    <textarea id="pembahasan" name="pembahasan" rows="15"
                        placeholder="1. Pembukaan dan Agenda. 2. Laporan Progres. 3. ..."></textarea>
                </div>

                <div class="form-group">
                    <label for="keputusan">Keputusan Rapat & Tindak Lanjut:</label>
                    <textarea id="keputusan" name="keputusan" rows="10"
                        placeholder="Tuliskan keputusan rapat dalam bentuk poin atau daftar tugas"></textarea>
                </div>

                <div class="form-group">
                    <label for="notulis">Nama Notulis:</label>
                    <input type="text" id="notulis" name="notulis" placeholder="Nama Notulis Rapat" />
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-save btn-primary-style">
                        Simpan Notulen
                    </button>
                    <button type="reset" class="btn btn-reset btn-secondary-style">
                        Reset Form
                    </button>
                </div>
                <div class="loading"></div>
            </form>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; 2025 Sipera Notulen App</p>
        </div>
    </footer>

    <script>
    /**
     * js/notulen.js
     * Fungsi untuk validasi formulir dan menambahkan feedback pengguna
     */

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('notulen-form');
        const loadingDiv = document.querySelector('.loading');

        // Tambahkan event listener untuk submit form
        if (form) {
            form.addEventListener('submit', function(event) {

                // 1. Mencegah submit default
                event.preventDefault();

                // 2. Lakukan Validasi
                if (validateForm(form)) {

                    // 3. Tampilkan Loading Status dan Sembunyikan Tombol
                    showLoading();

                    // 4. Proses Pengiriman (Simulasi)
                    // Dalam skenario nyata, di sinilah Anda akan menggunakan
                    // fetch() atau XMLHttpRequest untuk mengirim data ke server.

                    // Karena action form Anda adalah "hasil-notulen.html", 
                    // kita akan menunda pengiriman (submit) form selama 1 detik
                    // untuk mensimulasikan proses loading.
                    setTimeout(() => {
                        // Setelah selesai loading, lanjutkan pengiriman form
                        form.submit();
                    }, 1000);

                } else {
                    alert('Mohon lengkapi semua bidang yang wajib diisi sebelum menyimpan notulen.');
                }
            });
        }

        /**
         * Fungsi untuk validasi semua input yang dibutuhkan
         * @param {HTMLFormElement} formElement - Elemen formulir yang akan divalidasi
         * @returns {boolean} True jika semua valid, False jika ada yang kosong
         */
        function validateForm(formElement) {
            let isValid = true;

            // Ambil semua input dan textarea (kecuali tombol)
            const requiredFields = formElement.querySelectorAll(
                'input:not([type="submit"]):not([type="reset"]), textarea'
            );

            requiredFields.forEach(field => {
                // Hapus kelas error sebelumnya
                field.classList.remove('input-error');

                // Cek jika bidang kosong (trim untuk menghilangkan spasi)
                if (field.value.trim() === '') {
                    isValid = false;
                    field.classList.add('input-error');
                }
            });

            return isValid;
        }

        /**
         * Fungsi untuk menampilkan indikator loading
         */
        function showLoading() {
            loadingDiv.innerHTML = '<div class="spinner"></div> Sedang memproses notulen...';
            loadingDiv.style.display = 'flex';

            // Sembunyikan tombol saat loading
            document.querySelector('.form-actions').style.display = 'none';
        }

        /**
         * Fungsi untuk menyembunyikan indikator loading (Jika tidak redirect, ini akan dipanggil)
         */
        // function hideLoading() {
        //     loadingDiv.style.display = 'none';
        //     document.querySelector('.form-actions').style.display = 'flex';
        // }
    });
    </script>
</body>

</html>