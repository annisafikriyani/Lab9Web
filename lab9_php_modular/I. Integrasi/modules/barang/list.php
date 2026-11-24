<?php
$stmt = $pdo->query("SELECT id_barang, kategori, nama, gambar, harga_beli, harga_jual, stok FROM data_barang ORDER BY id_barang ASC");
$barangList = $stmt->fetchAll();
?>

<h2>Data Barang</h2>
<a href="index.php?page=barang/add" class="btn btn-success">+ Tambah Barang</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Nama Barang</th>
            <th>Gambar</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th style="text-align: center;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($barangList)): ?>
            <tr>
                <td colspan="8" style="text-align: center;">Belum ada data barang.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($barangList as $row): ?>
                <tr>
                    <td><?= e((string) $row['id_barang']) ?></td>
                    <td><?= e($row['kategori']) ?></td>
                    <td><strong><?= e($row['nama']) ?></strong></td>
                    <td>
                        <?php if (!empty($row['gambar']) && file_exists('assets/img/' . $row['gambar'])): ?>
                            <img src="assets/img/<?= e($row['gambar']) ?>" class="img-preview" alt="gambar">
                        <?php else: ?>
                            <small><?= e($row['gambar'] ?: '-') ?></small>
                        <?php endif; ?>
                    </td>
                    <td>Rp <?= number_format((float)$row['harga_beli'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format((float)$row['harga_jual'], 0, ',', '.') ?></td>
                    <td><?= e((string) $row['stok']) ?></td>
                    <td style="text-align: center;">
                        <a href="index.php?page=barang/edit&id=<?= urlencode((string) $row['id_barang']) ?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?page=barang/delete&id=<?= urlencode((string) $row['id_barang']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>