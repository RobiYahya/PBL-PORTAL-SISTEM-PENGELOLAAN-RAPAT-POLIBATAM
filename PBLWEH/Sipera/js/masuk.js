document.addEventListener("DOMContentLoaded", function () {
  // Ambil elemen form login
  const loginForm = document.getElementById("loginForm");

  // Tambahkan event listener untuk submit form
  if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
      // Mencegah form dikirim secara default
      event.preventDefault();

      // Panggil fungsi untuk memvalidasi form
      validateForm();
    });
  }

  /**
   * Fungsi untuk memvalidasi semua field pada form login.
   */
  function validateForm() {
    // Ambil nilai dari input field
    const namaInput = document.getElementById("nama");
    const nimInput = document.getElementById("nim");
    const passwordInput = document.getElementById("password");

    const nama = namaInput.value.trim();
    const nim = nimInput.value.trim();
    const password = passwordInput.value.trim();

    // Ambil elemen pesan error
    const namaError = document.getElementById("namaError");
    const nimError = document.getElementById("nimError");
    const passwordError = document.getElementById("passwordError");

    // Reset semua pesan error dan kelas 'error'
    let isValid = true;

    namaError.style.display = "none";
    namaInput.classList.remove("error");

    nimError.style.display = "none";
    nimInput.classList.remove("error");

    passwordError.style.display = "none";
    passwordInput.classList.remove("error");

    // --- Validasi Nama ---
    if (nama === "") {
      namaError.textContent = "Nama tidak boleh kosong.";
      namaError.style.display = "block";
      namaInput.classList.add("error");
      isValid = false;
    }

    // --- Validasi NIM ---
    if (nim === "") {
      nimError.textContent = "NIM tidak boleh kosong.";
      nimError.style.display = "block";
      nimInput.classList.add("error");
      isValid = false;
    }
    // Anda bisa menambahkan validasi format NIM di sini (misalnya, hanya angka)
    else if (!/^\d+$/.test(nim)) {
      nimError.textContent = "NIM harus berupa angka.";
      nimError.style.display = "block";
      nimInput.classList.add("error");
      isValid = false;
    }

    // --- Validasi Password ---
    if (password === "") {
      passwordError.textContent = "Password tidak boleh kosong.";
      passwordError.style.display = "block";
      passwordInput.classList.add("error");
      isValid = false;
    }

    // --- Proses Login jika semua validasi berhasil ---
    if (isValid) {
      // Tampilkan data login di konsol (hanya untuk debugging/simulasi)
      console.log("Login berhasil! Data yang dikirim:");
      console.log(`Nama: ${nama}`);
      console.log(`NIM: ${nim}`);
      console.log(`Password: ${password}`);

      // Lakukan permintaan AJAX atau Fetch ke server untuk proses otentikasi
      // Contoh simulasi:

      // Tunda sebentar untuk simulasi loading
      alert("Login Berhasil! Mengarahkan ke Dashboard...");

      // Arahkan ke halaman selanjutnya
      window.location.href = "dashboard.html"; // Ganti dengan halaman tujuan Anda
    }
  }
});
