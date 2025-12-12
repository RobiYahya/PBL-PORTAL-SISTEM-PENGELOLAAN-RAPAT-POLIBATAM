<?php

class DashboardController extends Controller {
    
    public function __construct()
    {
        // Kalau belum login, tendang ke Auth.
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }


    public function index()
    {
        $data['judul'] = 'Beranda - Sipera';
        $data['nama'] = $_SESSION['nama']; // Ambil nama dari sesi
        
        // Contoh ambil data rapat dari Model
        // $data['rapat'] = $this->model('Rapat')->getAllRapat();

        $this->view('templates/header', $data);
        $this->view('templates/sidebar'); // Navigasi pisah ke sini
        $this->view('dashboard/index', $data); // Isi dashboard utama
        $this->view('templates/footer');
    }
}