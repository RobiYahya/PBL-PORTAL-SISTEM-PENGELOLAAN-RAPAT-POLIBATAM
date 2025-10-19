document.addEventListener('DOMContentLoaded', () => {

    // --- DATA & SESI ---
    let session = {
        userId: 'user-budi',
        role: 'anggota',
    };
        const allRooms = [
        { id: 1, name: "Ruang GU 701", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 2, name: "Ruang GU 704", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 3, name: "Ruang GU 705", image: "../foto/room.jpg", status: "Terpakai" },
        { id: 4, name: "Aula Mini Gedung B", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 6, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 7, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 8, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 9, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 10, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 11, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 12, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 13, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 14, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 15, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 16, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 17, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 18, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 19, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 20, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 21, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 22, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 23, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 24, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 25, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 26, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 27, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 28, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 29, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 30, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 31, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 32, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 33, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 34, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 35, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 36, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 37, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 38, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 39, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 40, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 41, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
        { id: 42, name: "Ruangan ", image: "../foto/room.jpg", status: "Tersedia" },
    ];

    let allMeetings = [
        { id: 101, kode: 'PBL777', judul: 'Rapat Finalisasi Laporan PBL', tanggal: '2025-10-20', waktu: '10:00', ruanganId: 3, ruanganName: 'Laboratorium Jaringan', ketuaId: 'user-chandra', anggotaIds: [] }
    ];

    const mainContent = document.getElementById('main-content');
    const rapatSayaLink = document.getElementById('rapat-saya-link');
    const navNotulensi = document.getElementById('nav-notulensi');
    const kodeRapatInput = document.getElementById('kode-rapat');
    const kodeRapatBtn = document.querySelector('.sidebar-feature .input-group button');
    const navListRuangan = document.getElementById('nav-list-ruangan');

// --- FUNGSI BARU UNTUK MENGATUR TAMPILAN ---
    const showView = (viewId) => {
        // Sembunyikan semua view
        document.querySelectorAll('.view-container').forEach(view => {
            view.classList.add('hidden');
        });
        // Tampilkan view yang dipilih
        const activeView = document.getElementById(viewId);
        if (activeView) {
            activeView.classList.remove('hidden');
        }
    };

    // --- FUNGSI "PELUKIS" YANG SUDAH DIMODIFIKASI ---

    const renderRapatSayaView = () => {
        showView('rapat-saya-view');
        const myMeetings = allMeetings.filter(m => m.ketuaId === session.userId || m.anggotaIds.includes(session.userId));
        const tbody = document.getElementById('rapat-saya-tbody');

        if (myMeetings.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Anda belum terlibat dalam rapat apapun.</td></tr>';
            return;
        }

        tbody.innerHTML = myMeetings.map((meeting, index) => {
            const isKetua = meeting.ketuaId === session.userId;
            const peran = isKetua ? 'Ketua' : 'Anggota';
            const actions = isKetua ?
                `<button class="edit-btn" data-id="${meeting.id}">Edit</button> <button class="delete-btn" data-id="${meeting.id}">Hapus</button>` :
                `<button class="btn-secondary btn-lihat-detail" data-id="${meeting.id}">Lihat Detail</button>`;
            return `
                <tr>
                    <td style="text-align: center;">${index + 1}</td>
                    <td>${meeting.judul}</td>
                    <td>${peran}</td>
                    <td>${meeting.tanggal}</td>
                    <td class="actions-btn">${actions}</td>
                </tr>
            `;
        }).join('');
    };
    
    const renderListRuanganView = () => {
        showView('list-ruangan-view');
        const roomGrid = document.getElementById('room-grid-container');
        const sortedRooms = [...allRooms];
        roomGrid.innerHTML = sortedRooms.map(room => `
            <div class="room-card">
                <div class="room-card-image"><img src="${room.image || '../foto/default.jpg'}" alt="${room.name}"></div>
                <div class="room-card-content">
                    <h3>${room.name}</h3>
                    <p>Status: <strong>${room.status}</strong></p>
                    <div class="room-card-actions">
                        <button class="btn-secondary btn-reservasi" data-id="${room.id}" ${room.status === 'Terpakai' ? 'disabled' : ''}>Reservasi</button>
                    </div>
                </div>
            </div>
        `).join('');
    };

    const renderReservasiView = (room) => {
        showView('reservasi-view');
        // Isi nilai form yang sudah ada di HTML
        document.getElementById('reservasi-nama-ruangan').value = room.name;
        document.getElementById('reservasi-form').dataset.roomId = room.id; // Simpan ID ruangan
    };

    const renderRapatDetailView = (meeting, mode = 'lihat_detail') => {
        showView('rapat-detail-view');
        const [tahun, bulan, hari] = meeting.tanggal.split('-');
        const tanggalFormatted = `${hari}/${bulan}/${tahun}`;
        
        const titleEl = document.getElementById('detail-view-title');
        const subtitleEl = document.getElementById('detail-view-subtitle');

        if (mode === 'sukses_reservasi') {
            titleEl.textContent = 'Reservasi Berhasil!';
            subtitleEl.textContent = 'Anda sekarang adalah Ketua untuk rapat berikut:';
        } else {
            titleEl.textContent = 'Detail Rapat';
            subtitleEl.textContent = 'Informasi lengkap mengenai rapat yang Anda ikuti.';
        }
        
        // Isi detail ke elemen yang sudah ada di HTML
        document.getElementById('detail-judul').textContent = meeting.judul;
        document.getElementById('detail-tanggal').textContent = tanggalFormatted;
        document.getElementById('detail-waktu').textContent = meeting.waktu;
        document.getElementById('detail-ruangan').textContent = meeting.ruanganName;
        document.getElementById('detail-kode').textContent = meeting.kode;
    };
    
    // --- FUNGSI LOGIKA (EVENT HANDLERS) ---

    const handleMainContentClick = (event) => {
        const target = event.target;
        if (target.classList.contains('btn-reservasi')) {
            const roomId = parseInt(target.dataset.id);
            const selectedRoom = allRooms.find(r => r.id === roomId);
            renderReservasiView(selectedRoom);
        }
        if (target.classList.contains('btn-lihat-detail')) {
            const meetingId = parseInt(target.dataset.id);
            const selectedMeeting = allMeetings.find(m => m.id === meetingId);
            renderRapatDetailView(selectedMeeting, 'lihat_detail');
        }
    };

    const handleReservasiSubmit = () => {
        const form = document.getElementById('reservasi-form');
        const roomId = parseInt(form.dataset.roomId);
        const room = allRooms.find(r => r.id === roomId);

        if (!room) {
            alert('Error: Ruangan tidak ditemukan!');
            return;
        }
        
        const newMeeting = {
            id: Date.now(),
            kode: Math.random().toString(36).substring(2, 8).toUpperCase(),
            judul: document.getElementById('judul-rapat').value,
            tanggal: document.getElementById('tanggal-rapat').value,
            waktu: document.getElementById('waktu-rapat').value,
            ruanganId: roomId,
            ruanganName: room.name,
            ketuaId: session.userId,
            anggotaIds: [],
            notulen: ''
        };
        allMeetings.push(newMeeting);
        room.status = 'Terpakai';
        updateDynamicMenus();
        renderRapatDetailView(newMeeting, 'sukses_reservasi');
    };

    const handleJoinMeetingByCode = () => {
        const inputKode = kodeRapatInput.value.trim().toUpperCase();
        if (!inputKode) { alert('Silakan masukkan Kode Rapat.'); return; }

        const foundMeeting = allMeetings.find(m => m.kode === inputKode);

        if (foundMeeting) {
            const userAlreadyJoined = foundMeeting.anggotaIds.includes(session.userId) || foundMeeting.ketuaId === session.userId;
            if (userAlreadyJoined) { alert('Anda sudah tergabung dalam rapat ini.'); return; }
            
            foundMeeting.anggotaIds.push(session.userId);

            updateDynamicMenus();
            alert(`Anda berhasil bergabung dengan rapat "${foundMeeting.judul}"!`);
            renderRapatDetailView(foundMeeting, 'lihat_detail');
        } else {
            alert('Kode Rapat tidak ditemukan atau salah.');
        }
        kodeRapatInput.value = '';
    };

    const updateDynamicMenus = () => {
        const userMeetings = allMeetings.filter(m => m.ketuaId === session.userId || m.anggotaIds.includes(session.userId));
        const isKetuaInAnyMeeting = allMeetings.some(m => m.ketuaId === session.userId);

        if (userMeetings.length > 0) {
            rapatSayaLink.classList.remove('hidden');
        } else {
            rapatSayaLink.classList.add('hidden');
        }

        if (isKetuaInAnyMeeting) {
            session.role = 'ketua';
            navNotulensi.classList.remove('hidden');
        } else {
            session.role = 'anggota';
            navNotulensi.classList.add('hidden');
        }
    };

    // --- INISIALISASI ---
    const initializeDashboard = () => {
        renderListRuanganView();
        mainContent.addEventListener('click', handleMainContentClick);
        kodeRapatBtn.addEventListener('click', handleJoinMeetingByCode);
        rapatSayaLink.addEventListener('click', (e) => { e.preventDefault(); renderRapatSayaView(); });
        navListRuangan.addEventListener('click', (e) => { e.preventDefault(); renderListRuanganView(); });
        document.getElementById('kembali-btn').addEventListener('click', renderListRuanganView);
        document.getElementById('reservasi-form').addEventListener('submit', (e) => { e.preventDefault(); handleReservasiSubmit(); });
        document.getElementById('kembali-ke-list').addEventListener('click', renderRapatSayaView);
        updateDynamicMenus();
    };
    initializeDashboard();
});