function displayFormData() {
        // Objek untuk memudahkan pengambilan data dari URL
        const urlParams = new URLSearchParams(window.location.search);

        // Fungsi helper untuk mengisi data ke elemen HTML
        const fillElement = (id, paramName) => {
            const element = document.getElementById(id);
            if (element) {
                // Mengambil nilai berdasarkan nama parameter ('name' dari input)
                const value = urlParams.get(paramName);
                element.textContent = value ? value.replace(/\+/g, ' ') : 'Tidak ada data';
            }
        };

        // Pemanggilan fungsi untuk setiap field
        fillElement('display-tanggal', 'tanggal');
        fillElement('display-waktu', 'waktu');
        fillElement('display-tempat', 'tempat');
        fillElement('display-pemimpin', 'pemimpin');
        fillElement('display-topik', 'topik');
        fillElement('display-pembahasan', 'pembahasan'); // Isi Notulen
        fillElement('display-keputusan', 'keputusan');  // Keputusan
        fillElement('display-notulis', 'notulis');
    }

    // Jalankan fungsi saat halaman selesai dimuat
    window.onload = displayFormData;

    // Pastikan pustaka jsPDF dimuat
    const { jsPDF } = window.jspdf;

    function downloadNotulen() {
        // Targetkan elemen kontainer utama yang ingin Anda download
        const element = document.querySelector('.container'); 
        
        // Opsional: Sembunyikan tombol download/print sementara agar tidak ikut tercetak di PDF
        const downloadBtn = document.querySelector('.download-button');
        const printBtn = document.querySelector('.print-button');
        if (downloadBtn) downloadBtn.style.display = 'none';
        if (printBtn) printBtn.style.display = 'none';


        html2canvas(element, { 
            scale: 2, // Meningkatkan resolusi untuk hasil PDF yang lebih jernih
            useCORS: true 
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF({
                orientation: 'portrait', // orientasi A4
                unit: 'mm',
                format: 'a4'
            });
            
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();
            
            const imgHeight = (canvas.height * pdfWidth) / canvas.width;
            
            // Tambahkan gambar (hasil konversi canvas) ke PDF
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, imgHeight);
            
            // Simpan file
            pdf.save("Notulen_Rapat_" + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + ".pdf");
            
            // Kembalikan tombol ke tampilan semula setelah selesai
            if (downloadBtn) downloadBtn.style.display = 'inline-block';
            if (printBtn) printBtn.style.display = 'inline-block';
        });
    }

    // ... (Fungsi displayFormData() yang sudah ada) ...
