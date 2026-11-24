<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    setFlash('error', 'ID barang tidak valid.');
    redirect('barang/list');
}

try {
    // Cek dulu apakah data barang dengan id_barang tersebut ada
    $cekStmt = $pdo->prepare("SELECT id_barang, nama FROM data_barang WHERE id_barang = :id");
    $cekStmt->execute([':id' => $id]);
    $barang = $cekStmt->fetch();

    if (!$barang) {
        setFlash('error', 'Data barang tidak ditemukan.');
        redirect('barang/list');
    }

    // Hapus data barang
    $delStmt = $pdo->prepare("DELETE FROM data_barang WHERE id_barang = :id");
    $delStmt->execute([':id' => $id]);

    setFlash('success', 'Data barang "' . $barang['nama'] . '" berhasil dihapus.');
} catch (PDOException $e) {
    error_log($e->getMessage());
    setFlash('error', 'Gagal menghapus data barang.');
}

redirect('barang/list');