<?php
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

$barang = null;
if ($id !== false && $id !== null) {
    $stmt = db()->prepare('SELECT * FROM data_barang WHERE id_barang = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $barang = $stmt->get_result()->fetch_assoc();
}

if (!$barang) {
    http_response_code(404);
    echo '<section class="card"><h2>Data tidak ditemukan</h2>'
       . '<a class="btn" href="' . e(url('barang/list')) . '">Kembali ke daftar</a></section>';
    return;
}

$errors = [];
$old = [
    'nama'       => $barang['nama'],
    'kategori'   => $barang['kategori'],
    'harga_jual' => $barang['harga_jual'],
    'harga_beli' => $barang['harga_beli'],
    'stok'       => $barang['stok'],
];
$gambarLama = $barang['gambar'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid($_POST['csrf'] ?? null)) {
        $errors[] = 'Permintaan tidak valid. Muat ulang halaman lalu coba lagi.';
    } else {
        [$data, $errors] = validasiBarang($_POST);
        $old = $data;

        [$gambar, $errGambar] = uploadGambar($_FILES['file_gambar'] ?? []);
        if ($errGambar !== null) {
            $errors[] = $errGambar;
        }

        if (empty($errors)) {
            $hargaJual = (float) $data['harga_jual'];
            $hargaBeli = (float) $data['harga_beli'];
            $stok      = (int) $data['stok'];

            if ($gambar !== null) {
                $stmt = db()->prepare(
                    'UPDATE data_barang SET nama = ?, kategori = ?, harga_jual = ?, harga_beli = ?, stok = ?, gambar = ?
                     WHERE id_barang = ?'
                );
                $stmt->bind_param('ssddisi', $data['nama'], $data['kategori'], $hargaJual, $hargaBeli, $stok, $gambar, $id);
            } else {
                $stmt = db()->prepare(
                    'UPDATE data_barang SET nama = ?, kategori = ?, harga_jual = ?, harga_beli = ?, stok = ?
                     WHERE id_barang = ?'
                );
                $stmt->bind_param('ssddii', $data['nama'], $data['kategori'], $hargaJual, $hargaBeli, $stok, $id);
            }
            $stmt->execute();

            setFlash('success', 'Barang berhasil diperbarui.');
            redirect('barang/list');
        }
    }
}

$judul = 'Ubah Barang';
$tombol = 'Simpan Perubahan';
require __DIR__ . '/_form.php';
