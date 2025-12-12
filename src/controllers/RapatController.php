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

    // Halaman Rapat Saya (Pengganti rapat_saya.php)
    public function index()
    {
        $data['judul'] = 'Rapat Saya';
        $userId = $_SESSION['user_id'];
        
        // Auto update status dulu
        $this->model('Rapat')->autoUpdateStatus();

        // Ambil data per tab
        $data['terjadwal'] = $this->model('Rapat')->getRapatByUser($userId, 'terjadwal');
        $data['dibatalkan'] = $this->model('Rapat')->getRapatByUser($userId, 'batal');
        $data['selesai'] = $this->model('Rapat')->getRapatByUser($userId, 'selesai');

        // Hitung jumlah
        $data['count_terjadwal'] = count($data['terjadwal']);
        $data['count_dibatalkan'] = count($data['dibatalkan']);
        $data['count_selesai'] = count($data['selesai']);

        $this->view('templates/header', $data);
        $this->view('rapat/index', $data); // Pastikan view ini adalah isi dari rapat_saya.php (tapi sudah diamputasi)
        $this->view('templates/footer');
    }

    // Halaman Buat Rapat
    public function create()
    {
        $data['judul'] = 'Buat Rapat Baru';
        
        // AMBIL SEMUA USER KECUALI DIRI SENDIRI
        // (Pastikan User Model punya method getAllUsers)
        $data['users'] = $this->model('User')->getAllUsers(); 

        $this->view('templates/header', $data);
        $this->view('rapat/create', $data);
        $this->view('templates/footer');
    }

    // Tampilkan Form Edit
    public function detail($id)
    {
        $data['judul'] = 'Detail Rapat';
        
        // 1. Ambil Data Rapatnya
        $data['rapat'] = $this->model('Rapat')->getRapatById($id);

        // VALIDASI 1: Rapat Ada Gak?
        if (!$data['rapat']) {
            Flasher::setFlash('Gagal', 'Rapat tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
        $userId = $_SESSION['user_id'];
        $pembuatId = $data['rapat']['id_pembuat'];
        
        // Ambil daftar ID peserta yang diundang (Array [1, 5, 9...])
        // Kita pakai fungsi getPesertaIds yang sudah kita buat di Model Rapat
        $pesertaIds = $this->model('Rapat')->getPesertaIds($id);

        // Cek: Apakah saya Pembuat? ATAU Apakah saya ada di daftar Peserta?
        $isAllowed = ($userId == $pembuatId) || in_array($userId, $pesertaIds);

        if (!$isAllowed) {
            // TENDANG KELUAR!
            Flasher::setFlash('Akses Ditolak', 'Anda tidak diundang ke rapat ini! Jangan mengintip.', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
        // 2. Ambil Siapa Pesertanya (Detail Lengkap untuk View)
        $data['peserta'] = $this->model('Rapat')->getPesertaByRapat($id);

        $this->view('templates/header', $data);
        $this->view('rapat/detail', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        $data['judul'] = 'Edit Rapat';
        
        // 1. Ambil Data Rapat berdasarkan ID dari URL
        $data['rapat'] = $this->model('Rapat')->getRapatById($id);
        
        // Cek jika rapat tidak ditemukan di database
        if (!$data['rapat']) {
            Flasher::setFlash('Gagal', 'Rapat tidak ditemukan.', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        // --- VALIDASI PEMBUAT (Opsional: Matikan jika ingin tes dulu) ---
        // Logika: Jika ID user yang login BEDA dengan ID pembuat rapat, tolak.
        if ($data['rapat']['id_pembuat'] != $_SESSION['user_id']) {
            Flasher::setFlash('Akses Ditolak', 'Hanya pembuat rapat yang bisa mengedit.', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
        // -------------------------------------------------------------

        // 2. Ambil Semua User (Untuk daftar pilihan checkbox peserta)
        $data['users'] = $this->model('User')->getAllUsers();

        // 3. Ambil Peserta yang SUDAH diundang (Untuk mencentang otomatis checkbox)
        // Pastikan Model Rapat punya fungsi getPesertaIds()!
        $data['peserta_ids'] = $this->model('Rapat')->getPesertaIds($id);

        // 4. Tampilkan View
        $this->view('templates/header', $data);
        $this->view('rapat/edit', $data);
        $this->view('templates/footer');
    }

    // Proses Update ke Database
    public function update()
    {
        if( $this->model('Rapat')->updateRapat($_POST) > 0 ) {
            Flasher::setFlash('Berhasil', 'Data rapat diperbarui', 'success');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        } else {
            // Jika tidak ada perubahan (0 row affected) tetap anggap sukses atau info
            Flasher::setFlash('Info', 'Tidak ada perubahan data', 'warning');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
    }

    // Proses Simpan (Pengganti proses_rapat.php)
    public function store()
    {
        if ($this->model('Rapat')->tambahRapat($_POST, $_SESSION['user_id']) > 0) {
            
            $_SESSION['popup_type'] = 'success';
            $_SESSION['popup_title'] = 'Berhasil!';
            $_SESSION['popup_text'] = 'Rapat berhasil dibuat. Notifikasi telah dikirim ke dashboard anggota.';
            
            header('Location: ' . BASEURL . '/rapat');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'Rapat gagal dibuat', 'danger');
            header('Location: ' . BASEURL . '/rapat/create');
            exit;
        }
    }

    // Proses Batalkan (Pengganti batalkan_rapat.php)
    public function cancel($id)
    {
        if ($this->model('Rapat')->batalkanRapat($id, $_SESSION['user_id']) > 0) {
            Flasher::setFlash('Berhasil', 'Rapat dibatalkan', 'warning');
        } else {
            Flasher::setFlash('Gagal', 'Anda tidak punya akses', 'danger');
        }
        header('Location: ' . BASEURL . '/rapat');
        exit;
    }
    // Halaman Form Absensi
    public function absensi($id)
    {
        $data['judul'] = 'Absensi Rapat';
        $data['rapat'] = $this->model('Rapat')->getRapatById($id);
        $data['peserta'] = $this->model('Rapat')->getPesertaByRapat($id);

        // Validasi: Hanya pembuat yang boleh absen
        if($data['rapat']['id_pembuat'] != $_SESSION['user_id']) {
            Flasher::setFlash('Gagal', 'Akses ditolak!', 'danger');
            header('Location: ' . BASEURL . '/rapat/detail/' . $id);
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('rapat/absensi', $data); // Kita akan buat view ini sebentar lagi
        $this->view('templates/footer');
    }

    // Proses Simpan Absensi
    public function processAbsensi()
    {
        // 1. Simpan Absensi
        $this->model('Rapat')->updatePresensi($_POST);

        // 2. Upload Notulen dengan VALIDASI
        if (isset($_FILES['file_notulen']) && $_FILES['file_notulen']['error'] === 0) {
            
            $namaFile = $_FILES['file_notulen']['name'];
            $tmpName  = $_FILES['file_notulen']['tmp_name'];
            $fileSize = $_FILES['file_notulen']['size'];
            $fileType = $_FILES['file_notulen']['type'];
            
            // A. Validasi Ekstensi (Hanya PDF dan DOCX)
            $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            $allowed = ['pdf', 'doc', 'docx'];
            
            // B. Validasi Ukuran (Max 5MB)
            if (!in_array($ext, $allowed)) {
                Flasher::setFlash('Gagal', 'Format file harus PDF atau Word!', 'danger');
                header('Location: ' . BASEURL . '/rapat/absensi/' . $_POST['id_rapat']);
                exit;
            }
            
            if ($fileSize > 5000000) {
                Flasher::setFlash('Gagal', 'Ukuran file maksimal 5MB!', 'danger');
                header('Location: ' . BASEURL . '/rapat/absensi/' . $_POST['id_rapat']);
                exit;
            }

            // C. Proses Upload Aman
            $namaBaru = 'notulen_' . $_POST['id_rapat'] . '_' . time() . '.' . $ext;
            $tujuan   = '../public/files/notulen/' . $namaBaru;

            if (!file_exists('../public/files/notulen/')) {
                mkdir('../public/files/notulen/', 0755, true);
            }

            if (move_uploaded_file($tmpName, $tujuan)) {
                $this->model('Rapat')->updateNotulen($_POST['id_rapat'], $namaBaru);
                Flasher::setFlash('Berhasil', 'Absensi & Notulen tersimpan!', 'success');
            } else {
                Flasher::setFlash('Gagal', 'Gagal upload ke server', 'danger');
            }
        } else {
            Flasher::setFlash('Berhasil', 'Absensi tersimpan (Tanpa Notulen)', 'success');
        }
        
        header('Location: ' . BASEURL . '/rapat/detail/' . $_POST['id_rapat']);
        exit;
    }
}