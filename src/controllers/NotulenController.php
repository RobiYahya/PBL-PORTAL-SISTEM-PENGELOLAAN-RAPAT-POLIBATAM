<?php
// Nama File: NotulenController.php
// Deskripsi: Mengelola upload file notulen rapat.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

class NotulenController extends Controller {
    
    public function __construct()
    {
        if ($_SESSION['status'] != 'login') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // Menampilkan form upload
    public function upload($id_rapat)
    {
        $data['judul'] = 'Upload Notulen';
        $data['rapat'] = $this->model('Rapat')->getRapatById($id_rapat);

        $this->view('templates/header', $data);
        $this->view('templates/sidebar');
        $this->view('notulen/upload', $data);
        $this->view('templates/footer');
    }

    // Proses Upload
    public function prosesUpload()
    {
        $namaFile   = $_FILES['file_notulen']['name'];
        $ukuranFile = $_FILES['file_notulen']['size'];
        $error      = $_FILES['file_notulen']['error'];
        $tmpName    = $_FILES['file_notulen']['tmp_name'];

        if ($error === 4) {
            Flasher::setFlash('gagal', 'Pilih file notulen dulu!', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            return false;
        }

        $ekstensiValid = ['pdf', 'doc', 'docx'];
        $ekstensiFile  = explode('.', $namaFile);
        $ekstensiFile  = strtolower(end($ekstensiFile));

        if (!in_array($ekstensiFile, $ekstensiValid)) {
            Flasher::setFlash('gagal', 'Yang anda upload bukan PDF/Dokumen!', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            return false;
        }

        if ($ukuranFile > 2000000) {
            Flasher::setFlash('gagal', 'Ukuran file terlalu besar (Max 2MB)!', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            return false;
        }

        $namaFileBaru = uniqid() . '_' . $namaFile;
        move_uploaded_file($tmpName, '../public/uploads/' . $namaFileBaru);

        if( $this->model('Rapat')->updateNotulen($_POST['id_rapat'], $namaFileBaru) > 0 ) {
            Flasher::setFlash('berhasil', 'Notulen berhasil diupload', 'success');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        } else {
            Flasher::setFlash('gagal', 'Upload gagal database', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            exit;
        }
    }
}