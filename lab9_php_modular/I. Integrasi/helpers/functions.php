<?php

function e(?string $nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

function redirect(string $page): void
{
    header('Location: index.php?page=' . urlencode($page));
    exit;
}

/* Helper Flash Message (Sukses & Gagal) */
function setFlash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampilkanFlash(): void
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        echo '<div class="alert alert-' . e($f['tipe']) . '">' . e($f['pesan']) . '</div>';
    }
}

/* Helper Active Navigation */
function menuAktif(string $page, string $prefix): string
{
    return strpos($page, $prefix) === 0 ? 'active' : '';
}

function sudahLogin(): bool
{
    return !empty($_SESSION['user_login']);
}

function wajibLogin(): void
{
    if (!sudahLogin()) {
        setFlash('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        redirect('login');
    }
}