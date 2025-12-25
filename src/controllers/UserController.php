<?php
// Nama File: UserController.php
// Deskripsi: Mengelola data Profil Pengguna dan CRUD User (Admin).

class UserController extends Controller {
    
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    // ======================================================
    // BAGIAN 1: FITUR PROFIL PENGGUNA
    // ======================================================

    public function profile()
    {
        $data['judul'] = 'Profil Saya';
        $data['user']  = $this->model('User')->getUserById($_SESSION['user_id']);

        $this->view('templates/header', $data);
        $this->view('user/profile', $data); 
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($this->model('User')->updateDataUser($_POST, $_FILES) > 0) {
            Flasher::setFlash('Berhasil', 'Profil berhasil diperbarui', 'success');
        } else {
            Flasher::setFlash('Info', 'Data profil tersimpan', 'success');
        }
        
        header('Location: ' . BASEURL . '/user/profile');
        exit;
    }

    // ======================================================
    // BAGIAN 2: FITUR ADMIN (MANAJEMEN USER)
    // ======================================================

    public function index()
    {
        $data['judul'] = 'Daftar Pengguna';
        $data['users'] = $this->model('User')->getAllUsers();

        $this->view('templates/header', $data);
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        $data['judul'] = 'Tambah User Baru';
        
        $this->view('templates/header', $data);
        $this->view('user/create');
        $this->view('templates/footer');
    }

    public function simpan()
    {
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

    public function hapus($id)
    {
        // Pastikan model User memiliki method hapusDataUser
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