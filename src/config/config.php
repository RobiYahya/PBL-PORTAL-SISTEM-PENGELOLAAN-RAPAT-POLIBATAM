<?php

// 1. Deteksi Protokol (HTTP atau HTTPS)
// XAMPP default biasanya http, tapi script ini jaga-jaga kalau kau pakai SSL
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";

// 2. Deteksi Host
// Ini akan otomatis berisi 'localhost' jika kau buka di laptop,
// atau '192.168.x.x' jika kau buka di HP.
$host = $_SERVER['HTTP_HOST'];

// 3. Nama Folder Project
// GANTI 'sipera' JIKA NAMA FOLDER DI HTDOCS-MU BEDA
$path = '/sipera/public';

// 4. Gabungkan Semuanya
define('BASEURL', $protocol . $host . $path);

// --- Konfigurasi Database (Tetap Localhost) ---
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_sipera');