<?php
// Nama File: DashboardController.php
// Deskripsi: Controller untuk halaman dashboard utama (opsional jika redirect ke RapatController).

class DashboardController extends Controller {
    
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Beranda - Sipera';
        $data['nama']  = $_SESSION['nama'];
        
        $this->view('templates/header', $data);
        $this->view('templates/sidebar'); 
        $this->view('dashboard/index', $data); 
        $this->view('templates/footer');
    }
}