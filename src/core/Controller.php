<?php
// Nama File: Controller.php
// Deskripsi: Kelas induk (Base Controller) untuk memuat View dan Model.
// Dibuat oleh: [NAMA_PENULIS] - NIM: [NIM]
// Tanggal: [TANGGAL_HARI_INI]

class Controller {
    
    // Fungsi untuk memanggil View
    public function view($view, $data = [])
    {
        if (file_exists('../src/views/' . $view . '.php')) {
            require_once '../src/views/' . $view . '.php';
        } else {
            die("Error: View '$view' tidak ditemukan di folder src/views!");
        }
    }

    // Fungsi untuk memanggil Model
    public function model($model)
    {
        if (file_exists('../src/models/' . $model . '.php')) {
            require_once '../src/models/' . $model . '.php';
            return new $model;
        } else {
            die("Error: Model '$model' tidak ditemukan di folder src/models!");
        }
    }
}