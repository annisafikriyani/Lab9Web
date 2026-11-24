<?php
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

$errors = [];
$old = ['nama' => '', 'kategori' => daftarKategori()[0], 'harga_jual' => '', 'harga_beli' => '', 'stok' => ''];

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
            $stmt = db()->prepare(
                'INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar)
                 VALUES (?, ?, ?, ?, ?, ?)'
            );
            $hargaJual = (float) $data['harga_jual'];
            $hargaBeli = (float) $data['harga_beli'];
            $stok      = (int) $data['stok'];
            $path      = $gambar ?? '';
            $stmt->bind_param('ssddis', $data['nama'], $data['kategori'], $hargaJual, $hargaBeli, $stok, $path);
            $stmt->execute();

            setFlash('success', 'Barang berhasil ditambahkan.');
            redirect('barang/list');
        }
    }
}

$judul = 'Tambah Barang';
$tombol = 'Simpan';
require __DIR__ . '/_form.php';
