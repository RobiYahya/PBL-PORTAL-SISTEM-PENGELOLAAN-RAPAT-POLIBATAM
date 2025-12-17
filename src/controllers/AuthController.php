<?php
// Nama File: AuthController.php
// Deskripsi: Mengelola proses Autentikasi (Login, Register, Logout).
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

class AuthController extends Controller {
    
    // 1. HALAMAN FORM LOGIN
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $data['judul'] = 'Login';
        $this->view('templates/header', $data);
        $this->view('auth/login');
        $this->view('templates/footer_auth');
    }

    // 2. PROSES LOGIN
    public function login()
    {
        if (empty($_POST)) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $user = $this->model('User')->cekLogin($_POST['nik'], $_POST['password']);

        if ($user) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama_lengkap'];
            $_SESSION['nik']     = $user['nik'];
            $_SESSION['role']    = $user['jabatan'];
            $_SESSION['status']  = 'login';
            
            // Cek Undangan Baru (Notifikasi Popup)
            $undanganBaru = $this->model('User')->getUndanganBaru($user['id_user']);
            
            if (!empty($undanganBaru)) {
                $judul = [];
                foreach($undanganBaru as $u) {
                    $judul[] = $u['judul_rapat'];
                }
                $daftarRapat = implode(', ', $judul);

                $_SESSION['popup_type']  = 'info';
                $_SESSION['popup_title'] = 'Undangan Rapat Baru! 📩';
                $_SESSION['popup_text']  = "Anda telah diundang ke: " . $daftarRapat;

                $this->model('User')->tandaiUndanganDibaca($user['id_user']);
            }
            header('Location: ' . BASEURL . '/rapat');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'NIK atau Password salah', 'danger');
            header('Location: ' . BASEURL . '/auth'); 
            exit;
        }
    }

    // 3. HALAMAN REGISTER
    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
        $data['judul'] = 'Daftar Akun';
        $this->view('templates/header', $data);
        $this->view('auth/register');
        $this->view('templates/footer_auth');
    }

    // 4. PROSES REGISTER
    public function prosesRegister()
    {
        if ($_POST['password'] !== $_POST['ulangi_password']) {
            Flasher::setFlash('Gagal', 'Konfirmasi password tidak cocok', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }
        
        $data['jabatan'] = 'dosen'; // Default role
        
        if ($this->model('User')->tambahDataUser($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'Akun berhasil dibuat, silakan login', 'success');
            header('Location: ' . BASEURL . '/auth');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'NIK sudah terdaftar', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }
    }

    // 5. LOGOUT
    public function logout()
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}