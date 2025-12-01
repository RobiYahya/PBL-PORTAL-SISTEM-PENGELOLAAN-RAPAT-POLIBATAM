<?php

class AuthController extends Controller {
    
    // URL: /public/auth
    public function index()
    {
        $data['judul'] = 'Login - Sipera';
        $this->view('templates/header.php', $data);
        $this->view('auth/login.php'); // Pastikan file ini ada di src/views/auth/login.php
        $this->view('templates/footer.php');
    }

    // URL: /public/auth/login
    // Ini yang dipanggil oleh <form action> di login.php
    public function login()
    {
        // Cek apakah ada kiriman data POST
        if (isset($_POST['nik']) && isset($_POST['password'])) {
            
            // Panggil Model User untuk cari data
            // (Kau wajib buat method 'cekUser' di model User nanti)
            $user = $this->model('User')->cekUser($_POST['nik']);

            if ($user) {
                // Verifikasi Password (Gunakan password_verify kalau sudah hash)
                // Untuk sekarang teks biasa:
                if ($_POST['password'] == $user['password']) {
                    
                    // Set Session
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['nama'] = $user['nama_lengkap'];
                    $_SESSION['role'] = $user['jabatan'];
                    $_SESSION['status'] = 'login';

                    // Redirect ke Dashboard
                    // (Pastikan kau punya DashboardController)
                    header('Location: ' . BASEURL . '/dashboard');
                    exit;
                }
            }

            // Jika Gagal
            Flasher::setFlash('Gagal', 'NIK atau Password salah', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // URL: /public/auth/logout
    public function logout()
    {
        session_destroy();
        session_unset();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}