<?php

class RapatController extends Controller {
    
    public function __construct()
    {
        // Cek Login Wajib
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    // 1. HALAMAN DASHBOARD (Rapat Saya)
    public function index()
    {
        $data['judul'] = 'Rapat Saya';
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        
        // Auto update status (kadaluarsa)
        $this->model('Rapat')->autoUpdateStatus();

        // --- LOGIKA UTAMA: SIAPA BISA LIHAT APA ---
        if ($role == 'admin') {
             // Admin melihat SEMUA rapat (termasuk yang pending review)
            $data['rapat'] = $this->model('Rapat')->getAllRapat(); 
        } else {
             // Dosen melihat rapat sendiri (pembuat/peserta)
            $data['rapat'] = $this->model('Rapat')->getRapatByUser($userId); 
        }
        
        // Data Per Tab (Terjadwal, Batal, Selesai)
        $data['terjadwal']  = $this->model('Rapat')->getRapatByUser($userId, 'terjadwal');
        $data['dibatalkan'] = $this->model('Rapat')->getRapatByUser($userId, 'dibatalkan');
        $data['selesai']    = $this->model('Rapat')->getRapatByUser($userId, 'selesai');

        // Hitung jumlah untuk Badge
        $data['count_terjadwal']  = count($data['terjadwal']);
        $data['count_dibatalkan'] = count($data['dibatalkan']);
        $data['count_selesai']    = count($data['selesai']);

        $this->view('templates/header', $data);
        $this->view('rapat/index', $data);
        $this->view('templates/footer');
    }

    // 2. HALAMAN BUAT RAPAT
    public function create()
    {
        // --- BLOKIR ADMIN (Admin Tidak Boleh Buat Rapat) ---
        if ($_SESSION['role'] == 'admin') {
            Flasher::setFlash('Info', 'Admin bertugas menyetujui rapat, bukan membuat rapat.', 'warning');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
        // ---------------------------------------------------

        $data['judul'] = 'Buat Rapat Baru';
        $data['users'] = $this->model('User')->getAllUsers(); 

        $this->view('templates/header', $data);
        $this->view('rapat/create', $data);
        $this->view('templates/footer');
    }

    // 3. PROSES SIMPAN RAPAT BARU
    public function store()
    {
        // Tentukan Status & Pesan
        if ($_SESSION['role'] == 'admin') {
            $_POST['status'] = 'terjadwal';
            $pesan = 'Rapat berhasil diterbitkan dan undangan dikirim.';
        } else {
            $_POST['status'] = 'menunggu_konfirmasi';
            $pesan = 'Pengajuan berhasil dikirim! Mohon tunggu persetujuan Admin TU.';
        }

        // Simpan (Parameter ke-2 adalah ID Pembuat)
        if ($this->model('Rapat')->tambahRapat($_POST, $_SESSION['user_id']) > 0) {
            $_SESSION['popup_type'] = 'success';
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

    // 4. HALAMAN DETAIL (Updated: Admin Boleh Lihat)
    public function detail($id)
    {
        $data['judul'] = 'Detail Rapat';
        $data['rapat'] = $this->model('Rapat')->getRapatById($id);

        if (!$data['rapat']) {
            Flasher::setFlash('Gagal', 'Rapat tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        $pembuatId = $data['rapat']['id_pembuat'];
        $pesertaIds = $this->model('Rapat')->getPesertaIds($id);

        // IZIN AKSES: Pembuat ATAU Peserta ATAU Admin
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

    // 5. HALAMAN EDIT (Updated: Admin Boleh Edit)
    public function edit($id)
    {
        $data['judul'] = 'Edit Rapat';
        $data['rapat'] = $this->model('Rapat')->getRapatById($id);
        
        if (!$data['rapat']) {
            header('Location: ' . BASEURL . '/rapat'); exit;
        }

        // IZIN EDIT: Hanya Pembuat ATAU Admin
        if ($data['rapat']['id_pembuat'] != $_SESSION['user_id'] && $_SESSION['role'] != 'admin') {
            Flasher::setFlash('Akses Ditolak', 'Hanya pembuat atau Admin yang bisa mengedit.', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $data['users'] = $this->model('User')->getAllUsers();
        $data['peserta_ids'] = $this->model('Rapat')->getPesertaIds($id);

        $this->view('templates/header', $data);
        $this->view('rapat/edit', $data);
        $this->view('templates/footer');
    }

    // 6. PROSES UPDATE
    public function update()
    {
        if( $this->model('Rapat')->updateRapat($_POST) > 0 ) {
            Flasher::setFlash('Berhasil', 'Data rapat diperbarui', 'success');
        } else {
            Flasher::setFlash('Info', 'Tidak ada perubahan data', 'warning');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }

    // 7. APPROVE (Khusus Admin)
    public function approve($id)
    {
        if ($_SESSION['role'] != 'admin') { header('Location: ' . BASEURL); exit; }

        if ($this->model('Rapat')->updateStatusRapat($id, 'terjadwal') > 0) {
            Flasher::setFlash('Sukses', 'Rapat disetujui & diterbitkan!', 'success');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }

    // 8. REJECT (Khusus Admin)
    public function reject($id)
    {
        if ($_SESSION['role'] != 'admin') { header('Location: ' . BASEURL); exit; }

        if ($this->model('Rapat')->updateStatusRapat($id, 'dibatalkan') > 0) {
            Flasher::setFlash('Ditolak', 'Pengajuan rapat ditolak.', 'warning');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }

    // 9. ABSENSI
    public function absensi($id)
    {
        $data['judul'] = 'Absensi Rapat';
        $data['rapat'] = $this->model('Rapat')->getRapatById($id);
        $data['peserta'] = $this->model('Rapat')->getPesertaByRapat($id);

        // Hanya pembuat yang boleh absen
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
            $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            
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

    // 11. CANCEL (Manual User)
    public function cancel($id)
    {
        if ($this->model('Rapat')->batalkanRapat($id, $_SESSION['user_id']) > 0) {
            Flasher::setFlash('Berhasil', 'Rapat dibatalkan', 'warning');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }
}