<?php

class RapatController extends Controller {
    
    public function __construct()
    {
        if ($_SESSION['status'] != 'login') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // URL: /public/rapat
    public function index()
    {
        $data['judul'] = 'Daftar Rapat';
        // Panggil model untuk ambil semua data rapat
        $data['rapat'] = $this->model('Rapat')->getAllRapat();

        $this->view('templates/header', $data);
        $this->view('templates/sidebar');
        $this->view('rapat/index', $data); // Tabel daftar rapat
        $this->view('templates/footer');
    }

    // URL: /public/rapat/tambah
    public function tambah()
    {
        $data['judul'] = 'Buat Rapat Baru';
        
        $this->view('templates/header', $data);
        $this->view('templates/sidebar');
        $this->view('rapat/create'); // Form input rapat
        $this->view('templates/footer');
    }

    // URL: /public/rapat/simpan
    public function simpan()
    {
        // Panggil method tambahDataRapat di model
        // $_POST dikirim bulat-bulat ke model
        if( $this->model('Rapat')->tambahDataRapat($_POST) > 0 ) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
    }
}