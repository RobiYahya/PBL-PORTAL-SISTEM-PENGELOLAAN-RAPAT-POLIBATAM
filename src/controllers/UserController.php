<?php

class UserController extends Controller {
    
    public function __construct()
    {
        // Gembok Keamanan: Cek Login
        if ($_SESSION['status'] != 'login') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
        
        // Opsional: Cek apakah role-nya Admin?
        // if ($_SESSION['role'] != 'admin') { ... tendang ... }
    }

    // Tampilkan Semua User
    public function index()
    {
        $data['judul'] = 'Daftar Pengguna';
        $data['users'] = $this->model('User')->getAllUsers(); // Pastikan method ini ada di Model

        $this->view('templates/header', $data);
        $this->view('templates/sidebar');
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }

    // Form Tambah User
    public function tambah()
    {
        $data['judul'] = 'Tambah User Baru';
        
        $this->view('templates/header', $data);
        $this->view('templates/sidebar');
        $this->view('user/create');
        $this->view('templates/footer');
    }

    // Proses Simpan User Baru
    public function simpan()
    {
        // Validasi password match (jika ada konfirmasi password)
        if ($_POST['password'] !== $_POST['konfirmasi_password']) {
            Flasher::setFlash('gagal', 'Password tidak cocok', 'danger');
            header('Location: ' . BASEURL . '/user/tambah');
            exit;
        }

        // Kirim ke Model
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