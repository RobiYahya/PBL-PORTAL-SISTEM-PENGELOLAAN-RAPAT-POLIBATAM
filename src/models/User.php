<?php

class User {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // UNTUK LOGIN
    public function cekUser($nik)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE nik = :nik');
        $this->db->bind('nik', $nik);
        return $this->db->single(); // Mengembalikan satu baris data user (termasuk password)
    }

    // UNTUK DROPDOWN PESERTA (Pilih Dosen)
    public function getAllUsers()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY nama_lengkap ASC');
        return $this->db->resultSet();
    }

    // UNTUK PROFIL
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_user = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // TAMBAH USER BARU (Opsional, jika ada fitur Admin)
    public function tambahDataUser($data)
    {
        $query = "INSERT INTO " . $this->table . "
                    (nik, password, nama_lengkap, jabatan)
                VALUES
                    (:nik, :password, :nama_lengkap, :jabatan)";

        $this->db->query($query);
        $this->db->bind('nik', $data['nik']);
        // Password disimpan mentah sesuai requestmu (NOT RECOMMENDED FOR PROD)
        $this->db->bind('password', $data['password']); 
        $this->db->bind('nama_lengkap', $data['nama']);
        $this->db->bind('jabatan', 'dosen'); // Default dosen

        $this->db->execute();
        return $this->db->rowCount();
    }
}