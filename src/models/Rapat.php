<?php

class Rapat {
    private $table = 'rapat';
    private $table_peserta = 'peserta';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // --- [INI FUNGSI YANG HILANG DAN BIKIN ERROR] ---
    public function autoUpdateStatus()
    {
        // Gabungkan tgl_rapat dan jam_selesai untuk cek waktu
        // Jika jam_selesai kosong, anggap 23:59
        $query = "UPDATE " . $this->table . " SET status = 'selesai' 
                WHERE status = 'terjadwal' 
                AND CONCAT(tgl_rapat, ' ', IFNULL(jam_selesai, '23:59:00')) < NOW()";
        
        $this->db->query($query);
        $this->db->execute();
    }
    // ------------------------------------------------

    // Ambil Rapat Saya (Pembuat atau Peserta)
    public function getRapatByUser($userId, $status)
    {
        // Query Union: Rapat yang saya buat + Rapat yang saya diundang
        $query = "SELECT r.*, u.nama_lengkap as pembuat 
                FROM " . $this->table . " r
                JOIN users u ON r.id_pembuat = u.id_user
                WHERE r.id_pembuat = :uid AND r.status = :status

                UNION

                SELECT r.*, u.nama_lengkap as pembuat 
                FROM " . $this->table . " r
                JOIN users u ON r.id_pembuat = u.id_user
                JOIN " . $this->table_peserta . " pr ON r.id_rapat = pr.id_rapat
                WHERE pr.id_user = :uid AND r.status = :status

                ORDER BY tgl_rapat DESC, jam_mulai DESC";

        $this->db->query($query);
        $this->db->bind('uid', $userId);
        $this->db->bind('status', $status);
        return $this->db->resultSet();
    }

