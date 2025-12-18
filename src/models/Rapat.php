<?php
// Nama File: Rapat.php
// Deskripsi: Model inti untuk pengelolaan data rapat, peserta, dan absensi.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

class Rapat {
    private $table = 'rapat';
    private $table_peserta = 'peserta';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // 1. UPDATE OTOMATIS STATUS
    public function autoUpdateStatus()
    {
        $query = "UPDATE " . $this->table . " SET status = 'selesai' 
                  WHERE status = 'terjadwal' 
                  AND CONCAT(tgl_rapat, ' ', IFNULL(jam_selesai, '23:59:00')) < NOW()";
        
        $this->db->query($query);
        $this->db->execute();
    }

    // 2. AMBIL SEMUA RAPAT (ADMIN)
    public function getAllRapat()
    {
        $query = "SELECT r.*, u.nama_lengkap as pembuat 
                  FROM " . $this->table . " r
                  JOIN users u ON r.id_pembuat = u.id_user
                  ORDER BY r.tgl_rapat DESC, r.jam_mulai DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // 3. AMBIL RAPAT USER
    public function getRapatByUser($userId, $status = null)
    {
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

    // 4. AMBIL DETAIL RAPAT
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
        $this->db->bind('deskripsi', $data['agenda']);
        $this->db->bind('lokasi', $data['ruangan_rapat']);
        $this->db->bind('tgl', $data['tanggal_rapat']);
        $this->db->bind('mulai', $data['jam_mulai']);
        $this->db->bind('selesai', $data['jam_selesai']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();
        $idRapat = $this->db->lastInsertId();

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

    // 6. UPDATE STATUS
    public function updateStatusRapat($id, $status)
    {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id_rapat = :id";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 7. BATALKAN RAPAT
    public function batalkanRapat($idRapat, $userId)
    {
        $query = "UPDATE " . $this->table . " SET status = 'dibatalkan' WHERE id_rapat = :id";
        $this->db->query($query);
        $this->db->bind('id', $idRapat);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 8. PENDUKUNG
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
        $this->db->query("SELECT id_user FROM " . $this->table_peserta . " WHERE id_rapat = :id");
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
    
    // UPDATE RAPAT (REVISI LOGIKA: HANYA TAMBAH/HAPUS YANG BERUBAH)
    // Tujuannya agar status_kehadiran tidak ter-reset jika rapat diedit.
    public function updateRapat($data)
    {
        // 1. Update Data Utama
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
        
        // 2. Kelola Peserta (Sinkronisasi Cerdas)
        // Ambil peserta lama dari DB
        $existingIds = $this->getPesertaIds($data['id_rapat']);
        
        // Peserta baru dari Form (jika kosong array kosong)
        $newIds = isset($data['peserta']) && is_array($data['peserta']) ? $data['peserta'] : [];

        // A. Hapus yang tidak ada di list baru
        $toDelete = array_diff($existingIds, $newIds);
        if (!empty($toDelete)) {
            // Karena tidak pakai WHERE IN array binding, kita loop manual (Inefisien tapi aman untuk PDO basic)
            foreach ($toDelete as $delUid) {
                $this->db->query("DELETE FROM " . $this->table_peserta . " WHERE id_rapat = :rid AND id_user = :uid");
                $this->db->bind('rid', $data['id_rapat']);
                $this->db->bind('uid', $delUid);
                $this->db->execute();
            }
        }

        // B. Tambah yang belum ada (INSERT IGNORE / Cek dulu)
        $toAdd = array_diff($newIds, $existingIds);
        if (!empty($toAdd)) {
            foreach ($toAdd as $addUid) {
                $this->db->query("INSERT INTO " . $this->table_peserta . " (id_rapat, id_user, status_kehadiran) VALUES (:rid, :uid, 'alpa')");
                $this->db->bind('rid', $data['id_rapat']);
                $this->db->bind('uid', $addUid);
                $this->db->execute();
            }
        }

        return $this->db->rowCount();
    }

    // 8. HAPUS RAPAT PERMANEN (Hanya untuk status Batal/Reject)
    public function hapusRapat($id)
    {
        // 1. Ambil nama file notulen dulu (untuk dihapus dari folder)
        $this->db->query("SELECT file_notulen FROM " . $this->table . " WHERE id_rapat = :id");
        $this->db->bind('id', $id);
        $rapat = $this->db->single();

        // 2. Hapus File Fisik jika ada
        if ($rapat && !empty($rapat['file_notulen'])) {
            $path = '../public/files/notulen/' . $rapat['file_notulen'];
            if (file_exists($path)) {
                unlink($path); // Hapus file dari server
            }
        }

        // 3. Hapus Data Peserta (Foreign Key)
        $this->db->query("DELETE FROM " . $this->table_peserta . " WHERE id_rapat = :id");
        $this->db->bind('id', $id);
        $this->db->execute();

        // 4. Hapus Data Rapat Utama
        $this->db->query("DELETE FROM " . $this->table . " WHERE id_rapat = :id");
        $this->db->bind('id', $id);
        $this->db->execute();

        return $this->db->rowCount();
    }
}