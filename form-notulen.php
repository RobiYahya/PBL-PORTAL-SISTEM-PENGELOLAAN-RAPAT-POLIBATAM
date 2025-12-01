<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Notulen Rapat - Sipera</title>
    <link rel="stylesheet" href="./public/css/style-daftar.css" />
    <link rel="stylesheet" href="./public/css/responsive.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="main-center">
        <div class="registration-container neumorphic-panel">
            <div class="header-section">
                <img src="./public/foto/logo.png" alt="Logo Sipera" class="logo" />
                <h2 class="main-title">Form Pencatatan Notulen <i class="fas fa-clipboard-list"></i></h2>
                <p class="subtitle">
                    Anda sedang mencatat notulen untuk rapat:<br>
                    <strong id="judulRapatDisplay">Loading...</strong>
                </p>
                <p class="mt-10">
                    <small>ID Rapat: <span id="rapatIdDisplay"></span></small>
                </p>
            </div>

            <form id="notulenForm">
                
                <div class="form-group">
                    <label for="tanggalRapat" class="neumorphic-label">Tanggal Rapat</label>
                    <div class="neumorphic-input-readonly">
                        <span id="displayTanggalRapat">25 Desember 2025</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notulis" class="neumorphic-label">Notulis (Nama Admin)</label>
                    <div class="neumorphic-input-readonly">
                        <span id="displayNotulis">Admin Sipera</span>
                    </div>
                </div>

                <hr class="neumorphic-divider">
                
                <div class="form-group">
                    <label for="agenda" class="neumorphic-label">Agenda Rapat Utama</label>
                    <textarea
                        id="agenda"
                        name="agenda"
                        class="neumorphic-textarea"
                        placeholder="Tuliskan daftar agenda utama yang dibahas..."
                        rows="3"
                        required
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="poinDiskusi" class="neumorphic-label">Poin-Poin Diskusi & Hasil Keputusan</label>
                    <textarea
                        id="poinDiskusi"
                        name="poinDiskusi"
                        class="neumorphic-textarea"
                        placeholder="Catat poin diskusi penting dan keputusan yang diambil..."
                        rows="8"
                        required
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="tindakLanjut" class="neumorphic-label">Tindak Lanjut (Action Items)</label>
                    <textarea
                        id="tindakLanjut"
                        name="tindakLanjut"
                        class="neumorphic-textarea"
                        placeholder="Sebutkan tugas/tanggung jawab yang perlu ditindaklanjuti dan PIC-nya..."
                        rows="4"
                    ></textarea>
                </div>

                <div class="form-group checkbox-group mt-20">
                    <input type="checkbox" id="selesai" name="selesai" class="neumorphic-checkbox">
                    <label for="selesai" class="neumorphic-checkbox-label">
                        Centang jika pencatatan notulen **SELESAI** dan siap dipublikasikan.
                    </label>
                </div>

                <button type="submit" class="neumorphic-btn btn-primary">
                    <i class="fas fa-save"></i> Simpan dan Publikasikan Notulen
                </button>
                <div class="mt-10 text-center">
                    <a href="#" id="kembaliDetail" class="text-secondary-dark neumorphic-text-link">
                        <i class="fas fa-arrow-left"></i> Kembali ke Detail Rapat
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="js/script-notulen.js"></script>
</body>
</html>