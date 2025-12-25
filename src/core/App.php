<?php
// Nama File: App.php
// Deskripsi: Kelas Router utama yang memproses URL dan memanggil Controller/Method yang sesuai.

class App {
    // Default controller
    protected $controller = 'HomeController'; 
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        
        // 1. Cek Controller
        if (isset($url[0])) {
            $nama_controller = ucfirst($url[0]) . 'Controller';
            if (file_exists('../src/controllers/' . $nama_controller . '.php')) {
                $this->controller = $nama_controller;
                unset($url[0]);
            }
        }

        require_once '../src/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Cek Method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Kelola Parameter
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 4. Jalankan
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}