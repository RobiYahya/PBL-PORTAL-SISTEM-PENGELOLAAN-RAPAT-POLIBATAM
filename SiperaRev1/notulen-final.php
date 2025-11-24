<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Notulen Rapat</title>
    <!-- Load Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Konfigurasi Tailwind untuk menggunakan font Poppins dan warna kustom -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'primary-bg': '#E0E5EC', // Warna latar belakang Neumorphism
                        'soft-gray': '#F0F2F5', // Warna elemen yang lebih cerah
                        'accent-blue': '#4F46E5', // Warna untuk tombol/link
                    },
                    boxShadow: {
                        'neo-out': '9px 9px 16px #A3B1C6, -9px -9px 16px #FFFFFF', // Shadow timbul (ekstrusi)
                        'neo-in': 'inset 5px 5px 10px #A3B1C6, inset -5px -5px 10px #FFFFFF', // Shadow tertekan (inset)
                    }
                }
            }
        }
    </script>
    <!-- Load Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    <!-- Gaya khusus untuk body dan separator agar terlihat Neumorphism -->
    <style>
        body {
            background-color: #E0E5EC;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        /* Custom separator to simulate a soft 3D line */
        .neumorphism-separator {
            border: none;
            height: 1px;
            background: linear-gradient(to right, #A3B1C6, #E0E5EC, #A3B1C6);
            margin: 2rem 0;
            opacity: 0.5;
        }
        /* Style for the logo placeholder since the original image file is local */
        .logo-placeholder {
            width: 40px;
            height: 40px;
            background-color: #4F46E5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="font-sans text-gray-700">


    <!-- Kontainer Utama dengan Efek Neumorphism Timbul (3D) -->
    <div class="container main-content-card w-11/12 max-w-4xl bg-primary-bg shadow-neo-out rounded-3xl p-6 md:p-10 my-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-6 text-center">Detail Notulen Rapat</h1>
        
        <h2 class="section-header text-xl font-semibold text-gray-600 mb-4 border-b pb-2 border-primary-bg">Detail Rapat</h2>
        
        <!-- Grup Detail dengan tata letak responsif -->
        <div class="detail-group grid grid-cols-1 md:grid-cols-2 gap-4 text-sm md:text-base">
            <div class="detail-row flex flex-col p-3 bg-primary-bg rounded-xl shadow-neo-out">
                <strong class="text-gray-500 font-medium mb-1">Tanggal Rapat:</strong>
                <span id="display-tanggal" class="font-bold text-gray-800">18/10/2025</span>
            </div>
            <div class="detail-row flex flex-col p-3 bg-primary-bg rounded-xl shadow-neo-out">
                <strong class="text-gray-500 font-medium mb-1">Waktu Rapat:</strong>
                <span id="display-waktu" class="font-bold text-gray-800">10:00</span>
            </div>
            <div class="detail-row flex flex-col p-3 bg-primary-bg rounded-xl shadow-neo-out">
                <strong class="text-gray-500 font-medium mb-1">Tempat / Ruang:</strong>
                <span id="display-tempat" class="font-bold text-gray-800">GU Ruang 701</span>
            </div>
            <div class="detail-row flex flex-col p-3 bg-primary-bg rounded-xl shadow-neo-out">
                <strong class="text-gray-500 font-medium mb-1">Pemimpin Rapat:</strong>
                <span id="display-pemimpin" class="font-bold text-gray-800">Prof. Dr. Andi Sudirman, M.Kom.</span>
            </div>
            <div class="detail-row md:col-span-2 flex flex-col p-3 bg-primary-bg rounded-xl shadow-neo-out">
                <strong class="text-gray-500 font-medium mb-1">Topik Rapat:</strong>
                <span id="display-topik" class="font-bold text-gray-800">Rapat Evaluasi Program Studi</span>
            </div>
        </div>

        <hr class="neumorphism-separator" />

        <h2 class="section-header text-xl font-semibold text-gray-600 mb-4">Isi Notulen (Poin-poin Pembahasan)</h2>

        <!-- Kotak Konten dengan Efek Neumorphism Tertekan (Inset) -->
        <div class="content-box w-full bg-primary-bg shadow-neo-in p-6 rounded-2xl min-h-[150px] whitespace-pre-line" id="display-isi-notulen">
            1. Pembukaan dan Agenda.
            2. Laporan Progres Program Semester Ganjil.
            3. Diskusi kendala pengajaran dan solusi.
            4. Pembahasan anggaran semester berikutnya.
        </div>

        <hr class="neumorphism-separator" />

        <h2 class="section-header text-xl font-semibold text-gray-600 mb-4">Keputusan Rapat & Tindak Lanjut</h2>
        
        <!-- Kotak Konten dengan Efek Neumorphism Tertekan (Inset) -->
        <div class="content-box w-full bg-primary-bg shadow-neo-in p-6 rounded-2xl min-h-[150px] whitespace-pre-line" id="display-keputusan">
            1. Ketua Prodi wajib meninjau ulang kurikulum mata kuliah X.
            2. Dosen Y ditugaskan membuat laporan keuangan.
            3. Rapat Tindak Lanjut akan diadakan pada 25 Oktober 2025.
        </div>

        <div class="footer-note mt-8 pt-4 border-t border-primary-bg flex justify-end text-right">
            <div>
                <strong class="text-gray-500 font-medium block">Nama Notulis:</strong>
                <span id="display-notulis" class="font-extrabold text-lg text-gray-800">Haikal Mubaroq Zafia</span>
            </div>
        </div>
    </div>
    


    <!-- Footer Neumorphism -->
    <footer class="footer w-full p-4 bg-primary-bg text-center text-xs text-gray-500 border-t border-gray-300 mt-auto">
        <p>&copy;2025 Sipera Notulen App - Desain Neumorphism 3D</p>
    </footer>

</body>
</html>