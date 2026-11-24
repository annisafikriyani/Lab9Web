<?php
// helpers/barang.php - function khusus modul barang (validasi dan upload gambar)

/** Daftar kategori yang diizinkan (sama dengan pilihan di Lab 8). */
function daftarKategori(): array
{
    return ['Komputer', 'Elektronik', 'Hand Phone'];
}

/**
 * Membersihkan dan memvalidasi input form barang.
 * Mengembalikan [data, daftarError].
 */
function validasiBarang(array $input): array
{
    $data = [
        'nama'       => trim((string) ($input['nama'] ?? '')),
        'kategori'   => (string) ($input['kategori'] ?? ''),
        'harga_jual' => trim((string) ($input['harga_jual'] ?? '')),
        'harga_beli' => trim((string) ($input['harga_beli'] ?? '')),
        'stok'       => trim((string) ($input['stok'] ?? '')),
    ];
    $error = [];

    if ($data['nama'] === '' || mb_strlen($data['nama']) > 100) {
        $error[] = 'Nama barang wajib diisi (maksimal 100 karakter).';
    }
    if (!in_array($data['kategori'], daftarKategori(), true)) {
        $error[] = 'Kategori tidak valid.';
    }
    if (!is_numeric($data['harga_jual']) || $data['harga_jual'] < 0) {
        $error[] = 'Harga jual harus berupa angka (0 atau lebih).';
    }
    if (!is_numeric($data['harga_beli']) || $data['harga_beli'] < 0) {
        $error[] = 'Harga beli harus berupa angka (0 atau lebih).';
    }
    if (filter_var($data['stok'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        $error[] = 'Stok harus berupa bilangan bulat (0 atau lebih).';
    }

    return [$data, $error];
}

/**
 * Memproses upload gambar dengan aman.
 * Mengembalikan [pathGambar|null, pesanError|null].
 * Jika tidak ada file yang dipilih, hasilnya [null, null].
 */
function uploadGambar(array $file): array
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return [null, null];
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [null, 'Upload gambar gagal.'];
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        return [null, 'Ukuran gambar maksimal 2 MB.'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
        return [null, 'Format gambar harus JPG, PNG, GIF, atau WEBP.'];
    }
    if (@getimagesize($file['tmp_name']) === false) {
        return [null, 'File yang diunggah bukan gambar yang valid.'];
    }

    $folder = dirname(__DIR__) . '/gambar';
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $namaBaru = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $folder . '/' . $namaBaru)) {
        return [null, 'Gagal menyimpan gambar.'];
    }

    return ['gambar/' . $namaBaru, null];
}

/** Alamat gambar barang. Mendukung data lama Lab 8 yang tersimpan sebagai "gambar/nama.jpg". */
function gambarUrl(?string $path): string
{
    $file = basename((string) $path);
    return $file === '' ? '' : assetUrl('gambar/' . rawurlencode($file));
}
