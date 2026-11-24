<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori   = trim($_POST['kategori'] ?? '');
    $nama       = trim($_POST['nama'] ?? '');
    $gambar     = trim($_POST['gambar'] ?? '');
    $harga_beli = (int) ($_POST['harga_beli'] ?? 0);
    $harga_jual = (int) ($_POST['harga_jual'] ?? 0);
    $stok       = (int) ($_POST['stok'] ?? 0);

    if ($kategori === '' || $nama === '') {
        setFlash('error', 'Kategori dan nama barang wajib diisi.');
        redirect('barang/add');
    }

    $stmt = $pdo->prepare(
        "INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok)
         VALUES (:kategori, :nama, :gambar, :harga_beli, :harga_jual, :stok)"
    );
    $stmt->execute([
        ':kategori'   => $kategori,
        ':nama'       => $nama,
        ':gambar'     => $gambar,
        ':harga_beli' => $harga_beli,
        ':harga_jual' => $harga_jual,
        ':stok'       => $stok,
    ]);

    setFlash('success', 'Data barang berhasil ditambahkan.');
    redirect('barang/list');
}
?>

<h2>Tambah Barang</h2>
<form method="POST" action="index.php?page=barang/add">
    <p>
        <label>Kategori</label><br>
        <input type="text" name="kategori" required>
    </p>
    <p>
        <label>Nama Barang</label><br>
        <input type="text" name="nama" required>
    </p>
    <p>
        <label>Nama File Gambar</label><br>
        <input type="text" name="gambar" placeholder="contoh: hp_vivo.jpg">
    </p>
    <p>
        <label>Harga Beli</label><br>
        <input type="number" name="harga_beli" value="0" required>
    </p>
    <p>
        <label>Harga Jual</label><br>
        <input type="number" name="harga_jual" value="0" required>
    </p>
    <p>
        <label>Stok</label><br>
        <input type="number" name="stok" value="0" required>
    </p>
    <button type="submit">Simpan</button>
    <a href="index.php?page=barang/list">Batal</a>
</form>