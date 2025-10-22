document.addEventListener('DOMContentLoaded', () => {
    const navItems = document.querySelectorAll('.sidebar-nav .nav-item');
    const views = document.querySelectorAll('.view-container');
    const modalContainer = document.getElementById('modal-container');
    const modalTitle = document.getElementById('modal-title');
    const modalForm = document.getElementById('modal-form');

    // Fungsi untuk menampilkan view tertentu
    window.showView = (viewId) => {
        // Sembunyikan semua view
        views.forEach(view => view.classList.add('hidden'));
        
        // Tampilkan view yang dipilih
        const targetView = document.getElementById(viewId + '-view');
        if (targetView) {
            targetView.classList.remove('hidden');
        }

        // Atur status aktif di sidebar
        navItems.forEach(item => item.classList.remove('active'));
        const activeItem = document.querySelector(`.sidebar-nav .nav-item[data-view="${viewId}"]`);
        if (activeItem) {
            activeItem.classList.add('active');
        }
    };

    // Event listener untuk navigasi sidebar
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const viewId = item.getAttribute('data-view');
            showView(viewId);
        });
    });

    // Default: tampilkan overview saat pertama kali dimuat
    showView('overview');


    // --- Logika Modal (Contoh) ---
    window.openAddUserModal = () => {
        modalTitle.textContent = "Tambah Pengguna Baru";
        modalForm.innerHTML = `
            <div class="form-group">
                <label for="modal-name">Nama:</label>
                <input type="text" id="modal-name" class="neumorphism-input" required placeholder="Nama Lengkap">
            </div>
            <div class="form-group">
                <label for="modal-nim">NIM:</label>
                <input type="text" id="modal-nim" class="neumorphism-input" required placeholder="NIM/NIP">
            </div>
            <div class="form-group">
                <label for="modal-role">Peran:</label>
                <select id="modal-role" class="neumorphism-input" required>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Dosen">Dosen</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
            <div class="form-group">
                <label for="modal-password">Password Awal:</label>
                <input type="password" id="modal-password" class="neumorphism-input" required>
            </div>
        `;
        modalContainer.style.display = 'flex';
    };

    window.openAddRoomModal = () => {
        modalTitle.textContent = "Tambah Ruangan Baru";
        modalForm.innerHTML = `
            <div class="form-group">
                <label for="modal-room-name">Nama Ruangan:</label>
                <input type="text" id="modal-room-name" class="neumorphism-input" required placeholder="Contoh: GU Ruang 705">
            </div>
            <div class="form-group">
                <label for="modal-capacity">Kapasitas:</label>
                <input type="number" id="modal-capacity" class="neumorphism-input" required value="20">
            </div>
            <div class="form-group">
                <label for="modal-facilities">Fasilitas (pisahkan dengan koma):</label>
                <input type="text" id="modal-facilities" class="neumorphism-input" placeholder="Projector, AC, Whiteboard">
            </div>
        `;
        modalContainer.style.display = 'flex';
    };

    window.closeModal = () => {
        modalContainer.style.display = 'none';
        modalForm.innerHTML = ''; // Kosongkan form setelah ditutup
    };

    // Menutup modal jika klik di luar form
    modalContainer.addEventListener('click', (e) => {
        if (e.target === modalContainer) {
            closeModal();
        }
    });

    // Contoh submit handler
    modalForm.addEventListener('submit', (e) => {
        e.preventDefault();
        alert("Data berhasil disimpan! (Ini hanya simulasi)");
        closeModal();
        // Di sini seharusnya ada AJAX call untuk menyimpan data ke server
    });


    // --- Data Mockup untuk Simulasi ---
    // Di lingkungan nyata, data ini akan diambil dari API.
    
    // Fungsi untuk memuat data pengguna (simulasi)
    const loadUserTable = () => {
        const userData = [
            // Data sudah ada di HTML
            { id: 2, name: 'Dina Amelia', nim: '332101002', email: 'dina@polibatam.ac.id', role: 'Dosen', status: 'Aktif' },
            { id: 3, name: 'Budi Santoso', nim: '332101003', email: 'budi@polibatam.ac.id', role: 'Mahasiswa', status: 'Non-Aktif' },
        ];
        const tbody = document.getElementById('user-table-body');
        // Clear existing rows (keep the initial one)
        // tbody.innerHTML = ''; 

        userData.forEach((user, index) => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${index + 2}</td>
                <td>${user.name}</td>
                <td>${user.nim}</td>
                <td>${user.email}</td>
                <td>${user.role}</td>
                <td>${user.status}</td>
                <td>
                    <button class="btn-edit"><i class="fas fa-pen"></i></button>
                    <button class="btn-delete"><i class="fas fa-trash"></i></button>
                </td>
            `;
        });
    };

    // Panggil fungsi saat DOM selesai dimuat
    loadUserTable();
});