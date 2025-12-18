# SIPERA — Sistem Pengelolaan Rapat Polibatam

![Banner SIPERA](public/foto/logo.png)

> **Project Based Learning (PBL)**
> Program Studi Teknik Informatika — Politeknik Negeri Batam
> Semester 1 | Tahun Ajaran 2025

---

## 📌 Deskripsi Project

**SIPERA (Sistem Pengelolaan Rapat)** adalah aplikasi berbasis web yang dikembangkan untuk mendigitalkan dan menyederhanakan proses manajemen rapat di lingkungan Politeknik Negeri Batam.

Aplikasi ini mencakup seluruh siklus rapat, mulai dari pengajuan jadwal, pengelolaan undangan, absensi digital, hingga pengarsipan notulen rapat secara terpusat.

SIPERA dibangun menggunakan **PHP Native** dengan pendekatan arsitektur **MVC (Model–View–Controller)** untuk memastikan struktur kode yang terorganisir, mudah dipahami, dan mudah dikembangkan.

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Hak Akses

* Login berbasis **Nomor Induk Karyawan (NIK)**
* **Role-Based Access Control (RBAC):**

  * **Admin:** Manajemen user, persetujuan atau penolakan pengajuan rapat
  * **Dosen/Staff:** Pengajuan rapat, absensi, dan akses notulen
* Keamanan password menggunakan `password_hash()`

### 📅 Manajemen Rapat

* Dashboard interaktif dengan filter status rapat
* Pengajuan rapat lengkap (agenda, waktu, ruangan)
* Undangan otomatis ke peserta rapat
* Pencarian rapat secara real-time tanpa reload halaman

### ✅ Absensi & Notulen

* Absensi digital dengan status kehadiran
* Upload notulen rapat (PDF/DOCX)
* Download notulen oleh peserta rapat

### 👤 Manajemen Pengguna

* Edit profil pengguna
* Ganti password
* Notifikasi undangan rapat

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP 8.x (OOP & MVC)
* **Frontend:** HTML5, CSS3 (Custom Neumorphism UI), JavaScript (Vanilla)
* **Database:** MySQL / MariaDB
* **Library Pendukung:**

  * SweetAlert2
  * Flatpickr
  * FontAwesome

---

## 📂 Struktur Folder

```text
sipera/
├── assets/             # Dokumentasi dan screenshot
├── public/             # Folder publik
│   ├── css/            # Stylesheet
│   ├── foto/           # Logo & foto profil
│   ├── files/          # File notulen rapat
│   └── index.php       # Entry point aplikasi
├── src/
│   ├── config/         # Konfigurasi aplikasi & database
│   ├── controllers/   # Controller (alur logika)
│   ├── core/           # Core system
│   ├── models/         # Model & query database
│   └── views/          # Tampilan aplikasi
└── README.md
```

---

## 🚀 Instalasi

1. **Clone repository**

   ```bash
   git clone https://github.com/RobiYahya/PBL-PORTAL-SISTEM-PENGELOLAAN-RAPAT-POLIBATAM.git
   ```

2. **Konfigurasi Database**

   * Jalankan Apache & MySQL (XAMPP)
   * Buat database `db_sipera`
   * Import file `db_sipera.sql`

3. **Konfigurasi Aplikasi**

   * Pindahkan project ke `htdocs`
   * Edit file `src/config/config.php`

   ```php
   define('BASEURL', 'http://localhost/sipera/public');
   define('DB_NAME', 'db_sipera');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

4. **Jalankan Aplikasi**

   * Akses melalui browser:
     `http://localhost/sipera/public`

---

## 🔑 Akun Demo

**Admin**
* NIK: `213162`
* Password: `admin#No1`

**User**

* NIK: `112094`
* Password: `12345`

---

## 🖼️ Screenshot Aplikasi

Berikut beberapa tampilan utama dari aplikasi **SIPERA**:

### Halaman Login
Halaman autentikasi awal yang digunakan pengguna untuk masuk ke sistem SIPERA dengan memasukkan Nomor Induk Karyawan (NIK) dan password sesuai dengan hak akses masing-masing role (Admin atau User).
![Login](assets/login_preview.png)

### Dashboard User
Menampilkan daftar rapat yang diikuti oleh pengguna, lengkap dengan informasi jadwal, status rapat, serta akses cepat menuju detail rapat dan notulen.
![Dashboard User](assets/dashboard_preview.png)

### Buat Rapat
Halaman formulir pengajuan rapat yang digunakan oleh dosen atau staf untuk menentukan agenda rapat, waktu pelaksanaan, lokasi, serta peserta yang akan diundang.
![Buat Rapat](assets/create_preview.png)

### Detail Rapat
Menampilkan informasi lengkap mengenai rapat, termasuk agenda, daftar peserta, status kehadiran, serta fitur unggah dan unduh notulen setelah rapat selesai.
![Detail](assets/detail_preview.png)

---

## 👥 Tim Pengembang

* **Haikal Mubaroq Zafia** — Fullstack Developer
* **Robi Yahya Harahap** — Frontend & UI Designer
* **Rangga Surya Saputra** — Backend Developer
* **Fenni Patrik Simanjuntak** — Dokumentasi & Testing

---

## 📄 Lisensi

© 2025 SIPERA Polibatam.
Project ini dibuat untuk keperluan akademik (Project Based Learning).
