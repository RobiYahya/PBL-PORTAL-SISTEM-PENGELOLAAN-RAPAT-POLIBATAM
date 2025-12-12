<main class="container notulen-main">
    <h1 class="main-title">📝 Upload Notulen Rapat</h1>

    <section class="notulen-form-section neumorphism-card">
        <h2>Rapat: <?= $data['rapat']['judul_rapat']; ?></h2>
        
        <form action="<?= BASEURL; ?>/notulen/prosesUpload" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_rapat" value="<?= $data['rapat']['id_rapat']; ?>">

            <div class="form-group">
                <label>Tanggal Rapat:</label>
                <input type="text" value="<?= date('d M Y', strtotime($data['rapat']['tanggal_rapat'])); ?>" disabled class="neumorphic-input" />
            </div>

            <div class="form-group">
                <label>Pilih File Notulen (PDF/DOCX, Max 2MB):</label>
                <input type="file" name="file_notulen" required class="neumorphic-input" accept=".pdf,.doc,.docx">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-save btn-primary-style">Upload Notulen</button>
                <a href="<?= BASEURL; ?>/rapat" class="btn btn-reset btn-secondary-style">Batal</a>
            </div>
        </form>
    </section>
</main>