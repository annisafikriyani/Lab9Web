<?php
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

// Penghapusan hanya lewat POST + token CSRF, tidak pernah lewat URL GET.
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfValid($_POST['csrf'] ?? null)) {
    setFlash('error', 'Permintaan hapus tidak valid.');
    redirect('barang/list');
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    setFlash('error', 'ID barang tidak valid.');
    redirect('barang/list');
}

$stmt = db()->prepare('DELETE FROM data_barang WHERE id_barang = ?');
$stmt->bind_param('i', $id);
$stmt->execute();

setFlash($stmt->affected_rows > 0 ? 'success' : 'error',
         $stmt->affected_rows > 0 ? 'Barang berhasil dihapus.' : 'Data tidak ditemukan.');
redirect('barang/list');
