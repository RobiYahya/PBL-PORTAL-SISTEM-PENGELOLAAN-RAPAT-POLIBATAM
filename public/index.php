<?php
// public/index.php

if( !session_id() ) session_start();

// Config
require_once '../src/config/config.php';

// Core MVC (WAJIB URUT)
require_once '../src/core/App.php';
require_once '../src/core/Controller.php';
require_once '../src/core/Database.php';
require_once '../src/core/Flasher.php'; // <--- INI WAJIB DINYALAKAN!

// Jalankan
$app = new App();