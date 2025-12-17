<?php
// Nama File: HomeController.php
// Deskripsi: Controller untuk halaman depan (Landing Page).
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

class HomeController extends Controller {
    public function index()
    {
        // Jika sudah login, langsung ke Dashboard Rapat
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }

        $data['judul'] = 'Sipera - Portal Rapat Polibatam';
        
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}