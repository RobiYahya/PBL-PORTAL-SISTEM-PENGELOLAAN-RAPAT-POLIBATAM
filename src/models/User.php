<?php

class User {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // 1. Ambil Semua User (Untuk List Undangan Rapat & Admin Panel)
    public function getAllUsers()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY nama_lengkap ASC');
        return $this->db->resultSet();
    }

    // 2. Ambil Satu User berdasarkan ID (Untuk Profil)
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_user=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // 3. Tambah User Baru (Register)
    public function tambahDataUser($data)
    {
        // Cek apakah NIK sudah ada?
        $this->db->query("SELECT * FROM " . $this->table . " WHERE nik = :nik");
        $this->db->bind('nik', $data['nik']);
        $this->db->execute();
        if($this->db->rowCount() > 0) {
            return 0; // Gagal, NIK duplikat
        }

        $query = "INSERT INTO " . $this->table . "
                    (nama_lengkap, nik, email, password, jabatan)
                  VALUES
                    (:nama, :nik, :email, :password, :jabatan)";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama_lengkap']);
        $this->db->bind('nik', $data['nik']);
        $this->db->bind('email', $data['email']);
        
        // Default jabatan jika tidak dipilih
        $jabatan = isset($data['jabatan']) ? $data['jabatan'] : 'dosen'; 
        $this->db->bind('jabatan', $jabatan);

        // Hash Password
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->bind('password', $passwordHash);

        $this->db->execute();

        return $this->db->rowCount();
    }

    // 4. Update Profil (Foto, Password, Nama)
    public function updateDataUser($data, $files)
    {
        $id = $_SESSION['user_id'];
        
        // 1. Siapkan Query Dasar
        $query = "UPDATE " . $this->table . " SET nama_lengkap = :nama, email = :email";
        
        // 2. Cek Password Baru
        if (!empty($data['password_baru'])) {
            $query .= ", password = :pass";
        }

        // 3. Cek Upload Foto
        $fotoBaru = null;
        if (isset($files['foto_profil']) && $files['foto_profil']['error'] === 0) {
            
            $namaFile = $files['foto_profil']['name'];
            $tmpName  = $files['foto_profil']['tmp_name'];
            $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            $valid    = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($ekstensi, $valid)) {
                // Nama Unik
                $fotoBaru = 'profile_' . $id . '_' . time() . '.' . $ekstensi;
                
                // Lokasi Simpan (Path Relative terhadap index.php)
                // Kita gunakan path yang sederhana karena kita sudah buat foldernya
                $tujuan = 'foto/profil/' . $fotoBaru;
                
                if (move_uploaded_file($tmpName, $tujuan)) {
                    $query .= ", foto = :foto";
                    
                    // (Opsional) Hapus foto lama
                    if(!empty($data['foto_lama']) && $data['foto_lama'] != 'default.png' && file_exists('foto/profil/' . $data['foto_lama'])){
                        unlink('foto/profil/' . $data['foto_lama']);
                    }
                }
            }
        }

        $query .= " WHERE id_user = :id";

        // Eksekusi Query
        $this->db->query($query);
        $this->db->bind('nama', $data['nama_lengkap']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('id', $id);

        if (!empty($data['password_baru'])) {
            $this->db->bind('pass', password_hash($data['password_baru'], PASSWORD_DEFAULT));
        }

        if ($fotoBaru) {
            $this->db->bind('foto', $fotoBaru);
        }

        $this->db->execute();
        
        // Update Session jika nama berubah
        if($this->db->rowCount() > 0) {
            $_SESSION['nama'] = $data['nama_lengkap'];
        }
        
        return $this->db->rowCount();
    }

    // 5. Cek Login (Untuk Auth)
    public function cekLogin($nik, $password)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE nik = :nik');
        $this->db->bind('nik', $nik);
        $user = $this->db->single();

        if($user) {
            if(password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    // Cek Undangan Baru (Unread)
    public function getUndanganBaru($userId)
    {
        // Ambil judul rapat dimana user ini jadi peserta DAN statusnya masih 'unread'
        $query = "SELECT r.judul_rapat 
                FROM peserta p
                JOIN rapat r ON p.id_rapat = r.id_rapat
                WHERE p.id_user = :uid AND p.notifikasi_status = 'unread'";
        
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        return $this->db->resultSet();
    }

    // Tandai Undangan Sudah Dibaca (Supaya popup tidak muncul terus)
    public function tandaiUndanganDibaca($userId)
    {
        $query = "UPDATE peserta SET notifikasi_status = 'read' WHERE id_user = :uid";
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        $this->db->execute();
    }
}