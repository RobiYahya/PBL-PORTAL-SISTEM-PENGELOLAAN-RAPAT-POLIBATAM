<?php

class Controller {
    
    // Fungsi untuk memanggil View (Tampilan)
    public function view($view, $data = [])
    {
        // Cek file view
        if (file_exists('../src/views/' . $view . '.php')) {
            require_once '../src/views/' . $view . '.php';
        } else {
            // Error handling untuk developer (Hapus saat production)
            die("Error: View '$view' tidak ditemukan di folder src/views!");
        }
    }

    // Fungsi untuk memanggil Model (Database Logic)
    public function model($model)
    {
        // Cek file model
        if (file_exists('../src/models/' . $model . '.php')) {
            require_once '../src/models/' . $model . '.php';
            return new $model;
        } else {
            die("Error: Model '$model' tidak ditemukan di folder src/models!");
        }
    }
}