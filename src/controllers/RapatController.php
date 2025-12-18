<?php
// Nama File: RapatController.php
// Deskripsi: Controller utama untuk CRUD Rapat, Absensi, dan Approval.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

class RapatController extends Controller {
    
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    // 1. DASHBOARD RAPAT
    public function index()
    {
        $data['judul'] = 'Rapat Saya';
        $userId = $_SESSION['user_id'];
        $role   = $_SESSION['role'];
        
        $this->model('Rapat')->autoUpdateStatus();

        if ($role == 'admin') {
            $data['rapat'] = $this->model('Rapat')->getAllRapat(); 
        } else {
            $data['rapat'] = $this->model('Rapat')->getRapatByUser($userId); 
        }
        
        $data['terjadwal']  = $this->model('Rapat')->getRapatByUser($userId, 'terjadwal');
        $data['dibatalkan'] = $this->model('Rapat')->getRapatByUser($userId, 'dibatalkan');
        $data['selesai']    = $this->model('Rapat')->getRapatByUser($userId, 'selesai');

        $data['count_terjadwal']  = count($data['terjadwal']);
        $data['count_dibatalkan'] = count($data['dibatalkan']);
        $data['count_selesai']    = count($data['selesai']);

        $this->view('templates/header', $data);
        $this->view('rapat/index', $data);
        $this->view('templates/footer');
    }

    // 2. FORM BUAT RAPAT
    public function create()
    {
        if ($_SESSION['role'] == 'admin') {
            Flasher::setFlash('Info', 'Admin bertugas menyetujui rapat, bukan membuat rapat.', 'warning');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $data['judul'] = 'Buat Rapat Baru';
        $data['users'] = $this->model('User')->getAllUsers(); 

        $this->view('templates/header', $data);
        $this->view('rapat/create', $data);
        $this->view('templates/footer');
    }

    // 3. PROSES SIMPAN RAPAT
    public function store()
    {
        // Fitur: Pilih Seluruh Dosen
        if (isset($_POST['target_rapat']) && in_array('dosen', $_POST['target_rapat'])) {
            $allUsers = $this->model('User')->getAllUsers();
            
            if (!isset($_POST['peserta'])) {
                $_POST['peserta'] = [];
            }

            foreach ($allUsers as $user) {
                if ($user['jabatan'] != 'admin' && $user['id_user'] != $_SESSION['user_id']) {
                    if (!in_array($user['id_user'], $_POST['peserta'])) {
                        $_POST['peserta'][] = $user['id_user'];
                    }
                }
            }
        }

        if ($_SESSION['role'] == 'admin') {
            $_POST['status'] = 'terjadwal';
            $pesan = 'Rapat berhasil diterbitkan dan undangan dikirim.';
        } else {
            $_POST['status'] = 'menunggu_konfirmasi';
            $pesan = 'Pengajuan berhasil dikirim! Mohon tunggu persetujuan Admin TU.';
        }

        if ($this->model('Rapat')->tambahRapat($_POST, $_SESSION['user_id']) > 0) {
            $_SESSION['popup_type']  = 'success';
            $_SESSION['popup_title'] = 'Berhasil!';
            $_SESSION['popup_text']  = $pesan;
            header('Location: ' . BASEURL . '/rapat');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'Rapat gagal dibuat', 'danger');
            header('Location: ' . BASEURL . '/rapat/create');
            exit;
        }
    }

