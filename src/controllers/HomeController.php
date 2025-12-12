<?php

class HomeController extends Controller {
    public function index()
    {
        // LOGIKA PINTAR:
        // Jika user ternyata SUDAH login, jangan kasih lihat landing page.
        // Langsung antar ke Rapat Saya.
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $data['judul'] = 'Sipera - Portal Rapat Polibatam';
        
        // Kita pakai header yang sama, karena di header sudah ada logika:
        // "Kalau belum login, tampilkan tombol Masuk/Daftar"
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}