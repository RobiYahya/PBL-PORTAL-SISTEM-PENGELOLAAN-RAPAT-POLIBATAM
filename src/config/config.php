<?php
// Nama File: config.php
// Deskripsi: File konfigurasi utama untuk Base URL dan Koneksi Database.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

// 1. Deteksi Protokol
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";

// 2. Deteksi Host
$host = $_SERVER['HTTP_HOST'];

// 3. Nama Folder Project
// PASTIKAN INI SESUAI DENGAN FOLDER DI HTDOCS
$path = '/sipera/public';

// 4. Gabungkan Semuanya
define('BASEURL', $protocol . $host . $path);

// --- Konfigurasi Database ---
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_sipera');