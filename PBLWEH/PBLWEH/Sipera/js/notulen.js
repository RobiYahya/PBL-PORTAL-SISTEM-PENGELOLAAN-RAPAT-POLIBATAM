document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("notulen-form");
  const loadingDiv = document.querySelector(".loading");

  // Mengganti fungsi alert() dengan tampilan pesan kustom yang sederhana
  function showMessage(message, type = "error") {
    const existingMessage = document.querySelector(".custom-message");
    if (existingMessage) existingMessage.remove();

    const messageDiv = document.createElement("div");
    messageDiv.className = `custom-message ${type}`;
    messageDiv.textContent = message;

    // Styling dasar untuk pesan (bisa ditambahkan ke style-notulen.css)
    messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            z-index: 1000;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: opacity 0.3s ease-in-out;
            background-color: ${type === "success" ? "#2ecc71" : "#e74c3c"};
        `;

    document.body.appendChild(messageDiv);

    // Hilangkan pesan setelah 5 detik
    setTimeout(() => {
      messageDiv.style.opacity = "0";
      setTimeout(() => messageDiv.remove(), 300);
    }, 5000);
  }

  // Fungsi untuk memvalidasi dan mengirim form
  function validateAndSubmit(event) {
    event.preventDefault(); // Hentikan pengiriman form default

    // Daftar semua field yang wajib diisi
    const requiredFields = [
      { id: "tanggal", name: "Tanggal Rapat" },
      { id: "waktu", name: "Waktu Rapat" },
      { id: "tempat", name: "Tempat Rapat" },
      { id: "pemimpin", name: "Pemimpin Rapat" },
      { id: "topik", name: "Topik Rapat" },
      { id: "pembahasan", name: "Poin Pembahasan" },
      { id: "keputusan", name: "Keputusan Rapat" },
      { id: "notulis", name: "Nama Notulis" },
    ];

    let isValid = true;
    const emptyFields = [];
    const notulenData = {};

    // Loop melalui semua field untuk validasi
    requiredFields.forEach((field) => {
      const inputElement = document.getElementById(field.id);
      const value = inputElement.value.trim();

      // Hapus kelas error lama
      inputElement.classList.remove("error");

      if (value === "") {
        emptyFields.push(field.name);
        inputElement.classList.add("error");
        isValid = false;
      } else {
        notulenData[field.id] = value;
      }
    });

    // Tampilkan pesan error jika ada field yang kosong
    if (!isValid) {
      const errorMessage =
        "Mohon lengkapi semua field yang wajib diisi:\n" +
        emptyFields.join(", ");
      showMessage(errorMessage, "error");
      return; // Hentikan proses jika validasi gagal
    }

    // --- Proses Penyimpanan Data dan Redirect ---

    // 1. Tampilkan loading indicator
    loadingDiv.textContent = "Memproses data...";
    loadingDiv.style.display = "block";

    // 2. Simpan data notulen ke localStorage
    // Menggunakan JSON.stringify untuk menyimpan objek sebagai string
    try {
      localStorage.setItem("notulenRapatData", JSON.stringify(notulenData));
      console.log(
        "Data notulen berhasil disimpan di localStorage:",
        notulenData
      );

      // 3. Simulasikan proses loading singkat (opsional)
      setTimeout(() => {
        loadingDiv.textContent = "";
        loadingDiv.style.display = "none";

        showMessage(
          "Notulen berhasil disimpan! Mengarahkan ke halaman hasil.",
          "success"
        );

        // 4. Redirect ke halaman hasil
        window.location.href = "hasil-notulen.html";
      }, 1000); // Tunggu 1 detik untuk simulasi proses
    } catch (e) {
      loadingDiv.style.display = "none";
      showMessage(
        "Gagal menyimpan data. Storage mungkin penuh atau tidak didukung.",
        "error"
      );
      console.error("Local Storage Error:", e);
    }
  }

  // Pasang event listener ke form
  form.addEventListener("submit", validateAndSubmit);

  // Tambahkan event listener untuk membersihkan kelas error saat input berubah
  form.querySelectorAll("input, textarea").forEach((input) => {
    input.addEventListener("input", () => {
      if (input.value.trim() !== "") {
        input.classList.remove("error");
      }
    });
  });
});
