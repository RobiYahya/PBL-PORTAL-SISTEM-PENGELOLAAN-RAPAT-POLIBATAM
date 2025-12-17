<?php
// Nama File: Notulen.php
// Deskripsi: Model untuk pencarian dan filter data notulen rapat.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

class Notulen {
    private $table = 'rapat';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Cari Rapat yang Sudah Ada Notulennya
    public function getRapatWithNotulen($keyword = null)
    {
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE file_notulen IS NOT NULL AND file_notulen != ''";
        
        if($keyword) {
            $sql .= " AND judul_rapat LIKE :keyword";
        }

        $this->db->query($sql);
        
        if($keyword) {
            $this->db->bind('keyword', "%$keyword%");
        }

        return $this->db->resultSet();
    }
}