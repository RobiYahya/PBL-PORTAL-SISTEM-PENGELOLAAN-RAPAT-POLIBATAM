-- ============================================
-- DATABASE SETUP UNTUK SIPERA
-- ============================================
-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS db_sipera CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_sipera;

-- ============================================
-- TABEL USERS (untuk login dan registrasi)
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nik VARCHAR(50) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    jabatan VARCHAR(50) DEFAULT 'mahasiswa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL RAPAT (untuk data rapat)
-- ============================================
CREATE TABLE IF NOT EXISTS rapat (
    id_rapat INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    judul_rapat VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    tanggal_rapat DATETIME,
    lokasi VARCHAR(100),
    status ENUM('draft', 'terjadwal', 'selesai', 'dibatalkan') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL NOTULEN (untuk catatan rapat)
-- ============================================
CREATE TABLE IF NOT EXISTS notulen (
    id_notulen INT PRIMARY KEY AUTO_INCREMENT,
    id_rapat INT NOT NULL,
    konten TEXT,
    penulis INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rapat) REFERENCES rapat(id_rapat) ON DELETE CASCADE,
    FOREIGN KEY (penulis) REFERENCES users(id_user) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL PESERTA RAPAT
-- ============================================
CREATE TABLE IF NOT EXISTS peserta_rapat (
    id_peserta INT PRIMARY KEY AUTO_INCREMENT,
    id_rapat INT NOT NULL,
    id_user INT NOT NULL,
    status_kehadiran ENUM('hadir', 'tidak_hadir', 'izin') DEFAULT 'hadir',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rapat) REFERENCES rapat(id_rapat) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    UNIQUE KEY unique_peserta (id_rapat, id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATA CONTOH UNTUK TESTING
-- ============================================
-- User admin (password: admin123)
INSERT IGNORE INTO users (nik, nama_lengkap, email, password, jabatan) VALUES
('3312501035', 'Admin Sipera', 'admin@polibatam.ac.id', '$2y$10$YIjlrHzJ8DjWQVwQMNtM2eL5nW7vZpQKqX1L5vF5cKDqHvH5uC8Gy', 'admin');

-- User contoh (password: password123)
INSERT IGNORE INTO users (nik, nama_lengkap, email, password, jabatan) VALUES
('3312501001', 'Budi Santoso', 'budi@polibatam.ac.id', '$2y$10$pKqkQvnHxRzFqF8xT1nU8OkVjZ0cL2H5P7nC9mR3Q5vX6wZ8aB1Pu', 'mahasiswa');

-- ============================================
-- INFORMASI PENTING
-- ============================================
-- Password untuk admin: admin123
-- Password untuk user: password123
-- 
-- Untuk membuat password hash baru, gunakan:
-- password_hash('password_anda', PASSWORD_DEFAULT)
-- 
-- Koneksi database:
-- Host: localhost
-- User: root
-- Password: (kosong)
-- Database: db_sipera
-- Port: 3306
