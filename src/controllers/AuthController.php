<?php

class AuthController extends Controller {
    
    // 1. HALAMAN FORM LOGIN (URL: /auth)
    public function index()
    {
        // --- PENGUSIRAN 1: JIKA SUDAH LOGIN, TENDANG KE DASHBOARD ---
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
        // ------------------------------------------------------------

        $data['judul'] = 'Login';
        $this->view('templates/header', $data);
        $this->view('auth/login');
        $this->view('templates/footer');
    }

    // 2. PROSES LOGIN (URL: /auth/login)
    public function login()
    {
        // Cek apakah ada data yang dikirim?
        if (empty($_POST)) {
            // Jika orang iseng buka /auth/login langsung tanpa kirim data,
            // kembalikan ke form login (/auth), JANGAN ke diri sendiri (/auth/login)
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $user = $this->model('User')->cekLogin($_POST['nik'], $_POST['password']);

        if ($user) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama_lengkap'];
            $_SESSION['nik'] = $user['nik'];
            $_SESSION['role'] = $user['jabatan'];
            $_SESSION['status'] = 'login';
            
            $undanganBaru = $this->model('User')->getUndanganBaru($user['id_user']);
            
            if (!empty($undanganBaru)) {
                // Ambil judul-judul rapatnya
                $judul = [];
                foreach($undanganBaru as $u) {
                    $judul[] = $u['judul_rapat'];
                }
                $daftarRapat = implode(', ', $judul);

                // Siapkan Pesan Popup
                $_SESSION['popup_type'] = 'info';
                $_SESSION['popup_title'] = 'Undangan Rapat Baru! 📩';
                $_SESSION['popup_text'] = "Anda telah diundang ke: " . $daftarRapat;

                // Tandai sudah dibaca di database (Supaya nanti pas refresh gak muncul lagi)
                $this->model('User')->tandaiUndanganDibaca($user['id_user']);
            }
            header('Location: ' . BASEURL . '/rapat');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'NIK atau Password salah', 'danger');
            
            // --- PERBAIKAN PENTING DI SINI ---
            // Kembalikan ke '/auth' (Halaman Form), BUKAN '/auth/login' (Proses)
            header('Location: ' . BASEURL . '/auth'); 
            exit;
        }
    }

    public function register()
    {
        // --- PENGUSIRAN 2: JIKA SUDAH LOGIN, TENDANG KE DASHBOARD ---
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
        $data['judul'] = 'Daftar Akun';
        $this->view('templates/header', $data);
        $this->view('auth/register');
        $this->view('templates/footer');
    }

    public function prosesRegister()
    {
        if ($_POST['password'] !== $_POST['ulangi_password']) {
            Flasher::setFlash('Gagal', 'Konfirmasi password tidak cocok', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        if ($this->model('User')->tambahDataUser($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'Akun berhasil dibuat, silakan login', 'success');
            
            // Redirect ke form login
            header('Location: ' . BASEURL . '/auth');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'NIK sudah terdaftar', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }
    }

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
        
        // Redirect ke form login
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}