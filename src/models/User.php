<?php
// Nama File: User.php
// Deskripsi: Model untuk mengelola data pengguna (CRUD User, Login, Profil).

class User {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // 1. Ambil Semua User
    public function getAllUsers()
    {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY nama_lengkap ASC");
        return $this->db->resultSet();
    }

    // 2. Ambil Satu User berdasarkan ID
    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_user=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // [BARU] Cek apakah email sudah ada (Untuk Validasi Register)
    public function cekEmail($email)
    {
        $this->db->query("SELECT email FROM " . $this->table . " WHERE email = :email");
        $this->db->bind('email', $email);
        $this->db->execute();
        return $this->db->rowCount(); // Mengembalikan 1 jika ada, 0 jika tidak
    }

    // 3. Tambah User Baru (Register)
    public function tambahDataUser($data)
    {
        // Cek NIK Duplikat
        $this->db->query("SELECT nik FROM " . $this->table . " WHERE nik = :nik");
        $this->db->bind('nik', $data['nik']);
        $this->db->execute();
        
        if($this->db->rowCount() > 0) {
            return 0; // Gagal, NIK sudah ada
        }

        $query = "INSERT INTO " . $this->table . " 
                    (nama_lengkap, nik, email, password, jabatan)
                  VALUES
                    (:nama, :nik, :email, :password, :jabatan)";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama_lengkap']);
        $this->db->bind('nik', $data['nik']);
        $this->db->bind('email', $data['email']);
        
        $jabatan = isset($data['jabatan']) ? $data['jabatan'] : 'dosen'; 
        $this->db->bind('jabatan', $jabatan);

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->bind('password', $passwordHash);

        $this->db->execute();
        return $this->db->rowCount();
    }

    // 4. Update Profil
    public function updateDataUser($data, $files)
    {
        // PERINGATAN: Mengakses $_SESSION di Model adalah bad practice (Coupling).
        // Tapi aku biarkan agar kodemu tetap jalan.
        $id = $_SESSION['user_id'];
        
        $query = "UPDATE " . $this->table . " SET nama_lengkap = :nama, email = :email";
        
        if (!empty($data['password_baru'])) {
            $query .= ", password = :pass";
        }

        $fotoBaru = null;
        if (isset($files['foto_profil']) && $files['foto_profil']['error'] === 0) {
            $namaFile = $files['foto_profil']['name'];
            $tmpName  = $files['foto_profil']['tmp_name'];
            $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            $valid    = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($ekstensi, $valid)) {
                $fotoBaru = 'profile_' . $id . '_' . time() . '.' . $ekstensi;
                $tujuan = 'foto/profil/' . $fotoBaru;
                
                if (move_uploaded_file($tmpName, $tujuan)) {
                    $query .= ", foto = :foto";
                    
                    // Hapus foto lama jika ada
                    if(!empty($data['foto_lama']) && $data['foto_lama'] != 'default.png' && file_exists('foto/profil/' . $data['foto_lama'])){
                        unlink('foto/profil/' . $data['foto_lama']);
                    }
                }
            }
        }

        $query .= " WHERE id_user = :id";

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
        
        if($this->db->rowCount() > 0) {
            $_SESSION['nama'] = $data['nama_lengkap'];
        }
        
        return $this->db->rowCount();
    }

    // 5. Cek Login
    public function cekLogin($nik, $password)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE nik = :nik");
        $this->db->bind('nik', $nik);
        $user = $this->db->single();

        if($user) {
            if(password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    // Notifikasi: Cek Undangan Baru
    public function getUndanganBaru($userId)
    {
        $query = "SELECT r.judul_rapat 
                  FROM peserta p
                  JOIN rapat r ON p.id_rapat = r.id_rapat
                  WHERE p.id_user = :uid AND p.notifikasi_status = 'unread'";
        
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        return $this->db->resultSet();
    }

    // Notifikasi: Tandai Sudah Dibaca
    public function tandaiUndanganDibaca($userId)
    {
        $query = "UPDATE peserta SET notifikasi_status = 'read' WHERE id_user = :uid";
        $this->db->query($query);
        $this->db->bind('uid', $userId);
        $this->db->execute();
    }
}