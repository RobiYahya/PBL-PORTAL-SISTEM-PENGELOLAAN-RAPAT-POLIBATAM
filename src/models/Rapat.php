<?php

class Rapat {
    private $table = 'rapat';
    private $table_peserta = 'peserta';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // 1. UPDATE OTOMATIS STATUS (Selesai jika lewat waktu)
    public function autoUpdateStatus()
    {
        $query = "UPDATE " . $this->table . " SET status = 'selesai' 
                WHERE status = 'terjadwal' 
                AND CONCAT(tgl_rapat, ' ', IFNULL(jam_selesai, '23:59:00')) < NOW()";
        
        $this->db->query($query);
        $this->db->execute();
    }

    // 2. AMBIL SEMUA RAPAT (KHUSUS ADMIN)
    public function getAllRapat()
    {
        $query = "SELECT r.*, u.nama_lengkap as pembuat 
                  FROM " . $this->table . " r
                  JOIN users u ON r.id_pembuat = u.id_user
                  ORDER BY r.tgl_rapat DESC, r.jam_mulai DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // 3. AMBIL RAPAT USER (FIXED: Status Opsional & Logika Akses)
    public function getRapatByUser($userId, $status = null)
    {
        // Query Dasar: Ambil rapat jika SAYA PEMBUAT -ATAU- SAYA PESERTA (yang sudah publish)
        $sql = "SELECT r.*, u.nama_lengkap as pembuat 
                FROM " . $this->table . " r
                JOIN users u ON r.id_pembuat = u.id_user 
                WHERE 
                (
                    r.id_pembuat = :user_id 
                    OR 
                    (
                        r.id_rapat IN (SELECT id_rapat FROM " . $this->table_peserta . " WHERE id_user = :user_id)
                        AND r.status != 'menunggu_konfirmasi' 
                    )
                )";

        // Filter Tambahan Jika Status Diisi
        if ($status != null) {
            $sql .= " AND r.status = :status";
        }

        $sql .= " ORDER BY r.tgl_rapat DESC, r.jam_mulai DESC";

        $this->db->query($sql);
        $this->db->bind('user_id', $userId);
        
        if ($status != null) {
            $this->db->bind('status', $status);
        }

        return $this->db->resultSet();
    }

    // 4. AMBIL DETAIL SATU RAPAT
    public function getRapatById($id)
    {
        $query = "SELECT r.*, u.nama_lengkap as pembuat 
                FROM " . $this->table . " r
                JOIN users u ON r.id_pembuat = u.id_user
                WHERE r.id_rapat = :id";

        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // 5. TAMBAH RAPAT BARU
    public function tambahRapat($data, $userId)
    {
        $query = "INSERT INTO " . $this->table . "
                    (id_pembuat, judul_rapat, deskripsi, lokasi, tgl_rapat, jam_mulai, jam_selesai, status)
                VALUES
                    (:pembuat, :judul, :deskripsi, :lokasi, :tgl, :mulai, :selesai, :status)";

        $this->db->query($query);
        $this->db->bind('pembuat', $userId);
        $this->db->bind('judul', $data['judul_rapat']);
        $this->db->bind('deskripsi', $data['agenda']); // Sesuaikan name='agenda' di form
        $this->db->bind('lokasi', $data['ruangan_rapat']); // Sesuaikan name='ruangan_rapat'
        $this->db->bind('tgl', $data['tanggal_rapat']);
        $this->db->bind('mulai', $data['jam_mulai']);
        $this->db->bind('selesai', $data['jam_selesai']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        $idRapat = $this->db->lastInsertId();

        // Input Peserta (Checkbox)
        if (isset($data['peserta']) && is_array($data['peserta'])) {
            foreach ($data['peserta'] as $uid) {
                $q_peserta = "INSERT IGNORE INTO " . $this->table_peserta . " 
                            (id_rapat, id_user, status_kehadiran) 
                            VALUES (:rid, :uid, 'alpa')"; 
                $this->db->query($q_peserta);
                $this->db->bind('rid', $idRapat);
                $this->db->bind('uid', $uid);
                $this->db->execute();
            }
        }
        
        return $this->db->rowCount();
    }

    // 6. UPDATE STATUS (PENTING BUAT ADMIN APPROVE)
    public function updateStatusRapat($id, $status)
    {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id_rapat = :id";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 7. BATALKAN RAPAT (Manual)
    public function batalkanRapat($idRapat, $userId)
    {
        // Hanya pembuat atau admin yang bisa
        $query = "UPDATE " . $this->table . " SET status = 'dibatalkan' 
                WHERE id_rapat = :id";
        
        $this->db->query($query);
        $this->db->bind('id', $idRapat);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 8. FUNGSI PENDUKUNG LAINNYA
    public function getPesertaByRapat($idRapat)
    {
        $query = "SELECT pr.*, u.nama_lengkap, u.jabatan, u.nik 
                FROM " . $this->table_peserta . " pr
                JOIN users u ON pr.id_user = u.id_user
                WHERE pr.id_rapat = :id ORDER BY u.nama_lengkap ASC";
        $this->db->query($query);
        $this->db->bind('id', $idRapat);
        return $this->db->resultSet();
    }

    public function getPesertaIds($id_rapat)
    {
        $this->db->query('SELECT id_user FROM ' . $this->table_peserta . ' WHERE id_rapat = :id');
        $this->db->bind('id', $id_rapat);
        $result = $this->db->resultSet();
        return array_column($result, 'id_user');
    }

    public function updatePresensi($data)
    {
        $jumlah = 0;
        if (isset($data['status']) && is_array($data['status'])) {
            foreach ($data['status'] as $uid => $st) {
                $this->db->query("UPDATE " . $this->table_peserta . " SET status_kehadiran = :st WHERE id_rapat = :rid AND id_user = :uid");
                $this->db->bind('st', $st);
                $this->db->bind('rid', $data['id_rapat']);
                $this->db->bind('uid', $uid);
                $this->db->execute();
                $jumlah++;
            }
        }
        return $jumlah;
    }

    public function updateNotulen($idRapat, $namaFile)
    {
        $this->db->query("UPDATE " . $this->table . " SET file_notulen = :file, status = 'selesai' WHERE id_rapat = :id");
        $this->db->bind('file', $namaFile);
        $this->db->bind('id', $idRapat);
        $this->db->execute();
        return $this->db->rowCount();
    }
    
    // Update Rapat (Edit)
    public function updateRapat($data)
    {
        $query = "UPDATE " . $this->table . " SET 
                    judul_rapat = :judul, deskripsi = :deskripsi, lokasi = :lokasi,
                    tgl_rapat = :tgl, jam_mulai = :mulai, jam_selesai = :selesai, status = :status
                WHERE id_rapat = :id";
        
        $this->db->query($query);
        $this->db->bind('judul', $data['judul_rapat']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('lokasi', $data['lokasi']);
        $this->db->bind('tgl', $data['tanggal_rapat']);
        $this->db->bind('mulai', $data['jam_mulai']);
        $this->db->bind('selesai', $data['jam_selesai']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('id', $data['id_rapat']);
        $this->db->execute();
        
        // Update Peserta (Hapus Lama -> Insert Baru)
        $this->db->query("DELETE FROM " . $this->table_peserta . " WHERE id_rapat = :rid");
        $this->db->bind('rid', $data['id_rapat']);
        $this->db->execute();

        if (isset($data['peserta']) && is_array($data['peserta'])) {
            foreach ($data['peserta'] as $uid) {
                $this->db->query("INSERT INTO " . $this->table_peserta . " (id_rapat, id_user) VALUES (:rid, :uid)");
                $this->db->bind('rid', $data['id_rapat']);
                $this->db->bind('uid', $uid);
                $this->db->execute();
            }
        }
        return $this->db->rowCount();
    }
}