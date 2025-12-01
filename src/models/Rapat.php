<?php

class Rapat {
    private $table = 'rapat';
    private $table_presensi = 'presensi';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // AMBIL SEMUA RAPAT (Join dengan nama pembuat)
    public function getAllRapat()
    {
        $query = "SELECT rapat.*, users.nama_lengkap as pembuat 
                FROM " . $this->table . " 
                JOIN users ON rapat.id_pembuat = users.id_user 
                ORDER BY tgl_rapat DESC, jam_mulai DESC";
        
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // AMBIL DETAIL SATU RAPAT
    public function getRapatById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_rapat = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // TAMBAH RAPAT BARU + UNDANG PESERTA
    public function tambahDataRapat($data)
    {
        // 1. Insert Data Rapat Utama
        $query = "INSERT INTO " . $this->table . "
                    (judul_rapat, deskripsi, lokasi, tgl_rapat, jam_mulai, jam_selesai, id_pembuat, status)
                VALUES
                    (:judul, :deskripsi, :lokasi, :tgl, :mulai, :selesai, :pembuat, 'terjadwal')";

        $this->db->query($query);
        $this->db->bind('judul', $data['judul_rapat']);
        $this->db->bind('deskripsi', $data['deskripsi']); // Pastikan di form name="deskripsi"
        $this->db->bind('lokasi', $data['lokasi']);
        $this->db->bind('tgl', $data['tanggal_rapat']);
        $this->db->bind('mulai', $data['jam_mulai']);
        $this->db->bind('selesai', $data['jam_selesai']);
        $this->db->bind('pembuat', $_SESSION['user_id']); // Ambil dari session login

        $this->db->execute();
        
        // 2. Ambil ID Rapat yang barusan dibuat
        // Kita butuh ini untuk insert ke tabel presensi
        $this->db->query("SELECT LAST_INSERT_ID() as id_baru");
        $newRapat = $this->db->single();
        $id_rapat = $newRapat['id_baru'];

        // 3. Insert Peserta ke Tabel Presensi (Looping)
        // Data 'peserta' dari form harus berupa array (checkbox/multiple select)
        if (isset($data['peserta']) && is_array($data['peserta'])) {
            foreach ($data['peserta'] as $id_user) {
                $q_presensi = "INSERT INTO " . $this->table_presensi . " 
                            (id_rapat, id_user, status) 
                            VALUES (:id_rapat, :id_user, 'alpa')";
                
                $this->db->query($q_presensi);
                $this->db->bind('id_rapat', $id_rapat);
                $this->db->bind('id_user', $id_user);
                $this->db->execute();
            }
        }

        return $this->db->rowCount();
    }

    // UPDATE NOTULEN (Hanya update nama file)
    public function updateNotulen($id_rapat, $nama_file)
    {
        $query = "UPDATE " . $this->table . " SET 
                    file_notulen = :file,
                    status = 'selesai' 
                WHERE id_rapat = :id";
        
        $this->db->query($query);
        $this->db->bind('file', $nama_file);
        $this->db->bind('id', $id_rapat);

        $this->db->execute();
        return $this->db->rowCount();
    }

    // AMBIL PESERTA UNTUK SATU RAPAT
    public function getPesertaRapat($id_rapat)
    {
        $query = "SELECT presensi.*, users.nama_lengkap, users.nik 
                FROM presensi 
                JOIN users ON presensi.id_user = users.id_user 
                WHERE presensi.id_rapat = :id";
        
        $this->db->query($query);
        $this->db->bind('id', $id_rapat);
        return $this->db->resultSet();
    }
}