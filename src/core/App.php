<?php

class App {
    // Default controller jika URL kosong (misal: buka localhost/sipera/public)
    // Pastikan kau punya DashboardController.php nanti!
    protected $controller = 'DashboardController'; 
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        // 1. Ambil URL yang sudah dipecah
        $url = $this->parseURL();
        
        // 2. Cek apakah file Controller ada?
        // URL[0] adalah nama controller (misal: public/auth/login -> auth)
        if (isset($url[0])) {
            // Ubah huruf awal jadi kapital + "Controller" (misal: auth -> AuthController)
            $nama_controller = ucfirst($url[0]) . 'Controller';
            
            if (file_exists('../src/controllers/' . $nama_controller . '.php')) {
                $this->controller = $nama_controller;
                unset($url[0]);
            }
        }

        // 3. Panggil file controller-nya
        require_once '../src/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 4. Cek Method (Fungsi di dalam Controller)
        // URL[1] adalah nama method (misal: public/auth/login -> login)
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 5. Kelola Parameter (Sisa URL)
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 6. Jalankan Controller & Method, kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            // Bersihkan URL dari karakter aneh
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Pecah URL berdasarkan tanda '/'
            $url = explode('/', $url);
            return $url;
        }
    }
}