<?php

class DashboardController extends Controller {
    
    public function __construct()
    {
        // Cegah akses tanpa login
        if ($_SESSION['status'] != 'login') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Dashboard - Sipera';
        $data['nama'] = $_SESSION['nama']; // Ambil nama dari sesi
        
        // Contoh ambil data rapat dari Model
        // $data['rapat'] = $this->model('Rapat')->getAllRapat();

        $this->view('templates/header', $data);
        $this->view('templates/sidebar'); // Navigasi pisah ke sini
        $this->view('dashboard/index', $data); // Isi dashboard utama
        $this->view('templates/footer');
    }
}