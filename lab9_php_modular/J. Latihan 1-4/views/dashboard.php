<?php
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

// Ringkasan data. Jika database belum siap, halaman tetap tampil.
$ringkasan = null;
try {
    $ringkasan = db()->query(
        'SELECT COUNT(*) AS jumlah, COALESCE(SUM(stok), 0) AS total_stok FROM data_barang'
    )->fetch_assoc();
    $termahal = db()->query(
        'SELECT nama, harga_jual FROM data_barang ORDER BY harga_jual DESC LIMIT 1'
    )->fetch_assoc();
} catch (Throwable $e) {
    error_log($e->getMessage());
}
?>
<section class="card">
    <h2>Dashboard</h2>
    <p>Selamat datang di aplikasi modular. Semua halaman memakai header, footer, dan router yang sama.</p>
</section>

<?php if ($ringkasan): ?>
<section class="card">
    <h2>Ringkasan Barang</h2>
    <div class="stats">
        <div class="stat"><strong><?= (int) $ringkasan['jumlah'] ?></strong><span>Jenis barang</span></div>
        <div class="stat"><strong><?= (int) $ringkasan['total_stok'] ?></strong><span>Total stok</span></div>
    </div>
    <?php if (!empty($termahal)): ?>
        <p>
            Barang termahal: <strong><?= e(ringkasTeks($termahal['nama'], 40)) ?></strong>
            (<?= e(formatRupiah((float) $termahal['harga_jual'])) ?>).
            Promo diskon 10%: <?= e(formatRupiah((float) $termahal['harga_jual'] - hitungDiskon((float) $termahal['harga_jual'], 10))) ?>.
        </p>
    <?php endif; ?>
    <a class="btn" href="<?= e(url('barang/list')) ?>">Lihat Data Barang</a>
</section>
<?php else: ?>
<section class="card">
    <h2>Ringkasan Barang</h2>
    <p>Database belum dapat dibaca. Pastikan MySQL menyala dan database <strong><?= e(DB_NAME) ?></strong> sudah ada (lihat <code>database.sql</code>).</p>
</section>
<?php endif; ?>
