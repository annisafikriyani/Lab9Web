<?php
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

$pesanStatus = '';
$sukses = false;
$nama = $email = $pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim((string) ($_POST['nama'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $pesan = trim((string) ($_POST['pesan'] ?? ''));

    if (!csrfValid($_POST['csrf'] ?? null)) {
        $pesanStatus = 'Permintaan tidak valid. Muat ulang halaman.';
    } elseif ($nama === '' || $pesan === '') {
        $pesanStatus = 'Nama dan pesan wajib diisi.';
    } elseif (!validasiEmail($email)) {
        $pesanStatus = 'Format email tidak valid.';
    } else {
        $sukses = true;
        $pesanStatus = 'Terima kasih, ' . $nama . '. Pesan Anda diterima.';
    }
}
?>
<section class="card">
    <h2>Kontak</h2>

    <?php if ($pesanStatus !== ''): ?>
        <div class="alert alert-<?= $sukses ? 'success' : 'error' ?>"><?= e($pesanStatus) ?></div>
    <?php endif; ?>

    <?php if ($sukses): ?>
        <p>Ringkasan pesan: <em><?= e(ringkasTeks($pesan, 60)) ?></em></p>
    <?php endif; ?>

    <form method="post" action="">
        <?= csrfField() ?>
        <div class="input">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?= e($sukses ? '' : $nama) ?>" required>
        </div>
        <div class="input">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?= e($sukses ? '' : $email) ?>" required>
        </div>
        <div class="input">
            <label for="pesan">Pesan</label>
            <textarea id="pesan" name="pesan" rows="4" required><?= e($sukses ? '' : $pesan) ?></textarea>
        </div>
        <button type="submit" class="btn">Kirim</button>
    </form>
</section>
