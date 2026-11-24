<?php
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

$barang = db()->query('SELECT * FROM data_barang ORDER BY id_barang DESC')->fetch_all(MYSQLI_ASSOC);
?>
<section class="card">
    <h2>Data Barang</h2>

    <?php if (isLoggedIn()): ?>
        <a class="btn" href="<?= e(url('barang/add')) ?>">Tambah Barang</a>
    <?php else: ?>
        <p class="muted">Login diperlukan untuk menambah, mengubah, atau menghapus data.</p>
    <?php endif; ?>

    <div class="table-wrap">
        <table>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php if (empty($barang)): ?>
                <tr><td colspan="7">Belum ada data.</td></tr>
            <?php endif; ?>
            <?php foreach ($barang as $row): ?>
                <tr>
                    <td>
                        <?php if (gambarUrl($row['gambar']) !== ''): ?>
                            <img src="<?= e(gambarUrl($row['gambar'])) ?>" alt="<?= e($row['nama']) ?>">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= e(ringkasTeks($row['nama'], 30)) ?></td>
                    <td><?= e($row['kategori']) ?></td>
                    <td><?= e(formatRupiah((float) $row['harga_jual'])) ?></td>
                    <td><?= e(formatRupiah((float) $row['harga_beli'])) ?></td>
                    <td><?= (int) $row['stok'] ?></td>
                    <td>
                        <?php if (isLoggedIn()): ?>
                            <a href="<?= e(url('barang/edit', ['id' => $row['id_barang']])) ?>">Ubah</a>
                            <form class="inline-form" method="post" action="<?= e(url('barang/delete')) ?>"
                                  onsubmit="return confirm('Hapus barang ini?');">
                                <?= csrfField() ?>
                                <input type="hidden" name="id" value="<?= (int) $row['id_barang'] ?>">
                                <button type="submit" class="link-button danger">Hapus</button>
                            </form>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>
