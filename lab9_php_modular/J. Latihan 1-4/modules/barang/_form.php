<?php
// Form bersama untuk Tambah dan Ubah barang.
// Variabel yang dipakai: $judul, $tombol, $errors, $old, $gambarLama (opsional)
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }
?>
<section class="card">
    <h2><?= e($judul) ?></h2>

    <?php foreach ($errors as $pesan): ?>
        <div class="alert alert-error"><?= e($pesan) ?></div>
    <?php endforeach; ?>

    <form method="post" action="" enctype="multipart/form-data">
        <?= csrfField() ?>

        <div class="input">
            <label for="nama">Nama Barang</label>
            <input type="text" id="nama" name="nama" value="<?= e($old['nama']) ?>" required>
        </div>

        <div class="input">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori">
                <?php foreach (daftarKategori() as $kat): ?>
                    <option value="<?= e($kat) ?>"<?= $old['kategori'] === $kat ? ' selected' : '' ?>><?= e($kat) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input">
            <label for="harga_jual">Harga Jual</label>
            <input type="text" id="harga_jual" name="harga_jual" value="<?= e($old['harga_jual']) ?>" required>
        </div>

        <div class="input">
            <label for="harga_beli">Harga Beli</label>
            <input type="text" id="harga_beli" name="harga_beli" value="<?= e($old['harga_beli']) ?>" required>
        </div>

        <div class="input">
            <label for="stok">Stok</label>
            <input type="text" id="stok" name="stok" value="<?= e($old['stok']) ?>" required>
        </div>

        <div class="input">
            <label for="file_gambar">File Gambar (maks. 2 MB)</label>
            <?php if (!empty($gambarLama) && gambarUrl($gambarLama) !== ''): ?>
                <img class="preview" src="<?= e(gambarUrl($gambarLama)) ?>" alt="Gambar saat ini">
                <small class="muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            <?php endif; ?>
            <input type="file" id="file_gambar" name="file_gambar" accept="image/*">
        </div>

        <button type="submit" class="btn"><?= e($tombol) ?></button>
        <a class="btn btn-secondary" href="<?= e(url('barang/list')) ?>">Batal</a>
    </form>
</section>
