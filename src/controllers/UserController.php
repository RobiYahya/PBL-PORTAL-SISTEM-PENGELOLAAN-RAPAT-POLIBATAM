<?php

class UserController extends Controller {
    
    public function __construct()
    {
        // Gembok Keamanan: Cek Login
        // Kita cek user_id karena itu kunci utama sesi kita
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    // ======================================================
    // BAGIAN 1: FITUR PROFIL PENGGUNA (YANG KAMU CARI)
    // ======================================================

    public function profile()
    {
        $data['judul'] = 'Profil Saya';
        
        // Ambil data user yang sedang login
        $data['user'] = $this->model('User')->getUserById($_SESSION['user_id']);

        $this->view('templates/header', $data);
        // Perhatikan: Kita tidak pakai sidebar di halaman profil agar layout Neumorphism rapi
        $this->view('user/profile', $data); 
        $this->view('templates/footer');
    }

    // Proses Update Profil (Foto & Password)
        public function update()
    {
        // Panggil Model (Cleaner)
        if ($this->model('User')->updateDataUser($_POST, $_FILES) > 0) {
            Flasher::setFlash('Berhasil', 'Profil berhasil diperbarui', 'success');
        } else {
            // Sukses tapi tidak ada data berubah (misal cuma klik simpan)
            Flasher::setFlash('Info', 'Data profil tersimpan', 'success');
        }
        
        header('Location: ' . BASEURL . '/user/profile');
        exit;
    }

    // ======================================================
    // BAGIAN 2: FITUR ADMIN (MANAJEMEN USER)
    // ======================================================

    // Tampilkan Semua User (Hanya untuk Admin sebaiknya)
    public function index()
    {
        $data['judul'] = 'Daftar Pengguna';
        $data['users'] = $this->model('User')->getAllUsers();

        $this->view('templates/header', $data);
        // $this->view('templates/sidebar'); // Aktifkan jika kamu punya sidebar
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }

    // Form Tambah User
    public function tambah()
    {
        $data['judul'] = 'Tambah User Baru';
        
        $this->view('templates/header', $data);
        // $this->view('templates/sidebar');
        $this->view('user/create');
        $this->view('templates/footer');
    }

    // Proses Simpan User Baru
    public function simpan()
    {
        // Validasi password match
        if ($_POST['password'] !== $_POST['konfirmasi_password']) {
            Flasher::setFlash('gagal', 'Password tidak cocok', 'danger');
            header('Location: ' . BASEURL . '/user/tambah');
            exit;
        }

        if( $this->model('User')->tambahDataUser($_POST) > 0 ) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
            header('Location: ' . BASEURL . '/user');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }

    // Hapus User
    public function hapus($id)
    {
        if( $this->model('User')->hapusDataUser($id) > 0 ) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/user');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }
}