    // Ambil Detail Satu Rapat
    public function getRapatById($id)
    {
        // Join dengan user untuk dapat nama pembuat
        $query = "SELECT r.*, u.nama_lengkap as pembuat 
                FROM " . $this->table . " r
                JOIN users u ON r.id_pembuat = u.id_user
                WHERE r.id_rapat = :id";

        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // Tambah Rapat Baru
    // Tambah Rapat Baru
    public function tambahRapat($data, $userId)
    {
        // 1. Insert Data Rapat
        $query = "INSERT INTO " . $this->table . "
                    (id_pembuat, judul_rapat, deskripsi, lokasi, tgl_rapat, jam_mulai, jam_selesai, status)
                VALUES
                    (:pembuat, :judul, :deskripsi, :lokasi, :tgl, :mulai, :selesai, :status)";

        $status = ($data['status_rapat'] == 'Draft') ? 'draft' : 'terjadwal';

        $this->db->query($query);
        $this->db->bind('pembuat', $userId);
        $this->db->bind('judul', $data['judul_rapat']);
        $this->db->bind('deskripsi', $data['tujuan_rapat']); 
        $this->db->bind('lokasi', $data['ruangan_rapat']);
        $this->db->bind('tgl', $data['tanggal_rapat']);
        $this->db->bind('mulai', $data['jam_mulai']);
        $this->db->bind('selesai', $data['jam_selesai']);
        $this->db->bind('status', $status);

        $this->db->execute();
        
        // 2. Ambil ID Rapat Barusan
        $idRapat = $this->db->lastInsertId();

        // 3. OPSIONAL: Input Peserta Berdasarkan JABATAN (Target Rapat)
        // (Ini dari checkbox "Seluruh Dosen", dll)
        if (isset($data['target_rapat']) && is_array($data['target_rapat'])) {
            foreach ($data['target_rapat'] as $jabatan) {
                $this->db->query("SELECT id_user FROM users WHERE jabatan = :jabatan");
                $this->db->bind('jabatan', $jabatan);
                $users = $this->db->resultSet();

                foreach ($users as $u) {
                    $q_peserta = "INSERT IGNORE INTO " . $this->table_peserta . " 
                                (id_rapat, id_user, status_kehadiran) 
                                VALUES (:rid, :uid, 'alpa')"; 
                    $this->db->query($q_peserta);
                    $this->db->bind('rid', $idRapat);
                    $this->db->bind('uid', $u['id_user']);
                    $this->db->execute();
                }
            }
        }

        // 4. UTAMA: Input Peserta INDIVIDU (Checkbox Nama Orang)
        // (Ini dari checkbox daftar nama dosen yang baru kita buat)
        if (isset($data['peserta']) && is_array($data['peserta'])) {
            foreach ($data['peserta'] as $id_user_target) {
                $q_peserta = "INSERT IGNORE INTO " . $this->table_peserta . " 
                            (id_rapat, id_user, status_kehadiran) 
                            VALUES (:rid, :uid, 'alpa')"; 
                
                $this->db->query($q_peserta);
                $this->db->bind('rid', $idRapat);
                $this->db->bind('uid', $id_user_target);
                $this->db->execute();
            }
        }
        
        return $this->db->rowCount();
    }

    // Batalkan Rapat
    public function batalkanRapat($idRapat, $userId)
    {
        $query = "UPDATE " . $this->table . " SET status = 'batal' 
                WHERE id_rapat = :id AND id_pembuat = :uid";

        $this->db->query($query);
        $this->db->bind('id', $idRapat);
        $this->db->bind('uid', $userId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // Ambil Daftar Peserta dalam satu Rapat
    public function getPesertaByRapat($idRapat)
    {
        $query = "SELECT pr.*, u.nama_lengkap, u.jabatan, u.nik 
                FROM " . $this->table_peserta . " pr
                JOIN users u ON pr.id_user = u.id_user
                WHERE pr.id_rapat = :id
                ORDER BY u.nama_lengkap ASC";
        
        $this->db->query($query);
        $this->db->bind('id', $idRapat);
        return $this->db->resultSet();
    }

    // Update Absensi (Looping Update)
    public function updatePresensi($data)
    {
        $idRapat = $data['id_rapat'];
        $jumlahBerubah = 0;

        // $data['status'] berbentuk array: [id_user => 'hadir', id_user => 'sakit', ...]
        if (isset($data['status']) && is_array($data['status'])) {
            
            $query = "UPDATE " . $this->table_peserta . " 
                    SET status_kehadiran = :status 
                    WHERE id_rapat = :rid AND id_user = :uid";
            
            $this->db->query($query);

            foreach ($data['status'] as $uid => $statusKehadiran) {
                $this->db->bind('status', $statusKehadiran);
                $this->db->bind('rid', $idRapat);
                $this->db->bind('uid', $uid);
                $this->db->execute();
                
                $jumlahBerubah += $this->db->rowCount();
            }
        }
        
        return $jumlahBerubah; // Kembalikan > 0 jika ada yang berubah
    }

    // Update Notulen
    public function updateNotulen($idRapat, $namaFile)
    {
        $query = "UPDATE " . $this->table . " SET file_notulen = :file, status = 'selesai' 
                WHERE id_rapat = :id";
        $this->db->query($query);
        $this->db->bind('file', $namaFile);
        $this->db->bind('id', $idRapat);
        $this->db->execute();
        return $this->db->rowCount();
    }

   // --- TAMBAHAN PENTING UNTUK EDIT CHECKBOX ---
    public function getPesertaIds($id_rapat)
    {
        $this->db->query('SELECT id_user FROM ' . $this->table_peserta . ' WHERE id_rapat = :id');
        $this->db->bind('id', $id_rapat);
        $result = $this->db->resultSet();
        
        // Return array flat: [1, 5, 9]
        return array_column($result, 'id_user');
    }

    // --- REVISI updateRapat AGAR PESERTA IKUT TERUPDATE ---
    public function updateRapat($data)
    {
        // 1. Update Info Dasar
        $query = "UPDATE " . $this->table . " SET 
                    judul_rapat = :judul,
                    deskripsi = :deskripsi,
                    lokasi = :lokasi,
                    tgl_rapat = :tgl,
                    jam_mulai = :mulai,
                    jam_selesai = :selesai,
                    status = :status
                WHERE id_rapat = :id";

        $this->db->query($query);
        $this->db->bind('judul', $data['judul_rapat']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('lokasi', $data['lokasi']);
        $this->db->bind('tgl', $data['tanggal_rapat']);
        $this->db->bind('mulai', $data['jam_mulai']);
        $this->db->bind('selesai', $data['jam_selesai']);
        $this->db->bind('status', strtolower($data['status']));
        $this->db->bind('id', $data['id_rapat']);
        $this->db->execute();

        // 2. UPDATE PESERTA (Brutal tapi Aman: Hapus Semua -> Insert Baru)
        // Ini memastikan sinkronisasi sempurna
        $this->db->query("DELETE FROM " . $this->table_peserta . " WHERE id_rapat = :rid");
        $this->db->bind('rid', $data['id_rapat']);
        $this->db->execute();

        // 3. Insert Ulang Peserta Baru (Logic yg sama dengan tambahRapat)
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