<?php

class NotulenController extends Controller {
    
    public function __construct()
    {
        if ($_SESSION['status'] != 'login') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // Menampilkan form upload untuk rapat tertentu
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
        // 1. Ambil File
        $namaFile = $_FILES['file_notulen']['name'];
        $ukuranFile = $_FILES['file_notulen']['size'];
        $error = $_FILES['file_notulen']['error'];
        $tmpName = $_FILES['file_notulen']['tmp_name'];

        // 2. Cek apakah ada file yang diupload
        if ($error === 4) {
            Flasher::setFlash('gagal', 'Pilih file notulen dulu!', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            return false;
        }

        // 3. Cek Ekstensi (Hanya PDF yang boleh)
        $ekstensiValid = ['pdf', 'doc', 'docx'];
        $ekstensiFile = explode('.', $namaFile);
        $ekstensiFile = strtolower(end($ekstensiFile));

        if (!in_array($ekstensiFile, $ekstensiValid)) {
            Flasher::setFlash('gagal', 'Yang anda upload bukan PDF/Dokumen!', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            return false;
        }

        // 4. Cek Ukuran (Max 2MB)
        if ($ukuranFile > 2000000) {
            Flasher::setFlash('gagal', 'Ukuran file terlalu besar (Max 2MB)!', 'danger');
            header('Location: ' . BASEURL . '/rapat');
            return false;
        }

        // 5. Generate Nama Baru (Agar tidak menimpa file lain)
        // Contoh: 656473_RapatAnggaran.pdf
        $namaFileBaru = uniqid() . '_' . $namaFile;

        // 6. Pindahkan File ke folder public/uploads
        // Pastikan folder 'uploads' sudah dibuat di dalam 'public'!
        move_uploaded_file($tmpName, '../public/uploads/' . $namaFileBaru);

        // 7. Update Database (Simpan Nama Filenya Saja)
        // Kita pakai model Rapat karena kolom file_notulen ada di tabel rapat
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