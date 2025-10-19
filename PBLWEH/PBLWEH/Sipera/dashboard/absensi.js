// Set nilai default input datetime-local ke waktu saat ini (di sisi klien)
        document.addEventListener('DOMContentLoaded', (event) => {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('waktu').value = now.toISOString().slice(0, 16);
        });

        // Tambahkan fungsi sederhana untuk demonstrasi (Tidak menyimpan data)
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman formulir default

            const nama = document.getElementById('nama').value;
            const status = document.getElementById('status').value;

            if (nama && status) {
                alert(`Terima kasih, ${nama}. Kehadiran Anda (${status}) telah dicatat!`);
                // Di sini Anda akan menambahkan kode untuk mengirim data ke server
                this.reset(); // Mengatur ulang formulir setelah pengiriman (simulasi)
                // Set ulang waktu ke saat ini
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                document.getElementById('waktu').value = now.toISOString().slice(0, 16);
            }
        });