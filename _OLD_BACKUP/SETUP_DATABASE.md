# 📚 PANDUAN SETUP DATABASE SIPERA

## Cara Membuat Database di MySQL

### **Opsional: Otomatis (menggunakan `setup.php`)**

Jika Anda ingin menjalankan `setup_database.sql` secara otomatis tanpa membuka phpMyAdmin, ada file helper `setup.php` di root project.

- **Via browser (mudah)**: buka
   `http://localhost/PBL-PORTAL-SISTEM-PENGELOLAAN-RAPAT-POLIBATAM/setup.php` lalu klik tombol **Run Setup**.

- **Via PowerShell / CLI (otomatis)**: jalankan perintah berikut dari folder project:

```powershell
cd C:\xampp\htdocs\PBL-PORTAL-SISTEM-PENGELOLAAN-RAPAT-POLIBATAM
php setup.php --yes
# Jika PHP tidak di PATH, gunakan:
C:\xampp\php\php.exe setup.php --yes
```

Catatan keamanan: `setup.php` akan mengeksekusi isi `database/setup_database.sql` apa adanya dan **tidak** menghapus database yang sudah ada secara default. Gunakan `--yes` hanya jika Anda yakin.

### **Metode 1: Menggunakan phpMyAdmin (TERMUDAH)**

1. **Buka phpMyAdmin**
   - Buka browser
   - Ketik: `http://localhost/phpmyadmin`
   - Login dengan user: `root` (password kosong)

2. **Buat Database**
   - Klik menu **"Databases"** di atas
   - Di bagian "Create database", ketik: `db_sipera`
   - Pilih collation: `utf8mb4_unicode_ci`
   - Klik **"Create"**

3. **Import SQL File**
   - Klik database **`db_sipera`** yang baru dibuat
   - Pilih tab **"Import"** di atas
   - Klik **"Choose File"**
   - Pilih file: `database/setup_database.sql` (ada di project)
   - Klik **"Import"**
   - Tunggu sampai selesai (akan muncul pesan hijau)

✅ Database sudah siap dengan tabel dan data contoh!

---

### **Metode 2: Menggunakan Command Line MySQL**

1. **Buka Command Prompt / PowerShell**
   ```
   cd c:\xampp\mysql\bin
   ```

2. **Login ke MySQL**
   ```
   mysql -u root
   ```

3. **Buat Database**
   ```sql
   CREATE DATABASE db_sipera;
   USE db_sipera;
   ```

4. **Import File SQL**
   ```
   mysql -u root db_sipera < C:\xampp\htdocs\PBL-PORTAL-SISTEM-PENGELOLAAN-RAPAT-POLIBATAM\database\setup_database.sql
   ```

5. **Verifikasi**
   ```sql
   SHOW TABLES;
   SELECT * FROM users;
   ```

---

### **Metode 3: Manual (Copy-Paste SQL)**

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Buat database `db_sipera`**
3. **Klik tab "SQL"**
4. **Copy seluruh isi file `setup_database.sql`**
5. **Paste ke text area SQL**
6. **Klik "Go" / "Execute"**

---

## ✅ Struktur Database yang Dibuat

### **Tabel `users` (Users & Auth)**
```
id_user          (INT - Primary Key, Auto Increment)
nik              (VARCHAR - Unik, untuk login)
nama_lengkap     (VARCHAR)
email            (VARCHAR - Unik)
password         (VARCHAR - Terenkripsi)
jabatan          (VARCHAR - Default: 'mahasiswa')
created_at       (TIMESTAMP)
updated_at       (TIMESTAMP)
```

### **Tabel `rapat` (Data Rapat)**
```
id_rapat         (INT - Primary Key)
id_user          (INT - Foreign Key ke users)
judul_rapat      (VARCHAR)
deskripsi        (TEXT)
tanggal_rapat    (DATETIME)
lokasi           (VARCHAR)
status           (ENUM: draft, terjadwal, selesai, dibatalkan)
created_at       (TIMESTAMP)
updated_at       (TIMESTAMP)
```

### **Tabel `notulen` (Catatan Rapat)**
```
id_notulen       (INT - Primary Key)
id_rapat         (INT - Foreign Key ke rapat)
konten           (TEXT)
penulis          (INT - Foreign Key ke users)
created_at       (TIMESTAMP)
updated_at       (TIMESTAMP)
```

### **Tabel `peserta_rapat` (Kehadiran Peserta)**
```
id_peserta       (INT - Primary Key)
id_rapat         (INT - Foreign Key ke rapat)
id_user          (INT - Foreign Key ke users)
status_kehadiran (ENUM: hadir, tidak_hadir, izin)
created_at       (TIMESTAMP)
```

---

## 🔐 Data Testing yang Sudah Ada

### **User Admin**
- **NIM/NIP**: `3312501035`
- **Password**: `admin123`
- **Email**: `admin@polibatam.ac.id`
- **Jabatan**: admin

### **User Contoh**
- **NIM/NIP**: `3312501001`
- **Password**: `password123`
- **Email**: `budi@polibatam.ac.id`
- **Jabatan**: mahasiswa

---

## 🔗 Koneksi Database di Aplikasi

File `koneksi.php` sudah dikonfigurasi dengan:
```php
$host     = "localhost";
$user     = "root";
$password = "";
$database = "db_sipera";
```

✅ **Sudah otomatis terhubung ke aplikasi!**

---

## 📝 Membuat User Baru dengan Password Hash

Jika ingin menambah user baru, gunakan password hash:

```php
<?php
// Generate password hash
$password = "password_anda";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash: " . $hash;
?>
```

Kemudian insert ke database:
```sql
INSERT INTO users (nik, nama_lengkap, email, password, jabatan) 
VALUES ('3312501999', 'Nama Lengkap', 'email@polibatam.ac.id', 'HASH_YANG_DIHASILKAN', 'mahasiswa');
```

---

## ✅ Checklist Setup

- [ ] Database `db_sipera` sudah dibuat
- [ ] Tabel `users`, `rapat`, `notulen`, `peserta_rapat` sudah dibuat
- [ ] Data testing (admin & user contoh) sudah ada
- [ ] Koneksi di `koneksi.php` sudah benar
- [ ] Bisa login dengan NIM: `3312501035` dan Password: `admin123`

---

## 🚀 Siap Digunakan!

Setelah setup database selesai, aplikasi sudah siap digunakan:
- Login: `http://localhost/PBL-PORTAL-SISTEM-PENGELOLAAN-RAPAT-POLIBATAM/masuk.php`
- Registrasi: `http://localhost/PBL-PORTAL-SISTEM-PENGELOLAAN-RAPAT-POLIBATAM/daftar.php`