    // 4. DETAIL RAPAT
    public function detail($id)
    {
        $data['judul'] = 'Detail Rapat';
        $data['rapat'] = $this->model('Rapat')->getRapatById($id);

        if (!$data['rapat']) {
            Flasher::setFlash('Gagal', 'Rapat tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $userId     = $_SESSION['user_id'];
        $role       = $_SESSION['role'];
        $pembuatId  = $data['rapat']['id_pembuat'];
        $pesertaIds = $this->model('Rapat')->getPesertaIds($id);

        $isAllowed = ($userId == $pembuatId) || in_array($userId, $pesertaIds) || ($role == 'admin');

        if (!$isAllowed) {
            Flasher::setFlash('Akses Ditolak', 'Anda tidak memiliki akses ke rapat ini.', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $data['peserta'] = $this->model('Rapat')->getPesertaByRapat($id);

        $this->view('templates/header', $data);
        $this->view('rapat/detail', $data);
        $this->view('templates/footer');
    }

    // 5. EDIT RAPAT
    public function edit($id)
    {
        $data['judul'] = 'Edit Rapat';
        $data['rapat'] = $this->model('Rapat')->getRapatById($id);
        
        if (!$data['rapat']) {
            header('Location: ' . BASEURL . '/rapat'); exit;
        }

        if ($data['rapat']['id_pembuat'] != $_SESSION['user_id'] && $_SESSION['role'] != 'admin') {
            Flasher::setFlash('Akses Ditolak', 'Hanya pembuat atau Admin yang bisa mengedit.', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $data['users']       = $this->model('User')->getAllUsers();
        $data['peserta_ids'] = $this->model('Rapat')->getPesertaIds($id);

        $this->view('templates/header', $data);
        $this->view('rapat/edit', $data);
        $this->view('templates/footer');
    }

    // 6. PROSES UPDATE
    public function update()
    {
        if (isset($_POST['target_rapat']) && in_array('dosen', $_POST['target_rapat'])) {
            $allUsers = $this->model('User')->getAllUsers();
            
            if (!isset($_POST['peserta'])) {
                $_POST['peserta'] = [];
            }

            foreach ($allUsers as $user) {
                if ($user['jabatan'] != 'admin' && $user['id_user'] != $_SESSION['user_id']) {
                    if (!in_array($user['id_user'], $_POST['peserta'])) {
                        $_POST['peserta'][] = $user['id_user'];
                    }
                }
            }
        }

        if( $this->model('Rapat')->updateRapat($_POST) > 0 ) {
            Flasher::setFlash('Berhasil', 'Data rapat diperbarui', 'success');
        } else {
            Flasher::setFlash('Info', 'Tidak ada perubahan data', 'warning');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }

    // 7. APPROVE (Admin)
    public function approve($id)
    {
        if ($_SESSION['role'] != 'admin') { header('Location: ' . BASEURL); exit; }

        if ($this->model('Rapat')->updateStatusRapat($id, 'terjadwal') > 0) {
            Flasher::setFlash('Sukses', 'Rapat disetujui & diterbitkan!', 'success');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }

    // 8. REJECT (Admin)
    public function reject($id)
    {
        if ($_SESSION['role'] != 'admin') { header('Location: ' . BASEURL); exit; }

        if ($this->model('Rapat')->updateStatusRapat($id, 'dibatalkan') > 0) {
            Flasher::setFlash('Ditolak', 'Pengajuan rapat ditolak.', 'warning');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }

    // 9. HALAMAN ABSENSI
    public function absensi($id)
    {
        $data['judul']   = 'Absensi Rapat';
        $data['rapat']   = $this->model('Rapat')->getRapatById($id);
        $data['peserta'] = $this->model('Rapat')->getPesertaByRapat($id);

        if($data['rapat']['id_pembuat'] != $_SESSION['user_id']) {
            Flasher::setFlash('Gagal', 'Hanya ketua rapat yang bisa mengisi absensi!', 'danger');
            header('Location: ' . BASEURL . '/rapat/detail/' . $id);
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('rapat/absensi', $data);
        $this->view('templates/footer');
    }

    // 10. PROSES ABSENSI & NOTULEN
    public function processAbsensi()
    {
        $this->model('Rapat')->updatePresensi($_POST);

        if (isset($_FILES['file_notulen']) && $_FILES['file_notulen']['error'] === 0) {
            $namaFile = $_FILES['file_notulen']['name'];
            $tmpName  = $_FILES['file_notulen']['tmp_name'];
            $ext      = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            
            if (!in_array($ext, ['pdf', 'doc', 'docx']) || $_FILES['file_notulen']['size'] > 5000000) {
                Flasher::setFlash('Gagal', 'File harus PDF/Word max 5MB', 'danger');
                header('Location: ' . BASEURL . '/rapat/absensi/' . $_POST['id_rapat']);
                exit;
            }

            $namaBaru = 'notulen_' . $_POST['id_rapat'] . '_' . time() . '.' . $ext;
            if (move_uploaded_file($tmpName, '../public/files/notulen/' . $namaBaru)) {
                $this->model('Rapat')->updateNotulen($_POST['id_rapat'], $namaBaru);
            }
        }
        
        Flasher::setFlash('Berhasil', 'Absensi & Data tersimpan!', 'success');
        header('Location: ' . BASEURL . '/rapat/detail/' . $_POST['id_rapat']);
        exit;
    }

    // 11. CANCEL (Manual)
    public function cancel($id)
    {
        if ($this->model('Rapat')->batalkanRapat($id, $_SESSION['user_id']) > 0) {
            Flasher::setFlash('Berhasil', 'Rapat dibatalkan', 'warning');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }
    
    // 12. UPLOAD NOTULEN (Dari Dashboard)
    public function uploadNotulen()
    {
        if (isset($_FILES['file_notulen']) && $_FILES['file_notulen']['error'] === 0) {
            
            $idRapat  = $_POST['id_rapat'];
            $namaFile = $_FILES['file_notulen']['name'];
            $tmpName  = $_FILES['file_notulen']['tmp_name'];
            $fileSize = $_FILES['file_notulen']['size'];
            
            $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            if (!in_array($ext, ['pdf', 'doc', 'docx'])) {
                Flasher::setFlash('Gagal', 'Hanya file PDF atau Word yang diperbolehkan!', 'danger');
                header('Location: ' . BASEURL . '/rapat');
                exit;
            }

            if ($fileSize > 5000000) {
                Flasher::setFlash('Gagal', 'Ukuran file terlalu besar (Max 5MB)!', 'danger');
                header('Location: ' . BASEURL . '/rapat');
                exit;
            }

            $namaBaru = 'notulen_' . $idRapat . '_' . time() . '.' . $ext;
            $tujuan   = '../public/files/notulen/' . $namaBaru;

            if (!file_exists('../public/files/notulen/')) {
                mkdir('../public/files/notulen/', 0755, true);
            }

            if (move_uploaded_file($tmpName, $tujuan)) {
                $this->model('Rapat')->updateNotulen($idRapat, $namaBaru);
                Flasher::setFlash('Berhasil', 'Notulen berhasil diunggah!', 'success');
            } else {
                Flasher::setFlash('Gagal', 'Gagal mengunggah file ke server.', 'danger');
            }
        } else {
            Flasher::setFlash('Gagal', 'Tidak ada file yang dipilih.', 'danger');
        }

        header('Location: ' . BASEURL . '/rapat');
        exit;
    }
    public function delete($id)
    {
        // Cek data rapat dulu
        $rapat = $this->model('Rapat')->getRapatById($id);
        
        if (!$rapat) {
            Flasher::setFlash('Gagal', 'Data tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        // Validasi: Hanya Pembuat atau Admin yang boleh hapus
        if ($rapat['id_pembuat'] != $_SESSION['user_id'] && $_SESSION['role'] != 'admin') {
            Flasher::setFlash('Gagal', 'Akses ditolak!', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        // Validasi: JANGAN HAPUS YANG SUDAH SELESAI (Kecuali Admin maksa)
        if ($rapat['status'] == 'selesai' && $_SESSION['role'] != 'admin') {
            Flasher::setFlash('Gagal', 'Rapat yang sudah selesai tidak boleh dihapus demi arsip!', 'warning');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        if ($this->model('Rapat')->hapusRapat($id) > 0) {
            Flasher::setFlash('Berhasil', 'Rapat telah dihapus permanen.', 'success');
        } else {
            Flasher::setFlash('Gagal', 'Terjadi kesalahan penghapusan.', 'danger');
        }

        header('Location: ' . BASEURL . '/rapat');
        exit;
    }
}