<?php
// public/index.php

// 1. Mulai Sesi (Wajib untuk Login)
if( !session_id() ) session_start();

// 2. Panggil file Konfigurasi & Helper (Jika ada)
require_once '../src/config/config.php'; // Pastikan file ini ada!
// require_once '../src/core/Flasher.php'; // Jika sudah buat Flasher

// 3. Panggil Otak Utama (Core MVC)
require_once '../src/core/App.php';
require_once '../src/core/Controller.php';
require_once '../src/core/Database.php';
// (Atau gunakan spl_autoload_register kalau kau sudah paham, tapi manual dulu biar aman)

// 4. Jalankan Aplikasi
$app = new App();